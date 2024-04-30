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
        // return response()->json($id);
        $dataLk = BarangMasukDatalayout::where('barang_masuk_id', $id)->with('BarangMasukCsLK')->get();

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

            $dataUpdate = BarangMasukDatalayout::findOrFail($request->player_id);

            // return response()->json($dataPlayerID);

            $resulTotalBaju = $dataPlayer->total_baju_player;
            $resulSatatusBaju = $dataPlayer->status;

            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-player', 'public');
                if ($dataUpdate->file_corel_layout && file_exists(storage_path('app/public/' . $dataUpdate->file_corel_layout))) {
                    Storage::delete('public/' . $dataUpdate->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-player', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_player')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_player')->store('file-tangkap-layout-player', 'public');
                if ($dataUpdate->file_tangkap_layar_player && file_exists(storage_path('app/public/' . $dataUpdate->file_tangkap_layar_player))) {
                    Storage::delete('public/' . $dataUpdate->file_tangkap_layar_player);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_player')->store('file-tangkap-layout-player', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_player') === null) {
                $fileTangkapLayar = $dataUpdate->file_tangkap_layar_player;
            }
            $dataUpdate->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_palayer' => $request->panjang_kertas_palayer,
                'poly_player' => $request->poly_player,
                'file_tangkap_layar_player' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
            ]);
        }

        if ($request->pelatih_id) {
            $dataPelatih = BarangMasukDatalayout::join('lk_pelatihs', 'lk_pelatihs.id', '=', 'barang_masuk_datalayouts.lk_pelatih_id')
                ->leftJoin('pola_lengans', 'pola_lengans.id', '=', 'lk_pelatihs.pola_lengan_pelatih_id')
                ->select('barang_masuk_datalayouts.*', 'lk_pelatihs.*', 'pola_lengans.*')
                ->findOrFail($request->pelatih_id);

            $resulTotalBajuPlatih = $dataPelatih->total_baju_pelatih;
            $resulSatatusBajuPlatih = $dataPelatih->status;

            $dataUpdatePelatih = BarangMasukDatalayout::findOrFail($request->pelatih_id);
            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-pelatih', 'public');
                if ($dataUpdatePelatih->file_corel_layout && file_exists(storage_path('app/public/' . $dataUpdatePelatih->file_corel_layout))) {
                    Storage::delete('public/' . $dataUpdatePelatih->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-pelatih', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_pelatih')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_pelatih')->store('file-tangkap-layout-pelatih', 'public');
                if ($dataUpdatePelatih->file_tangkap_layar_pelatih && file_exists(storage_path('app/public/' . $dataUpdatePelatih->file_tangkap_layar_pelatih))) {
                    Storage::delete('public/' . $dataUpdatePelatih->file_tangkap_layar_pelatih);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_pelatih')->store('file-tangkap-layout-pelatih', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_pelatih') === null) {
                $fileTangkapLayar = $dataUpdatePelatih->file_tangkap_layar_pelatih;
            }
            $dataUpdatePelatih->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_pelatih' => $request->panjang_kertas_pelatih,
                'poly_pelatih' => $request->poly_pelatih,
                'file_tangkap_layar_pelatih' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
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

            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-kiper', 'public');
                if ($dataUpdateKiper->file_corel_layout && file_exists(storage_path('app/public/' . $dataUpdateKiper->file_corel_layout))) {
                    Storage::delete('public/' . $dataUpdateKiper->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_kiper')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_kiper')->store('file-tangkap-layout-kiper', 'public');
                if ($dataUpdateKiper->file_tangkap_layar_kiper && file_exists(storage_path('app/public/' . $dataUpdateKiper->file_tangkap_layar_kiper))) {
                    Storage::delete('public/' . $dataUpdateKiper->file_tangkap_layar_kiper);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_kiper')->store('file-tangkap-layout-kiper', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_kiper') === null) {
                $fileTangkapLayar = $dataUpdateKiper->file_tangkap_layar_kiper;
            }
            $dataUpdateKiper->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_kiper' => $request->panjang_kertas_kiper,
                'poly_kiper' => $request->poly_kiper,
                'file_tangkap_layar_kiper' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
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

            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-1', 'public');
                if ($dataUpdate1->file_corel_layout && file_exists(storage_path('app/public/' . $dataUpdate1->file_corel_layout))) {
                    Storage::delete('public/' . $dataUpdate1->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-1', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_1')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_1')->store('file-tangkap-layout-1', 'public');
                if ($dataUpdate1->file_tangkap_layar_1 && file_exists(storage_path('app/public/' . $dataUpdate1->file_tangkap_layar_1))) {
                    Storage::delete('public/' . $dataUpdate1->file_tangkap_layar_1);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_1')->store('file-tangkap-layout-1', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_1') === null) {
                $fileTangkapLayar = $dataUpdate1->file_tangkap_layar_1;
            }
            $dataUpdate1->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_1' => $request->panjang_kertas_1,
                'poly_1' => $request->poly_1,
                'file_tangkap_layar_1' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
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

            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-celana-player', 'public');
                if ($dataUpdateCelanaPlayer->file_corel_layout && file_exists(storage_path('app/public/' . $dataUpdateCelanaPlayer->file_corel_layout))) {
                    Storage::delete('public/' . $dataUpdateCelanaPlayer->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_pelayer')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_celana_pelayer')->store('file-tangkap-layout-celana-player', 'public');
                if ($dataUpdateCelanaPlayer->file_tangkap_layar_celana_pelayer && file_exists(storage_path('app/public/' . $dataUpdateCelanaPlayer->file_tangkap_layar_celana_pelayer))) {
                    Storage::delete('public/' . $dataUpdateCelanaPlayer->file_tangkap_layar_celana_pelayer);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_celana_pelayer')->store('file-tangkap-layout-celana-player', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_pelayer') === null) {
                $fileTangkapLayar = $dataUpdateCelanaPlayer->file_tangkap_layar_celana_pelayer;
            }
            $dataUpdateCelanaPlayer->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_celana_pelayer' => $request->panjang_kertas_celana_pelayer,
                'poly_celana_pelayer' => $request->poly_celana_pelayer,
                'file_tangkap_layar_celana_pelayer' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
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
            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-celana-pelatih', 'public');
                if ($dataUpdateCelanaPelatih->file_corel_layout && file_exists(storage_path('app/public/' . $dataUpdateCelanaPelatih->file_corel_layout))) {
                    Storage::delete('public/' . $dataUpdateCelanaPelatih->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-celana-pelatih', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_pelatih')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_celana_pelatih')->store('file-tangkap-layout-celana-pelatih', 'public');
                if ($dataUpdateCelanaPelatih->file_tangkap_layar_celana_pelatih && file_exists(storage_path('app/public/' . $dataUpdateCelanaPelatih->file_tangkap_layar_celana_pelatih))) {
                    Storage::delete('public/' . $dataUpdateCelanaPelatih->file_tangkap_layar_celana_pelatih);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_celana_pelatih')->store('file-tangkap-layout-celana-pelatih', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_pelatih') === null) {
                $fileTangkapLayar = $dataUpdateCelanaPelatih->file_tangkap_layar_celana_pelatih;
            }
            $dataUpdateCelanaPelatih->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_celana_pelatih' => $request->panjang_kertas_celana_pelatih,
                'poly_celana_pelatih' => $request->poly_celana_pelatih,
                'file_tangkap_layar_celana_pelatih' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
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
            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-celana-kiper', 'public');
                if ($dataUpdateCelanaKiper->file_corel_layout && file_exists(storage_path('app/public/' . $dataUpdateCelanaKiper->file_corel_layout))) {
                    Storage::delete('public/' . $dataUpdateCelanaKiper->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-celana-kiper', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_kiper')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_celana_kiper')->store('file-tangkap-layout-celana-kiper', 'public');
                if ($dataUpdateCelanaKiper->file_tangkap_layar_celana_kiper && file_exists(storage_path('app/public/' . $dataUpdateCelanaKiper->file_tangkap_layar_celana_kiper))) {
                    Storage::delete('public/' . $dataUpdateCelanaKiper->file_tangkap_layar_celana_kiper);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_celana_kiper')->store('file-tangkap-layout-celana-kiper', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_kiper') === null) {
                $fileTangkapLayar = $dataUpdateCelanaKiper->file_tangkap_layar_celana_kiper;
            }
            $dataUpdateCelanaKiper->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_celana_kiper' => $request->panjang_kertas_celana_kiper,
                'poly_celana_kiper' => $request->poly_celana_kiper,
                'file_tangkap_layar_celana_kiper' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
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

            if ($request->file('file_corel_layout')) {
                $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-celana-1', 'public');
                if ($dataUpdateCelana1->file_corel_layout && file_exists(storage_path('app/public/' . $dataUpdateCelana1->file_corel_layout))) {
                    Storage::delete('public/' . $dataUpdateCelana1->file_corel_layout);
                    $filebajuplayer = $request->file('file_corel_layout')->store('file-dari-layout-celana-1', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_1')) {
                $fileTangkapLayar = $request->file('file_tangkap_layar_celana_1')->store('file-tangkap-layout-celana-1', 'public');
                if ($dataUpdateCelana1->file_tangkap_layar_celana_1 && file_exists(storage_path('app/public/' . $dataUpdateCelana1->file_tangkap_layar_celana_1))) {
                    Storage::delete('public/' . $dataUpdateCelana1->file_tangkap_layar_celana_1);
                    $fileTangkapLayar = $request->file('file_tangkap_layar_celana_1')->store('file-tangkap-layout-celana-1', 'public');
                }
            }
            if ($request->file('file_tangkap_layar_celana_1') === null) {
                $fileTangkapLayar = $dataUpdateCelana1->file_tangkap_layar_celana_1;
            }
            $dataUpdateCelana1->update([
                'selesai' => Carbon::now(),

                'panjang_kertas_celana_1' => $request->panjang_kertas_celana_1,
                'poly_celana_1' => $request->poly_celana_1,
                'file_tangkap_layar_celana_1' => $fileTangkapLayar,

                'file_corel_layout' => $filebajuplayer,
                'tanda_telah_mengerjakan' => 1,
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
            return response()->json("heelo");
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
