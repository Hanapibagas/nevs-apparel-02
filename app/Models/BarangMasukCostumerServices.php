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

        // baju player
        'pola_lengan_player_id',
        'kera_baju_player_id',
        'jenis_sablon_baju_player',
        'jenis_kain_baju_player',
        'total_baju_player',
        'ket_tambahan_baju_player',
        'keterangan_baju_pelayer',

        // baju pelatih
        'pola_lengan_pelatih_id',
        'kerah_baju_pelatih_id',
        'jenis_sablon_baju_pelatih',
        'jenis_kain_baju_pelatih',
        'total_baju_pelatih',
        'ket_tambahan_baju_pelatih',
        'keterangan_baju_pelatih',

        // baju kiper
        'pola_lengan_kiper_id',
        'kerah_baju_kiper_id',
        'jenis_sablon_baju_kiper',
        'jenis_kain_baju_kiper',
        'total_baju_kiper',
        'ket_tambahan_baju_kiper',
        'keterangan_baju_kiper',

        // baju 1
        'pola_lengan_1_id',
        'kerah_baju_1_id',
        'jenis_sablon_baju_1',
        'jenis_kain_baju_1',
        'total_baju_1',
        'ket_tambahan_baju_1',
        'keterangan_baju_1',

        // celana player
        'pola_celana_player_id',
        'kerah_celana_player_id',
        'total_celana_player',
        'jenis_sablon_celana_player',
        'jenis_kain_celana_player',
        'ket_tambahan_celana_player',
        'keterangan_celana_pelayer',

        // celana pelatih
        'pola_celana_pelatih_id',
        'kerah_celana_pelatih_id',
        'total_celana_pelatih',
        'jenis_sablon_celana_pelatih',
        'jenis_kain_celana_pelatih',
        'ket_tambahan_celana_pelatih',
        'keterangan_celana_pelatih',

        // celana kiper
        'pola_celana_kiper_id',
        'kerah_celana_kiper_id',
        'total_celana_kiper',
        'jenis_sablon_celana_kiper',
        'jenis_kain_celana_kiper',
        'ket_tambahan_celana_kiper',
        'keterangan_celana_kiper',

        // celana 1
        'pola_celana_1_id',
        'kerah_celana_1_id',
        'total_celana_1',
        'jenis_sablon_celana_1',
        'jenis_kain_celana_1',
        'keterangan_celana_1',
        'ket_tambahan_celana_1',

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
}
