<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datapasien;
use App\Models\RekamMedis;
use App\Models\Ruang;
use App\Models\Obat;
use App\Models\dokter;
use Illuminate\Support\Facades\Auth;
use App\Services\TopsisService;

class DashboardDokterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:dokter');
    }

    public function index()
    {
        // Mendapatkan dokter ID dari user yang login
        $user = Auth::user();
        $dokter = dokter::where('id_user', $user->id)->first();
        
        $totalPasien = Datapasien::count();
        $totalRekamMedis = $dokter ? RekamMedis::where('dokter_id', $user->id)->count() : 0;
        $totalRuang = Ruang::count();
        $totalObat = Obat::count();

        return view('dokter.dashboard', compact('totalPasien', 'totalRekamMedis', 'totalRuang', 'totalObat', 'dokter'));
    }

    // --- Manajemen Pasien ---
    public function pasien()
    {
        $pasien = Datapasien::all();
        return view('dokter.pasien.index', compact('pasien'));
    }

    // --- Manajemen Rekam Medis ---
    public function rekamMedis()
    {
        $user = Auth::user();
        // Dokter hanya bisa melihat rekam medis yang mereka buat (atau semua tergantung aturan bisnis, kita tampilkan semua atau filter)
        // Kita tampilkan semua untuk mempermudah, atau yang terkait dokter ini. Mari kita tampilkan semua beserta relasinya.
        $rekamMedis = RekamMedis::with(['pasien', 'dokter'])->orderBy('created_at', 'desc')->get();
        return view('dokter.rekam-medis.index', compact('rekamMedis'));
    }

    public function createRekamMedis()
    {
        $pasien = \App\Models\Datapasien::all();
        return view('dokter.rekam-medis.create', compact('pasien'));
    }

    public function storeRekamMedis(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:user,id', // Cek di tabel user
            'keluhan_utama' => 'required|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'nullable|string',
            'resep_obat' => 'nullable|string',
        ]);

        $validated['dokter_id'] = Auth::id();
        RekamMedis::create($validated);

        return redirect()->route('dokter.rekam-medis.index')->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    public function editRekamMedis($id)
    {
        $rm = RekamMedis::findOrFail($id);
        // Pastikan hanya dokter yang membuat yang bisa edit atau admin
        if($rm->dokter_id != Auth::id()) {
            return redirect()->route('dokter.rekam-medis.index')->with('error', 'Anda tidak berhak mengedit rekam medis ini.');
        }
        $pasien = \App\Models\Datapasien::all();
        return view('dokter.rekam-medis.edit', compact('rm', 'pasien'));
    }

    public function updateRekamMedis(Request $request, $id)
    {
        $rm = RekamMedis::findOrFail($id);
        if($rm->dokter_id != Auth::id()) {
            return redirect()->route('dokter.rekam-medis.index')->with('error', 'Anda tidak berhak mengedit rekam medis ini.');
        }

        $validated = $request->validate([
            'keluhan_utama' => 'required|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'nullable|string',
            'resep_obat' => 'nullable|string',
        ]);

        $rm->update($validated);
        return redirect()->route('dokter.rekam-medis.index')->with('success', 'Rekam medis berhasil diperbarui.');
    }

    public function destroyRekamMedis($id)
    {
        $rm = RekamMedis::findOrFail($id);
        if($rm->dokter_id != Auth::id()) {
            return redirect()->route('dokter.rekam-medis.index')->with('error', 'Anda tidak berhak menghapus rekam medis ini.');
        }
        $rm->delete();
        return redirect()->route('dokter.rekam-medis.index')->with('success', 'Rekam medis berhasil dihapus.');
    }

    // --- SPK Rekomendasi Obat (TOPSIS) ---
    public function spkRekomendasiObat(Request $request)
    {
        $weights = [
            'stok' => $request->input('bobot_stok', 3),
            'harga' => $request->input('bobot_harga', 4),
            'bpjs' => $request->input('bobot_bpjs', 5),
        ];

        $topsisService = new TopsisService();
        $rekomendasi = $topsisService->calculate($weights);

        // Ambil top 10 saja untuk ditampilkan
        $topRekomendasi = array_slice($rekomendasi, 0, 10);

        return response()->json([
            'status' => 'success',
            'data' => $topRekomendasi
        ]);
    }

    // --- Melihat Data Ruang ---
    public function ruang()
    {
        $ruang = Ruang::all();
        return view('dokter.ruang.index', compact('ruang'));
    }

    // --- Melihat Data Obat ---
    public function obat()
    {
        $obat = Obat::all();
        return view('dokter.obat.index', compact('obat'));
    }
}
