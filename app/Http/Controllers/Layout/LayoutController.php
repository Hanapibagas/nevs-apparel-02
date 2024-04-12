<?php

namespace App\Http\Controllers\Layout;

use App\Http\Controllers\Controller;
use App\Models\BarangMasukCostumerServices;
use App\Models\BarangMasukDatalayout;
use App\Models\Laporan;
use App\Models\LaporanLkLayout;
use App\Models\PembagianKomisi;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class LayoutController extends Controller
{
    public function getIndexLkCs()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $oderCs = BarangMasukDatalayout::with('UserLayout', 'BarangMasukCsLK', 'BarangMasukCsLK.UsersOrder', 'BarangMasukCsLK.BarangMasukDisainer')
                ->where('users_layout_id', $user->id)
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukCsLK', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->asal_kota == 'jakarta') {
            $oderCs = BarangMasukDatalayout::with('UserLayout', 'BarangMasukCsLK', 'BarangMasukCsLK.UsersOrder', 'BarangMasukCsLK.BarangMasukDisainer')
                ->where('users_layout_id', $user->id)
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukCsLK', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->asal_kota == 'bandung') {
            $oderCs = BarangMasukDatalayout::with('UserLayout', 'BarangMasukCsLK', 'BarangMasukCsLK.UsersOrder', 'BarangMasukCsLK.BarangMasukDisainer')
                ->where('users_layout_id', $user->id)
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukCsLK', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $oderCs = BarangMasukDatalayout::with('UserLayout', 'BarangMasukCsLK', 'BarangMasukCsLK.UsersOrder', 'BarangMasukCsLK.BarangMasukDisainer')
                ->where('users_layout_id', $user->id)
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukCsLK', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // return response()->json($oderCs);
        return view('component.Layout.layout-lk-pegawai.index', compact('oderCs'));
    }

    public function getIndexLaporanLk()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $oderCs = BarangMasukDatalayout::with('UserLayout', 'BarangMasukCsLK', 'BarangMasukCsLK.UsersOrder', 'BarangMasukCsLK.BarangMasukDisainer')
                ->where('users_layout_id', $user->id)
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukCsLK', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->asal_kota == 'jakarta') {
            $oderCs = BarangMasukDatalayout::with('UserLayout', 'BarangMasukCsLK', 'BarangMasukCsLK.UsersOrder', 'BarangMasukCsLK.BarangMasukDisainer')
                ->where('users_layout_id', $user->id)
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukCsLK', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->asal_kota == 'bandung') {
            $oderCs = BarangMasukDatalayout::with('UserLayout', 'BarangMasukCsLK', 'BarangMasukCsLK.UsersOrder', 'BarangMasukCsLK.BarangMasukDisainer')
                ->where('users_layout_id', $user->id)
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukCsLK', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $oderCs = BarangMasukDatalayout::with('UserLayout', 'BarangMasukCsLK', 'BarangMasukCsLK.UsersOrder', 'BarangMasukCsLK.BarangMasukDisainer')
                ->where('users_layout_id', $user->id)
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukCsLK', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('component.Layout.laporan-layout.index', compact('oderCs'));
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

        // return response()->json($dataLk);
        view()->share('dataLk', $dataLk->BarangMasukDisainer->nama_tim);

        $pdf = PDF::loadview('component.Cs.costumer-service-lk-pegawai.export-data-baju', compact('dataLk'));
        $pdf->setPaper('A4', 'potrait');

        return $pdf->stream($dataLk->BarangMasukDisainer->nama_tim);
    }

    public function createLaporanLk($id)
    {
        $dataLk = BarangMasukDatalayout::with('BarangMasukCsLK')->find($id);

        return view('component.Layout.layout-lk-pegawai.cerate-laporan-lk', compact('dataLk'));
    }

    public function putLaporanLs(Request $request, $id)
    {
        $user = Auth::user();
        $dataLk = BarangMasukDatalayout::with('BarangMasukCsLK')->find($id);

        $validator = FacadesValidator::make($request->all(), [
            'file_corel_layout' => 'required|file',
            'file_tangkap_layar' => 'required|file',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'File Corel Disainer harus diisi!');
        }

        if ($request->file('file_corel_layout')) {
            $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout', 'public');
            if ($dataLk->file_corel_layout && file_exists(storage_path('app/public/' . $dataLk->file_corel_layout))) {
                Storage::delete('public/' . $dataLk->file_corel_layout);
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout', 'public');
            }
        }
        if ($request->file('file_tangkap_layar')) {
            $fileTangkapLayar = $request->file('file_tangkap_layar')->store('file-tangkap-layout', 'public');
            if ($dataLk->file_tangkap_layar && file_exists(storage_path('app/public/' . $dataLk->file_tangkap_layar))) {
                Storage::delete('public/' . $dataLk->file_tangkap_layar);
                $fileTangkapLayar = $request->file('file_tangkap_layar')->store('file-tangkap-layout', 'public');
            }
        }

        if ($request->file('file_tangkap_layar') === null) {
            $fileTangkapLayar = $dataLk->file_tangkap_layar;
        }

        if ($request->file('file_corel_layout') === null) {
            $filebajuplayer = $dataLk->file_corel_layout;
        }

        $dataLk->update([
            'selesai' => Carbon::now(),
            'panjang_kertas' => $request->panjang_kertas,
            'poly' => $request->poly,
            'file_corel_layout' => $filebajuplayer,
            'file_tangkap_layar' => $fileTangkapLayar,
            'tanda_telah_mengerjakan' => 1,
        ]);


        if (
            $dataLk !== null &&
            isset($dataLk->BarangMasukCsLK) &&
            $dataLk->BarangMasukCsLK !== null &&
            isset($dataLk->BarangMasukCsLK->LenganPlayer) &&
            $dataLk->BarangMasukCsLK->LenganPlayer !== null &&
            isset($dataLk->BarangMasukCsLK->LenganPlayer->status)
        ) {
            $dataKomisi1 = $dataLk->BarangMasukCsLK->LenganPlayer->status == 1;
        } else {
            $dataKomisi1 = false;
        }

        if (
            $dataLk !== null &&
            isset($dataLk->BarangMasukCsLK) &&
            $dataLk->BarangMasukCsLK !== null &&
            isset($dataLk->BarangMasukCsLK->LenganPelatih) &&
            $dataLk->BarangMasukCsLK->LenganPelatih !== null &&
            isset($dataLk->BarangMasukCsLK->LenganPelatih->status)
        ) {
            $dataKomisi2 = $dataLk->BarangMasukCsLK->LenganPelatih->status == 1;
        } else {
            $dataKomisi2 = false;
        }

        if (
            $dataLk !== null &&
            isset($dataLk->BarangMasukCsLK) &&
            $dataLk->BarangMasukCsLK !== null &&
            isset($dataLk->BarangMasukCsLK->LenganKiper) &&
            $dataLk->BarangMasukCsLK->LenganKiper !== null &&
            isset($dataLk->BarangMasukCsLK->LenganKiper->status)
        ) {
            $dataKomisi3 = $dataLk->BarangMasukCsLK->LenganKiper->status == 1;
        } else {
            $dataKomisi3 = false;
        }

        if (
            $dataLk !== null &&
            isset($dataLk->BarangMasukCsLK) &&
            $dataLk->BarangMasukCsLK !== null &&
            isset($dataLk->BarangMasukCsLK->Lengan1) &&
            $dataLk->BarangMasukCsLK->Lengan1 !== null &&
            isset($dataLk->BarangMasukCsLK->Lengan1->status)
        ) {
            $dataKomisi4 = $dataLk->BarangMasukCsLK->Lengan1->status == 1;
        } else {
            $dataKomisi4 = false;
        }

        if (
            $dataLk !== null &&
            isset($dataLk->BarangMasukCsLK) &&
            $dataLk->BarangMasukCsLK !== null &&
            isset($dataLk->BarangMasukCsLK->CelanaPlayer) &&
            $dataLk->BarangMasukCsLK->CelanaPlayer !== null &&
            isset($dataLk->BarangMasukCsLK->CelanaPlayer->status)
        ) {
            $dataKomisi5 = $dataLk->BarangMasukCsLK->CelanaPlayer->status == 1;
        } else {
            $dataKomisi5 = false;
        }

        if (
            $dataLk !== null &&
            isset($dataLk->BarangMasukCsLK) &&
            $dataLk->BarangMasukCsLK !== null &&
            isset($dataLk->BarangMasukCsLK->CelanaPelatih) &&
            $dataLk->BarangMasukCsLK->CelanaPelatih !== null &&
            isset($dataLk->BarangMasukCsLK->CelanaPelatih->status)
        ) {
            $dataKomisi6 = $dataLk->BarangMasukCsLK->CelanaPelatih->status == 1;
        } else {
            $dataKomisi6 = false;
        }

        if (
            $dataLk !== null &&
            isset($dataLk->BarangMasukCsLK) &&
            $dataLk->BarangMasukCsLK !== null &&
            isset($dataLk->BarangMasukCsLK->CelanaKiper) &&
            $dataLk->BarangMasukCsLK->CelanaKiper !== null &&
            isset($dataLk->BarangMasukCsLK->CelanaKiper->status)
        ) {
            $dataKomisi7 = $dataLk->BarangMasukCsLK->CelanaKiper->status == 1;
        } else {
            $dataKomisi7 = false;
        }

        if (
            $dataLk !== null &&
            isset($dataLk->BarangMasukCsLK) &&
            $dataLk->BarangMasukCsLK !== null &&
            isset($dataLk->BarangMasukCsLK->Celana1) &&
            $dataLk->BarangMasukCsLK->Celana1 !== null &&
            isset($dataLk->BarangMasukCsLK->Celana1->status)
        ) {
            $dataKomisi8 = $dataLk->BarangMasukCsLK->Celana1->status == 1;
        } else {
            $dataKomisi8 = false;
        }

        if ($dataKomisi1 == 1) {
            $dataBajuPlayer = $dataLk->BarangMasukCsLK->total_baju_player;
        } elseif ($dataKomisi1 == 0) {
            $dataBajuPlayer = 0;
        }

        if ($dataKomisi2 == 1) {
            $dataBajuPelatih = $dataLk->BarangMasukCsLK->total_baju_pelatih;
        } elseif ($dataKomisi2 == 0) {
            $dataBajuPelatih = 0;
        }

        if ($dataKomisi3 == 1) {
            $dataBajuKiper = $dataLk->BarangMasukCsLK->total_baju_kiper;
        } elseif ($dataKomisi3 == 0) {
            $dataBajuKiper = 0;
        }

        if ($dataKomisi4 == 1) {
            $dataBaju1 = $dataLk->BarangMasukCsLK->total_baju_1;
        } elseif ($dataKomisi4 == 0) {
            $dataBaju1 = 0;
        }

        if ($dataKomisi5 == 1) {
            $dataCelanaPlayer = $dataLk->BarangMasukCsLK->total_celana_player;
        } elseif ($dataKomisi5 == 0) {
            $dataCelanaPlayer = 0;
        }

        if ($dataKomisi6 == 1) {
            $dataCelanaPelatih = $dataLk->BarangMasukCsLK->total_celana_pelatih;
        } elseif ($dataKomisi6 == 0) {
            $dataCelanaPelatih = 0;
        }

        if ($dataKomisi7 == 1) {
            $dataCelanaKiper = $dataLk->BarangMasukCsLK->total_celana_kiper;
        } elseif ($dataKomisi7 == 0) {
            $dataCelanaKiper = 0;
        }

        if ($dataKomisi8 == 1) {
            $dataCelana1 = $dataLk->BarangMasukCsLK->total_celana_1;
        } elseif ($dataKomisi8 == 0) {
            $dataCelana1 = 0;
        }

        $deadline = Carbon::parse($dataLk->deadline);
        $selesai = Carbon::parse($dataLk->selesai);

        if ($selesai->lt($deadline)) {
            $selisihHari = $selesai->diffInDaysFiltered(function (Carbon $date) use ($deadline) {
                return $date->lte($deadline);
            });
            $totalBarang = $dataBajuPlayer + $dataBajuPelatih + $dataBajuKiper + $dataBaju1 +
                $dataCelanaPlayer + $dataCelanaPelatih + $dataCelanaKiper + $dataCelana1;
            $hargaPerBarang = 750;
            $totalHarga = $totalBarang * $hargaPerBarang;
            $keterangan = "- $selisihHari";
        } else {
            $selisihHari = $selesai->diffInDays($deadline);
            if ($selisihHari == 0) {
                $totalBarang = $dataBajuPlayer + $dataBajuPelatih + $dataBajuKiper + $dataBaju1 +
                    $dataCelanaPlayer + $dataCelanaPelatih + $dataCelanaKiper + $dataCelana1;
                $hargaPerBarang = 750;
                $totalHarga = $totalBarang * $hargaPerBarang;
                $keterangan = "- $selisihHari";
            } else {
                $keterangan = "+ $selisihHari";
            }
        }


        if ($keterangan == "- $selisihHari") {
            PembagianKomisi::create([
                'user_id' => $user->id,
                'layout_id' => $dataLk->id,
                'tanggal' => Carbon::now(),
                'jumlah_komisi' => $totalHarga,
                'kota' => $dataLk->BarangMasukCsLK->kota_produksi,
            ]);
        } else {
            PembagianKomisi::create([
                'user_id' => $user->id,
                'layout_id' => $dataLk->id,
                'tanggal' => Carbon::now(),
                'jumlah_komisi' => "0",
                'kota' => $dataLk->BarangMasukCsLK->kota_produksi,
            ]);
        }

        if ($dataLk->BarangMasukCsLK->jenis_mesin == 'mimaki') {
            $laporan = Laporan::where('barang_masuk_layout_id', $dataLk->id)->first();
            if ($laporan) {
                $laporan->update([
                    'status' => 'Mesin Mimaki',
                ]);
            }
        } elseif ($dataLk->BarangMasukCsLK->jenis_mesin == 'atexco') {
            $laporan = Laporan::where('barang_masuk_layout_id', $dataLk->id)->first();
            if ($laporan) {
                $laporan->update([
                    'status' => 'Mesin Atexco',
                ]);
            }
        }

        return redirect()->route('getIndexLkLayoutPegawai')->with('success', 'Selamat data yang anda input telah terkirim!');
    }
}
