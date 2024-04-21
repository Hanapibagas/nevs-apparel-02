<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasukCostumerServices extends Model
{
    use HasFactory;

    protected $fillable = [
        // order
        'no_order',
        'kota_produksi',
        'barang_masuk_disainer_id',
        'cs_id',
        'disainer_id',
        'jenis_mesin',
        'no_nota',

        // produksi
        'layout_id',
        'jenis_produksi',
        'pola',
        'tanggal_masuk',
        'deadline',
        'ket_hari',

        'total_baju_player',
        'total_baju_pelatih',
        'total_baju_kiper',
        'total_baju_1',
        'total_celana_player',
        'total_celana_pelatih',
        'total_celana_kiper',
        'total_celana_1',

        'file_corel_disainer',
        'keterangan_lengkap',
        'aksi',
        'tanda_telah_mengerjakan',
    ];

    public function Gambar()
    {
        return $this->belongsTo(Gambar::class, 'barang_masuk_disainer_id');
    }

    public function BarangMasukDisainer()
    {
        return $this->belongsTo(BarangMasukDisainer::class, 'barang_masuk_disainer_id');
    }

    public function Users()
    {
        return $this->belongsTo(User::class, 'disainer_id');
    }

    public function UsersOrder()
    {
        return $this->belongsTo(User::class, 'cs_id');
    }

    public function UsersLk()
    {
        return $this->belongsTo(User::class, 'layout_id');
    }

    public function MesinAtexco()
    {
        return $this->hasMany(MesinAtexco::class, 'barang_masuk');
    }

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

    // 1
    public function Kera1()
    {
        return $this->belongsTo(KeraBaju::class, 'kerah_baju_1_id');
    }
    public function Lengan1()
    {
        return $this->belongsTo(PolaLengan::class, 'pola_lengan_1_id');
    }
    public function Celana1()
    {
        return $this->belongsTo(PolaLengan::class, 'pola_celana_1_id');
    }

    public function BarangMasukCostumerServicesLkPlyer()
    {
        return $this->hasMany(LkPlayer::class, 'barang_masuk_id');
    }

    public function BarangMasukCostumerServicesLkPelatih()
    {
        return $this->hasMany(LkPelatih::class, 'barang_masuk_id');
    }

    public function BarangMasukCostumerServicesLkKiper()
    {
        return $this->hasMany(LkKiper::class, 'barang_masuk_id');
    }

    public function BarangMasukCostumerServicesLk1()
    {
        return $this->hasMany(LkBaju1::class, 'barang_masuk_id');
    }
    public function BarangMasukCostumerServicesLkCelanaPlyer()
    {
        return $this->hasMany(LkCelanaPlayer::class, 'barang_masuk_id');
    }
    public function BarangMasukCostumerServicesLkCelanaPelatih()
    {
        return $this->hasMany(LkCelanaPelatih::class, 'baraang_masuk_id');
    }
    public function BarangMasukCostumerServicesLkCelanaKiper()
    {
        return $this->hasMany(LkCelanaKiper::class, 'barang_masuk_id');
    }
    public function BarangMasukCostumerServicesLkCelana1()
    {
        return $this->hasMany(LkCelana1::class, 'barang_masuk_id');
    }
}
