<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolaLengan extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_kera',
        'status',
        'gambar',
    ];

    public function BarangMasukCostumerServices()
    {
        return $this->hasMany(BarangMasukCostumerServices::class, 'jenis_pola_lengan_id');
    }
}
