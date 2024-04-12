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
        'deadline',
        'selesai',
        'foto',
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
