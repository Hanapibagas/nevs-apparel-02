<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gambar extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_masuk_costumer_services_id',

        'file_baju_player',
        'file_baju_pelatih',
        'file_baju_kiper',
        'file_baju_1',
        'file_celana_player',
        'file_celana_pelatih',
        'file_celana_kiper',
        'file_celana_1',
    ];

    public function BarangMasukCostumerServices()
    {
        return $this->hasMany(BarangMasukCostumerServices::class, 'barang_masuk_costumer_services_id');
    }
}
