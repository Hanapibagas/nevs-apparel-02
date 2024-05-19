<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSortir extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_order_id',
        'penanggung_jawab_id',
        'manual_cut_id',
        'laser_cut_id',

        'lk_player_id',
        'lk_pelatih_id',
        'lk_kiper_id',
        'kertas_id',
        'cetak_id',
        'lk_1_id',
        'lk_celana_player_id',
        'lk_celana_pelatih_id',
        'lk_celana_kiper_id',
        'lk_celana_1_id',

        'no_error',
        'panjang_kertas',
        'berat',
        'bahan',
        'foto',

        'no_error_pelatih',
        'panjang_kertas_pelatih',
        'berat_pelatih',
        'bahan_pelatih',
        'foto_pelatih',

        'no_error_kiper',
        'panjang_kertas_kiper',
        'berat_kiper',
        'bahan_kiper',
        'foto_kiper',

        'no_error_1',
        'panjang_kertas_1',
        'berat_1',
        'bahan_1',
        'foto_1',

        'no_error_celana_pelayer',
        'panjang_kertas_celana_pelayer',
        'berat_celana_pelayer',
        'bahan_celana_pelayer',
        'foto_celana_pelayer',

        'no_error_celana_pelatih',
        'panjang_kertas_celana_pelatih',
        'berat_celana_pelatih',
        'bahan_celana_pelatih',
        'foto_celana_pelatih',

        'no_error_celana_kiper',
        'panjang_kertas_celana_kiper',
        'berat_celana_kiper',
        'bahan_celana_kiper',
        'foto_celana_kiper',

        'no_error_celana_1',
        'panjang_kertas_celana_1',
        'berat_celana_1',
        'bahan_celana_1',
        'foto_celana_1',

        'selesai',
        'tanda_telah_mengerjakan',
        'deadline',

        'keterangan',
        'keterangan2',
        'keterangan3',
        'keterangan4',
        'keterangan5',
        'keterangan6',
        'keterangan7',
        'keterangan8',
    ];

    public function Kertas()
    {
        return $this->belongsTo(BahanCetak::class, 'kertas_id');
    }

    public function Kain()
    {
        return $this->belongsTo(BahanKain::class, 'cetak_id');
    }

    public function BarangMasukCs()
    {
        return $this->belongsTo(BarangMasukCostumerServices::class, 'no_order_id');
    }

    public function BarangMasukManualCut()
    {
        return $this->belongsTo(DataManualCut::class, 'manual_cut_id');
    }

    public function UserSortir()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab_id');
    }
}
