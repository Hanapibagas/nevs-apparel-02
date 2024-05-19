<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanCetakSortir extends Model
{
    use HasFactory;

    protected $fillable = [
        'press_kain_id',
        'kain_id',
        'daerah',
        'total_kain',
    ];

    public function Kain()
    {
        return $this->belongsTo(BahanKain::class, 'kain_id');
    }
}
