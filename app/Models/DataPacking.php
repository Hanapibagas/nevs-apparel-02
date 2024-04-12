<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPacking extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_order_id',
        'prass_id',
        'selesai',
        'deadline',
        'tanda_telah_mengerjakan',
    ];

    public function BarangMasukCs()
    {
        return $this->belongsTo(BarangMasukCostumerServices::class, 'no_order_id');
    }

    public function BarangMasukPress()
    {
        return $this->belongsTo(DataPressTagSize::class, 'prass_id');
    }
}
