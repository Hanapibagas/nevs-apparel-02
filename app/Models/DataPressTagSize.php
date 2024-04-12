<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPressTagSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_order_id',
        'jahit_baju_id',
        'jahit_celana_id',
        'deadline',
        'selesai',
        'tanda_telah_mengerjakan',
    ];

    public function BarangMasukCs()
    {
        return $this->belongsTo(BarangMasukCostumerServices::class, 'no_order_id');
    }

    public function BarangMasukJahitCelana()
    {
        return $this->belongsTo(DataJahitCelana::class, 'jahit_celana_id');
    }
}
