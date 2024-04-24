<?php

namespace App\Http\Controllers\LaserCut;

use App\Http\Controllers\Controller;
use App\Models\BarangMasukCostumerServices;
use App\Models\BarangMasukDatalayout;
use App\Models\DataLaserCut;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class LaserCutController extends Controller
{
    public function getIndex()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = DataLaserCut::with('BarangMasukCs', 'BarangMasukPresKain', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = DataLaserCut::with('BarangMasukCs', 'BarangMasukPresKain', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = DataLaserCut::with('BarangMasukCs', 'BarangMasukPresKain', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } else {
            $dataMasuk = DataLaserCut::with('BarangMasukCs', 'BarangMasukPresKain', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        }

        return view('component.Laser-Cut.index', compact('dataMasuk'));
    }

    public function getInputLaporan($id)
    {
        $dataMasuk = DataLaserCut::with('BarangMasukPresKain')->get();

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

        return view('component.Laser-Cut.cerate-laporan-mesin', compact('dataMasuk', 'formattedData'));
    }

    public function putLaporan(Request $request, $id)
    {
        $user = Auth::user();

        if ($request->player_id) {
            $dataMasukPlayer = DataLaserCut::findOrFail($request->player_id);

            if ($request->file('file_foto')) {
                $fileGambar = $request->file('file_foto')->store('manual-cut-player', 'public');
                if ($dataMasukPlayer->file_foto && file_exists(storage_path('app/public/' . $dataMasukPlayer->file_foto))) {
                    Storage::delete('public/' . $dataMasukPlayer->file_foto);
                    $fileGambar = $request->file('file_foto')->store('manual-cut-player', 'public');
                }
            }

            if ($request->file('file_foto') === null) {
                $fileGambar = $dataMasukPlayer->file_foto;
            }

            $dataMasukPlayer->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->pelatih_id) {
            $dataMasukPelatih = DataLaserCut::findOrFail($request->pelatih_id);

            if ($request->file('file_foto_pelatih')) {
                $fileGambar = $request->file('file_foto_pelatih')->store('manual-cut-pelatih', 'public');
                if ($dataMasukPelatih->file_foto_pelatih && file_exists(storage_path('app/public/' . $dataMasukPelatih->file_foto_pelatih))) {
                    Storage::delete('public/' . $dataMasukPelatih->file_foto_pelatih);
                    $fileGambar = $request->file('file_foto_pelatih')->store('manual-cut-pelatih', 'public');
                }
            }

            if ($request->file('file_foto_pelatih') === null) {
                $fileGambar = $dataMasukPelatih->file_foto_pelatih;
            }

            $dataMasukPelatih->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto_pelatih' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->kiper_id) {
            $dataMasukKiper = DataLaserCut::findOrFail($request->kiper_id);

            if ($request->file('file_foto_kiper')) {
                $fileGambar = $request->file('file_foto_kiper')->store('manual-cut-kiper', 'public');
                if ($dataMasukKiper->file_foto_kiper && file_exists(storage_path('app/public/' . $dataMasukKiper->file_foto_kiper))) {
                    Storage::delete('public/' . $dataMasukKiper->file_foto_kiper);
                    $fileGambar = $request->file('file_foto_kiper')->store('manual-cut-kiper', 'public');
                }
            }

            if ($request->file('file_foto_kiper') === null) {
                $fileGambar = $dataMasukKiper->file_foto_kiper;
            }

            $dataMasukKiper->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto_kiper' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->lk1_id) {
            $dataMasuk1 = DataLaserCut::findOrFail($request->lk1_id);

            if ($request->file('file_foto_1')) {
                $fileGambar = $request->file('file_foto_1')->store('manual-cut-1', 'public');
                if ($dataMasuk1->file_foto_1 && file_exists(storage_path('app/public/' . $dataMasuk1->file_foto_1))) {
                    Storage::delete('public/' . $dataMasuk1->file_foto_1);
                    $fileGambar = $request->file('file_foto_1')->store('manual-cut-1', 'public');
                }
            }

            if ($request->file('file_foto_1') === null) {
                $fileGambar = $dataMasuk1->file_foto_1;
            }

            $dataMasuk1->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto_1' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_player_id) {
            $dataMasukCelanaPlayer = DataLaserCut::findOrFail($request->celana_player_id);

            if ($request->file('file_foto_celana_player')) {
                $fileGambar = $request->file('file_foto_celana_player')->store('manual-cut-celana-player', 'public');
                if ($dataMasukCelanaPlayer->file_foto_celana_player && file_exists(storage_path('app/public/' . $dataMasukCelanaPlayer->file_foto_celana_player))) {
                    Storage::delete('public/' . $dataMasukCelanaPlayer->file_foto_celana_player);
                    $fileGambar = $request->file('file_foto_celana_player')->store('manual-cut-celana-player', 'public');
                }
            }

            if ($request->file('file_foto_celana_player') === null) {
                $fileGambar = $dataMasukCelanaPlayer->file_foto_celana_player;
            }

            $dataMasukCelanaPlayer->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto_celana_player' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_pelatih_id) {
            $dataMasukCelanaPelatih = DataLaserCut::findOrFail($request->celana_pelatih_id);

            if ($request->file('file_foto_celana_pelatih')) {
                $fileGambar = $request->file('file_foto_celana_pelatih')->store('manual-cut-pelatih', 'public');
                if ($dataMasukCelanaPelatih->file_foto_celana_pelatih && file_exists(storage_path('app/public/' . $dataMasukCelanaPelatih->file_foto_celana_pelatih))) {
                    Storage::delete('public/' . $dataMasukCelanaPelatih->file_foto_celana_pelatih);
                    $fileGambar = $request->file('file_foto_celana_pelatih')->store('manual-cut-pelatih', 'public');
                }
            }

            if ($request->file('file_foto_celana_pelatih') === null) {
                $fileGambar = $dataMasukCelanaPelatih->file_foto_celana_pelatih;
            }

            $dataMasukCelanaPelatih->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto_celana_pelatih' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_kiper_id) {
            $dataMasukCelanaKiper = DataLaserCut::findOrFail($request->celana_kiper_id);

            if ($request->file('file_foto_celana_kiper')) {
                $fileGambar = $request->file('file_foto_celana_kiper')->store('manaul-cut-celana-kiper', 'public');
                if ($dataMasukCelanaKiper->file_foto_celana_kiper && file_exists(storage_path('app/public/' . $dataMasukCelanaKiper->file_foto_celana_kiper))) {
                    Storage::delete('public/' . $dataMasukCelanaKiper->file_foto_celana_kiper);
                    $fileGambar = $request->file('file_foto_celana_kiper')->store('manaul-cut-celana-kiper', 'public');
                }
            }

            if ($request->file('file_foto_celana_kiper') === null) {
                $fileGambar = $dataMasukCelanaKiper->file_foto_celana_kiper;
            }

            $dataMasukCelanaKiper->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto_celana_kiper' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_1_id) {
            $dataMasukCelana1 = DataLaserCut::findOrFail($request->celana_1_id);

            if ($request->file('file_foto_celana_1')) {
                $fileGambar = $request->file('file_foto_celana_1')->store('manual-cut-celana-1', 'public');
                if ($dataMasukCelana1->file_foto_celana_1 && file_exists(storage_path('app/public/' . $dataMasukCelana1->file_foto_celana_1))) {
                    Storage::delete('public/' . $dataMasukCelana1->file_foto_celana_1);
                    $fileGambar = $request->file('file_foto_celana_1')->store('manual-cut-celana-1', 'public');
                }
            }

            if ($request->file('file_foto_celana_1') === null) {
                $fileGambar = $dataMasukCelana1->file_foto_celana_1;
            }

            $dataMasukCelana1->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto_celana_1' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }

        if ($dataMasukPlayer) {
            if ($request->player_id) {
                $laporanPlayer = Laporan::findOrFail($request->player_id);
                if ($laporanPlayer) {
                    $laporanPlayer->update([
                        'status' => 'Manual Cut',
                    ]);
                }
            }
            if ($request->pelatih_id) {
                $laporanPelatih = Laporan::findOrFail($request->pelatih_id);
                if ($laporanPelatih) {
                    $laporanPelatih->update([
                        'status' => 'Manual Cut',
                    ]);
                }
            }
            if ($request->kiper_id) {
                $laporanKiper = Laporan::findOrFail($request->kiper_id);
                if ($laporanKiper) {
                    $laporanKiper->update([
                        'status' => 'Manual Cut',
                    ]);
                }
            }
            if ($request->lk1_id) {
                $laporan1 = Laporan::findOrFail($request->lk1_id);
                if ($laporan1) {
                    $laporan1->update([
                        'status' => 'Manual Cut',
                    ]);
                }
            }
            if ($request->celana_player_id) {
                $laporanCelanaPlayer = Laporan::findOrFail($request->celana_player_id);
                if ($laporanCelanaPlayer) {
                    $laporanCelanaPlayer->update([
                        'status' => 'Manual Cut',
                    ]);
                }
            }
            if ($request->celana_pelatih_id) {
                $laporanCelanaPelatih = Laporan::findOrFail($request->celana_pelatih_id);
                if ($laporanCelanaPelatih) {
                    $laporanCelanaPelatih->update([
                        'status' => 'Manual Cut',
                    ]);
                }
            }
            if ($request->celana_kiper_id) {
                $laporanCelanaKiper = Laporan::findOrFail($request->celana_kiper_id);
                if ($laporanCelanaKiper) {
                    $laporanCelanaKiper->update([
                        'status' => 'Manual Cut',
                    ]);
                }
            }
            if ($request->celana_1_id) {
                $laporanCelana1 = Laporan::findOrFail($request->celana_1_id);
                if ($laporanCelana1) {
                    $laporanCelana1->update([
                        'status' => 'Manual Cut',
                    ]);
                }
            }
        }

        return redirect()->route('getIndexFixLaserCut')->with('success', 'Selamat data yang anda input telah terkirim!');
    }

    public function getIndexFix()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = DataLaserCut::with('BarangMasukCs', 'BarangMasukPresKain', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = DataLaserCut::with('BarangMasukCs', 'BarangMasukPresKain', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = DataLaserCut::with('BarangMasukCs', 'BarangMasukPresKain', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } else {
            $dataMasuk = DataLaserCut::with('BarangMasukCs', 'BarangMasukPresKain', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukPresKain', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        }

        return view('component.Laser-Cut.index-fix', compact('dataMasuk'));
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
