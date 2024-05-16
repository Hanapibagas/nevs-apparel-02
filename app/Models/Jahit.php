<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jahit extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_order_id',
        'penanggung_jawab_id',

        'lk_player_id',
        'lk_pelatih_id',
        'lk_kiper_id',
        'lk_1_id',
        'lk_celana_player_id',
        'lk_celana_pelatih_id',
        'lk_celana_kiper_id',
        'lk_celana_1_id',

        'sortir_id',
        'deadline',
        'selesai',

        'leher',
        'pola_badan',
        'pola_celana',
        'foto',

        'leher_pelatih',
        'pola_badan_pelatih',
        'pola_celana_pelatih',
        'foto_pelatih',

        'leher_kiper',
        'pola_badan_kiper',
        'pola_celana_kiper',
        'foto_kiper',

        'leher_1',
        'pola_badan_1',
        'pola_celana_1',
        'foto_1',

        'leher_celana_pelayer',
        'pola_badan_celana_pelayer',
        'pola_celana_celana_pelayer',
        'foto_celana_pelayer',

        'leher_celana_pelatih',
        'pola_badan_celana_pelatih',
        'pola_celana_celana_pelatih',
        'foto_celana_pelatih',

        'leher_celana_kiper',
        'pola_badan_celana_kiper',
        'pola_celana_celana_kiper',
        'foto_celana_kiper',

        'leher_celana_1',
        'pola_badan_celana_1',
        'pola_celana_celana_1',
        'foto_celana_1',

        'serah_terima',
        'tanda_telah_mengerjakan',
        'keterangan',
        'keterangan2',
        'keterangan3',
        'keterangan4',
        'keterangan5',
        'keterangan6',
        'keterangan7',
        'keterangan8',
    ];

    public function BarangMasukCs()
    {
        return $this->belongsTo(BarangMasukCostumerServices::class, 'no_order_id');
    }

    public function BarangMasukSortir()
    {
        return $this->belongsTo(DataSortir::class, 'sortir_id');
    }

    public function UserJahitBaju()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab_id');
    }
}
