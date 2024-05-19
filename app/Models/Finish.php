<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finish extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_order_id',
        'jahit_baju_id',
        'lk_player_id',
        'lk_pelatih_id',
        'lk_kiper_id',
        'lk_1_id',
        'lk_celana_player_id',
        'lk_celana_pelatih_id',
        'lk_celana_kiper_id',
        'lk_celana_1_id',
        'deadline',
        'selesai',
        'foto',
        'foto_pelatih',
        'foto_kiper',
        'foto_1',
        'foto_celana_pelayer',
        'foto_celana_pelatih',
        'foto_celana_kiper',
        'foto_celana_1',
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

    public function BarangMasukCs()
    {
        return $this->belongsTo(BarangMasukCostumerServices::class, 'no_order_id');
    }

    public function BarangMasukJahitCelana()
    {
        return $this->belongsTo(Jahit::class, 'jahit_baju_id');
    }
}
