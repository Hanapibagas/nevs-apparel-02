<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasukMesin extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_masuk_disainer_id',
        'nama_mesin_id',
        'users_id',
        'nama_penanggung_jawab_mesin_ACC',
        'file',
        'status',
        'keterangan'
    ];

    public function BarangMasukDisainer()
    {
        return $this->belongsTo(BarangMasukDisainer::class, 'barang_masuk_disainer_id');
    }

    public function Users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function User()
    {
        return $this->belongsTo(User::class, 'nama_mesin_id');
    }
}
