<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\RekamMedis;
use App\Models\PengeluaranObat;
use App\Models\Datapasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource (Obat).
     */
    public function index()
    {
        $obats = Obat::latest()->get();
        return view('petugas.obat.index', compact('obats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_obat' => 'nullable|string|max:255',
            'nama_obat' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'satuan' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'is_bpjs' => 'nullable|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['is_bpjs'] = $request->has('is_bpjs') ? 1 : 0;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/foto_obat', $fotoName);
            $validated['foto'] = $fotoName;
        }

        Obat::create($validated);
        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);
        
        $validated = $request->validate([
            'kode_obat' => 'nullable|string|max:255',
            'nama_obat' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'satuan' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'is_bpjs' => 'nullable|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['is_bpjs'] = $request->has('is_bpjs') ? 1 : 0;

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($obat->foto) {
                Storage::delete('public/foto_obat/' . $obat->foto);
            }
            
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/foto_obat', $fotoName);
            $validated['foto'] = $fotoName;
        }

        $obat->update($validated);
        return redirect()->route('obat.index')->with('success', 'Obat berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();
        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus.');
    }

    /**
     * Menampilkan antrean resep dari dokter
     */
    public function resep()
    {
        // Get RekamMedis that have resep_obat not null and maybe haven't been fully processed
        // For simplicity, we just order by latest
        $resep = RekamMedis::with(['pasien', 'dokter'])
            ->withExists('pengeluaranObat')
            ->whereNotNull('resep_obat')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('petugas.obat.resep', compact('resep'));
    }

    /**
     * Menampilkan form pengeluaran obat untuk suatu rekam medis
     */
    public function pengeluaran($id)
    {
        $rekam = RekamMedis::with(['pasien', 'dokter'])->findOrFail($id);
        $pasien = Datapasien::where('user_id', $rekam->pasien_id)->first();
        
        $obats = Obat::where('stok', '>', 0)->get();
        $pengeluaran = PengeluaranObat::with('obat')->where('rekam_medis_id', $id)->get();

        return view('petugas.obat.pengeluaran', compact('rekam', 'pasien', 'obats', 'pengeluaran'));
    }

    /**
     * Proses simpan pengeluaran obat
     */
    public function storePengeluaran(Request $request, $id)
    {
        $rekam = RekamMedis::findOrFail($id);
        
        $request->validate([
            'obat_id' => 'required|array',
            'obat_id.*' => 'required|exists:obats,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric|min:0',
            'subtotal' => 'required|array',
            'keterangan' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $obatIds = $request->input('obat_id');
            $jumlahs = $request->input('jumlah');
            $hargas = $request->input('harga');
            $subtotals = $request->input('subtotal');
            $keterangans = $request->input('keterangan');

            for ($i = 0; $i < count($obatIds); $i++) {
                $obat = Obat::findOrFail($obatIds[$i]);
                
                // Check stock
                if ($obat->stok < $jumlahs[$i]) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Stok obat ' . $obat->nama_obat . ' tidak mencukupi.');
                }

                // Create record
                PengeluaranObat::create([
                    'rekam_medis_id' => $id,
                    'obat_id' => $obatIds[$i],
                    'jumlah' => $jumlahs[$i],
                    'harga' => $hargas[$i],
                    'subtotal' => $subtotals[$i],
                    'keterangan' => $keterangans[$i] ?? null,
                ]);

                // Reduce stock
                $obat->stok -= $jumlahs[$i];
                $obat->save();
            }

            DB::commit();
            return redirect()->route('obat.resep')->with('success', 'Pengeluaran obat berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error store pengeluaran: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }
}
