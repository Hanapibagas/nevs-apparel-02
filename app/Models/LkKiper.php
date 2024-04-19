<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkKiper extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_masuk_id',
        'status_kiper',
        'pola_lengan_kiper_id',
        'kerah_baju_kiper_id',
        'jenis_sablon_baju_kiper',
        'jenis_kain_baju_kiper',
        'total_baju_kiper',
        'ket_tambahan_baju_kiper',
        'keterangan_baju_kiper',
    ];

    // kiper
    public function KeraKiper()
    {
        return $this->belongsTo(KeraBaju::class, 'kerah_baju_kiper_id');
    }
    public function LenganKiper()
    {
        return $this->belongsTo(PolaLengan::class, 'pola_lengan_kiper_id');
    }
    public function CelanaKiper()
    {
        return $this->belongsTo(PolaLengan::class, 'pola_celana_kiper_id');
    }
}
