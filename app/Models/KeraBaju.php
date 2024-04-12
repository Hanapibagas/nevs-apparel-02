<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeraBaju extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_kera',
        'gambar',
    ];

    public function BarangMasukCostumerServices()
    {
        return $this->hasMany(BarangMasukCostumerServices::class, 'jenis_kerah_baju_id');
    }
}
