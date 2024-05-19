<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPress extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_order_id',
        'barang_masuk_layout_id',
        'penanggung_jawab_id',
        'lk_player_id',
        'lk_pelatih_id',
        'lk_kiper_id',
        'lk_1_id',
        'lk_celana_player_id',
        'lk_celana_pelatih_id',
        'lk_celana_kiper_id',
        'lk_celana_1_id',
        'nama_mesin',
        'deadline',
        'selesai',
        'file_foto',
        'file_foto_pelatih',
        'file_foto_kiper',
        'file_foto_1',
        'file_foto_celana_player',
        'file_foto_celana_pelatih',
        'file_foto_celana_kiper',
        'file_foto_celana_1',
        'keterangan',
        'keterangan2',
        'keterangan3',
        'keterangan4',
        'keterangan5',
        'keterangan6',
        'keterangan7',
        'keterangan8',
        'tanda_telah_mengerjakan',
    ];

    public function BarangMasukCs()
    {
        return $this->belongsTo(BarangMasukCostumerServices::class, 'no_order_id');
    }

    public function UserMesinAtexco()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab_id');
    }

    public function BarangMasukLayout()
    {
        return $this->belongsTo(BarangMasukDatalayout::class, 'barang_masuk_layout_id');
    }
}
