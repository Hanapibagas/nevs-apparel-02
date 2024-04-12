<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cut extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_order_id',
        'penanggung_jawab_id',
        'press_kain_id',
        'deadline',
        'selesai',
        'foto',
        'tanda_telah_mengerjakan'
    ];

    public function BarangMasukCs()
    {
        return $this->belongsTo(BarangMasukCostumerServices::class, 'no_order_id');
    }

    public function BarangMasukPresKain()
    {
        return $this->belongsTo(DataPressKain::class, 'press_kain_id');
    }

    public function UserLaserCut()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab_id');
    }
}
