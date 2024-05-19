<?php

namespace App\Http\Controllers\Layout;

use App\Http\Controllers\Controller;
use App\Models\BahanCetak;
use App\Models\BarangMasukCostumerServices;
use App\Models\BarangMasukDatalayout;
use App\Models\GambarTangkapLayar;
use App\Models\Laporan;
use App\Models\LaporanKainLayout;
use App\Models\LaporanLkLayout;
use App\Models\PembagianKomisi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $oderCs = $oderCs->values()->all();
        } elseif ($user->asal_kota == 'jakarta') {
            $oderCs = BarangMasukDatalayout::with('UserLayout', 'BarangMasukCsLK', 'BarangMasukCsLK.UsersOrder', 'BarangMasukCsLK.BarangMasukDisainer')
                ->where('users_layout_id', $user->id)
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukCsLK', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $oderCs = $oderCs->values()->all();
        } elseif ($user->asal_kota == 'bandung') {
            $oderCs = BarangMasukDatalayout::with('UserLayout', 'BarangMasukCsLK', 'BarangMasukCsLK.UsersOrder', 'BarangMasukCsLK.BarangMasukDisainer')
                ->where('users_layout_id', $user->id)
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukCsLK', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $oderCs = $oderCs->values()->all();
        } else {
            $oderCs = BarangMasukDatalayout::with('UserLayout', 'BarangMasukCsLK', 'BarangMasukCsLK.UsersOrder', 'BarangMasukCsLK.BarangMasukDisainer')
                ->where('users_layout_id', $user->id)
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukCsLK', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $oderCs = $oderCs->values()->all();
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
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $oderCs = $oderCs->values()->all();
        } elseif ($user->asal_kota == 'jakarta') {
            $oderCs = BarangMasukDatalayout::with('UserLayout', 'BarangMasukCsLK', 'BarangMasukCsLK.UsersOrder', 'BarangMasukCsLK.BarangMasukDisainer')
                ->where('users_layout_id', $user->id)
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukCsLK', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $oderCs = $oderCs->values()->all();
        } elseif ($user->asal_kota == 'bandung') {
            $oderCs = BarangMasukDatalayout::with('UserLayout', 'BarangMasukCsLK', 'BarangMasukCsLK.UsersOrder', 'BarangMasukCsLK.BarangMasukDisainer')
                ->where('users_layout_id', $user->id)
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukCsLK', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $oderCs = $oderCs->values()->all();
        } else {
            $oderCs = BarangMasukDatalayout::with('UserLayout', 'BarangMasukCsLK', 'BarangMasukCsLK.UsersOrder', 'BarangMasukCsLK.BarangMasukDisainer')
                ->where('users_layout_id', $user->id)
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukCsLK', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $oderCs = $oderCs->values()->all();
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
            'Gambar',

            'BarangMasukCostumerServicesLkPlyer',
            'BarangMasukCostumerServicesLkPlyer.LenganPlayer',
            'BarangMasukCostumerServicesLkPlyer.KeraPlayer',

            'BarangMasukCostumerServicesLkPelatih',
            'BarangMasukCostumerServicesLkPelatih.LenganPelatih',
            'BarangMasukCostumerServicesLkPelatih.KeraPelatih',

            'BarangMasukCostumerServicesLkKiper',
            'BarangMasukCostumerServicesLkKiper.LenganKiper',
            'BarangMasukCostumerServicesLkKiper.KeraKiper',

            'BarangMasukCostumerServicesLk1',
            'BarangMasukCostumerServicesLk1.Lengan1',
            'BarangMasukCostumerServicesLk1.Kera1',

            'BarangMasukCostumerServicesLkCelanaPlyer',
            'BarangMasukCostumerServicesLkCelanaPlyer.KeraCelanaPlayer',
            'BarangMasukCostumerServicesLkCelanaPlyer.CelanaCelanaPlayer',

            'BarangMasukCostumerServicesLkCelanaPelatih',
            'BarangMasukCostumerServicesLkCelanaPelatih.KeraCelanapelatih',
            'BarangMasukCostumerServicesLkCelanaPelatih.CelanaCelanapelatih',

            'BarangMasukCostumerServicesLkCelanaKiper',
            'BarangMasukCostumerServicesLkCelanaKiper.CelanaCealanaKiper',
            'BarangMasukCostumerServicesLkCelanaKiper.KeraCealanaKiper',

            'BarangMasukCostumerServicesLkCelana1',
            'BarangMasukCostumerServicesLkCelana1.KeraCealana1',
            'BarangMasukCostumerServicesLkCelana1.CelanaCelana1',
        )->findOrFail($id);

        // return response()->json($dataLk);
        view()->share('dataLk', $dataLk->BarangMasukDisainer->nama_tim);

        $pdf = PDF::loadview('component.Cs.costumer-service-lk-pegawai.export-data-baju', compact('dataLk'));
        $pdf->setPaper('A4', 'potrait');

        return $pdf->stream($dataLk->BarangMasukDisainer->nama_tim);
    }

    public function createLaporanLk($id)
    {
        // return response()->json($id);
        $dataLk = BarangMasukDatalayout::where('barang_masuk_id', $id)->with('BarangMasukCsLK')->get();

        $bahanKertas = BahanCetak::all();
        $formattedData = [];

        foreach ($dataLk as $item) {
            if ($item->lk_player_id) {
                $formattedData['player'][] = [
                    'id' => $item->id,
                    'panjang_kertas_player' => $item->panjang_kertas_player,
                    'poly_player' => $item->poly_player,
                    'file_corel_layout' => $item->file_corel_layout,
                    'file_tangkap_layar_player' => $item->file_tangkap_layar_player
                ];
            } elseif ($item->lk_pelatih_id) {
                $formattedData['pelatih'][] = [
                    'id' => $item->id,
                    'panjang_kertas_pelatih' => $item->panjang_kertas_pelatih,
                    'poly_pelatih' => $item->poly_pelatih,
                    'file_corel_layout' => $item->file_corel_layout,
                    'file_tangkap_layar_pelatih' => $item->file_tangkap_layar_pelatih,
                ];
            } elseif ($item->lk_kiper_id) {
                $formattedData['kiper'][] = [
                    'id' => $item->id,
                    'panjang_kertas_kiper' => $item->panjang_kertas_kiper,
                    'poly_kiper' => $item->poly_kiper,
                    'file_corel_layout' => $item->file_corel_layout,
                    'file_tangkap_layar_kiper' => $item->file_tangkap_layar_kiper
                ];
            } elseif ($item->lk_1_id) {
                $formattedData['lk_1'][] = [
                    'id' => $item->id,
                    'panjang_kertas_1' => $item->panjang_kertas_1,
                    'poly_1' => $item->poly_1,
                    'file_corel_layout' => $item->file_corel_layout,
                    'file_tangkap_layar_1' => $item->file_tangkap_layar_1,
                ];
            } elseif ($item->lk_celana_player_id) {
                $formattedData['celana_player'][] = [
                    'id' => $item->id,
                    'panjang_kertas_celana_player' => $item->panjang_kertas_celana_player,
                    'poly_celana_player' => $item->poly_celana_player,
                    'file_corel_layout' => $item->file_corel_layout,
                    'file_tangkap_layar_celana_pelayer' => $item->file_tangkap_layar_celana_pelayer,
                ];
            } elseif ($item->lk_celana_pelatih_id) {
                $formattedData['celana_pelatih'][] = [
                    'id' => $item->id,
                    'panjang_kertas_celana_pelatih' => $item->panjang_kertas_celana_pelatih,
                    'poly_celana_pelatih' => $item->poly_celana_pelatih,
                    'file_corel_layout' => $item->file_corel_layout,
                    'file_tangkap_layar_celana_pelatih' => $item->file_tangkap_layar_celana_pelatih
                ];
            } elseif ($item->lk_celana_kiper_id) {
                $formattedData['celana_kiper'][] = [
                    'id' => $item->id,
                    'panjang_kertas_celana_kiper' => $item->panjang_kertas_celana_kiper,
                    'poly_celana_kiper' => $item->poly_celana_kiper,
                    'file_corel_layout' => $item->file_corel_layout,
                    'file_tangkap_layar_celana_kiper' => $item->file_tangkap_layar_celana_kiper
                ];
            } elseif ($item->lk_celana_1_id) {
                $formattedData['celana_1'][] = [
                    'id' => $item->id,
                    'panjang_kertas_celana_1' => $item->panjang_kertas_celana_1,
                    'poly_celana_1' => $item->poly_celana_1,
                    'file_corel_layout' => $item->file_corel_layout,
                    'file_tangkap_layar_celana_1' => $item->file_tangkap_layar_celana_1,
                ];
            }
        }

        // return response()->json($formattedData);

        return view('component.Layout.layout-lk-pegawai.cerate-laporan-lk', compact('dataLk', 'formattedData', 'bahanKertas'));
    }

    public function putLaporanLs(Request $request)
    {
        // return response()->json($request->all());
        $user = Auth::user();

        if ($request->player_id) {

            $dataPlayer = BarangMasukDatalayout::join('lk_players', 'lk_players.id', '=', 'barang_masuk_datalayouts.lk_player_id')
                ->join('barang_masuk_costumer_services', 'barang_masuk_costumer_services.id', '=', 'barang_masuk_datalayouts.barang_masuk_id')
                ->leftJoin('pola_lengans', 'pola_lengans.id', '=', 'lk_players.pola_lengan_player_id')
                ->select('barang_masuk_datalayouts.*', 'lk_players.*', 'pola_lengans.*', 'barang_masuk_costumer_services.*')
                ->findOrFail($request->player_id);

            if ($request->file('file_tangkap_layar_player')) {
                $fileTangkapLayarPlayer = $request->file('file_tangkap_layar_player')->store('file-tangkap-layout-player', 'public');
            }

            if ($request->file('file_tangkap_layar_pelatih')) {
                $fileTangkapLayarPelatih = $request->file('file_tangkap_layar_pelatih')->store('file-tangkap-layout-pelatih', 'public');
            } else {
                $fileTangkapLayarPelatih = null;
            }

            if ($request->file('file_tangkap_layar_kiper')) {
                $fileTangkapLayarKiper = $request->file('file_tangkap_layar_kiper')->store('file-tangkap-layout-kiper', 'public');
            } else {
                $fileTangkapLayarKiper = null;
            }

            if ($request->file('file_tangkap_layar_1')) {
                $fileTangkapLayar1 = $request->file('file_tangkap_layar_1')->store('file-tangkap-layout-1', 'public');
            } else {
                $fileTangkapLayar1 = null;
            }

            if ($request->file('file_tangkap_layar_celana_pelayer')) {
                $fileTangkapLayarCelanaPlayer = $request->file('file_tangkap_layar_celana_pelayer')->store('file-tangkap-layout-celana-player', 'public');
            } else {
                $fileTangkapLayarCelanaPlayer = null;
            }

            if ($request->file('file_tangkap_layar_celana_pelatih')) {
                $fileTangkapLayarCelanaPelatih = $request->file('file_tangkap_layar_celana_pelatih')->store('file-tangkap-layout-celana-pelatih', 'public');
            } else {
                $fileTangkapLayarCelanaPelatih = null;
            }

            if ($request->file('file_tangkap_layar_celana_kiper')) {
                $fileTangkapLayarCelanaKiper = $request->file('file_tangkap_layar_celana_kiper')->store('file-tangkap-layout-celana-kiper', 'public');
            } else {
                $fileTangkapLayarCelanaKiper = null;
            }

            if ($request->file('file_tangkap_layar_celana_1')) {
                $fileTangkapLayarCelana1 = $request->file('file_tangkap_layar_celana_1')->store('file-tangkap-layout-celana-1', 'public');
            } else {
                $fileTangkapLayarCelana1 = null;
            }

            $test = GambarTangkapLayar::create([
                'barang_masuk_datalayouts_id' => $request->player_id,
                'file_tangkap_layar_player' => $fileTangkapLayarPlayer,
                'file_tangkap_layar_pelatih' => $fileTangkapLayarPelatih,
                'file_tangkap_layar_kiper' => $fileTangkapLayarKiper,
                'file_tangkap_layar_1' => $fileTangkapLayar1,
                'file_tangkap_layar_celana_pelayer' => $fileTangkapLayarCelanaPlayer,
                'file_tangkap_layar_celana_pelatih' => $fileTangkapLayarCelanaPelatih,
                'file_tangkap_layar_celana_kiper' => $fileTangkapLayarCelanaKiper,
                'file_tangkap_layar_celana_1' => $fileTangkapLayarCelana1,
            ]);

            $dataUpdate = BarangMasukDatalayout::with('BarangMasukCsLK')->findOrFail($request->player_id);

            $resulTotalBaju = $dataPlayer->total_baju_player;
            $resulSatatusBaju = $dataPlayer->status;

            if ($request->file('file_corel_layout')) {
                $validator = Validator::make($request->all(), [
                    'file_corel_layout' => 'file|max:5120'
                ]);

                if ($validator->fails()) {
                    return back()->with('error', 'Mohon maaf ukuran file yang anda berikan sangat besar mohon tinggalkan pesan keterangan saja');
                }

                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-player', 'public');
                if ($dataUpdate->file_corel_layout && file_exists(storage_path('app/public/' . $dataUpdate->file_corel_layout))) {
                    Storage::delete('public/' . $dataUpdate->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-player', 'public');
                }
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataUpdate->update([
                'selesai' => $selesaiTime,

                'panjang_kertas_palayer' => $request->panjang_kertas_palayer,
                'poly_player' => $request->poly_player,
                'keterangan1' => $request->keterangan1,
                'kertas_id' => $request->kertas_id,

                'file_corel_layout' => $filebajuplayer ?? $dataUpdate->file_corel_layout,
                'tanda_telah_mengerjakan' => 1,
            ]);

            $d = LaporanKainLayout::create([
                'layout_id' => $dataUpdate->id,
                'kertas_id' => $request->kertas_id,
                'daerah' => $dataUpdate->BarangMasukCsLK->kota_produksi,
                'total_kertas' => $request->panjang_kertas_palayer,
            ]);
        } else {
            $resulTotalBaju = 0;
            $resulSatatusBaju = null;
        }

        if ($request->pelatih_id) {
            $dataPelatih = BarangMasukDatalayout::join('lk_pelatihs', 'lk_pelatihs.id', '=', 'barang_masuk_datalayouts.lk_pelatih_id')
                ->leftJoin('pola_lengans', 'pola_lengans.id', '=', 'lk_pelatihs.pola_lengan_pelatih_id')
                ->select('barang_masuk_datalayouts.*', 'lk_pelatihs.*', 'pola_lengans.*')
                ->findOrFail($request->pelatih_id);

            $resulTotalBajuPlatih = $dataPelatih->total_baju_pelatih;
            $resulSatatusBajuPlatih = $dataPelatih->status;

            $dataUpdatePelatih = BarangMasukDatalayout::findOrFail($request->pelatih_id);
            if ($request->file('file_corel_layout2')) {
                $validator = Validator::make($request->all(), [
                    'file_corel_layout2' => 'file|max:5120'
                ]);

                if ($validator->fails()) {
                    return back()->with('error', 'Mohon maaf ukuran file yang anda berikan sangat besar mohon tinggalkan pesan keterangan saja');
                }

                $filebajuplayer = $request->file('file_corel_layout2')->store('file-dari-layout-pelatih', 'public');
                if ($dataUpdatePelatih->file_corel_layout2 && file_exists(storage_path('app/public/' . $dataUpdatePelatih->file_corel_layout2))) {
                    Storage::delete('public/' . $dataUpdatePelatih->file_corel_layout2);
                    $filebajuplayer = $request->file('file_corel_layout2')->store('file-dari-layout-pelatih', 'public');
                }
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataUpdatePelatih->update([
                'selesai' => $selesaiTime,

                'panjang_kertas_pelatih' => $request->panjang_kertas_pelatih,
                'poly_pelatih' => $request->poly_pelatih,
                'keterangan2' => $request->keterangan2,
                'kertas_id' => $request->kertas_id,

                'file_corel_layout2' => $filebajuplayer ?? $dataUpdatePelatih->file_corel_layout2,
                'tanda_telah_mengerjakan' => 1,
            ]);
            LaporanKainLayout::create([
                'layout_id' => $dataUpdatePelatih->id,
                'kertas_id' => $request->kertas_id,
                'daerah' => $dataUpdatePelatih->BarangMasukCsLK->kota_produksi,
                'total_kertas' => $request->panjang_kertas_pelatih,
            ]);
        } else {
            $resulTotalBajuPlatih = 0;
            $resulSatatusBajuPlatih = null;
        }

        if ($request->kiper_id) {
            $dataKiper = BarangMasukDatalayout::join('lk_kipers', 'lk_kipers.id', '=', 'barang_masuk_datalayouts.lk_kiper_id')
                ->leftJoin('pola_lengans', 'pola_lengans.id', '=', 'lk_kipers.pola_lengan_kiper_id')
                ->select('barang_masuk_datalayouts.*', 'lk_kipers.*', 'pola_lengans.*')
                ->findOrFail($request->kiper_id);

            $resulTotalBajuKiper = $dataKiper->total_baju_kiper;
            $resulSatatusBajuKiper = $dataKiper->status;

            $dataUpdateKiper = BarangMasukDatalayout::findOrFail($request->kiper_id);

            if ($request->file('file_corel_layout3')) {
                $validator = Validator::make($request->all(), [
                    'file_corel_layout3' => 'file|max:5120'
                ]);

                if ($validator->fails()) {
                    return back()->with('error', 'Mohon maaf ukuran file yang anda berikan sangat besar mohon tinggalkan pesan keterangan saja');
                }
                $filebajuplayer = $request->file('file_corel_layout3')->store('file-dari-layout-kiper', 'public');
                if ($dataUpdateKiper->file_corel_layout3 && file_exists(storage_path('app/public/' . $dataUpdateKiper->file_corel_layout3))) {
                    Storage::delete('public/' . $dataUpdateKiper->file_corel_layout3);
                    $filebajuplayer = $request->file('file_corel_layout3')->store('file-dari-layout', 'public');
                }
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataUpdateKiper->update([
                'selesai' => $selesaiTime,

                'panjang_kertas_kiper' => $request->panjang_kertas_kiper,
                'poly_kiper' => $request->poly_kiper,
                'keterangan3' => $request->keterangan3,
                'kertas_id' => $request->kertas_id,

                'file_corel_layout3' => $filebajuplayer ?? $dataUpdateKiper->file_corel_layout3,
                'tanda_telah_mengerjakan' => 1,
            ]);
            LaporanKainLayout::create([
                'layout_id' => $dataUpdateKiper->id,
                'kertas_id' => $request->kertas_id,
                'daerah' => $dataUpdateKiper->BarangMasukCsLK->kota_produksi,
                'total_kertas' => $request->panjang_kertas_kiper,
            ]);
        } else {
            $resulTotalBajuKiper = 0;
            $resulSatatusBajuKiper = null;
        }

        if ($request->lk1_id) {
            $data1 = BarangMasukDatalayout::join('lk_baju1s', 'lk_baju1s.id', '=', 'barang_masuk_datalayouts.lk_1_id')
                ->leftJoin('pola_lengans', 'pola_lengans.id', '=', 'lk_baju1s.pola_lengan_1_id')
                ->select('barang_masuk_datalayouts.*', 'lk_baju1s.*', 'pola_lengans.*')
                ->findOrFail($request->lk1_id);

            $resulTotalBaju1 = $data1->total_baju_1;
            $resulSatatusBaju1 = $data1->status;

            $dataUpdate1 = BarangMasukDatalayout::findOrFail($request->lk1_id);

            if ($request->file('file_corel_layout4')) {
                $validator = Validator::make($request->all(), [
                    'file_corel_layout4' => 'file|max:5120'
                ]);

                if ($validator->fails()) {
                    return back()->with('error', 'Mohon maaf ukuran file yang anda berikan sangat besar mohon tinggalkan pesan keterangan saja');
                }

                $filebajuplayer = $request->file('file_corel_layout4')->store('file-dari-layout-1', 'public');
                if ($dataUpdate1->file_corel_layout4 && file_exists(storage_path('app/public/' . $dataUpdate1->file_corel_layout4))) {
                    Storage::delete('public/' . $dataUpdate1->file_corel_layout4);
                    $filebajuplayer = $request->file('file_corel_layout4')->store('file-dari-layout-1', 'public');
                }
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataUpdate1->update([
                'selesai' => $selesaiTime,

                'panjang_kertas_1' => $request->panjang_kertas_1,
                'poly_1' => $request->poly_1,
                'keterangan4' => $request->keterangan4,
                'kertas_id' => $request->kertas_id,

                'file_corel_layout4' => $filebajuplayer ?? $dataUpdate1->file_corel_layout4,
                'tanda_telah_mengerjakan' => 1,
            ]);
            LaporanKainLayout::create([
                'layout_id' => $dataUpdate1->id,
                'kertas_id' => $request->kertas_id,
                'daerah' => $dataUpdate1->BarangMasukCsLK->kota_produksi,
                'total_kertas' => $request->panjang_kertas_1,
            ]);
        } else {
            $resulTotalBaju1 = 0;
            $resulSatatusBaju1 = null;
        }

        if ($request->celana_player_id) {
            $dataCelanaPlayer = BarangMasukDatalayout::join('lk_celana_players', 'lk_celana_players.id', '=', 'barang_masuk_datalayouts.lk_celana_player_id')
                ->leftJoin('pola_lengans', 'pola_lengans.id', '=', 'lk_celana_players.pola_celana_player_id')
                ->select('barang_masuk_datalayouts.*', 'lk_celana_players.*', 'pola_lengans.*')
                ->findOrFail($request->celana_player_id);

            $resulTotalCelanaPlayer = $dataCelanaPlayer->total_celana_player;
            $resulSatatusCelanaPlayer = $dataCelanaPlayer->status;

            $dataUpdateCelanaPlayer = BarangMasukDatalayout::findOrFail($request->celana_player_id);

            if ($request->file('file_corel_layout5')) {
                $validator = Validator::make($request->all(), [
                    'file_corel_layout5' => 'file|max:5120'
                ]);

                if ($validator->fails()) {
                    return back()->with('error', 'Mohon maaf ukuran file yang anda berikan sangat besar mohon tinggalkan pesan keterangan saja');
                }
                $filebajuplayer = $request->file('file_corel_layout5')->store('file-dari-layout-celana-player', 'public');
                if ($dataUpdateCelanaPlayer->file_corel_layout5 && file_exists(storage_path('app/public/' . $dataUpdateCelanaPlayer->file_corel_layout5))) {
                    Storage::delete('public/' . $dataUpdateCelanaPlayer->file_corel_layout5);
                    $filebajuplayer = $request->file('file_corel_layout5')->store('file-dari-layout', 'public');
                }
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataUpdateCelanaPlayer->update([
                'selesai' => $selesaiTime,

                'panjang_kertas_celana_pelayer' => $request->panjang_kertas_celana_pelayer,
                'poly_celana_pelayer' => $request->poly_celana_pelayer,
                'keterangan5' => $request->keterangan5,
                'kertas_id' => $request->kertas_id,

                'file_corel_layout5' => $filebajuplayer ?? $dataUpdateCelanaPlayer->file_corel_layout5,
                'tanda_telah_mengerjakan' => 1,
            ]);
            LaporanKainLayout::create([
                'layout_id' => $dataUpdateCelanaPlayer->id,
                'kertas_id' => $request->kertas_id,
                'daerah' => $dataUpdateCelanaPlayer->BarangMasukCsLK->kota_produksi,
                'total_kertas' => $request->panjang_kertas_celana_pelayer,
            ]);
        } else {
            $resulTotalCelanaPlayer = 0;
            $resulSatatusCelanaPlayer = null;
        }

        if ($request->celana_pelatih_id) {
            $dataCelanaPelatih = BarangMasukDatalayout::join('lk_celana_pelatihs', 'lk_celana_pelatihs.id', '=', 'barang_masuk_datalayouts.lk_celana_pelatih_id')
                ->leftJoin('pola_lengans', 'pola_lengans.id', '=', 'lk_celana_pelatihs.pola_celana_pelatih_id')
                ->select('barang_masuk_datalayouts.*', 'lk_celana_pelatihs.*', 'pola_lengans.*')
                ->findOrFail($request->celana_pelatih_id);

            $resulTotalCelanaPelatih = $dataCelanaPelatih->total_celana_pelatih;
            $resulSatatusCelanaPelatih = $dataCelanaPelatih->status;

            $dataUpdateCelanaPelatih = BarangMasukDatalayout::findOrFail($request->celana_pelatih_id);
            if ($request->file('file_corel_layout6')) {
                $validator = Validator::make($request->all(), [
                    'file_corel_layout6' => 'file|max:5120'
                ]);

                if ($validator->fails()) {
                    return back()->with('error', 'Mohon maaf ukuran file yang anda berikan sangat besar mohon tinggalkan pesan keterangan saja');
                }
                $filebajuplayer = $request->file('file_corel_layout6')->store('file-dari-layout-celana-pelatih', 'public');
                if ($dataUpdateCelanaPelatih->file_corel_layout6 && file_exists(storage_path('app/public/' . $dataUpdateCelanaPelatih->file_corel_layout6))) {
                    Storage::delete('public/' . $dataUpdateCelanaPelatih->file_corel_layout6);
                    $filebajuplayer = $request->file('file_corel_layout6')->store('file-dari-layout-celana-pelatih', 'public');
                }
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataUpdateCelanaPelatih->update([
                'selesai' => $selesaiTime,

                'panjang_kertas_celana_pelatih' => $request->panjang_kertas_celana_pelatih,
                'poly_celana_pelatih' => $request->poly_celana_pelatih,
                'keterangan6' => $request->keterangan6,
                'kertas_id' => $request->kertas_id,

                'file_corel_layout6' => $filebajuplayer ?? $dataUpdateCelanaPelatih->file_corel_layout6,
                'tanda_telah_mengerjakan' => 1,
            ]);

            LaporanKainLayout::create([
                'layout_id' => $dataUpdateCelanaPelatih->id,
                'kertas_id' => $request->kertas_id,
                'daerah' => $dataUpdateCelanaPelatih->BarangMasukCsLK->kota_produksi,
                'total_kertas' => $request->panjang_kertas_celana_pelatih,
            ]);
        } else {
            $resulTotalCelanaPelatih = 0;
            $resulSatatusCelanaPelatih = null;
        }

        if ($request->celana_kiper_id) {
            $dataCelanaKiper = BarangMasukDatalayout::join('lk_celana_kipers', 'lk_celana_kipers.id', '=', 'barang_masuk_datalayouts.lk_celana_kiper_id')
                ->leftJoin('pola_lengans', 'pola_lengans.id', '=', 'lk_celana_kipers.pola_celana_kiper_id')
                ->select('barang_masuk_datalayouts.*', 'lk_celana_kipers.*', 'pola_lengans.*')
                ->findOrFail($request->celana_kiper_id);

            $resulTotalCelanaKiper = $dataCelanaKiper->total_celana_kiper;
            $resulSatatusCelanaKiper = $dataCelanaKiper->status;

            $dataUpdateCelanaKiper = BarangMasukDatalayout::findOrFail($request->celana_kiper_id);
            if ($request->file('file_corel_layout7')) {
                $validator = Validator::make($request->all(), [
                    'file_corel_layout7' => 'file|max:5120'
                ]);

                if ($validator->fails()) {
                    return back()->with('error', 'Mohon maaf ukuran file yang anda berikan sangat besar mohon tinggalkan pesan keterangan saja');
                }
                $filebajuplayer = $request->file('file_corel_layout7')->store('file-dari-layout-celana-kiper', 'public');
                if ($dataUpdateCelanaKiper->file_corel_layout7 && file_exists(storage_path('app/public/' . $dataUpdateCelanaKiper->file_corel_layout7))) {
                    Storage::delete('public/' . $dataUpdateCelanaKiper->file_corel_layout7);
                    $filebajuplayer = $request->file('file_corel_layout7')->store('file-dari-layout-celana-kiper', 'public');
                }
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataUpdateCelanaKiper->update([
                'selesai' => $selesaiTime,

                'panjang_kertas_celana_kiper' => $request->panjang_kertas_celana_kiper,
                'poly_celana_kiper' => $request->poly_celana_kiper,
                'keterangan7' => $request->keterangan7,
                'kertas_id' => $request->kertas_id,

                'file_corel_layout7' => $filebajuplayer ?? $dataUpdateCelanaKiper->file_corel_layout7,
                'tanda_telah_mengerjakan' => 1,
            ]);

            LaporanKainLayout::create([
                'layout_id' => $dataUpdateCelanaKiper->id,
                'kertas_id' => $request->kertas_id,
                'daerah' => $dataUpdateCelanaKiper->BarangMasukCsLK->kota_produksi,
                'total_kertas' => $request->panjang_kertas_celana_kiper,
            ]);
        } else {
            $resulTotalCelanaKiper = 0;
            $resulSatatusCelanaKiper = null;
        }

        if ($request->celana_1_id) {
            $dataCelana1 = BarangMasukDatalayout::join('lk_celana1s', 'lk_celana1s.id', '=', 'barang_masuk_datalayouts.lk_celana_1_id')
                ->leftJoin('pola_lengans', 'pola_lengans.id', '=', 'lk_celana1s.pola_celana_1_id')
                ->select('barang_masuk_datalayouts.*', 'lk_celana1s.*', 'pola_lengans.*')
                ->findOrFail($request->celana_1_id);

            $resulTotalCelana1 = $dataPlayer->total_celana_1;
            $resulSatatusCelana1 = $dataPlayer->status;

            $dataUpdateCelana1 = BarangMasukDatalayout::findOrFail($request->celana_1_id);

            if ($request->file('file_corel_layout8')) {
                $validator = Validator::make($request->all(), [
                    'file_corel_layout8' => 'file|max:5120'
                ]);

                if ($validator->fails()) {
                    return back()->with('error', 'Mohon maaf ukuran file yang anda berikan sangat besar mohon tinggalkan pesan keterangan saja');
                }

                $filebajuplayer = $request->file('file_corel_layout8')->store('file-dari-layout-celana-1', 'public');
                if ($dataUpdateCelana1->file_corel_layout8 && file_exists(storage_path('app/public/' . $dataUpdateCelana1->file_corel_layout8))) {
                    Storage::delete('public/' . $dataUpdateCelana1->file_corel_layout8);
                    $filebajuplayer = $request->file('file_corel_layout8')->store('file-dari-layout-celana-1', 'public');
                }
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataUpdateCelana1->update([
                'selesai' => $selesaiTime,

                'panjang_kertas_celana_1' => $request->panjang_kertas_celana_1,
                'poly_celana_1' => $request->poly_celana_1,
                'keterangan8' => $request->keterangan8,
                'kertas_id' => $request->kertas_id,

                'file_corel_layout8' => $filebajuplayer ?? $dataUpdateCelana1->file_corel_layout8,
                'tanda_telah_mengerjakan' => 1,
            ]);

            LaporanKainLayout::create([
                'layout_id' => $dataUpdateCelana1->id,
                'kertas_id' => $request->kertas_id,
                'daerah' => $dataUpdateCelana1->BarangMasukCsLK->kota_produksi,
                'total_kertas' => $request->panjang_kertas_celana_1,
            ]);
        } else {
            $resulTotalCelana1 = 0;
            $resulSatatusCelana1 = null;
        }

        if ($resulSatatusBaju == 1) {
            $dataBajuPlayer = $resulTotalBaju;
        } else {
            $dataBajuPlayer = 0;
        }

        if ($resulSatatusBajuPlatih == 1) {
            $dataBajuPelatih = $resulTotalBajuPlatih;
        } else {
            $dataBajuPelatih = 0;
        }

        if ($resulSatatusBajuKiper == 1) {
            $dataBajuKiper = $resulTotalBajuKiper;
        } else {
            $dataBajuKiper = 0;
        }

        if ($resulSatatusBaju1 == 1) {
            $dataBaju1 = $resulTotalBaju1;
        } else {
            $dataBaju1 = 0;
        }

        if ($resulSatatusCelanaPlayer == 1) {
            $dataCelanaPlayer = $resulTotalCelanaPlayer;
        } else {
            $dataCelanaPlayer = 0;
        }

        if ($resulSatatusCelanaPelatih == 1) {
            $dataCelanaPelatih = $resulTotalCelanaPelatih;
        } else {
            $dataCelanaPelatih = 0;
        }

        if ($resulSatatusCelanaKiper == 1) {
            $dataCelanaKiper = $resulTotalCelanaKiper;
        } else {
            $dataCelanaKiper = 0;
        }

        if ($resulSatatusCelana1 == 1) {
            $dataCelana1 = $resulTotalCelana1;
        } else {
            $dataCelana1 = 0;
        }

        $deadline = Carbon::parse($dataPlayer->deadline);
        $selesai = Carbon::parse($dataPlayer->selesai);

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
                'layout_id' => $request->player_id,
                'tanggal' => Carbon::now(),
                'jumlah_komisi' => $totalHarga,
                'kota' => $dataPlayer->kota_produksi,
            ]);
        } else {
            PembagianKomisi::create([
                'user_id' => $user->id,
                'layout_id' => $dataPlayer->id,
                'tanggal' => Carbon::now(),
                'jumlah_komisi' => "0",
                'kota' => $dataPlayer->kota_produksi,
            ]);
        }

        if ($dataPlayer->jenis_mesin == 'mimaki') {
            if ($request->player_id) {
                $laporanPlayer = Laporan::where('barang_masuk_layout_id', $request->player_id)->first();
                if ($laporanPlayer) {
                    $laporanPlayer->update([
                        'status' => 'Mesin Mimaki',
                    ]);
                }
            }
            if ($request->pelatih_id) {
                $laporanPelatih = Laporan::where('barang_masuk_layout_id', $request->pelatih_id)->first();
                if ($laporanPelatih) {
                    $laporanPelatih->update([
                        'status' => 'Mesin Mimaki',
                    ]);
                }
            }
            if ($request->kiper_id) {
                $laporanKiper = Laporan::where('barang_masuk_layout_id', $request->kiper_id)->first();
                if ($laporanKiper) {
                    $laporanKiper->update([
                        'status' => 'Mesin Mimaki',
                    ]);
                }
            }
            if ($request->lk1_id) {
                $laporan1 = Laporan::where('barang_masuk_layout_id', $request->lk1_id)->first();
                if ($laporan1) {
                    $laporan1->update([
                        'status' => 'Mesin Mimaki',
                    ]);
                }
            }
            if ($request->celana_player_id) {
                $laporanCealanaPlayer = Laporan::where('barang_masuk_layout_id', $request->celana_player_id)->first();
                if ($laporanCealanaPlayer) {
                    $laporanCealanaPlayer->update([
                        'status' => 'Mesin Mimaki',
                    ]);
                }
            }
            if ($request->celana_pelatih_id) {
                $laporanCelanaPelatih = Laporan::where('barang_masuk_layout_id', $request->celana_pelatih_id)->first();
                if ($laporanCelanaPelatih) {
                    $laporanCelanaPelatih->update([
                        'status' => 'Mesin Mimaki',
                    ]);
                }
            }
            if ($request->celana_kiper_id) {
                $laporanCelanaKiper = Laporan::where('barang_masuk_layout_id', $request->celana_kiper_id)->first();
                if ($laporanCelanaKiper) {
                    $laporanCelanaKiper->update([
                        'status' => 'Mesin Mimaki',
                    ]);
                }
            }
            if ($request->celana_1_id) {
                $laporanCelana1 = Laporan::where('barang_masuk_layout_id', $request->celana_1_id)->first();
                if ($laporanCelana1) {
                    $laporanCelana1->update([
                        'status' => 'Mesin Mimaki',
                    ]);
                }
            }
        } elseif ($dataPlayer->jenis_mesin == 'atexco') {
            if ($request->player_id) {
                $laporanPlayer = Laporan::where('barang_masuk_layout_id', $request->player_id)->first();
                if ($laporanPlayer) {
                    $laporanPlayer->update([
                        'status' => 'Mesin Atexco',
                    ]);
                }
            }
            if ($request->pelatih_id) {
                $laporanPelatih = Laporan::where('barang_masuk_layout_id', $request->pelatih_id)->first();
                if ($laporanPelatih) {
                    $laporanPelatih->update([
                        'status' => 'Mesin Atexco',
                    ]);
                }
            }
            if ($request->kiper_id) {
                $laporanKiper = Laporan::where('barang_masuk_layout_id', $request->kiper_id)->first();
                if ($laporanKiper) {
                    $laporanKiper->update([
                        'status' => 'Mesin Atexco',
                    ]);
                }
            }
            if ($request->lk1_id) {
                $laporan1 = Laporan::where('barang_masuk_layout_id', $request->lk1_id)->first();
                if ($laporan1) {
                    $laporan1->update([
                        'status' => 'Mesin Atexco',
                    ]);
                }
            }
            if ($request->celana_player_id) {
                $laporanCealanaPlayer = Laporan::where('barang_masuk_layout_id', $request->celana_player_id)->first();
                if ($laporanCealanaPlayer) {
                    $laporanCealanaPlayer->update([
                        'status' => 'Mesin Atexco',
                    ]);
                }
            }
            if ($request->celana_pelatih_id) {
                $laporanCelanaPelatih = Laporan::where('barang_masuk_layout_id', $request->celana_pelatih_id)->first();
                if ($laporanCelanaPelatih) {
                    $laporanCelanaPelatih->update([
                        'status' => 'Mesin Atexco',
                    ]);
                }
            }
            if ($request->celana_kiper_id) {
                $laporanCelanaKiper = Laporan::where('barang_masuk_layout_id', $request->celana_kiper_id)->first();
                if ($laporanCelanaKiper) {
                    $laporanCelanaKiper->update([
                        'status' => 'Mesin Atexco',
                    ]);
                }
            }
            if ($request->celana_1_id) {
                $laporanCelana1 = Laporan::where('barang_masuk_layout_id', $request->celana_1_id)->first();
                if ($laporanCelana1) {
                    $laporanCelana1->update([
                        'status' => 'Mesin Atexco',
                    ]);
                }
            }
        }

        return redirect()->route('getIndexLaporanLk')->with('success', 'Selamat data yang anda input telah terkirim!');
    }
}
