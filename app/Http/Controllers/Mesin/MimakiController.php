<?php

namespace App\Http\Controllers\Mesin;

use App\Http\Controllers\Controller;
use App\Models\BarangMasukCostumerServices;
use App\Models\BarangMasukDatalayout;
use App\Models\BarangMasukMesin;
use App\Models\Laporan;
use App\Models\MesinMimaki;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class MimakiController extends Controller
{
    public function getIndexMimaki()
    {
        $user = Auth::user();
        $mesin = BarangMasukMesin::where('nama_mesin_id',  $user->id)
            ->with('Users', 'BarangMasukDisainer')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('component.Mesin.mesin-mimaki-pegawai.index', compact('mesin'));
    }

    public function putFeedBackToDisainer(Request $request, $id)
    {
        $user = Auth::user();

        $mesin = BarangMasukMesin::find($id);

        $mesin->update([
            'nama_penanggung_jawab_mesin_ACC' => $user->id,
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Selamat data yang input berhasil!');
    }

    public function getIndexDataMasukMimaki()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get();
        } else {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get();
        }

        return view('component.Mesin.data-masuk-mesin-mimaki.index', compact('dataMasuk'));
    }

    public function getInputLaporan($id)
    {
        $dataMasuk = MesinMimaki::with('BarangMasukCs')->find($id);
        return view('component.Mesin.data-masuk-mesin-mimaki.cerate-laporan-mesin', compact('dataMasuk'));
    }

    public function putLaporanMesin(Request $request, $id)
    {
        $user = Auth::user();
        $dataMasuk = MesinMimaki::with('BarangMasukCs')->find($id);

        if ($request->file('file_foto')) {
            $fileTangkapLayar = $request->file('file_foto')->store('file-laporan-mimaki', 'public');
            if ($dataMasuk->file_foto && file_exists(storage_path('app/public/' . $dataMasuk->file_foto))) {
                Storage::delete('public/' . $dataMasuk->file_foto);
                $fileTangkapLayar = $request->file('file_foto')->store('file-laporan-mimaki', 'public');
            }
        }

        if ($request->file('file_foto') === null) {
            $fileTangkapLayar = $dataMasuk->file_foto;
        }

        $dataMasuk->update([
            'penanggung_jawab_id' => $user->id,
            'selesai' => Carbon::now(),
            'file_foto' => $fileTangkapLayar,
            'tanda_telah_mengerjakan' => 1
        ]);

        if ($dataMasuk) {
            $laporan = Laporan::where('barang_masuk_mesin_mimaki_id', $dataMasuk->id)->first();
            if ($laporan) {
                $laporan->update([
                    'status' => 'Press Kain',
                ]);
            }
        }

        return redirect()->route('getIndexDataMasukMimakiFix')->with('success', 'Selamat data yang anda input telah terkirim!');
    }

    public function getIndexDataMasukMimakiFix()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get();
        } else {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get();
        }

        return view('component.Mesin.data-masuk-mesin-fix-mimaki.index', compact('dataMasuk'));
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
