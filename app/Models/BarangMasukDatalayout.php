<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasukDatalayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_layout_id',
        'lk_player_id',
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

        'panjang_kertas_pelatih',
        'poly_pelatih',

        'panjang_kertas_kiper',
        'poly_kiper',

        'panjang_kertas_1',
        'poly_1',

        'panjang_kertas_celana_pelayer',
        'poly_celana_pelayer',

        'panjang_kertas_celana_pelatih',
        'poly_celana_pelatih',

        'panjang_kertas_celana_kiper',
        'poly_celana_kiper',

        'panjang_kertas_celana_1',
        'poly_celana_1',

        'selesai',
        'tanda_telah_mengerjakan',
        'file_corel_layout',
        'file_tangkap_layar',
    ];

    public function UserLayout()
    {
        return $this->belongsTo(User::class, 'users_layout_id');
    }

    public function BarangMasukCsLK()
    {
        return $this->belongsTo(BarangMasukCostumerServices::class, 'no_order_id');
    }
}
