<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RuangController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:petugas']);
    }

    public function index()
    {
        $ruangs = Ruang::all();
        return view('petugas.ruang.index', compact('ruangs'));
    }

    public function create()
    {
        return view('petugas.ruang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|string',
            'user_id' => 'required|exists:user,id',
        ]);

        Ruang::create([
            'nama_ruang' => $request->nama_ruang,
            'kapasitas' => $request->kapasitas,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('ruang.index')->with('success', 'Data ruang berhasil ditambahkan');
    }

    public function edit(Ruang $ruang)
    {
        return view('petugas.ruang.edit', compact('ruang'));
    }

    public function update(Request $request, Ruang $ruang)
    {
        $request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        $ruang->update([
            'nama_ruang' => $request->nama_ruang,
            'kapasitas' => $request->kapasitas,
            'status' => $request->status,
        ]);

        return redirect()->route('ruang.index')->with('success', 'Data ruang berhasil diperbarui');
    }

    public function destroy(Ruang $ruang)
    {
        $ruang->delete();
        return redirect()->route('ruang.index')->with('success', 'Data ruang berhasil dihapus');
    }
}
