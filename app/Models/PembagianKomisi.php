<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembagianKomisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'layout_id',
        'jumlah_komisi',
        'tanggal',
        'kota'
    ];

    public function BarangMasukCs()
    {
        return $this->belongsTo(BarangMasukCostumerServices::class, 'layout_id');
    }


    public function UserLayout()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
