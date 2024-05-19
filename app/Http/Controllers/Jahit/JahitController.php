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
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = Jahit::with('BarangMasukCs', 'BarangMasukSortir', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukSortir', function ($query) {
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
            $dataMasuk = Jahit::with('BarangMasukCs', 'BarangMasukSortir', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukSortir', function ($query) {
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
            $dataMasuk = Jahit::with('BarangMasukCs', 'BarangMasukSortir', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukSortir', function ($query) {
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

        return view('component.Jahit.index', compact('dataMasuk'));
    }

    public function getInputLaporan($id)
    {
        $dataMasuk = Jahit::where('no_order_id', $id)->with('BarangMasukCs')->get();

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

        return view('component.Jahit.cerate-laporan-mesin', compact('dataMasuk', 'formattedData'));
    }

    public function getInputLaporanSerah($id)
    {
        $dataMasuk = Jahit::where('no_order_id', $id)->with('BarangMasukCs')->get();

        $formattedData = [];

        foreach ($dataMasuk as $item) {
            if ($item->lk_player_id) {
                $formattedData['player'][] = [
                    'id' => $item->id,
                    'leher' => $item->leher,
                    'keterangan' => $item->keterangan,
                ];
            } elseif ($item->lk_pelatih_id) {
                $formattedData['pelatih'][] = [
                    'id' => $item->id,
                    'leher_pelatih' => $item->leher_pelatih,
                    'keterangan2' => $item->keterangan2,
                ];
            } elseif ($item->lk_kiper_id) {
                $formattedData['kiper'][] = [
                    'id' => $item->id,
                    'leher_kiper' => $item->leher_kiper,
                    'keterangan3' => $item->keterangan3,
                ];
            } elseif ($item->lk_1_id) {
                $formattedData['lk_1'][] = [
                    'id' => $item->id,
                    'leher_1' => $item->leher_1,
                    'keterangan4' => $item->keterangan4,
                ];
            } elseif ($item->lk_celana_player_id) {
                $formattedData['celana_player'][] = [
                    'id' => $item->id,
                    'leher_celana_pelayer' => $item->leher_celana_pelayer,
                    'keterangan5' => $item->keterangan5,
                ];
            } elseif ($item->lk_celana_pelatih_id) {
                $formattedData['celana_pelatih'][] = [
                    'id' => $item->id,
                    'leher_celana_pelatih' => $item->leher_celana_pelatih,
                    'keterangan6' => $item->keterangan6,
                ];
            } elseif ($item->lk_celana_kiper_id) {
                $formattedData['celana_kiper'][] = [
                    'id' => $item->id,
                    'leher_celana_kiper' => $item->leher_celana_kiper,
                    'keterangan7' => $item->keterangan7,
                ];
            } elseif ($item->lk_celana_1_id) {
                $formattedData['celana_1'][] = [
                    'id' => $item->id,
                    'leher_celana_1' => $item->leher_celana_1,
                    'keterangan8' => $item->keterangan8,
                ];
            }
        }

        return view('component.Jahit.cerate-laporan-mesin-terima', compact('dataMasuk', 'formattedData'));
    }

    public function putLaporan(Request $request)
    {
        // return response()->json($request->all());
        $user = Auth::user();
        if ($request->player_id) {
            $dataMasukPlayer = Jahit::find($request->player_id);

            if ($request->file('pola_badan')) {
                $fileGambar = $request->file('pola_badan')->store('serah-terima-player', 'public');
                if ($dataMasukPlayer->pola_badan && file_exists(storage_path('app/public/' . $dataMasukPlayer->pola_badan))) {
                    Storage::delete('public/' . $dataMasukPlayer->pola_badan);
                    $fileGambar = $request->file('pola_badan')->store('serah-terima-player', 'public');
                }
            }

            if ($request->file('pola_badan') === null) {
                $fileGambar = $dataMasukPlayer->pola_badan;
            }

            $dataMasukPlayer->update([
                'penanggung_jawab_id' => $user->id,
                'leher' => $request->leher,
                'keterangan' => $request->keterangan,
                'pola_badan' => $fileGambar,
                'serah_terima' => 1
            ]);
        }
        if ($request->pelatih_id) {
            $dataMasukPelatih = Jahit::find($request->pelatih_id);

            if ($request->file('pola_badan_pelatih')) {
                $fileGambar = $request->file('pola_badan_pelatih')->store('serah-terima-pelatih', 'public');
                if ($dataMasukPelatih->pola_badan_pelatih && file_exists(storage_path('app/public/' . $dataMasukPelatih->pola_badan_pelatih))) {
                    Storage::delete('public/' . $dataMasukPelatih->pola_badan_pelatih);
                    $fileGambar = $request->file('pola_badan_pelatih')->store('serah-terima-pelatih', 'public');
                }
            }

            if ($request->file('pola_badan_pelatih') === null) {
                $fileGambar = $dataMasukPelatih->pola_badan_pelatih;
            }

            $dataMasukPelatih->update([
                'penanggung_jawab_id' => $user->id,
                'leher_pelatih' => $request->leher_pelatih,
                'keterangan2' => $request->keterangan2,
                'pola_badan_pelatih' => $fileGambar,
                'serah_terima' => 1
            ]);
        }
        if ($request->kiper_id) {
            $dataMasukKiper = Jahit::find($request->kiper_id);

            if ($request->file('pola_badan_kiper')) {
                $fileGambar = $request->file('pola_badan_kiper')->store('serah-terima-kiper', 'public');
                if ($dataMasukKiper->pola_badan_kiper && file_exists(storage_path('app/public/' . $dataMasukKiper->pola_badan_kiper))) {
                    Storage::delete('public/' . $dataMasukKiper->pola_badan_kiper);
                    $fileGambar = $request->file('pola_badan_kiper')->store('serah-terima-kiper', 'public');
                }
            }

            if ($request->file('pola_badan_kiper') === null) {
                $fileGambar = $dataMasukKiper->pola_badan_kiper;
            }

            $dataMasukKiper->update([
                'penanggung_jawab_id' => $user->id,
                'leher_kiper' => $request->leher_kiper,
                'keterangan3' => $request->keterangan3,
                'pola_badan_kiper' => $fileGambar,
                'serah_terima' => 1
            ]);
        }
        if ($request->lk1_id) {
            $dataMasuk1 = Jahit::find($request->lk1_id);

            if ($request->file('pola_badan_1')) {
                $fileGambar = $request->file('pola_badan_1')->store('serah-terima-1', 'public');
                if ($dataMasuk1->pola_badan_1 && file_exists(storage_path('app/public/' . $dataMasuk1->pola_badan_1))) {
                    Storage::delete('public/' . $dataMasuk1->pola_badan_1);
                    $fileGambar = $request->file('pola_badan_1')->store('serah-terima-1', 'public');
                }
            }

            if ($request->file('pola_badan_1') === null) {
                $fileGambar = $dataMasuk1->pola_badan_1;
            }

            $dataMasuk1->update([
                'penanggung_jawab_id' => $user->id,
                'leher_1' => $request->leher_1,
                'keterangan4' => $request->keterangan4,
                'pola_badan_1' => $fileGambar,
                'serah_terima' => 1
            ]);
        }
        if ($request->celana_player_id) {
            $dataMasukCelanaPlayer = Jahit::find($request->celana_player_id);

            if ($request->file('pola_badan_celana_pelayer')) {
                $fileGambar = $request->file('pola_badan_celana_pelayer')->store('serah-terima-celana-player', 'public');
                if ($dataMasukCelanaPlayer->pola_badan_celana_pelayer && file_exists(storage_path('app/public/' . $dataMasukCelanaPlayer->pola_badan_celana_pelayer))) {
                    Storage::delete('public/' . $dataMasukCelanaPlayer->pola_badan_celana_pelayer);
                    $fileGambar = $request->file('pola_badan_celana_pelayer')->store('serah-terima-celana-player', 'public');
                }
            }

            if ($request->file('pola_badan_celana_pelayer') === null) {
                $fileGambar = $dataMasukCelanaPlayer->pola_badan_celana_pelayer;
            }

            $dataMasukCelanaPlayer->update([
                'penanggung_jawab_id' => $user->id,
                'leher_celana_pelayer' => $request->leher_celana_pelayer,
                'keterangan5' => $request->keterangan5,
                'pola_badan_celana_pelayer' => $fileGambar,
                'serah_terima' => 1
            ]);
        }
        if ($request->celana_pelatih_id) {
            $dataMasukCelanaPelatih = Jahit::find($request->celana_pelatih_id);

            if ($request->file('pola_badan_celana_pelatih')) {
                $fileGambar = $request->file('pola_badan_celana_pelatih')->store('serah-terima-celana-pelatih', 'public');
                if ($dataMasukCelanaPelatih->pola_badan_celana_pelatih && file_exists(storage_path('app/public/' . $dataMasukCelanaPelatih->pola_badan_celana_pelatih))) {
                    Storage::delete('public/' . $dataMasukCelanaPelatih->pola_badan_celana_pelatih);
                    $fileGambar = $request->file('pola_badan_celana_pelatih')->store('serah-terima-celana-pelatih', 'public');
                }
            }

            if ($request->file('pola_badan_celana_pelatih') === null) {
                $fileGambar = $dataMasukCelanaPelatih->pola_badan_celana_pelatih;
            }

            $dataMasukCelanaPelatih->update([
                'penanggung_jawab_id' => $user->id,
                'leher_celana_pelatih' => $request->leher_celana_pelatih,
                'keterangan6' => $request->keterangan6,
                'pola_badan_celana_pelatih' => $fileGambar,
                'serah_terima' => 1
            ]);
        }
        if ($request->celana_kiper_id) {
            $dataMasukCelanaKiper = Jahit::find($request->celana_kiper_id);

            if ($request->file('pola_badan_celana_kiper')) {
                $fileGambar = $request->file('pola_badan_celana_kiper')->store('serah-terima-celana-kiper', 'public');
                if ($dataMasukCelanaKiper->pola_badan_celana_kiper && file_exists(storage_path('app/public/' . $dataMasukCelanaKiper->pola_badan_celana_kiper))) {
                    Storage::delete('public/' . $dataMasukCelanaKiper->pola_badan_celana_kiper);
                    $fileGambar = $request->file('pola_badan_celana_kiper')->store('serah-terima-celana-kiper', 'public');
                }
            }

            if ($request->file('pola_badan_celana_kiper') === null) {
                $fileGambar = $dataMasukCelanaKiper->pola_badan_celana_kiper;
            }

            $dataMasukCelanaKiper->update([
                'penanggung_jawab_id' => $user->id,
                'leher_celana_kiper' => $request->leher_celana_kiper,
                'keterangan7' => $request->keterangan7,
                'pola_badan_celana_kiper' => $fileGambar,
                'serah_terima' => 1
            ]);
        }
        if ($request->celana_1_id) {
            $dataMasukCelana1 = Jahit::find($request->celana_1_id);

            if ($request->file('pola_badan_celana_1')) {
                $fileGambar = $request->file('pola_badan_celana_1')->store('serah-terima-celana-1', 'public');
                if ($dataMasukCelana1->pola_badan_celana_1 && file_exists(storage_path('app/public/' . $dataMasukCelana1->pola_badan_celana_1))) {
                    Storage::delete('public/' . $dataMasukCelana1->pola_badan_celana_1);
                    $fileGambar = $request->file('pola_badan_celana_1')->store('serah-terima-celana-1', 'public');
                }
            }

            if ($request->file('pola_badan_celana_1') === null) {
                $fileGambar = $dataMasukCelana1->pola_badan_celana_1;
            }

            $dataMasukCelana1->update([
                'penanggung_jawab_id' => $user->id,
                'leher_celana_1' => $request->leher_celana_1,
                'keterangan8' => $request->keterangan8,
                'pola_badan_celana_1' => $fileGambar,
                'serah_terima' => 1
            ]);
        }

        return redirect()->route('getIndexJahit')->with('success', 'Selamat data yang anda input telah terkirim!');
    }

    public function putLaporanSerahTerima(Request $request)
    {
        // return response()->json($request->all());
        $user = Auth::user();

        if ($request->player_id) {
            $dataMasukPlayer = Jahit::find($request->player_id);

            if ($request->file('foto')) {
                $fileGambar = $request->file('foto')->store('serah-terima-player', 'public');
                if ($dataMasukPlayer->foto && file_exists(storage_path('app/public/' . $dataMasukPlayer->foto))) {
                    Storage::delete('public/' . $dataMasukPlayer->foto);
                    $fileGambar = $request->file('foto')->store('serah-terima-player', 'public');
                }
            }

            if ($request->file('foto') === null) {
                $fileGambar = $dataMasukPlayer->foto;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasukPlayer->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => $selesaiTime,
                'foto' => $fileGambar,
                'keterangan' => $request->keterangan,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->pelatih_id) {
            $dataMasukPelatih = Jahit::find($request->pelatih_id);

            if ($request->file('foto_pelatih')) {
                $fileGambar = $request->file('foto_pelatih')->store('serah-terima-pelatih', 'public');
                if ($dataMasukPelatih->foto_pelatih && file_exists(storage_path('app/public/' . $dataMasukPelatih->foto_pelatih))) {
                    Storage::delete('public/' . $dataMasukPelatih->foto_pelatih);
                    $fileGambar = $request->file('foto_pelatih')->store('serah-terima-pelatih', 'public');
                }
            }

            if ($request->file('foto_pelatih') === null) {
                $fileGambar = $dataMasukPelatih->foto_pelatih;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasukPelatih->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => $selesaiTime,
                'foto_pelatih' => $fileGambar,
                'keterangan2' => $request->keterangan2,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->kiper_id) {
            $dataMasukKiper = Jahit::find($request->kiper_id);

            if ($request->file('foto_kiper')) {
                $fileGambar = $request->file('foto_kiper')->store('serah-terima-kiper', 'public');
                if ($dataMasukKiper->foto_kiper && file_exists(storage_path('app/public/' . $dataMasukKiper->foto_kiper))) {
                    Storage::delete('public/' . $dataMasukKiper->foto_kiper);
                    $fileGambar = $request->file('foto_kiper')->store('serah-terima-kiper', 'public');
                }
            }

            if ($request->file('foto_kiper') === null) {
                $fileGambar = $dataMasukKiper->foto_kiper;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasukKiper->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => $selesaiTime,
                'foto_kiper' => $fileGambar,
                'keterangan3' => $request->keterangan3,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->lk1_id) {
            $dataMasuk1 = Jahit::find($request->lk1_id);

            if ($request->file('foto_1')) {
                $fileGambar = $request->file('foto_1')->store('serah-terima-1', 'public');
                if ($dataMasuk1->foto_1 && file_exists(storage_path('app/public/' . $dataMasuk1->foto_1))) {
                    Storage::delete('public/' . $dataMasuk1->foto_1);
                    $fileGambar = $request->file('foto_1')->store('serah-terima-1', 'public');
                }
            }

            if ($request->file('foto_1') === null) {
                $fileGambar = $dataMasuk1->foto_1;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasuk1->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => $selesaiTime,
                'foto_1' => $fileGambar,
                'keterangan4' => $request->keterangan4,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_player_id) {
            $dataMasukCelanaPlayer = Jahit::find($request->celana_player_id);

            if ($request->file('foto_celana_pelayer')) {
                $fileGambar = $request->file('foto_celana_pelayer')->store('serah-terima-celana-player', 'public');
                if ($dataMasukCelanaPlayer->foto_celana_pelayer && file_exists(storage_path('app/public/' . $dataMasukCelanaPlayer->foto_celana_pelayer))) {
                    Storage::delete('public/' . $dataMasukCelanaPlayer->foto_celana_pelayer);
                    $fileGambar = $request->file('foto_celana_pelayer')->store('serah-terima-celana-player', 'public');
                }
            }

            if ($request->file('foto_celana_pelayer') === null) {
                $fileGambar = $dataMasukCelanaPlayer->foto_celana_pelayer;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasukCelanaPlayer->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => $selesaiTime,
                'foto_celana_pelayer' => $fileGambar,
                'keterangan5' => $request->keterangan5,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_pelatih_id) {
            $dataMasukCelanaPelatih = Jahit::find($request->celana_pelatih_id);

            if ($request->file('foto_celana_pelatih')) {
                $fileGambar = $request->file('foto_celana_pelatih')->store('serah-terima-celana-pelatih', 'public');
                if ($dataMasukCelanaPelatih->foto_celana_pelatih && file_exists(storage_path('app/public/' . $dataMasukCelanaPelatih->foto_celana_pelatih))) {
                    Storage::delete('public/' . $dataMasukCelanaPelatih->foto_celana_pelatih);
                    $fileGambar = $request->file('foto_celana_pelatih')->store('serah-terima-celana-pelatih', 'public');
                }
            }

            if ($request->file('foto_celana_pelatih') === null) {
                $fileGambar = $dataMasukCelanaPelatih->foto_celana_pelatih;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasukCelanaPelatih->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => $selesaiTime,
                'foto_celana_pelatih' => $fileGambar,
                'keterangan6' => $request->keterangan6,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_kiper_id) {
            $dataMasukCelanaKiper = Jahit::find($request->celana_kiper_id);

            if ($request->file('foto_celana_kiper')) {
                $fileGambar = $request->file('foto_celana_kiper')->store('serah-terima-celana-kiper', 'public');
                if ($dataMasukCelanaKiper->foto_celana_kiper && file_exists(storage_path('app/public/' . $dataMasukCelanaKiper->foto_celana_kiper))) {
                    Storage::delete('public/' . $dataMasukCelanaKiper->foto_celana_kiper);
                    $fileGambar = $request->file('foto_celana_kiper')->store('serah-terima-celana-kiper', 'public');
                }
            }

            if ($request->file('foto_celana_kiper') === null) {
                $fileGambar = $dataMasukCelanaKiper->foto_celana_kiper;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasukCelanaKiper->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => $selesaiTime,
                'foto_celana_kiper' => $fileGambar,
                'keterangan7' => $request->keterangan7,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_1_id) {
            $dataMasukCelana1 = Jahit::find($request->celana_1_id);

            if ($request->file('foto_celana_1')) {
                $fileGambar = $request->file('foto_celana_1')->store('serah-terima-celana-1', 'public');
                if ($dataMasukCelana1->foto_celana_1 && file_exists(storage_path('app/public/' . $dataMasukCelana1->foto_celana_1))) {
                    Storage::delete('public/' . $dataMasukCelana1->foto_celana_1);
                    $fileGambar = $request->file('foto_celana_1')->store('serah-terima-celana-1', 'public');
                }
            }

            if ($request->file('foto_celana_1') === null) {
                $fileGambar = $dataMasukCelana1->foto_celana_1;
            }

            $localTime = $request->input('local_time');
            $selesaiTime = Carbon::parse($localTime);

            $dataMasukCelana1->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => $selesaiTime,
                'foto_celana_1' => $fileGambar,
                'keterangan8' => $request->keterangan8,
                'tanda_telah_mengerjakan' => 1
            ]);
        }

        if ($dataMasukPlayer) {
            if ($request->player_id) {
                $laporanPlayer = Laporan::where('jahit_id', $request->player_id)->first();
                if ($laporanPlayer) {
                    $laporanPlayer->update([
                        'status' => 'Finis',
                    ]);
                }
            }
            if ($request->pelatih_id) {
                $laporanPelatih = Laporan::where('jahit_id', $request->pelatih_id)->first();
                if ($laporanPelatih) {
                    $laporanPelatih->update([
                        'status' => 'Finis',
                    ]);
                }
            }
            if ($request->kiper_id) {
                $laporanKiper = Laporan::where('jahit_id', $request->kiper_id)->first();
                if ($laporanKiper) {
                    $laporanKiper->update([
                        'status' => 'Finis',
                    ]);
                }
            }
            if ($request->lk1_id) {
                $laporan1 = Laporan::where('jahit_id', $request->lk1_id)->first();
                if ($laporan1) {
                    $laporan1->update([
                        'status' => 'Finis',
                    ]);
                }
            }
            if ($request->celana_player_id) {
                $laporanCelanaPelayer = Laporan::where('jahit_id', $request->celana_player_id)->first();
                if ($laporanCelanaPelayer) {
                    $laporanCelanaPelayer->update([
                        'status' => 'Finis',
                    ]);
                }
            }
            if ($request->celana_pelatih_id) {
                $laporanCelanaPelatih = Laporan::where('jahit_id', $request->celana_pelatih_id)->first();
                if ($laporanCelanaPelatih) {
                    $laporanCelanaPelatih->update([
                        'status' => 'Finis',
                    ]);
                }
            }
            if ($request->celana_kiper_id) {
                $laporanCelanaKiper = Laporan::where('jahit_id', $request->celana_kiper_id)->first();
                if ($laporanCelanaKiper) {
                    $laporanCelanaKiper->update([
                        'status' => 'Finis',
                    ]);
                }
            }
            if ($request->celana_1_id) {
                $laporanCelana1 = Laporan::where('jahit_id', $request->celana_1_id)->first();
                if ($laporanCelana1) {
                    $laporanCelana1->update([
                        'status' => 'Finis',
                    ]);
                }
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
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = Jahit::with('BarangMasukCs', 'BarangMasukSortir', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukSortir', function ($query) {
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
            $dataMasuk = Jahit::with('BarangMasukCs', 'BarangMasukSortir', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukSortir', function ($query) {
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
            $dataMasuk = Jahit::with('BarangMasukCs', 'BarangMasukSortir', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukSortir', function ($query) {
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
        return view('component.Jahit.index-fix', compact('dataMasuk'));
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
