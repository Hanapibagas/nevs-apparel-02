<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkPlayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_masuk_id',
        'pola_lengan_player_id',
        'kera_baju_player_id',
        'jenis_sablon_baju_player',
        'jenis_kain_baju_player',
        'total_baju_player',
        'status_player',
        'ket_tambahan_baju_player',
        'keterangan_baju_pelayer',
    ];

    public function BarangMasukCostumerServices()
    {
        return $this->hasMany(BarangMasukCostumerServices::class, 'barang_masuk_id');
    }
}
