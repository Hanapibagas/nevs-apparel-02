<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkCelanaPelatih extends Model
{
    use HasFactory;

    protected $fillable = [
        'baraang_masuk_id',
        'status_celana_pelatih',
        'pola_celana_pelatih_id',
        'kerah_celana_pelatih_id',
        'total_celana_pelatih',
        'jenis_sablon_celana_pelatih',
        'jenis_kain_celana_pelatih',
        'ket_tambahan_celana_pelatih',
        'keterangan_celana_pelatih',
    ];

    public function BarangMasukCostumerServices()
    {
        return $this->hasMany(BarangMasukCostumerServices::class, 'barang_masuk_id');
    }

    public function KeraCelanapelatih()
    {
        return $this->belongsTo(KeraBaju::class, 'kerah_celana_pelatih_id');
    }
    public function LenganCelanapelatih()
    {
        return $this->belongsTo(PolaLengan::class, 'pola_lengan_player_id');
    }
    public function CelanaCelanapelatih()
    {
        return $this->belongsTo(PolaLengan::class, 'pola_celana_pelatih_id');
    }
}
