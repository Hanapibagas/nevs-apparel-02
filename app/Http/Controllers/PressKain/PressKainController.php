<?php

namespace App\Http\Controllers\PressKain;

use App\Http\Controllers\Controller;
use App\Models\DataPressKain;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\BarangMasukCostumerServices;
use App\Models\BarangMasukDatalayout;
use PDF;

class PressKainController extends Controller
{
    public function getindexDataMasukPress()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = DataPressKain::with('BarangMasukCs', 'MesinAtexco', 'MesinMimaki', 'BarangMasukCs.BarangMasukDisainer')
                ->where(function ($query) {
                    $query->whereHas('MesinAtexco', function ($subquery) {
                        $subquery->whereNotNull('selesai');
                    })
                        ->orWhereHas('MesinMimaki', function ($query) {
                            $query->whereNotNull('selesai');
                        });
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->where('tanda_telah_mengerjakan', 0)
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = DataPressKain::with('BarangMasukCs', 'MesinAtexco', 'MesinMimaki', 'BarangMasukCs.BarangMasukDisainer')
                ->where(function ($query) {
                    $query->whereHas('MesinAtexco', function ($subquery) {
                        $subquery->whereNotNull('selesai');
                    })
                        ->orWhereHas('MesinMimaki', function ($query) {
                            $query->whereNotNull('selesai');
                        });
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->where('tanda_telah_mengerjakan', 0)
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = DataPressKain::with('BarangMasukCs', 'MesinAtexco', 'MesinMimaki', 'BarangMasukCs.BarangMasukDisainer')
                ->where(function ($query) {
                    $query->whereHas('MesinAtexco', function ($subquery) {
                        $subquery->whereNotNull('selesai');
                    })
                        ->orWhereHas('MesinMimaki', function ($query) {
                            $query->whereNotNull('selesai');
                        });
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->where('tanda_telah_mengerjakan', 0)
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } else {
            $dataMasuk = DataPressKain::with('BarangMasukCs', 'MesinAtexco', 'MesinMimaki', 'BarangMasukCs.BarangMasukDisainer')
                ->where(function ($query) {
                    $query->whereHas('MesinAtexco', function ($subquery) {
                        $subquery->whereNotNull('selesai');
                    })
                        ->orWhereHas('MesinMimaki', function ($query) {
                            $query->whereNotNull('selesai');
                        });
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->where('tanda_telah_mengerjakan', 0)
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        }

        return view('component.Press-Kain.index', compact('dataMasuk'));
    }

    public function getInputLaporan($id)
    {
        $dataMasuk = DataPressKain::where('no_order_id', $id)->with('BarangMasukCs')->get();

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

        // return response()->json($formattedData);
        return view('component.Press-Kain.cerate-laporan-mesin', compact('dataMasuk', 'formattedData'));
    }

    public function putLaporan(Request $request)
    {
        $user = Auth::user();

        if ($request->player_id) {
            $dataMasukPlayer = DataPressKain::with('BarangMasukCs')->findOrFail($request->player_id);

            if ($request->file('gambar')) {
                $fileGambar = $request->file('gambar')->store('press-kain-player', 'public');
                if ($dataMasukPlayer->gambar && file_exists(storage_path('app/public/' . $dataMasukPlayer->gambar))) {
                    Storage::delete('public/' . $dataMasukPlayer->gambar);
                    $fileGambar = $request->file('gambar')->store('press-kain-player', 'public');
                }
            }

            if ($request->file('gambar') === null) {
                $fileGambar = $dataMasukPlayer->gambar;
            }

            $dataMasukPlayer->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'kain' => $request->kain,
                'berat' => $request->berat,
                'gambar' => $fileGambar,

                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->pelatih_id) {
            $dataMasukPelatih = DataPressKain::with('BarangMasukCs')->findOrFail($request->pelatih_id);

            if ($request->file('gambar_pelatih')) {
                $data1 = $request->file('gambar_pelatih')->store('press-kain-pelatih', 'public');
                if ($dataMasukPelatih->gambar_pelatih && file_exists(storage_path('app/public/' . $dataMasukPelatih->gambar_pelatih))) {
                    Storage::delete('public/' . $dataMasukPelatih->gambar_pelatih);
                    $data1 = $request->file('gambar_pelatih')->store('press-kain-pelatih', 'public');
                }
            }

            if ($request->file('gambar_pelatih') === null) {
                $data1 = $dataMasukPelatih->gambar_pelatih;
            }

            $dataMasukPelatih->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),

                'kain_pelatih' => $request->kain_pelatih,
                'berat_pelatih' => $request->berat_pelatih,
                'gambar_pelatih' => $data1,

                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->kiper_id) {
            $dataMasukKiper = DataPressKain::with('BarangMasukCs')->findOrFail($request->kiper_id);

            if ($request->file('gambar_kiper')) {
                $data2 = $request->file('gambar_kiper')->store('press-kain-kiper', 'public');
                if ($dataMasukKiper->gambar_kiper && file_exists(storage_path('app/public/' . $dataMasukKiper->gambar_kiper))) {
                    Storage::delete('public/' . $dataMasukKiper->gambar_kiper);
                    $data2 = $request->file('gambar_kiper')->store('press-kain-kiper', 'public');
                }
            }

            if ($request->file('gambar_kiper') === null) {
                $data2 = $dataMasukKiper->gambar_kiper;
            }

            $dataMasukKiper->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),

                'kain_kiper' => $request->kain_kiper,
                'berat_kiper' => $request->berat_kiper,
                'gambar_kiper' => $data2,

                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->lk1_id) {
            $dataMasuk1 = DataPressKain::with('BarangMasukCs')->findOrFail($request->lk1_id);

            if ($request->file('gambar_1')) {
                $data3 = $request->file('gambar_1')->store('press-kain-1', 'public');
                if ($dataMasuk1->gambar_1 && file_exists(storage_path('app/public/' . $dataMasuk1->gambar_1))) {
                    Storage::delete('public/' . $dataMasuk1->gambar_1);
                    $data3 = $request->file('gambar_1')->store('press-kain-1', 'public');
                }
            }

            if ($request->file('gambar_1') === null) {
                $data3 = $dataMasuk1->gambar_1;
            }

            $dataMasuk1->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),

                'kain_1' => $request->kain_1,
                'berat_1' => $request->berat_1,
                'gambar_1' => $data3,

                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_player_id) {
            $dataMasukCelanaPlayer = DataPressKain::with('BarangMasukCs')->findOrFail($request->celana_player_id);

            if ($request->file('gambar_celana_player')) {
                $data4 = $request->file('gambar_celana_player')->store('press-kain-celana-player', 'public');
                if ($dataMasukCelanaPlayer->gambar_celana_player && file_exists(storage_path('app/public/' . $dataMasukCelanaPlayer->gambar_celana_player))) {
                    Storage::delete('public/' . $dataMasukCelanaPlayer->gambar_celana_player);
                    $data4 = $request->file('gambar_celana_player')->store('press-kain-celana-player', 'public');
                }
            }

            if ($request->file('gambar_celana_player') === null) {
                $data4 = $dataMasukCelanaPlayer->gambar_celana_player;
            }

            $dataMasukCelanaPlayer->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),

                'kain_celana_player' => $request->kain_celana_player,
                'berat_celana_player' => $request->berat_celana_player,
                'gambar_celana_player' => $data4,

                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_pelatih_id) {
            $dataMasukCealanaPelatih = DataPressKain::with('BarangMasukCs')->findOrFail($request->celana_pelatih_id);

            if ($request->file('gambar_celana_pelatih')) {
                $data5 = $request->file('gambar_celana_pelatih')->store('press-kain-celana-pelatih', 'public');
                if ($dataMasukCealanaPelatih->gambar_celana_pelatih && file_exists(storage_path('app/public/' . $dataMasukCealanaPelatih->gambar_celana_pelatih))) {
                    Storage::delete('public/' . $dataMasukCealanaPelatih->gambar_celana_pelatih);
                    $data5 = $request->file('gambar_celana_pelatih')->store('press-kain-celana-pelatih', 'public');
                }
            }

            if ($request->file('gambar_celana_pelatih') === null) {
                $data5 = $dataMasukCealanaPelatih->gambar_celana_pelatih;
            }

            $dataMasukCealanaPelatih->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),

                'kain_celana_pelatih' => $request->kain_celana_pelatih,
                'berat_celana_pelatih' => $request->berat_celana_pelatih,
                'gambar_celana_pelatih' => $data5,

                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_kiper_id) {
            $dataMasukCelanaKiper = DataPressKain::with('BarangMasukCs')->findOrFail($request->celana_kiper_id);

            if ($request->file('gambar_celana_kiper')) {
                $data6 = $request->file('gambar_celana_kiper')->store('press-kain-celana-kiper', 'public');
                if ($dataMasukCelanaKiper->gambar_celana_kiper && file_exists(storage_path('app/public/' . $dataMasukCelanaKiper->gambar_celana_kiper))) {
                    Storage::delete('public/' . $dataMasukCelanaKiper->gambar_celana_kiper);
                    $data6 = $request->file('gambar_celana_kiper')->store('press-kain-celana-kiper', 'public');
                }
            }

            if ($request->file('gambar_celana_kiper') === null) {
                $data6 = $dataMasukCelanaKiper->gambar_celana_kiper;
            }

            $dataMasukCelanaKiper->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),

                'kain_celana_kiper' => $request->kain_celana_kiper,
                'berat_celana_kiper' => $request->berat,
                'gambar_celana_kiper' => $data6,

                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_1_id) {
            $dataMasukCelana1 = DataPressKain::with('BarangMasukCs')->findOrFail($request->celana_1_id);

            if ($request->file('gambar_celana_1')) {
                $data7 = $request->file('gambar_celana_1')->store('press-kain-celana-1', 'public');
                if ($dataMasukCelana1->gambar_celana_1 && file_exists(storage_path('app/public/' . $dataMasukCelana1->gambar_celana_1))) {
                    Storage::delete('public/' . $dataMasukCelana1->gambar_celana_1);
                    $data7 = $request->file('gambar_celana_1')->store('press-kain-celana-1', 'public');
                }
            }

            if ($request->file('gambar_celana_1') === null) {
                $data7 = $dataMasukCelana1->gambar_celana_1;
            }

            $dataMasukCelana1->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),

                'kain_celana_1' => $request->kain_celana_1,
                'berat_celana_1' => $request->berat,
                'gambar_celana_1' => $data7,

                'tanda_telah_mengerjakan' => 1
            ]);
        }


        if ($dataMasukPlayer) {
            if ($request->player_id) {
                $laporanPlayer = Laporan::where('barang_masuk_presskain_id', $request->player_id)->first();
                if ($laporanPlayer) {
                    $laporanPlayer->update([
                        'status' => 'Laser Cut',
                    ]);
                }
            }
            if ($request->pelatih_id) {
                $laporanPelatih = Laporan::where('barang_masuk_presskain_id', $request->pelatih_id)->first();
                if ($laporanPelatih) {
                    $laporanPelatih->update([
                        'status' => 'Laser Cut',
                    ]);
                }
            }
            if ($request->kiper_id) {
                $laporanKiper = Laporan::where('barang_masuk_presskain_id', $request->kiper_id)->first();
                if ($laporanKiper) {
                    $laporanKiper->update([
                        'status' => 'Laser Cut',
                    ]);
                }
            }
            if ($request->lk1_id) {
                $laporan1 = Laporan::where('barang_masuk_presskain_id', $request->lk1_id)->first();
                if ($laporan1) {
                    $laporan1->update([
                        'status' => 'Laser Cut',
                    ]);
                }
            }
            if ($request->celana_player_id) {
                $laporanCelanaPlayer = Laporan::where('barang_masuk_presskain_id', $request->celana_player_id)->first();
                if ($laporanCelanaPlayer) {
                    $laporanCelanaPlayer->update([
                        'status' => 'Laser Cut',
                    ]);
                }
            }
            if ($request->celana_pelatih_id) {
                $laporanCelanaPelatih = Laporan::where('barang_masuk_presskain_id', $request->celana_pelatih_id)->first();
                if ($laporanCelanaPelatih) {
                    $laporanCelanaPelatih->update([
                        'status' => 'Laser Cut',
                    ]);
                }
            }
            if ($request->celana_kiper_id) {
                $laporanCelanaKiper = Laporan::where('barang_masuk_presskain_id', $request->celana_kiper_id)->first();
                if ($laporanCelanaKiper) {
                    $laporanCelanaKiper->update([
                        'status' => 'Laser Cut',
                    ]);
                }
            }
            if ($request->celana_1_id) {
                $laporanCelana1 = Laporan::where('barang_masuk_presskain_id', $request->celana_1_id)->first();
                if ($laporanCelana1) {
                    $laporanCelana1->update([
                        'status' => 'Laser Cut',
                    ]);
                }
            }
        }

        return redirect()->route('getindexDataMasukPress')->with('success', 'Selamat data yang anda input telah terkirim!');
    }

    public function getindexDataMasukPressFix()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = DataPressKain::with('BarangMasukCs', 'MesinAtexco', 'MesinMimaki', 'BarangMasukCs.BarangMasukDisainer')
                ->where(function ($query) {
                    $query->whereHas('MesinAtexco', function ($subquery) {
                        $subquery->whereNotNull('selesai');
                    })
                        ->orWhereHas('MesinMimaki', function ($query) {
                            $query->whereNotNull('selesai');
                        });
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->where('tanda_telah_mengerjakan', 1)
                ->get()
                ->groupBy('no_orderd_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = DataPressKain::with('BarangMasukCs', 'MesinAtexco', 'MesinMimaki', 'BarangMasukCs.BarangMasukDisainer')
                ->where(function ($query) {
                    $query->whereHas('MesinAtexco', function ($subquery) {
                        $subquery->whereNotNull('selesai');
                    })
                        ->orWhereHas('MesinMimaki', function ($query) {
                            $query->whereNotNull('selesai');
                        });
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->where('tanda_telah_mengerjakan', 1)
                ->get()
                ->groupBy('no_orderd_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = DataPressKain::with('BarangMasukCs', 'MesinAtexco', 'MesinMimaki', 'BarangMasukCs.BarangMasukDisainer')
                ->where(function ($query) {
                    $query->whereHas('MesinAtexco', function ($subquery) {
                        $subquery->whereNotNull('selesai');
                    })
                        ->orWhereHas('MesinMimaki', function ($query) {
                            $query->whereNotNull('selesai');
                        });
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->where('tanda_telah_mengerjakan', 1)
                ->get()
                ->groupBy('no_orderd_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } else {
            $dataMasuk = DataPressKain::with('BarangMasukCs', 'MesinAtexco', 'MesinMimaki', 'BarangMasukCs.BarangMasukDisainer')
                ->where(function ($query) {
                    $query->whereHas('MesinAtexco', function ($subquery) {
                        $subquery->whereNotNull('selesai');
                    })
                        ->orWhereHas('MesinMimaki', function ($query) {
                            $query->whereNotNull('selesai');
                        });
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->where('tanda_telah_mengerjakan', 1)
                ->get()
                ->groupBy('no_orderd_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        }

        return view('component.Press-Kain.index-fix', compact('dataMasuk'));
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
