<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengeluaranObat;
use App\Models\RekamMedis;

class LaporanFarmasiController extends Controller
{
    /**
     * Laporan Riwayat Obat (Pengeluaran)
     */
    public function riwayatObat()
    {
        // Mengambil semua riwayat pengeluaran obat beserta relasinya
        $riwayatObat = PengeluaranObat::with(['obat', 'rekamMedis.pasien'])->latest()->paginate(20);
        return view('admin.laporan.riwayat-obat', compact('riwayatObat'));
    }

    /**
     * Laporan Riwayat Resep
     */
    public function riwayatResep()
    {
        // Mengambil rekam medis yang memiliki catatan resep
        $riwayatResep = RekamMedis::with(['pasien', 'dokter'])
            ->whereNotNull('resep_obat')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.laporan.riwayat-resep', compact('riwayatResep'));
    }
}
