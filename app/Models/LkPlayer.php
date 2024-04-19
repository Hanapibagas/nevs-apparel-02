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

    // public function BarangMasukCostumerServicesLkPlyer()
    // {
    //     return $this->belongsTo(BarangMasukCostumerServices::class, 'barang_masuk_id');
    // }

    // player
    public function KeraPlayer()
    {
        return $this->belongsTo(KeraBaju::class, 'kera_baju_player_id');
    }
    public function LenganPlayer()
    {
        return $this->belongsTo(PolaLengan::class, 'pola_lengan_player_id');
    }
    public function CelanaPlayer()
    {
        return $this->belongsTo(PolaLengan::class, 'pola_celana_player_id');
    }
}
