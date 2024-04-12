<?php

namespace App\Http\Controllers\Sortir;

use App\Http\Controllers\Controller;
use App\Models\DataSortir;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BarangMasukCostumerServices;
use App\Models\BarangMasukDatalayout;
use PDF;
use Illuminate\Support\Facades\Storage;

class SortirController extends Controller
{
    public function getIndex()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = DataSortir::with('BarangMasukCs', 'BarangMasukManualCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukManualCut', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->get();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = DataSortir::with('BarangMasukCs', 'BarangMasukManualCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukManualCut', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->get();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = DataSortir::with('BarangMasukCs', 'BarangMasukManualCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukManualCut', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->get();
        } else {
            $dataMasuk = DataSortir::with('BarangMasukCs', 'BarangMasukManualCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukManualCut', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->get();
        }

        return view('component.Sortir.index', compact('dataMasuk'));
    }

    public function getInputLaporan($id)
    {
        $dataMasuk = DataSortir::with('BarangMasukCs')->find($id);
        return view('component.Sortir.cerate-laporan-mesin', compact('dataMasuk'));
    }

    public function putLaporan(Request $request, $id)
    {
        $user = Auth::user();
        $dataMasuk = DataSortir::find($id);

        if ($request->file('foto')) {
            $fileGambar = $request->file('foto')->store('sortir', 'public');
            if ($dataMasuk->foto && file_exists(storage_path('app/public/' . $dataMasuk->foto))) {
                Storage::delete('public/' . $dataMasuk->foto);
                $fileGambar = $request->file('foto')->store('sortir', 'public');
            }
        }

        if ($request->file('foto') === null) {
            $fileGambar = $dataMasuk->foto;
        }

        $dataMasuk->update([
            'penanggung_jawab_id' => $user->id,
            'selesai' => Carbon::now(),
            'no_error' => $request->no_error,
            'panjang_kertas' => $request->panjang_kertas,
            'berat' => $request->berat,
            'bahan' => $request->bahan,
            'foto' =>  $fileGambar,
            'tanda_telah_mengerjakan' => 1
        ]);

        if ($dataMasuk) {
            $laporan = Laporan::where('barang_masuk_sortir_id', $dataMasuk->id)->first();
            if ($laporan) {
                $laporan->update([
                    'status' => 'Jahit',
                ]);
            }
        }

        return redirect()->route('getIndexFixSortir')->with('success', 'Selamat data yang anda input telah terkirim!');
    }

    public function getIndexFix()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = DataSortir::with('BarangMasukCs', 'BarangMasukManualCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukManualCut', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->get();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = DataSortir::with('BarangMasukCs', 'BarangMasukManualCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukManualCut', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->get();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = DataSortir::with('BarangMasukCs', 'BarangMasukManualCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukManualCut', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->get();
        } else {
            $dataMasuk = DataSortir::with('BarangMasukCs', 'BarangMasukManualCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukManualCut', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->get();
        }

        return view('component.Sortir.index-fix', compact('dataMasuk'));
    }

    public function cetakDataLk($id)
    {
        $dataLk = BarangMasukCostumerServices::with(
            'BarangMasukDisainer',
            'Users',
            'UsersOrder',
            'UsersLk',
            'KeraPlayer',
            'LenganPlayer',
            'CelanaPlayer',
            'KeraPelatih',
            'LenganPelatih',
            'CelanaPelatih',
            'KeraKiper',
            'LenganKiper',
            'CelanaKiper',
            'Kera1',
            'Lengan1',
            'Celana1'
        )->findOrFail($id);

        $layout = BarangMasukDatalayout::where('no_order_id', $dataLk->id)->first();

        // return response()->json($layout);
        view()->share('dataLk', $dataLk->BarangMasukDisainer->nama_tim);

        $pdf = PDF::loadview('component.Mesin.export-data-baju', compact('dataLk', 'layout'));
        $pdf->setPaper('A4', 'potrait');

        // return $pdf->stream('data-baju.pdf');
        $namaTimClean = preg_replace('/[^A-Za-z0-9\-]/', '', $dataLk->BarangMasukDisainer->nama_tim);
        return $pdf->stream($namaTimClean . '.pdf');

    }
}
