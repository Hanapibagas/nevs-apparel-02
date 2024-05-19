<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataManualCut extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_order_id',
        'penanggung_jawab_id',
        'laser_cut_id',
        'lk_player_id',
        'lk_pelatih_id',
        'lk_kiper_id',
        'kain_id',
        'lk_1_id',
        'lk_celana_player_id',
        'lk_celana_pelatih_id',
        'lk_celana_kiper_id',
        'lk_celana_1_id',
        'deadline',
        'selesai',
        'file_foto',
        'file_foto_pelatih',
        'file_foto_kiper',
        'file_foto_1',
        'file_foto_celana_player',
        'file_foto_celana_pelatih',
        'file_foto_celana_kiper',
        'file_foto_celana_1',
        'kain',
        'kain_pelatih',
        'kain_kiper',
        'kain_1',
        'kain_celana_player',
        'kain_celana_pelatih',
        'kain_celana_kiper',
        'kain_celana_1',
        'keterangan',
        'keterangan2',
        'keterangan3',
        'keterangan4',
        'keterangan5',
        'keterangan6',
        'keterangan7',
        'keterangan8',
        'tanda_telah_mengerjakan',
    ];

    public function Kain()
    {
        return $this->belongsTo(BahanKain::class, 'kain_id');
    }

    public function BarangMasukCs()
    {
        return $this->belongsTo(BarangMasukCostumerServices::class, 'no_order_id');
    }

    public function BarangMasukLaserCut()
    {
        return $this->belongsTo(DataLaserCut::class, 'laser_cut_id');
    }

    public function UserLaserCut()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab_id');
    }

    public function BarangMasukCostumerServicesLkPlyer()
    {
        return $this->hasMany(LkPlayer::class, 'id');
    }
    public function BarangMasukCostumerServicesLkPelatih()
    {
        return $this->hasMany(LkPelatih::class, 'id');
    }
    public function BarangMasukCostumerServicesLkKiper()
    {
        return $this->hasMany(LkKiper::class, 'id');
    }
    public function BarangMasukCostumerServicesLk1()
    {
        return $this->hasMany(LkBaju1::class, 'id');
    }
    public function BarangMasukCostumerServicesLkCelanaPlyer()
    {
        return $this->hasMany(LkCelanaPlayer::class, 'id');
    }
    public function BarangMasukCostumerServicesLkCelanaPelatih()
    {
        return $this->hasMany(LkCelanaPelatih::class, 'id');
    }
    public function BarangMasukCostumerServicesLkCelanaKiper()
    {
        return $this->hasMany(LkCelanaKiper::class, 'id');
    }
    public function BarangMasukCostumerServicesLkCelana1()
    {
        return $this->hasMany(LkCelana1::class, 'id');
    }
}
