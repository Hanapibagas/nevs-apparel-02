<?php

namespace App\Http\Controllers\Cut;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cut;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;
use Carbon\Carbon;
use App\Models\BarangMasukCostumerServices;
use App\Models\BarangMasukDatalayout;
use PDF;
use Illuminate\Support\Facades\Storage;

class CutController extends Controller
{
    public function getindexDataMasukPress()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = Cut::with('BarangMasukCs', 'BarangMasukPresKain', 'UserLaserCut')
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->where('tanda_telah_mengerjakan', 0)
                ->get();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = Cut::with('BarangMasukCs', 'BarangMasukPresKain', 'UserLaserCut')
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->where('tanda_telah_menger`jakan', 0)
                ->get();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = Cut::with('BarangMasukCs', 'BarangMasukPresKain', 'UserLaserCut')
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->where('tanda_telah_mengerjakan', 0)
                ->get();
        } else {
            $dataMasuk = Cut::with('BarangMasukCs', 'BarangMasukPresKain', 'UserLaserCut')
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->where('tanda_telah_mengerjakan', 0)
                ->get();
        }

        // return response()->json($dataMasuk);

        return view('component.Cut.index', compact('dataMasuk'));
    }

    public function getInputLaporan($id)
    {
        $dataMasuk = Cut::with('BarangMasukCs')->find($id);
        return view('component.Cut.cerate-laporan-mesin', compact('dataMasuk'));
    }

    public function putLaporan(Request $request, $id)
    {
        $user = Auth::user();
        $dataMasuk = Cut::with('BarangMasukCs')->find($id);

        if ($request->file('foto')) {
            $fileGambar = $request->file('foto')->store('cut', 'public');
            if ($dataMasuk->foto && file_exists(storage_path('app/public/' . $dataMasuk->foto))) {
                Storage::delete('public/' . $dataMasuk->foto);
                $fileGambar = $request->file('foto')->store('cut', 'public');
            }
        }

        if ($request->file('foto') === null) {
            $fileGambar = $dataMasuk->foto;
        }

        $dataMasuk->update([
            'penanggung_jawab_id' => $user->id,
            'selesai' => Carbon::now(),
            'foto' => $fileGambar,
            'tanda_telah_mengerjakan' => 1
        ]);

        if ($dataMasuk) {
            $laporan = Laporan::where('cut_id', $dataMasuk->id)->first();
            if ($laporan) {
                $laporan->update([
                    'status' => 'Sortir',
                ]);
            }
        }

        return redirect()->route('getindexDataMasukCutFix')->with('success', 'Selamat data yang anda input telah terkirim!');
    }

    public function getindexDataMasukPressFix()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = Cut::with('BarangMasukCs', 'BarangMasukPresKain', 'UserLaserCut')
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->where('tanda_telah_mengerjakan', 1)
                ->get();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = Cut::with('BarangMasukCs', 'BarangMasukPresKain', 'UserLaserCut')
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->where('tanda_telah_mengerjakan', 1)
                ->get();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = Cut::with('BarangMasukCs', 'BarangMasukPresKain', 'UserLaserCut')
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->where('tanda_telah_mengerjakan', 1)
                ->get();
        } else {
            $dataMasuk = Cut::with('BarangMasukCs', 'BarangMasukPresKain', 'UserLaserCut')
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->where('tanda_telah_mengerjakan', 1)
                ->get();
        }

        return view('component.Cut.index-fix', compact('dataMasuk'));
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
