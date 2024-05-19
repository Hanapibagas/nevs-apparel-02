<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKainLayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'layout_id',
        'kertas_id',
        'daerah',
        'total_kertas',
    ];

    public function Kertas()
    {
        return $this->belongsTo(BahanCetak::class, 'kertas_id');
    }
}
