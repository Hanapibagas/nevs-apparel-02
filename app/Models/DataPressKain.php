<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPressKain extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_order_id',
        'penanggung_jawab_id',
        'mesin_atexco_id',
        'mesin_mimaki_id',
        'deadline',
        'selesai',
        'kain',
        'berat',
        'gambar',

        'kain_pelatih',
        'berat_pelatih',
        'gambar_pelatih',

        'kain_kiper',
        'berat_kiper',
        'gambar_kiper',

        'kain_1',
        'berat_1',
        'gambar_1',

        'kain_celana_player',
        'berat_celana_player',
        'gambar_celana_player',

        'kain_celana_pelatih',
        'berat_celana_pelatih',
        'gambar_celana_pelatih',

        'kain_celana_kiper',
        'berat_celana_kiper',
        'gambar_celana_kiper',

        'kain_celana_1',
        'berat_celana_1',
        'gambar_celana_1',

        'tanda_telah_mengerjakan',
    ];

    public function BarangMasukCs()
    {
        return $this->belongsTo(BarangMasukCostumerServices::class, 'no_order_id');
    }

    public function MesinMimaki()
    {
        return $this->belongsTo(MesinMimaki::class, 'mesin_mimaki_id');
    }

    public function MesinAtexco()
    {
        return $this->belongsTo(MesinAtexco::class, 'mesin_atexco_id');
    }
}
