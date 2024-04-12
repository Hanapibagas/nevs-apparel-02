<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_masuk_costumer_services_id',
        'barang_masuk_layout_id',
        'barang_masuk_mesin_atexco_id',
        'barang_masuk_mesin_mimaki_id',
        'barang_masuk_presskain_id',
        'cut_id',
        'barang_masuk_sortir_id',
        'jahit_id',
        'finis_id',
        'status'
    ];

    public function BarangMasukCs()
    {
        return $this->belongsTo(BarangMasukCostumerServices::class, 'barang_masuk_costumer_services_id');
    }

    public function BarangMasukLayout()
    {
        return $this->belongsTo(BarangMasukDatalayout::class, 'barang_masuk_layout_id');
    }

    public function BarangMasukMesinAtexco()
    {
        return $this->belongsTo(MesinAtexco::class, 'barang_masuk_mesin_atexco_id');
    }

    public function BarangMasukMesinMimaki()
    {
        return $this->belongsTo(MesinMimaki::class, 'barang_masuk_mesin_mimaki_id');
    }

    public function BarangMasukPressKain()
    {
        return $this->belongsTo(DataPressKain::class, 'barang_masuk_presskain_id');
    }

    public function BarangMasukLaserCut()
    {
        return $this->belongsTo(Cut::class, 'cut_id');
    }

    public function BarangMasukManualcut()
    {
        return $this->belongsTo(DataManualCut::class, 'barang_masuk_manualcut_id');
    }

    public function BarangMasukSortir()
    {
        return $this->belongsTo(DataSortir::class, 'barang_masuk_sortir_id');
    }

    public function BarangMasukJahitBaju()
    {
        return $this->belongsTo(Jahit::class, 'jahit_id');
    }

    public function BarangMasukJahitCelana()
    {
        return $this->belongsTo(DataJahitCelana::class, 'barang_masuk_jahit_celana_id');
    }

    public function BarangMasukPressTag()
    {
        return $this->belongsTo(Finish::class, 'finis_id');
    }

    public function BarangMasukPacking()
    {
        return $this->belongsTo(DataPacking::class, 'barang_masuk_packing_id');
    }
}
