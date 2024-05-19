<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasukDatalayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_layout_id',
        'barang_masuk_id',
        'lk_player_id',
        'kertas_id',
        'lk_pelatih_id',
        'lk_kiper_id',
        'lk_1_id',
        'lk_celana_player_id',
        'lk_celana_pelatih_id',
        'lk_celana_kiper_id',
        'lk_celana_1_id',
        'deadline',

        'panjang_kertas_palayer',
        'poly_player',
        'file_tangkap_layar_player',

        'panjang_kertas_pelatih',
        'poly_pelatih',
        'file_tangkap_layar_pelatih',

        'panjang_kertas_kiper',
        'poly_kiper',
        'file_tangkap_layar_kiper',

        'panjang_kertas_1',
        'poly_1',
        'file_tangkap_layar_1',

        'panjang_kertas_celana_pelayer',
        'poly_celana_pelayer',
        'file_tangkap_layar_celana_pelayer',

        'panjang_kertas_celana_pelatih',
        'poly_celana_pelatih',
        'file_tangkap_layar_celana_pelatih',

        'panjang_kertas_celana_kiper',
        'poly_celana_kiper',
        'file_tangkap_layar_celana_kiper',

        'panjang_kertas_celana_1',
        'poly_celana_1',
        'file_tangkap_layar_celana_1',

        'selesai',
        'tanda_telah_mengerjakan',
        'file_corel_layout',
        'file_corel_layout2',
        'file_corel_layout3',
        'file_corel_layout4',
        'file_corel_layout5',
        'file_corel_layout6',
        'file_corel_layout7',
        'file_corel_layout8',
        'keterangan1',
        'keterangan2',
        'keterangan3',
        'keterangan4',
        'keterangan5',
        'keterangan6',
        'keterangan7',
        'keterangan8',
    ];

    public function GamarTangkaplayar()
    {
        return $this->hasMany(GambarTangkapLayar::class, 'barang_masuk_datalayouts_id');
    }

    public function Kertas()
    {
        return $this->belongsTo(BahanKain::class, 'kertas_id');
    }

    public function UserLayout()
    {
        return $this->belongsTo(User::class, 'users_layout_id');
    }

    public function BarangMasukCsLK()
    {
        return $this->belongsTo(BarangMasukCostumerServices::class, 'barang_masuk_id');
    }

    public function BarangMasukCostumerServicesLkPlyer()
    {
        return $this->hasOne(LkPlayer::class, 'id');
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
