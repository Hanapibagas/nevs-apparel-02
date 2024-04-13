<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkCelana1 extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_masuk_id',
        'status_celana_1',
        'pola_celana_1_id',
        'kerah_celana_1_id',
        'total_celana_1',
        'jenis_sablon_celana_1',
        'jenis_kain_celana_1',
        'keterangan_celana_1',
        'ket_tambahan_celana_1',
    ];

    public function BarangMasukCostumerServices()
    {
        return $this->hasMany(BarangMasukCostumerServices::class, 'barang_masuk_id');
    }
}
