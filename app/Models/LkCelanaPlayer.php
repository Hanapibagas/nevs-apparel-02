<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkCelanaPlayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_masuk_id',
        'status_celana_player',
        'pola_celana_player_id',
        'kerah_celana_player_id',
        'total_celana_player',
        'jenis_sablon_celana_player',
        'jenis_kain_celana_player',
        'ket_tambahan_celana_player',
        'keterangan_celana_pelayer',
    ];

    public function BarangMasukCostumerServices()
    {
        return $this->hasMany(BarangMasukCostumerServices::class, 'barang_masuk_id');
    }

    public function KeraCelanaPlayer()
    {
        return $this->belongsTo(KeraBaju::class, 'kerah_celana_player_id');
    }
    public function LenganCealanaPlayer()
    {
        return $this->belongsTo(PolaLengan::class, 'pola_lengan_player_id');
    }
    public function CelanaCelanaPlayer()
    {
        return $this->belongsTo(PolaLengan::class, 'pola_celana_player_id');
    }
}
