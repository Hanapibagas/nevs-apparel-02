<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkPelatih extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_masuk_id',
        'status_pelatih',
        'pola_lengan_pelatih_id',
        'kerah_baju_pelatih_id',
        'jenis_sablon_baju_pelatih',
        'jenis_kain_baju_pelatih',
        'total_baju_pelatih',
        'ket_tambahan_baju_pelatih',
        'keterangan_baju_pelatih',
    ];

    // pelatih
    public function KeraPelatih()
    {
        return $this->belongsTo(KeraBaju::class, 'kerah_baju_pelatih_id');
    }
    public function LenganPelatih()
    {
        return $this->belongsTo(PolaLengan::class, 'pola_lengan_pelatih_id');
    }
    public function CelanaPelatih()
    {
        return $this->belongsTo(PolaLengan::class, 'pola_celana_pelatih_id');
    }
}
