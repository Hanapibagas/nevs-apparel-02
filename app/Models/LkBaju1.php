<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkBaju1 extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_masuk_id',
        'status_baju_1',
        'pola_lengan_1_id',
        'kerah_baju_1_id',
        'jenis_sablon_baju_1',
        'jenis_kain_baju_1',
        'total_baju_1',
        'ket_tambahan_baju_1',
        'keterangan_baju_1',
    ];

    public function BarangMasukCostumerServices()
    {
        return $this->hasMany(BarangMasukCostumerServices::class, 'barang_masuk_id');
    }
}
