<?php

namespace App\Services;

use App\Models\Obat;

class TopsisService
{
    /**
     * Hitung rekomendasi obat menggunakan metode TOPSIS
     * 
     * @param array $weights Bobot untuk masing-masing kriteria: [stok, harga, bpjs]
     * @return array
     */
    public function calculate($weights = ['stok' => 3, 'harga' => 4, 'bpjs' => 5])
    {
        // Ambil obat yang stoknya lebih dari 0
        $obats = Obat::where('stok', '>', 0)->get();
        
        if ($obats->isEmpty()) {
            return [];
        }

        // 1. Matrix Keputusan (Decision Matrix)
        $matrix = [];
        foreach ($obats as $obat) {
            $matrix[] = [
                'id' => $obat->id,
                'nama' => $obat->nama_obat,
                'stok' => $obat->stok,             // Benefit
                'harga' => $obat->harga > 0 ? $obat->harga : 1, // Cost (hindari 0)
                'bpjs' => $obat->is_bpjs ? 1 : 0,  // Benefit
                'foto' => $obat->foto,
            ];
        }

        // 2. Normalisasi Matriks
        // Hitung pembagi (akar dari jumlah kuadrat)
        $sumSq = ['stok' => 0, 'harga' => 0, 'bpjs' => 0];
        foreach ($matrix as $row) {
            $sumSq['stok'] += pow($row['stok'], 2);
            $sumSq['harga'] += pow($row['harga'], 2);
            $sumSq['bpjs'] += pow($row['bpjs'], 2);
        }

        $pembagi = [
            'stok' => sqrt($sumSq['stok']) == 0 ? 1 : sqrt($sumSq['stok']),
            'harga' => sqrt($sumSq['harga']) == 0 ? 1 : sqrt($sumSq['harga']),
            'bpjs' => sqrt($sumSq['bpjs']) == 0 ? 1 : sqrt($sumSq['bpjs']),
        ];

        $normalized = [];
        foreach ($matrix as $row) {
            $normalized[] = [
                'id' => $row['id'],
                'nama' => $row['nama'],
                'stok' => $row['stok'] / $pembagi['stok'],
                'harga' => $row['harga'] / $pembagi['harga'],
                'bpjs' => $row['bpjs'] / $pembagi['bpjs'],
                'foto' => $row['foto'],
            ];
        }

        // 3. Matriks Normalisasi Terbobot (Weighted Normalized Matrix)
        $weighted = [];
        foreach ($normalized as $row) {
            $weighted[] = [
                'id' => $row['id'],
                'nama' => $row['nama'],
                'stok' => $row['stok'] * $weights['stok'],
                'harga' => $row['harga'] * $weights['harga'],
                'bpjs' => $row['bpjs'] * $weights['bpjs'],
                'foto' => $row['foto'],
                'raw_stok' => $matrix[array_search($row['id'], array_column($matrix, 'id'))]['stok'],
                'raw_harga' => $matrix[array_search($row['id'], array_column($matrix, 'id'))]['harga'],
                'raw_bpjs' => $matrix[array_search($row['id'], array_column($matrix, 'id'))]['bpjs'],
            ];
        }

        // 4. Solusi Ideal Positif (A+) dan Negatif (A-)
        // Stok: Benefit (Max+, Min-)
        // Harga: Cost (Min+, Max-)
        // BPJS: Benefit (Max+, Min-)
        $aPlus = [
            'stok' => max(array_column($weighted, 'stok')),
            'harga' => min(array_column($weighted, 'harga')),
            'bpjs' => max(array_column($weighted, 'bpjs')),
        ];

        $aMinus = [
            'stok' => min(array_column($weighted, 'stok')),
            'harga' => max(array_column($weighted, 'harga')),
            'bpjs' => min(array_column($weighted, 'bpjs')),
        ];

        // 5. Jarak Solusi Ideal (D+ dan D-)
        $distances = [];
        foreach ($weighted as $index => $row) {
            $dPlus = sqrt(
                pow($row['stok'] - $aPlus['stok'], 2) +
                pow($row['harga'] - $aPlus['harga'], 2) +
                pow($row['bpjs'] - $aPlus['bpjs'], 2)
            );

            $dMinus = sqrt(
                pow($row['stok'] - $aMinus['stok'], 2) +
                pow($row['harga'] - $aMinus['harga'], 2) +
                pow($row['bpjs'] - $aMinus['bpjs'], 2)
            );

            // 6. Nilai Preferensi (V)
            $v = 0;
            if ($dPlus + $dMinus > 0) {
                $v = $dMinus / ($dPlus + $dMinus);
            }

            $distances[] = [
                'id' => $row['id'],
                'nama' => $row['nama'],
                'stok' => $row['raw_stok'],
                'harga' => $row['raw_harga'],
                'is_bpjs' => $row['raw_bpjs'] == 1,
                'foto' => $row['foto'],
                'dPlus' => $dPlus,
                'dMinus' => $dMinus,
                'score' => round($v, 4),
            ];
        }

        // 7. Urutkan berdasarkan nilai preferensi tertinggi
        usort($distances, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return $distances;
    }
}
