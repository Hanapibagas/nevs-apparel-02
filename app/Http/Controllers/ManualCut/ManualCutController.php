<?php

namespace App\Http\Controllers\ManualCut;

use App\Http\Controllers\Controller;
use App\Models\BahanKain;
use App\Models\BarangMasukCostumerServices;
use App\Models\BarangMasukDatalayout;
use App\Models\DataManualCut;
use App\Models\Laporan;
use App\Models\LaporanCetakCutPolos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;


class ManualCutController extends Controller
{
    public function getIndex()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = DataManualCut::with(
                'BarangMasukCs',
                'BarangMasukLaserCut',
                'BarangMasukCs.BarangMasukDisainer',
                'BarangMasukCostumerServicesLkPlyer',

                'BarangMasukCostumerServicesLkPelatih',

                'BarangMasukCostumerServicesLkKiper',
                'BarangMasukCostumerServicesLk1',

                'BarangMasukCostumerServicesLkCelanaPlyer',

                'BarangMasukCostumerServicesLkCelanaPelatih',
                'BarangMasukCostumerServicesLkCelanaKiper',

                'BarangMasukCostumerServicesLkCelana1',
            )
                ->where('tanda_telah_mengerjakan', 0)
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
            $dataMasuk = DataManualCut::with('BarangMasukCs', 'BarangMasukLaserCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukLaserCut', function ($query) {
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
            $dataMasuk = DataManualCut::with('BarangMasukCs', 'BarangMasukLaserCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukLaserCut', function ($query) {
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
            $dataMasuk = DataManualCut::with('BarangMasukCs', 'BarangMasukLaserCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukLaserCut', function ($query) {
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

        // return response()->json($dataMasuk);
        return view('component.Manual-Cut.index', compact('dataMasuk'));
    }

    public function getInputLaporan($id)
    {
        $dataMasuk = DataManualCut::where('no_order_id', $id)->with('BarangMasukLaserCut')->get();

        $bahanKain = BahanKain::all();
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

        return view('component.Manual-Cut.cerate-laporan-mesin', compact('dataMasuk', 'bahanKain', 'formattedData'));
    }

    public function putLaporan(Request $request)
    {
        $user = Auth::user();

        if ($request->player_id) {
            $dataMasukPlayer = DataManualCut::with('BarangMasukCs')->findOrFail($request->player_id);

            if ($request->file('file_foto')) {
                $fileGambar = $request->file('file_foto')->store('laser-cut-player', 'public');
                if ($dataMasukPlayer->file_foto && file_exists(storage_path('app/public/' . $dataMasukPlayer->file_foto))) {
                    Storage::delete('public/' . $dataMasukPlayer->file_foto);
                    $fileGambar = $request->file('file_foto')->store('laser-cut-player', 'public');
                }
            }

            if ($request->file('file_foto') === null) {
                $fileGambar = $dataMasukPlayer->file_foto;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasukPlayer->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => $selesaiTime,
                'keterangan' => $request->keterangan,
                'kain_id' => $request->kain_id,
                'kain' => $request->kain,
                'file_foto' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);

            LaporanCetakCutPolos::create([
                'press_kain_id' => $dataMasukPlayer->id,
                'kain_id' => $request->kain_id,
                'daerah' => $dataMasukPlayer->BarangMasukCs->kota_produksi,
                'total_kain' => $request->kain
            ]);
        }
        if ($request->pelatih_id) {
            $dataMasukPelatih = DataManualCut::with('BarangMasukCs')->findOrFail($request->pelatih_id);

            if ($request->file('file_foto_pelatih')) {
                $fileGambar = $request->file('file_foto_pelatih')->store('laser-cut-pelatih', 'public');
                if ($dataMasukPelatih->file_foto_pelatih && file_exists(storage_path('app/public/' . $dataMasukPelatih->file_foto_pelatih))) {
                    Storage::delete('public/' . $dataMasukPelatih->file_foto_pelatih);
                    $fileGambar = $request->file('file_foto_pelatih')->store('laser-cut-pelatih', 'public');
                }
            }

            if ($request->file('file_foto_pelatih') === null) {
                $fileGambar = $dataMasukPelatih->file_foto_pelatih;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasukPelatih->update([
                'penanggung_jawab_id' => $user->id,
                'kain_id' => $request->kain_id,
                'kain_pelatih' => $request->kain_pelatih,
                'selesai' => $selesaiTime,
                'keterangan2' => $request->keterangan2,
                'file_foto_pelatih' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);

            LaporanCetakCutPolos::create([
                'press_kain_id' => $dataMasukPlayer->id,
                'kain_id' => $request->kain_id,
                'daerah' => $dataMasukPlayer->BarangMasukCs->kota_produksi,
                'total_kain' => $request->kain
            ]);
        }
        if ($request->kiper_id) {
            $dataMasukKiper = DataManualCut::with('BarangMasukCs')->findOrFail($request->kiper_id);

            if ($request->file('file_foto_kiper')) {
                $fileGambar = $request->file('file_foto_kiper')->store('laser-cut-kiper', 'public');
                if ($dataMasukKiper->file_foto_kiper && file_exists(storage_path('app/public/' . $dataMasukKiper->file_foto_kiper))) {
                    Storage::delete('public/' . $dataMasukKiper->file_foto_kiper);
                    $fileGambar = $request->file('file_foto_kiper')->store('laser-cut-kiper', 'public');
                }
            }

            if ($request->file('file_foto_kiper') === null) {
                $fileGambar = $dataMasukKiper->file_foto_kiper;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasukKiper->update([
                'penanggung_jawab_id' => $user->id,
                'keterangan3' => $request->keterangan3,
                'kain_id' => $request->kain_id,
                'kain_kiper' => $request->kain_kiper,
                'selesai' => $selesaiTime,
                'file_foto_kiper' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);

            LaporanCetakCutPolos::create([
                'press_kain_id' => $dataMasukPelatih->id,
                'kain_id' => $request->kain_id,
                'daerah' => $dataMasukPelatih->BarangMasukCs->kota_produksi,
                'total_kain' => $request->kain_kiper
            ]);
        }
        if ($request->lk1_id) {
            $dataMasuk1 = DataManualCut::with('BarangMasukCs')->findOrFail($request->lk1_id);

            if ($request->file('file_foto_1')) {
                $fileGambar = $request->file('file_foto_1')->store('laser-cut-1', 'public');
                if ($dataMasuk1->file_foto_1 && file_exists(storage_path('app/public/' . $dataMasuk1->file_foto_1))) {
                    Storage::delete('public/' . $dataMasuk1->file_foto_1);
                    $fileGambar = $request->file('file_foto_1')->store('laser-cut-1', 'public');
                }
            }

            if ($request->file('file_foto_1') === null) {
                $fileGambar = $dataMasuk1->file_foto_1;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasuk1->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => $selesaiTime,
                'keterangan4' => $request->keterangan4,
                'kain_1' => $request->kain_1,
                'kain_id' => $request->kain_id,
                'file_foto_1' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);

            LaporanCetakCutPolos::create([
                'press_kain_id' => $dataMasuk1->id,
                'kain_id' => $request->kain_id,
                'daerah' => $dataMasuk1->BarangMasukCs->kota_produksi,
                'total_kain' => $request->kain_1
            ]);
        }
        if ($request->celana_player_id) {
            $dataMasukCelanaPlayer = DataManualCut::with('BarangMasukCs')->findOrFail($request->celana_player_id);

            if ($request->file('file_foto_celana_player')) {
                $fileGambar = $request->file('file_foto_celana_player')->store('laser-cut-celana-player', 'public');
                if ($dataMasukCelanaPlayer->file_foto_celana_player && file_exists(storage_path('app/public/' . $dataMasukCelanaPlayer->file_foto_celana_player))) {
                    Storage::delete('public/' . $dataMasukCelanaPlayer->file_foto_celana_player);
                    $fileGambar = $request->file('file_foto_celana_player')->store('laser-cut-celana-player', 'public');
                }
            }

            if ($request->file('file_foto_celana_player') === null) {
                $fileGambar = $dataMasukCelanaPlayer->file_foto_celana_player;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasukCelanaPlayer->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => $selesaiTime,
                'keterangan5' => $request->keterangan5,
                'kain_celana_player' => $request->kain_celana_player,
                'kain_id' => $request->kain_id,
                'file_foto_celana_player' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);

            LaporanCetakCutPolos::create([
                'press_kain_id' => $dataMasukCelanaPlayer->id,
                'kain_id' => $request->kain_id,
                'daerah' => $dataMasukCelanaPlayer->BarangMasukCs->kota_produksi,
                'total_kain' => $request->kain_celana_player
            ]);
        }
        if ($request->celana_pelatih_id) {
            $dataMasukCelanaPelatih = DataManualCut::with('BarangMasukCs')->findOrFail($request->celana_pelatih_id);

            if ($request->file('file_foto_celana_pelatih')) {
                $fileGambar = $request->file('file_foto_celana_pelatih')->store('laser-cut-celana-pelatih', 'public');
                if ($dataMasukCelanaPelatih->file_foto_celana_pelatih && file_exists(storage_path('app/public/' . $dataMasukCelanaPelatih->file_foto_celana_pelatih))) {
                    Storage::delete('public/' . $dataMasukCelanaPelatih->file_foto_celana_pelatih);
                    $fileGambar = $request->file('file_foto_celana_pelatih')->store('laser-cut-celana-pelatih', 'public');
                }
            }

            if ($request->file('file_foto_celana_pelatih') === null) {
                $fileGambar = $dataMasukCelanaPelatih->file_foto_celana_pelatih;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasukCelanaPelatih->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => $selesaiTime,
                'file_foto_celana_pelatih' => $fileGambar,
                'kain_celana_pelatih' => $request->kain_celana_pelatih,
                'keterangan6' => $request->keterangan6,
                'kain_id' => $request->kain_id,
                'tanda_telah_mengerjakan' => 1
            ]);

            LaporanCetakCutPolos::create([
                'press_kain_id' => $dataMasukCelanaPelatih->id,
                'kain_id' => $request->kain_id,
                'daerah' => $dataMasukCelanaPelatih->BarangMasukCs->kota_produksi,
                'total_kain' => $request->kain_celana_pelatih
            ]);
        }
        if ($request->celana_kiper_id) {
            $dataMasukCelanaKiper = DataManualCut::with('BarangMasukCs')->findOrFail($request->celana_kiper_id);

            if ($request->file('file_foto_celana_kiper')) {
                $fileGambar = $request->file('file_foto_celana_kiper')->store('laser-cut-celana-kiper', 'public');
                if ($dataMasukCelanaKiper->file_foto_celana_kiper && file_exists(storage_path('app/public/' . $dataMasukCelanaKiper->file_foto_celana_kiper))) {
                    Storage::delete('public/' . $dataMasukCelanaKiper->file_foto_celana_kiper);
                    $fileGambar = $request->file('file_foto_celana_kiper')->store('laser-cut-celana-kiper', 'public');
                }
            }

            if ($request->file('file_foto_celana_kiper') === null) {
                $fileGambar = $dataMasukCelanaKiper->file_foto_celana_kiper;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasukCelanaKiper->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => $selesaiTime,
                'file_foto_celana_kiper' => $fileGambar,
                'kain_celana_kiper' => $request->kain_celana_kiper,
                'kain_id' => $request->kain_id,
                'keterangan7' => $request->keterangan7,
                'tanda_telah_mengerjakan' => 1
            ]);

            LaporanCetakCutPolos::create([
                'press_kain_id' => $dataMasukCelanaKiper->id,
                'kain_id' => $request->kain_id,
                'daerah' => $dataMasukCelanaKiper->BarangMasukCs->kota_produksi,
                'total_kain' => $request->kain_celana_kiper
            ]);
        }
        if ($request->celana_1_id) {
            $dataMasukCelana1 = DataManualCut::with('BarangMasukCs')->findOrFail($request->celana_1_id);

            if ($request->file('file_foto_celana_1')) {
                $fileGambar = $request->file('file_foto_celana_1')->store('laser-cut-celana-1', 'public');
                if ($dataMasukCelana1->file_foto_celana_1 && file_exists(storage_path('app/public/' . $dataMasukCelana1->file_foto_celana_1))) {
                    Storage::delete('public/' . $dataMasukCelana1->file_foto_celana_1);
                    $fileGambar = $request->file('file_foto_celana_1')->store('laser-cut-celana-1', 'public');
                }
            }

            if ($request->file('file_foto_celana_1') === null) {
                $fileGambar = $dataMasukCelana1->file_foto_celana_1;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasukCelana1->update([
                'penanggung_jawab_id' => $user->id,
                'keterangan8' => $request->keterangan8,
                'kain_celana_1' => $request->kain_celana_1,
                'kain_id' => $request->kain_id,
                'selesai' => $selesaiTime,
                'file_foto_celana_1' => $fileGambar,
                'tanda_telah_mengerjakan' => 1
            ]);

            LaporanCetakCutPolos::create([
                'press_kain_id' => $dataMasukCelana1->id,
                'kain_id' => $request->kain_id,
                'daerah' => $dataMasukCelana1->BarangMasukCs->kota_produksi,
                'total_kain' => $request->kain_celana_1
            ]);
        }
        // return response()->json($dataMasukPlayer);

        // if ($dataMasukPlayer) {
        if ($request->player_id) {
            $laporanPlayer = Laporan::where('barang_masuk_manualcut_id', $request->player_id)->first();
            if ($laporanPlayer) {
                $laporanPlayer->update([
                    'status' => 'Sortir',
                ]);
            }
        }
        if ($request->pelatih_id) {
            $laporanPelatih = Laporan::where('barang_masuk_manualcut_id', $request->pelatih_id)->first();
            if ($laporanPelatih) {
                $laporanPelatih->update([
                    'status' => 'Sortir',
                ]);
            }
        }
        if ($request->kiper_id) {
            $laporanKiper = Laporan::where('barang_masuk_manualcut_id', $request->kiper_id)->first();
            if ($laporanKiper) {
                $laporanKiper->update([
                    'status' => 'Sortir',
                ]);
            }
        }
        if ($request->lk1_id) {
            $laporan1 = Laporan::where('barang_masuk_manualcut_id', $request->lk1_id)->first();
            if ($laporan1) {
                $laporan1->update([
                    'status' => 'Sortir',
                ]);
            }
        }
        if ($request->celana_player_id) {
            $laporanCelanaPlayer = Laporan::where('barang_masuk_manualcut_id', $request->celana_player_id)->first();
            if ($laporanCelanaPlayer) {
                $laporanCelanaPlayer->update([
                    'status' => 'Sortir',
                ]);
            }
        }
        if ($request->celana_pelatih_id) {
            $laporanCelanaPelatih = Laporan::where('barang_masuk_manualcut_id', $request->celana_pelatih_id)->first();
            if ($laporanCelanaPelatih) {
                $laporanCelanaPelatih->update([
                    'status' => 'Sortir',
                ]);
            }
        }
        if ($request->celana_kiper_id) {
            $laporanCelanaKiper = Laporan::where('barang_masuk_manualcut_id', $request->celana_kiper_id)->first();
            if ($laporanCelanaKiper) {
                $laporanCelanaKiper->update([
                    'status' => 'Sortir',
                ]);
            }
        }
        if ($request->celana_1_id) {
            $laporanCelana1 = Laporan::where('barang_masuk_manualcut_id', $request->celana_1_id)->first();
            if ($laporanCelana1) {
                $laporanCelana1->update([
                    'status' => 'Sortir',
                ]);
            }
        }
        // }

        return redirect()->route('getIndexFixManualCut')->with('success', 'Selamat data yang anda input telah terkirim!');
    }

    public function getIndexFix()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = DataManualCut::with('BarangMasukCs', 'BarangMasukLaserCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukLaserCut', function ($query) {
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
            $dataMasuk = DataManualCut::with('BarangMasukCs', 'BarangMasukLaserCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukLaserCut', function ($query) {
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
            $dataMasuk = DataManualCut::with('BarangMasukCs', 'BarangMasukLaserCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukLaserCut', function ($query) {
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
            $dataMasuk = DataManualCut::with('BarangMasukCs', 'BarangMasukLaserCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukLaserCut', function ($query) {
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
        return view('component.Manual-Cut.index-fix', compact('dataMasuk'));
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

        $layout = BarangMasukDatalayout::with('GamarTangkaplayar')->where('barang_masuk_id', $id)->get();
        // return response()->json($layout);
        view()->share('dataLk', $dataLk->BarangMasukDisainer->nama_tim);

        $pdf = PDF::loadview('component.Mesin.export-data-baju', compact('dataLk', 'layout'));
        $pdf->setPaper('A4', 'potrait');

        // return $pdf->stream('data-baju.pdf');
        $namaTimClean = preg_replace('/[^A-Za-z0-9\-]/', '', $dataLk->BarangMasukDisainer->nama_tim);
        return $pdf->stream($namaTimClean . '.pdf');
    }
}
