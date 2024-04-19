<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkCelanaKiper extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_masuk_id',
        'status_celana_kiper',
        'pola_celana_kiper_id',
        'kerah_celana_kiper_id',
        'total_celana_kiper',
        'jenis_sablon_celana_kiper',
        'jenis_kain_celana_kiper',
        'ket_tambahan_celana_kiper',
        'keterangan_celana_kiper',
    ];

    public function BarangMasukCostumerServices()
    {
        return $this->hasMany(BarangMasukCostumerServices::class, 'barang_masuk_id');
    }

    public function KeraCealanaKiper()
    {
        return $this->belongsTo(KeraBaju::class, 'kerah_celana_kiper_id');
    }
    public function LenganCealanaKiper()
    {
        return $this->belongsTo(PolaLengan::class, 'pola_lengan_player_id');
    }
    public function CelanaCealanaKiper()
    {
        return $this->belongsTo(PolaLengan::class, 'pola_celana_kiper_id');
    }
}
