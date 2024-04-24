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
        $dataLk = BarangMasukDatalayout::with('BarangMasukCsLK')->get();

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

        return view('component.Layout.layout-lk-pegawai.cerate-laporan-lk', compact('dataLk', 'formattedData'));
    }

    public function putLaporanLs(Request $request, $id)
    {
        $user = Auth::user();

        if ($request->player_id) {
            $dataPlayer = BarangMasukDatalayout::with(
                'BarangMasukCsLK',
                'BarangMasukCostumerServicesLkPlyer.LenganPlayer',
                'BarangMasukCostumerServicesLkPelatih.LenganPelatih',
                'BarangMasukCostumerServicesLkKiper.LenganKiper',
                'BarangMasukCostumerServicesLk1.Lengan1',
                'BarangMasukCostumerServicesLkCelanaPlyer.CelanaCelanaPlayer',
                'BarangMasukCostumerServicesLkCelanaPelatih.CelanaCelanapelatih',
                'BarangMasukCostumerServicesLkCelanaKiper.CelanaCealanaKiper',
                'BarangMasukCostumerServicesLkCelana1.CelanaCelana1'
            )->findOrFail($request->player_id);

            $jumlahBajuPlayer = $dataPlayer->BarangMasukCostumerServicesLkPlyer;
            $resulTotalBaju = 0;
            $resulSatatusBaju = null;
            foreach ($jumlahBajuPlayer as $item) {
                $resulTotalBaju = $item->total_baju_player;
                $resulSatatusBaju = $item->LenganPlayer->status;
            }
            $jumlahBajuPelatih = $dataPlayer->BarangMasukCostumerServicesLkPelatih;
            $resulTotalBajuPelatih = 0;
            $resulSatatusBajuPelatih = null;
            foreach ($jumlahBajuPelatih as $item) {
                $resulTotalBajuPelatih = $item->total_baju_pelatih;
                $resulSatatusBajuPelatih = $item->LenganPelatih->status;
            }
            $jumlahBajuKiper = $dataPlayer->BarangMasukCostumerServicesLkKiper;
            $resulTotalBajuKiper = 0;
            $resulSatatusBajuKiper = null;
            foreach ($jumlahBajuKiper as $item) {
                $resulTotalBajuKiper = $item->total_baju_kiper;
                $resulSatatusBajuKiper = $item->LenganKiper->status;
            }
            $jumlahBaju1 = $dataPlayer->BarangMasukCostumerServicesLk1;
            $resulTotalBaju1 = 0;
            $resulSatatusBaju1 = null;
            foreach ($jumlahBaju1 as $item) {
                $resulTotalBaju1 = $item->total_baju_1;
                $resulSatatusBaju1 = $item->Lengan1->status;
            }
            $jumlahBajuCelanaPlayer = $dataPlayer->BarangMasukCostumerServicesLkCelanaPlyer;
            $resulTotalBajuCelanaPlayer = 0;
            $resulSatatusBajuCelanaPlayer = null;
            foreach ($jumlahBajuCelanaPlayer as $item) {
                $resulTotalBajuCelanaPlayer = $item->total_celana_player;
                $resulSatatusBajuCelanaPlayer = $item->CelanaCelanaPlayer->status;
            }
            $jumlahBajuCelanaPelatih = $dataPlayer->BarangMasukCostumerServicesLkCelanaPelatih;
            $resulTotalBajuCelanaPelatih = 0;
            $resulSatatusBajuCelanaPelatih = null;
            foreach ($jumlahBajuCelanaPelatih as $item) {
                $resulTotalBajuCelanaPelatih = $item->total_celana_pelatih;
                $resulSatatusBajuCelanaPelatih = $item->CelanaCelanapelatih->status;
            }
            $jumlahBajuCelanaKiper = $dataPlayer->BarangMasukCostumerServicesLkCelanaKiper;
            $resulTotalBajuCelanaKiper = 0;
            $resulSatatusBajuCelanaKiper = null;
            foreach ($jumlahBajuCelanaKiper as $item) {
                $resulTotalBajuCelanaKiper = $item->total_celana_kiper;
                $resulSatatusBajuCelanaKiper = $item->CelanaCealanaKiper->status;
            }
            $jumlahBajuCelana1 = $dataPlayer->BarangMasukCostumerServicesLkCelana1;
            $resulTotalBajuCelana1 = 0;
            $resulSatatusBajuCelana1 = null;
            foreach ($jumlahBajuCelana1 as $item) {
                $resulTotalBajuCelana1 = $item->total_celana_1;
                $resulSatatusBajuCelana1 = $item->CelanaCelana1->status;
            }

            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-player', 'public');
                if ($dataPlayer->file_corel_layout && file_exists(storage_path('app/public/' . $dataPlayer->file_corel_layout))) {
                    Storage::delete('public/' . $dataPlayer->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-player', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_player')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_player')->store('file-tangkap-layout-player', 'public');
                if ($dataPlayer->file_tangkap_layar_player && file_exists(storage_path('app/public/' . $dataPlayer->file_tangkap_layar_player))) {
                    Storage::delete('public/' . $dataPlayer->file_tangkap_layar_player);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_player')->store('file-tangkap-layout-player', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_player') === null) {
                $fileTangkapLayar = $dataPlayer->file_tangkap_layar_player;
            }
            $dataPlayer->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_palayer' => $request->panjang_kertas_palayer,
                'poly_player' => $request->poly_player,
                'file_tangkap_layar_player' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
            ]);
        }
        if ($request->pelatih_id) {
            $dataPelatih = BarangMasukDatalayout::with('BarangMasukCostumerServicesLkPelatih')->findOrFail($request->pelatih_id);
            $dataPelatih->load('BarangMasukCostumerServicesLkPelatih');

            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-pelatih', 'public');
                if ($dataPelatih->file_corel_layout && file_exists(storage_path('app/public/' . $dataPelatih->file_corel_layout))) {
                    Storage::delete('public/' . $dataPelatih->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-pelatih', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_pelatih')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_pelatih')->store('file-tangkap-layout-pelatih', 'public');
                if ($dataPelatih->file_tangkap_layar_pelatih && file_exists(storage_path('app/public/' . $dataPelatih->file_tangkap_layar_pelatih))) {
                    Storage::delete('public/' . $dataPelatih->file_tangkap_layar_pelatih);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_pelatih')->store('file-tangkap-layout-pelatih', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_pelatih') === null) {
                $fileTangkapLayar = $dataPelatih->file_tangkap_layar_pelatih;
            }
            $dataPelatih->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_pelatih' => $request->panjang_kertas_pelatih,
                'poly_pelatih' => $request->poly_pelatih,
                'file_tangkap_layar_pelatih' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
            ]);
        }
        if ($request->kiper_id) {
            $dataKiper = BarangMasukDatalayout::findOrFail($request->kiper_id);

            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-kiper', 'public');
                if ($dataKiper->file_corel_layout && file_exists(storage_path('app/public/' . $dataKiper->file_corel_layout))) {
                    Storage::delete('public/' . $dataKiper->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_kiper')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_kiper')->store('file-tangkap-layout-kiper', 'public');
                if ($dataKiper->file_tangkap_layar_kiper && file_exists(storage_path('app/public/' . $dataKiper->file_tangkap_layar_kiper))) {
                    Storage::delete('public/' . $dataKiper->file_tangkap_layar_kiper);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_kiper')->store('file-tangkap-layout-kiper', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_kiper') === null) {
                $fileTangkapLayar = $dataKiper->file_tangkap_layar_kiper;
            }
            $dataKiper->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_kiper' => $request->panjang_kertas_kiper,
                'poly_kiper' => $request->poly_kiper,
                'file_tangkap_layar_kiper' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
            ]);
        }
        if ($request->lk1_id) {
            $data1 = BarangMasukDatalayout::findOrFail($request->lk1_id);

            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-1', 'public');
                if ($data1->file_corel_layout && file_exists(storage_path('app/public/' . $data1->file_corel_layout))) {
                    Storage::delete('public/' . $data1->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-1', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_1')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_1')->store('file-tangkap-layout-1', 'public');
                if ($data1->file_tangkap_layar_1 && file_exists(storage_path('app/public/' . $data1->file_tangkap_layar_1))) {
                    Storage::delete('public/' . $data1->file_tangkap_layar_1);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_1')->store('file-tangkap-layout-1', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_1') === null) {
                $fileTangkapLayar = $data1->file_tangkap_layar_1;
            }
            $data1->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_1' => $request->panjang_kertas_1,
                'poly_1' => $request->poly_1,
                'file_tangkap_layar_1' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
            ]);
        }
        if ($request->celana_player_id) {
            $dataCelanaPlayer = BarangMasukDatalayout::findOrFail($request->celana_player_id);


            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-celana-player', 'public');
                if ($dataCelanaPlayer->file_corel_layout && file_exists(storage_path('app/public/' . $dataCelanaPlayer->file_corel_layout))) {
                    Storage::delete('public/' . $dataCelanaPlayer->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_pelayer')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_celana_pelayer')->store('file-tangkap-layout-celana-player', 'public');
                if ($dataCelanaPlayer->file_tangkap_layar_celana_pelayer && file_exists(storage_path('app/public/' . $dataCelanaPlayer->file_tangkap_layar_celana_pelayer))) {
                    Storage::delete('public/' . $dataCelanaPlayer->file_tangkap_layar_celana_pelayer);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_celana_pelayer')->store('file-tangkap-layout-celana-player', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_pelayer') === null) {
                $fileTangkapLayar = $dataCelanaPlayer->file_tangkap_layar_celana_pelayer;
            }
            $dataCelanaPlayer->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_celana_pelayer' => $request->panjang_kertas_celana_pelayer,
                'poly_celana_pelayer' => $request->poly_celana_pelayer,
                'file_tangkap_layar_celana_pelayer' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
            ]);
        }
        if ($request->celana_pelatih_id) {
            $dataCelanaPelatih = BarangMasukDatalayout::findOrFail($request->celana_pelatih_id);



            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-celana-pelatih', 'public');
                if ($dataCelanaPelatih->file_corel_layout && file_exists(storage_path('app/public/' . $dataCelanaPelatih->file_corel_layout))) {
                    Storage::delete('public/' . $dataCelanaPelatih->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-celana-pelatih', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_pelatih')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_celana_pelatih')->store('file-tangkap-layout-celana-pelatih', 'public');
                if ($dataCelanaPelatih->file_tangkap_layar_celana_pelatih && file_exists(storage_path('app/public/' . $dataCelanaPelatih->file_tangkap_layar_celana_pelatih))) {
                    Storage::delete('public/' . $dataCelanaPelatih->file_tangkap_layar_celana_pelatih);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_celana_pelatih')->store('file-tangkap-layout-celana-pelatih', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_pelatih') === null) {
                $fileTangkapLayar = $dataCelanaPelatih->file_tangkap_layar_celana_pelatih;
            }
            $dataCelanaPelatih->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_celana_pelatih' => $request->panjang_kertas_celana_pelatih,
                'poly_celana_pelatih' => $request->poly_celana_pelatih,
                'file_tangkap_layar_celana_pelatih' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
            ]);
        }
        if ($request->celana_kiper_id) {
            $dataCelanaKiper = BarangMasukDatalayout::findOrFail($request->celana_kiper_id);


            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-celana-kiper', 'public');
                if ($dataCelanaKiper->file_corel_layout && file_exists(storage_path('app/public/' . $dataCelanaKiper->file_corel_layout))) {
                    Storage::delete('public/' . $dataCelanaKiper->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-celana-kiper', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_kiper')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_celana_kiper')->store('file-tangkap-layout-celana-kiper', 'public');
                if ($dataCelanaKiper->file_tangkap_layar_celana_kiper && file_exists(storage_path('app/public/' . $dataCelanaKiper->file_tangkap_layar_celana_kiper))) {
                    Storage::delete('public/' . $dataCelanaKiper->file_tangkap_layar_celana_kiper);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_celana_kiper')->store('file-tangkap-layout-celana-kiper', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_kiper') === null) {
                $fileTangkapLayar = $dataCelanaKiper->file_tangkap_layar_celana_kiper;
            }
            $dataCelanaKiper->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_celana_kiper' => $request->panjang_kertas_celana_kiper,
                'poly_celana_kiper' => $request->poly_celana_kiper,
                'file_tangkap_layar_celana_kiper' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
            ]);
        }
        if ($request->celana_1_id) {
            $dataCelana1 = BarangMasukDatalayout::findOrFail($request->celana_1_id);


            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-celana-1', 'public');
                if ($dataCelana1->file_corel_layout && file_exists(storage_path('app/public/' . $dataCelana1->file_corel_layout))) {
                    Storage::delete('public/' . $dataCelana1->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-celana-1', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_1')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_celana_1')->store('file-tangkap-layout-celana-1', 'public');
                if ($dataCelana1->file_tangkap_layar_celana_1 && file_exists(storage_path('app/public/' . $dataCelana1->file_tangkap_layar_celana_1))) {
                    Storage::delete('public/' . $dataCelana1->file_tangkap_layar_celana_1);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_celana_1')->store('file-tangkap-layout-celana-1', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_1') === null) {
                $fileTangkapLayar = $dataCelana1->file_tangkap_layar_celana_1;
            }
            $dataCelana1->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_celana_1' => $request->panjang_kertas_celana_1,
                'poly_celana_1' => $request->poly_celana_1,
                'file_tangkap_layar_celana_1' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
            ]);
        }

        if ($resulSatatusBaju == 1) {
            $dataBajuPlayer = $resulTotalBaju;
        } else {
            $dataBajuPlayer = 0;
        }

        if ($resulSatatusBajuPelatih == 1) {
            $dataBajuPelatih = $resulTotalBajuPelatih;
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

        if ($resulSatatusBajuCelanaPlayer == 1) {
            $dataCelanaPlayer = $resulTotalBajuCelanaPlayer;
        } else {
            $dataCelanaPlayer = 0;
        }

        if ($resulSatatusBajuCelanaPelatih == 1) {
            $dataCelanaPelatih = $resulTotalBajuCelanaPelatih;
        } else {
            $dataCelanaPelatih = 0;
        }

        if ($resulSatatusBajuCelanaKiper == 1) {
            $dataCelanaKiper = $resulTotalBajuCelanaKiper;
        } else {
            $dataCelanaKiper = 0;
        }

        if ($resulSatatusBajuCelana1 == 1) {
            $dataCelana1 = $resulTotalBajuCelana1;
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
                'layout_id' => $dataPlayer->id,
                'tanggal' => Carbon::now(),
                'jumlah_komisi' => $totalHarga,
                'kota' => $dataPlayer->BarangMasukCsLK->kota_produksi,
            ]);
        } else {
            PembagianKomisi::create([
                'user_id' => $user->id,
                'layout_id' => $dataPlayer->id,
                'tanggal' => Carbon::now(),
                'jumlah_komisi' => "0",
                'kota' => $dataPlayer->BarangMasukCsLK->kota_produksi,
            ]);
        }

        if ($dataPlayer->BarangMasukCsLK->jenis_mesin == 'mimaki') {
            $laporan = Laporan::where('barang_masuk_layout_id', $dataPlayer->id)->first();
            if ($laporan) {
                $laporan->update([
                    'status' => 'Mesin Mimaki',
                ]);
            }
        } elseif ($dataPlayer->BarangMasukCsLK->jenis_mesin == 'atexco') {
            $laporan = Laporan::where('barang_masuk_layout_id', $dataPlayer->id)->first();
            if ($laporan) {
                $laporan->update([
                    'status' => 'Mesin Atexco',
                ]);
            }
        }

        return redirect()->route('getIndexLkLayoutPegawai')->with('success', 'Selamat data yang anda input telah terkirim!');
    }
}
