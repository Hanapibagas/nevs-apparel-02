<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasukDatalayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_layout_id',
        'no_order_id',
        'deadline',
        'panjang_kertas',
        'poly',
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
