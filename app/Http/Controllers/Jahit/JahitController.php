<?php

namespace App\Http\Controllers\Jahit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Laporan;
use App\Models\Jahit;
use Illuminate\Support\Facades\Auth;
use App\Models\BarangMasukCostumerServices;
use App\Models\BarangMasukDatalayout;
use PDF;
use Illuminate\Support\Facades\Storage;

class JahitController extends Controller
{
    public function getIndex()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = Jahit::with('BarangMasukCs', 'BarangMasukSortir', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukSortir', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->get();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = Jahit::with('BarangMasukCs', 'BarangMasukSortir', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukSortir', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->get();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = Jahit::with('BarangMasukCs', 'BarangMasukSortir', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukSortir', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->get();
        } else {
            $dataMasuk = Jahit::with('BarangMasukCs', 'BarangMasukSortir', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukSortir', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->get();
        }

        return view('component.Jahit.index', compact('dataMasuk'));
    }

    public function getInputLaporan($id)
    {
        $dataMasuk = Jahit::with('BarangMasukCs')->find($id);
        return view('component.Jahit.cerate-laporan-mesin', compact('dataMasuk'));
    }

    public function getInputLaporanSerah($id)
    {
        $dataMasuk = Jahit::with('BarangMasukCs')->find($id);
        return view('component.Jahit.cerate-laporan-mesin-terima', compact('dataMasuk'));
    }

    public function putLaporan(Request $request, $id)
    {
        $user = Auth::user();
        $dataMasuk = Jahit::find($id);

        if ($request->file('pola_badan')) {
            $fileGambar = $request->file('pola_badan')->store('serah-terima', 'public');
            if ($dataMasuk->pola_badan && file_exists(storage_path('app/public/' . $dataMasuk->pola_badan))) {
                Storage::delete('public/' . $dataMasuk->pola_badan);
                $fileGambar = $request->file('pola_badan')->store('serah-terima', 'public');
            }
        }

        if ($request->file('pola_badan') === null) {
            $fileGambar = $dataMasuk->pola_badan;
        }

        $dataMasuk->update([
            'penanggung_jawab_id' => $user->id,
            'leher' => $request->leher,
            'pola_badan' => $fileGambar,
            'serah_terima' => 1
        ]);

        return redirect()->route('getIndexJahit')->with('success', 'Selamat data yang anda input telah terkirim!');
    }

    public function putLaporanSerahTerima(Request $request, $id)
    {
        $user = Auth::user();
        $dataMasuk = Jahit::find($id);

        if ($request->file('foto')) {
            $fileGambar = $request->file('foto')->store('serah-terima', 'public');
            if ($dataMasuk->foto && file_exists(storage_path('app/public/' . $dataMasuk->foto))) {
                Storage::delete('public/' . $dataMasuk->foto);
                $fileGambar = $request->file('foto')->store('serah-terima', 'public');
            }
        }

        if ($request->file('foto') === null) {
            $fileGambar = $dataMasuk->foto;
        }

        $dataMasuk->update([
            'penanggung_jawab_id' => $user->id,
            'selesai' => Carbon::now(),
            'leher' => $request->leher,
            'foto' => $fileGambar,
            'serah_terima' => 1,
            'tanda_telah_mengerjakan' => 1
        ]);


        if ($dataMasuk) {
            $laporan = Laporan::where('jahit_id', $dataMasuk->id)->first();
            if ($laporan) {
                $laporan->update([
                    'status' => 'Finis',
                ]);
            }
        }

        return redirect()->route('getIndexFixJahit')->with('success', 'Selamat data yang anda input telah terkirim!');
    }

    public function getIndexFix()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = Jahit::with('BarangMasukCs', 'BarangMasukSortir', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukSortir', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->get();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = Jahit::with('BarangMasukCs', 'BarangMasukSortir', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukSortir', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->get();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = Jahit::with('BarangMasukCs', 'BarangMasukSortir', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukSortir', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->get();
        } else {
            $dataMasuk = Jahit::with('BarangMasukCs', 'BarangMasukSortir', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukSortir', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->get();
        }
        return view('component.Jahit.index-fix', compact('dataMasuk'));
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
