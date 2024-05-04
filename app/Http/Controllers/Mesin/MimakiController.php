<?php

namespace App\Http\Controllers\Mesin;

use App\Http\Controllers\Controller;
use App\Models\BarangMasukCostumerServices;
use App\Models\BarangMasukDatalayout;
use App\Models\BarangMasukMesin;
use App\Models\Laporan;
use App\Models\MesinMimaki;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class MimakiController extends Controller
{
    public function getIndexMimaki()
    {
        $user = Auth::user();
        $mesin = BarangMasukMesin::where('nama_mesin_id',  $user->id)
            ->with('Users', 'BarangMasukDisainer')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('component.Mesin.mesin-mimaki-pegawai.index', compact('mesin'));
    }

    public function putFeedBackToDisainer(Request $request, $id)
    {
        $user = Auth::user();

        $mesin = BarangMasukMesin::find($id);

        $mesin->update([
            'nama_penanggung_jawab_mesin_ACC' => $user->id,
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Selamat data yang input berhasil!');
    }

    public function getIndexDataMasukMimaki()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } else {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get()
                ->groupBy('barang_masuk_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        }

        return view('component.Mesin.data-masuk-mesin-mimaki.index', compact('dataMasuk'));
    }

    public function getInputLaporan($id)
    {
        $dataMasuk = MesinMimaki::where('no_order_id', $id)->with('BarangMasukCs')->get();

        foreach ($dataMasuk as $item) {
            if ($item->lk_player_id) {
                $formattedData['player'][] = [
                    'id' => $item->id,
                    'file_foto' => $item->file_foto
                ];
            } elseif ($item->lk_pelatih_id) {
                $formattedData['pelatih'][] = [
                    'id' => $item->id,
                    'file_foto_pelatih' => $item->file_foto_pelatih,
                ];
            } elseif ($item->lk_kiper_id) {
                $formattedData['kiper'][] = [
                    'id' => $item->id,
                    'file_foto_kiper' => $item->file_foto_kiper
                ];
            } elseif ($item->lk_1_id) {
                $formattedData['lk_1'][] = [
                    'id' => $item->id,
                    'file_foto_1' => $item->file_foto_1,
                ];
            } elseif ($item->lk_celana_player_id) {
                $formattedData['celana_player'][] = [
                    'id' => $item->id,
                    'file_foto_celana_pelayer' => $item->file_foto_celana_pelayer,
                ];
            } elseif ($item->lk_celana_pelatih_id) {
                $formattedData['celana_pelatih'][] = [
                    'id' => $item->id,
                    'file_foto_celana_pelatih' => $item->file_foto_celana_pelatih
                ];
            } elseif ($item->lk_celana_kiper_id) {
                $formattedData['celana_kiper'][] = [
                    'id' => $item->id,
                    'file_foto_celana_kiper' => $item->file_foto_celana_kiper
                ];
            } elseif ($item->lk_celana_1_id) {
                $formattedData['celana_1'][] = [
                    'id' => $item->id,
                    'file_foto_celana_1' => $item->file_foto_celana_1,
                ];
            }
        }

        return view('component.Mesin.data-masuk-mesin-mimaki.cerate-laporan-mesin', compact('dataMasuk', 'formattedData'));
    }

    public function putLaporanMesin(Request $request)
    {
        $user = Auth::user();

        if ($request->player_id) {
            $dataMasukPlayer = MesinMimaki::findOrFail($request->player_id);

            if ($request->file('file_foto')) {
                $fileTangkapLayar = $request->file('file_foto')->store('file-laporan-mimaki-player', 'public');
                if ($dataMasukPlayer->file_foto && file_exists(storage_path('app/public/' . $dataMasukPlayer->file_foto))) {
                    Storage::delete('public/' . $dataMasukPlayer->file_foto);
                    $fileTangkapLayar = $request->file('file_foto')->store('file-laporan-mimaki-player', 'public');
                }
            }

            if ($request->file('file_foto') === null) {
                $fileTangkapLayar = $dataMasukPlayer->file_foto;
            }

            $dataMasukPlayer->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto' => $fileTangkapLayar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->pelatih_id) {
            $dataMasukPelatih = MesinMimaki::findOrFail($request->pelatih_id);

            if ($request->file('file_foto_pelatih')) {
                $fileTangkapLayar = $request->file('file_foto_pelatih')->store('file-laporan-mimaki-pelatih', 'public');
                if ($dataMasukPelatih->file_foto_pelatih && file_exists(storage_path('app/public/' . $dataMasukPelatih->file_foto_pelatih))) {
                    Storage::delete('public/' . $dataMasukPelatih->file_foto_pelatih);
                    $fileTangkapLayar = $request->file('file_foto_pelatih')->store('file-laporan-mimaki-pelatih', 'public');
                }
            }

            if ($request->file('file_foto_pelatih') === null) {
                $fileTangkapLayar = $dataMasukPelatih->file_foto_pelatih;
            }

            $dataMasukPelatih->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto_pelatih' => $fileTangkapLayar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->kiper_id) {
            $dataMasukKiper = MesinMimaki::findOrFail($request->kiper_id);

            if ($request->file('file_foto_kiper')) {
                $fileTangkapLayar = $request->file('file_foto_kiper')->store('file-laporan-mimaki-kiper', 'public');
                if ($dataMasukKiper->file_foto_kiper && file_exists(storage_path('app/public/' . $dataMasukKiper->file_foto_kiper))) {
                    Storage::delete('public/' . $dataMasukKiper->file_foto_kiper);
                    $fileTangkapLayar = $request->file('file_foto_kiper')->store('file-laporan-mimaki-kiper', 'public');
                }
            }

            if ($request->file('file_foto_kiper') === null) {
                $fileTangkapLayar = $dataMasukKiper->file_foto_kiper;
            }

            $dataMasukKiper->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto_kiper' => $fileTangkapLayar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->lk1_id) {
            $dataMasuk1 = MesinMimaki::findOrFail($request->lk1_id);

            if ($request->file('file_foto_1')) {
                $fileTangkapLayar = $request->file('file_foto_1')->store('file-laporan-mimaki-1', 'public');
                if ($dataMasuk1->file_foto_1 && file_exists(storage_path('app/public/' . $dataMasuk1->file_foto_1))) {
                    Storage::delete('public/' . $dataMasuk1->file_foto_1);
                    $fileTangkapLayar = $request->file('file_foto_1')->store('file-laporan-mimaki-1', 'public');
                }
            }

            if ($request->file('file_foto_1') === null) {
                $fileTangkapLayar = $dataMasuk1->file_foto_1;
            }

            $dataMasuk1->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto_1' => $fileTangkapLayar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_player_id) {
            $dataMasukCelanaPlayer = MesinMimaki::findOrFail($request->celana_player_id);

            if ($request->file('file_foto_celana_player')) {
                $fileTangkapLayar = $request->file('file_foto_celana_player')->store('file-laporan-mimaki-celana-player', 'public');
                if ($dataMasukCelanaPlayer->file_foto_celana_player && file_exists(storage_path('app/public/' . $dataMasukCelanaPlayer->file_foto_celana_player))) {
                    Storage::delete('public/' . $dataMasukCelanaPlayer->file_foto_celana_player);
                    $fileTangkapLayar = $request->file('file_foto_celana_player')->store('file-laporan-mimaki-celana-player', 'public');
                }
            }

            if ($request->file('file_foto_celana_player') === null) {
                $fileTangkapLayar = $dataMasukCelanaPlayer->file_foto_celana_player;
            }

            $dataMasukCelanaPlayer->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto_celana_player' => $fileTangkapLayar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_pelatih_id) {
            $dataMasukCelanaPelatih = MesinMimaki::findOrFail($request->celana_pelatih_id);

            if ($request->file('file_foto_celana_pelatih')) {
                $fileTangkapLayar = $request->file('file_foto_celana_pelatih')->store('file-laporan-mimaki-celana-pelatih', 'public');
                if ($dataMasukCelanaPelatih->file_foto_celana_pelatih && file_exists(storage_path('app/public/' . $dataMasukCelanaPelatih->file_foto_celana_pelatih))) {
                    Storage::delete('public/' . $dataMasukCelanaPelatih->file_foto_celana_pelatih);
                    $fileTangkapLayar = $request->file('file_foto_celana_pelatih')->store('file-laporan-mimaki-celana-pelatih', 'public');
                }
            }

            if ($request->file('file_foto_celana_pelatih') === null) {
                $fileTangkapLayar = $dataMasukCelanaPelatih->file_foto_celana_pelatih;
            }

            $dataMasukCelanaPelatih->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto_celana_pelatih' => $fileTangkapLayar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_kiper_id) {
            $dataMasukCelanaKiper = MesinMimaki::findOrFail($request->celana_kiper_id);

            if ($request->file('file_foto_celana_kiper')) {
                $fileTangkapLayar = $request->file('file_foto_celana_kiper')->store('file-laporan-mimaki-celana-kiper', 'public');
                if ($dataMasukCelanaKiper->file_foto_celana_kiper && file_exists(storage_path('app/public/' . $dataMasukCelanaKiper->file_foto_celana_kiper))) {
                    Storage::delete('public/' . $dataMasukCelanaKiper->file_foto_celana_kiper);
                    $fileTangkapLayar = $request->file('file_foto_celana_kiper')->store('file-laporan-mimaki-celana-kiper', 'public');
                }
            }

            if ($request->file('file_foto_celana_kiper') === null) {
                $fileTangkapLayar = $dataMasukCelanaKiper->file_foto_celana_kiper;
            }

            $dataMasukCelanaKiper->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto_celana_kiper' => $fileTangkapLayar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }
        if ($request->celana_1_id) {
            $dataMasukCelana1 = MesinMimaki::findOrFail($request->celana_1_id);

            if ($request->file('file_foto_celana_1')) {
                $fileTangkapLayar = $request->file('file_foto_celana_1')->store('file-laporan-mimaki-celana-1', 'public');
                if ($dataMasukCelana1->file_foto_celana_1 && file_exists(storage_path('app/public/' . $dataMasukCelana1->file_foto_celana_1))) {
                    Storage::delete('public/' . $dataMasukCelana1->file_foto_celana_1);
                    $fileTangkapLayar = $request->file('file_foto_celana_1')->store('file-laporan-mimaki-celana-1', 'public');
                }
            }

            if ($request->file('file_foto_celana_1') === null) {
                $fileTangkapLayar = $dataMasukCelana1->file_foto_celana_1;
            }

            $dataMasukCelana1->update([
                'penanggung_jawab_id' => $user->id,
                'selesai' => Carbon::now(),
                'file_foto_celana_1' => $fileTangkapLayar,
                'tanda_telah_mengerjakan' => 1
            ]);
        }

        if ($dataMasukPlayer) {
            if ($request->player_id) {
                $laporanPlayer = Laporan::where('barang_masuk_mesin_mimaki_id', $request->player_id)->first();
                if ($laporanPlayer) {
                    $laporanPlayer->update([
                        'status' => 'Press Kain',
                    ]);
                }
            }
            if ($request->pelatih_id) {
                $laporanPelatih = Laporan::where('barang_masuk_mesin_mimaki_id', $request->pelatih_id)->first();
                if ($laporanPelatih) {
                    $laporanPelatih->update([
                        'status' => 'Press Kain',
                    ]);
                }
            }
            if ($request->kiper_id) {
                $laporanKiper = Laporan::where('barang_masuk_mesin_mimaki_id', $request->kiper_id)->first();
                if ($laporanKiper) {
                    $laporanKiper->update([
                        'status' => 'Press Kain',
                    ]);
                }
            }
            if ($request->lk1_id) {
                $laporan1 = Laporan::where('barang_masuk_mesin_mimaki_id', $request->lk1_id)->first();
                if ($laporan1) {
                    $laporan1->update([
                        'status' => 'Press Kain',
                    ]);
                }
            }
            if ($request->celana_player_id) {
                $laporanCelanaPlayer = Laporan::where('barang_masuk_mesin_mimaki_id', $request->celana_player_id)->first();
                if ($laporanCelanaPlayer) {
                    $laporanCelanaPlayer->update([
                        'status' => 'Press Kain',
                    ]);
                }
            }
            if ($request->celana_pelatih_id) {
                $laporanCelanaPelatih = Laporan::where('barang_masuk_mesin_mimaki_id', $request->celana_pelatih_id)->first();
                if ($laporanCelanaPelatih) {
                    $laporanCelanaPelatih->update([
                        'status' => 'Press Kain',
                    ]);
                }
            }
            if ($request->celana_kiper_id) {
                $laporanCelanaKiper = Laporan::where('barang_masuk_mesin_mimaki_id', $request->celana_kiper_id)->first();
                if ($laporanCelanaKiper) {
                    $laporanCelanaKiper->update([
                        'status' => 'Press Kain',
                    ]);
                }
            }
            if ($request->celana_1_id) {
                $laporanCelana1 = Laporan::where('barang_masuk_mesin_mimaki_id', $request->celana_1_id)->first();
                if ($laporanCelana1) {
                    $laporanCelana1->update([
                        'status' => 'Press Kain',
                    ]);
                }
            }
        }

        return redirect()->route('getIndexDataMasukMimakiFix')->with('success', 'Selamat data yang anda input telah terkirim!');
    }

    public function getIndexDataMasukMimakiFix()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        } else {
            $dataMasuk = MesinMimaki::with('BarangMasukCs', 'BarangMasukLayout', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->whereHas('BarangMasukLayout', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->get()
                ->groupBy('no_order_id')
                ->map(function ($group) {
                    return $group->first();
                });
            $dataMasuk = $dataMasuk->values()->all();
        }

        return view('component.Mesin.data-masuk-mesin-fix-mimaki.index', compact('dataMasuk'));
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
