<?php

namespace App\Http\Controllers\PressTag;

use App\Http\Controllers\Controller;
use App\Models\DataPressTagSize;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PressTagController extends Controller
{
    public function getIndex()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = DataPressTagSize::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->get();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = DataPressTagSize::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->get();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = DataPressTagSize::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->get();
        } else {
            $dataMasuk = DataPressTagSize::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->get();
        }

        return view('component.Press-Tag.index', compact('dataMasuk'));
    }

    public function getInputLaporan($id)
    {
        $dataMasuk = DataPressTagSize::with('BarangMasukCs')->find($id);
        return view('component.Press-Tag.cerate-laporan-mesin', compact('dataMasuk'));
    }

    public function putLaporan(Request $request, $id)
    {
        $user = Auth::user();
        $dataMasuk = DataPressTagSize::find($id);

        $dataMasuk->update([
            'penanggung_jawab_id' => $user->id,
            'selesai' => Carbon::now(),
            'tanda_telah_mengerjakan' => 1
        ]);

        if ($dataMasuk) {
            $laporan = Laporan::where('barang_masuk_pressTagSize_id', $dataMasuk->id)->first();
            if ($laporan) {
                $laporan->update([
                    'status' => 'Packing',
                ]);
            }
        }

        return redirect()->route('getIndexFixPressTag')->with('success', 'Selamat data yang anda input telah terkirim!');
    }

    public function getIndexFix()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = DataPressTagSize::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->get();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = DataPressTagSize::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->get();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = DataPressTagSize::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->get();
        } else {
            $dataMasuk = DataPressTagSize::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->get();
        }


        return view('component.Press-Tag.index-fix', compact('dataMasuk'));
    }
}
