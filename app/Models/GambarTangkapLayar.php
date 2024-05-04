<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarTangkapLayar extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_masuk_datalayouts_id',
        'file_tangkap_layar_player',
        'file_tangkap_layar_pelatih',
        'file_tangkap_layar_kiper',
        'file_tangkap_layar_1',
        'file_tangkap_layar_celana_pelayer',
        'file_tangkap_layar_celana_pelatih',
        'file_tangkap_layar_celana_kiper',
        'file_tangkap_layar_celana_1',
    ];
}
