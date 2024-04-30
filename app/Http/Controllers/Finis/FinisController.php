<?php

namespace App\Http\Controllers\Finis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Finish;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;
use Carbon\Carbon;
use App\Models\BarangMasukCostumerServices;
use App\Models\BarangMasukDatalayout;
use PDF;

class FinisController extends Controller
{
    public function getIndex()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = Finish::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = Finish::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = Finish::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } else {
            $dataMasuk = Finish::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        }

        return view('component.Finis.index', compact('dataMasuk'));
    }

    public function getInputLaporan($id)
    {
        $dataMasuk = Finish::where('no_order_id', $id)->with('BarangMasukCs')->get();

        $formattedData = [];

        foreach ($dataMasuk as $item) {
            if ($item->lk_player_id) {
                $formattedData['player'][] = [
                    'id' => $item->id,
                ];
            } elseif ($item->lk_pelatih_id) {
                $formattedData['pelatih'][] = [
                    'id' => $item->id,
                ];
            } elseif ($item->lk_kiper_id) {
                $formattedData['kiper'][] = [
                    'id' => $item->id,
                ];
            } elseif ($item->lk_1_id) {
                $formattedData['lk_1'][] = [
                    'id' => $item->id,
                ];
            } elseif ($item->lk_celana_player_id) {
                $formattedData['celana_player'][] = [
                    'id' => $item->id,
                ];
            } elseif ($item->lk_celana_pelatih_id) {
                $formattedData['celana_pelatih'][] = [
                    'id' => $item->id,
                ];
            } elseif ($item->lk_celana_kiper_id) {
                $formattedData['celana_kiper'][] = [
                    'id' => $item->id,
                ];
            } elseif ($item->lk_celana_1_id) {
                $formattedData['celana_1'][] = [
                    'id' => $item->id,
                ];
            }
        }

        return view('component.Finis.cerate-laporan-mesin', compact('dataMasuk', 'formattedData'));
    }

    public function putLaporan(Request $request)
    {
        $user = Auth::user();

        if ($request->player_id) {
            $dataMasukPlayer = Finish::find($request->player_id);

            if ($request->file('foto')) {
                $fileGambar = $request->file('foto')->store('finish-player', 'public');
                if ($dataMasukPlayer->foto && file_exists(storage_path('app/public/' . $dataMasukPlayer->foto))) {
                    Storage::delete('public/' . $dataMasukPlayer->foto);
                    $fileGambar = $request->file('foto')->store('finish-player', 'public');
                }
            }

            if ($request->file('foto') === null) {
                $fileGambar = $dataMasukPlayer->foto;
            }

            $dataMasukPlayer->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'foto' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->pelatih_id) {
            $dataMasukPelatih = Finish::find($request->pelatih_id);

            if ($request->file('foto_pelatih')) {
                $fileGambar = $request->file('foto_pelatih')->store('finish-pelatih', 'public');
                if ($dataMasukPelatih->foto_pelatih && file_exists(storage_path('app/public/' . $dataMasukPelatih->foto_pelatih))) {
                    Storage::delete('public/' . $dataMasukPelatih->foto_pelatih);
                    $fileGambar = $request->file('foto_pelatih')->store('finish-pelatih', 'public');
                }
            }

            if ($request->file('foto_pelatih') === null) {
                $fileGambar = $dataMasukPelatih->foto_pelatih;
            }

            $dataMasukPelatih->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'foto_pelatih' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->kiper_id) {
            $dataMasukKiper = Finish::find($request->kiper_id);

            if ($request->file('foto_kiper')) {
                $fileGambar = $request->file('foto_kiper')->store('finish-kiper', 'public');
                if ($dataMasukKiper->foto_kiper && file_exists(storage_path('app/public/' . $dataMasukKiper->foto_kiper))) {
                    Storage::delete('public/' . $dataMasukKiper->foto_kiper);
                    $fileGambar = $request->file('foto_kiper')->store('finish-kiper', 'public');
                }
            }

            if ($request->file('foto_kiper') === null) {
                $fileGambar = $dataMasukKiper->foto_kiper;
            }

            $dataMasukKiper->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'foto_kiper' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->lk1_id) {
            $dataMasuk1 = Finish::find($request->lk1_id);

            if ($request->file('foto_1')) {
                $fileGambar = $request->file('foto_1')->store('finish-1', 'public');
                if ($dataMasuk1->foto_1 && file_exists(storage_path('app/public/' . $dataMasuk1->foto_1))) {
                    Storage::delete('public/' . $dataMasuk1->foto_1);
                    $fileGambar = $request->file('foto_1')->store('finish-1', 'public');
                }
            }

            if ($request->file('foto_1') === null) {
                $fileGambar = $dataMasuk1->foto_1;
            }

            $dataMasuk1->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'foto_1' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_player_id) {
            $dataMasukCelanaPlayer = Finish::find($request->celana_player_id);

            if ($request->file('foto_celana_pelayer')) {
                $fileGambar = $request->file('foto_celana_pelayer')->store('finish-celana-player', 'public');
                if ($dataMasukCelanaPlayer->foto_celana_pelayer && file_exists(storage_path('app/public/' . $dataMasukCelanaPlayer->foto_celana_pelayer))) {
                    Storage::delete('public/' . $dataMasukCelanaPlayer->foto_celana_pelayer);
                    $fileGambar = $request->file('foto_celana_pelayer')->store('finish-celana-player', 'public');
                }
            }

            if ($request->file('foto_celana_pelayer') === null) {
                $fileGambar = $dataMasukCelanaPlayer->foto_celana_pelayer;
            }

            $dataMasukCelanaPlayer->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'foto_celana_pelayer' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_pelatih_id) {
            $dataMasukCelanapelatih = Finish::find($request->celana_pelatih_id);

            if ($request->file('foto_celana_pelatih')) {
                $fileGambar = $request->file('foto_celana_pelatih')->store('finish-celana-pelatih', 'public');
                if ($dataMasukCelanapelatih->foto_celana_pelatih && file_exists(storage_path('app/public/' . $dataMasukCelanapelatih->foto_celana_pelatih))) {
                    Storage::delete('public/' . $dataMasukCelanapelatih->foto_celana_pelatih);
                    $fileGambar = $request->file('foto_celana_pelatih')->store('finish-celana-pelatih', 'public');
                }
            }

            if ($request->file('foto_celana_pelatih') === null) {
                $fileGambar = $dataMasukCelanapelatih->foto_celana_pelatih;
            }

            $dataMasukCelanapelatih->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'foto_celana_pelatih' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_kiper_id) {
            $dataMasukCelanaKiper = Finish::find($request->celana_kiper_id);

            if ($request->file('foto_celana_kiper')) {
                $fileGambar = $request->file('foto_celana_kiper')->store('finish-celana-kiper', 'public');
                if ($dataMasukCelanaKiper->foto_celana_kiper && file_exists(storage_path('app/public/' . $dataMasukCelanaKiper->foto_celana_kiper))) {
                    Storage::delete('public/' . $dataMasukCelanaKiper->foto_celana_kiper);
                    $fileGambar = $request->file('foto_celana_kiper')->store('finish-celana-kiper', 'public');
                }
            }

            if ($request->file('foto_celana_kiper') === null) {
                $fileGambar = $dataMasukCelanaKiper->foto_celana_kiper;
            }

            $dataMasukCelanaKiper->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'foto_celana_kiper' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_1_id) {
            $dataMasukCelana1 = Finish::find($request->celana_1_id);

            if ($request->file('foto_celana_1')) {
                $fileGambar = $request->file('foto_celana_1')->store('finish-celana-1', 'public');
                if ($dataMasukCelana1->foto_celana_1 && file_exists(storage_path('app/public/' . $dataMasukCelana1->foto_celana_1))) {
                    Storage::delete('public/' . $dataMasukCelana1->foto_celana_1);
                    $fileGambar = $request->file('foto_celana_1')->store('finish-celana-1', 'public');
                }
            }

            if ($request->file('foto_celana_1') === null) {
                $fileGambar = $dataMasukCelana1->foto_celana_1;
            }

            $dataMasukCelana1->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'foto_celana_1' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }

        if ($dataMasukPlayer) {
            if ($request->player_id) {
                $laporanPlayer = Laporan::where('finis_id', $request->player_id)->first();
                if ($laporanPlayer) {
                    $laporanPlayer->update([
                        'status' => 'Selesai',
                    ]);
                }
            }
            if ($request->pelatih_id) {
                $laporanPelatih = Laporan::where('finis_id', $request->pelatih_id)->first();
                if ($laporanPelatih) {
                    $laporanPelatih->update([
                        'status' => 'Selesai',
                    ]);
                }
            }
            if ($request->kiper_id) {
                $laporanKiper = Laporan::where('finis_id', $request->kiper_id)->first();
                if ($laporanKiper) {
                    $laporanKiper->update([
                        'status' => 'Selesai',
                    ]);
                }
            }
            if ($request->lk1_id) {
                $laporan1 = Laporan::where('finis_id', $request->lk1_id)->first();
                if ($laporan1) {
                    $laporan1->update([
                        'status' => 'Selesai',
                    ]);
                }
            }
            if ($request->celana_player_id) {
                $laporanCelanaPlayer = Laporan::where('finis_id', $request->celana_player_id)->first();
                if ($laporanCelanaPlayer) {
                    $laporanCelanaPlayer->update([
                        'status' => 'Selesai',
                    ]);
                }
            }
            if ($request->celana_pelatih_id) {
                $laporanCelanaPelatih = Laporan::where('finis_id', $request->celana_pelatih_id)->first();
                if ($laporanCelanaPelatih) {
                    $laporanCelanaPelatih->update([
                        'status' => 'Selesai',
                    ]);
                }
            }
            if ($request->celana_kiper_id) {
                $laporanCelanaKiper = Laporan::where('finis_id', $request->celana_kiper_id)->first();
                if ($laporanCelanaKiper) {
                    $laporanCelanaKiper->update([
                        'status' => 'Selesai',
                    ]);
                }
            }
            if ($request->celana_1_id) {
                $laporanCelana1 = Laporan::where('finis_id', $request->celana_1_id)->first();
                if ($laporanCelana1) {
                    $laporanCelana1->update([
                        'status' => 'Selesai',
                    ]);
                }
            }
        }

        return redirect()->route('getIndexFixFinis')->with('success', 'Selamat data yang anda input telah terkirim!');
    }

    public function getIndexFix()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = Finish::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = Finish::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = Finish::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } else {
            $dataMasuk = Finish::with('BarangMasukCs', 'BarangMasukJahitCelana', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukJahitCelana', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        }

        return view('component.Finis.index-fix', compact('dataMasuk'));
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

        $layout = BarangMasukDatalayout::where('barang_masuk_id', $dataLk->BarangMasukDisainer->id)->get();

        $formattedData = [];

        foreach ($layout as $item) {
            if ($item->lk_player_id) {
                $formattedData['player'] = [
                    'file_tangkap_layar_player' => $item->file_tangkap_layar_player
                ];
            } elseif ($item->lk_pelatih_id) {
                $formattedData['pelatih'] = [
                    'file_tangkap_layar_pelatih' => $item->file_tangkap_layar_pelatih,
                ];
            } elseif ($item->lk_kiper_id) {
                $formattedData['kiper'] = [
                    'file_tangkap_layar_kiper' => $item->file_tangkap_layar_kiper
                ];
            } elseif ($item->lk_1_id) {
                $formattedData['lk_1'] = [
                    'file_tangkap_layar_1' => $item->file_tangkap_layar_1,
                ];
            } elseif ($item->lk_celana_player_id) {
                $formattedData['celana_player'] = [
                    'file_tangkap_layar_celana_pelayer' => $item->file_tangkap_layar_celana_pelayer,
                ];
            } elseif ($item->lk_celana_pelatih_id) {
                $formattedData['celana_pelatih'] = [
                    'file_tangkap_layar_celana_pelatih' => $item->file_tangkap_layar_celana_pelatih
                ];
            } elseif ($item->lk_celana_kiper_id) {
                $formattedData['celana_kiper'] = [
                    'file_tangkap_layar_celana_kiper' => $item->file_tangkap_layar_celana_kiper
                ];
            } elseif ($item->lk_celana_1_id) {
                $formattedData['celana_1'] = [
                    'file_tangkap_layar_celana_1' => $item->file_tangkap_layar_celana_1,
                ];
            }
        }

        // return response()->json($layout);
        view()->share('dataLk', $dataLk->BarangMasukDisainer->nama_tim);

        $pdf = PDF::loadview('component.Mesin.export-data-baju', compact('dataLk', 'formattedData'));
        $pdf->setPaper('A4', 'potrait');

        // return $pdf->stream('data-baju.pdf');
        $namaTimClean = preg_replace('/[^A-Za-z0-9\-]/', '', $dataLk->BarangMasukDisainer->nama_tim);
        return $pdf->stream($namaTimClean . '.pdf');
    }
}
