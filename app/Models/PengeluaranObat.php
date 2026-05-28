<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranObat extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran_obats';

    protected $fillable = [
        'rekam_medis_id',
        'obat_id',
        'jumlah',
        'harga',
        'subtotal',
        'keterangan',
    ];

    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class, 'rekam_medis_id');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}
