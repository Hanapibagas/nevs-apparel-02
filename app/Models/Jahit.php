<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jahit extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_order_id',
        'penanggung_jawab_id',
        'sortir_id',
        'deadline',
        'selesai',
        'leher',
        'pola_badan',
        'pola_celana',
        'foto',
        'serah_terima',
        'tanda_telah_mengerjakan'
    ];

    public function BarangMasukCs()
    {
        return $this->belongsTo(BarangMasukCostumerServices::class, 'no_order_id');
    }

    public function BarangMasukSortir()
    {
        return $this->belongsTo(DataSortir::class, 'sortir_id');
    }

    public function UserJahitBaju()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab_id');
    }
}
