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
                ->get();
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
                ->get();
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
                ->get();
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
                ->get();
        }

        return view('component.Press-Kain.index', compact('dataMasuk'));
    }

    public function getInputLaporan($id)
    {
        $dataMasuk = DataPressKain::with('BarangMasukCs')->find($id);
        return view('component.Press-Kain.cerate-laporan-mesin', compact('dataMasuk'));
    }

    public function putLaporan(Request $request, $id)
    {
        $user = Auth::user();
        $dataMasuk = DataPressKain::with('BarangMasukCs')->find($id);

        if ($request->file('gambar')) {
            $fileGambar = $request->file('gambar')->store('press-kain', 'public');
            if ($dataMasuk->gambar && file_exists(storage_path('app/public/' . $dataMasuk->gambar))) {
                Storage::delete('public/' . $dataMasuk->gambar);
                $fileGambar = $request->file('gambar')->store('press-kain', 'public');
            }
        }
        if ($request->file('gambar_pelatih')) {
            $data1 = $request->file('gambar_pelatih')->store('press-kain', 'public');
            if ($dataMasuk->gambar_pelatih && file_exists(storage_path('app/public/' . $dataMasuk->gambar_pelatih))) {
                Storage::delete('public/' . $dataMasuk->gambar_pelatih);
                $data1 = $request->file('gambar_pelatih')->store('press-kain', 'public');
            }
        }
        if ($request->file('gambar_kiper')) {
            $data2 = $request->file('gambar_kiper')->store('press-kain', 'public');
            if ($dataMasuk->gambar_kiper && file_exists(storage_path('app/public/' . $dataMasuk->gambar_kiper))) {
                Storage::delete('public/' . $dataMasuk->gambar_kiper);
                $data2 = $request->file('gambar_kiper')->store('press-kain', 'public');
            }
        }
        if ($request->file('gambar_1')) {
            $data3 = $request->file('gambar_1')->store('press-kain', 'public');
            if ($dataMasuk->gambar_1 && file_exists(storage_path('app/public/' . $dataMasuk->gambar_1))) {
                Storage::delete('public/' . $dataMasuk->gambar_1);
                $data3 = $request->file('gambar_1')->store('press-kain', 'public');
            }
        }
        if ($request->file('gambar_celana_player')) {
            $data4 = $request->file('gambar_celana_player')->store('press-kain', 'public');
            if ($dataMasuk->gambar_celana_player && file_exists(storage_path('app/public/' . $dataMasuk->gambar_celana_player))) {
                Storage::delete('public/' . $dataMasuk->gambar_celana_player);
                $data4 = $request->file('gambar_celana_player')->store('press-kain', 'public');
            }
        }
        if ($request->file('gambar_celana_pelatih')) {
            $data5 = $request->file('gambar_celana_pelatih')->store('press-kain', 'public');
            if ($dataMasuk->gambar_celana_pelatih && file_exists(storage_path('app/public/' . $dataMasuk->gambar_celana_pelatih))) {
                Storage::delete('public/' . $dataMasuk->gambar_celana_pelatih);
                $data5 = $request->file('gambar_celana_pelatih')->store('press-kain', 'public');
            }
        }
        if ($request->file('gambar_celana_kiper')) {
            $data6 = $request->file('gambar_celana_kiper')->store('press-kain', 'public');
            if ($dataMasuk->gambar_celana_kiper && file_exists(storage_path('app/public/' . $dataMasuk->gambar_celana_kiper))) {
                Storage::delete('public/' . $dataMasuk->gambar_celana_kiper);
                $data6 = $request->file('gambar_celana_kiper')->store('press-kain', 'public');
            }
        }
        if ($request->file('gambar_celana_1')) {
            $data7 = $request->file('gambar_celana_1')->store('press-kain', 'public');
            if ($dataMasuk->gambar_celana_1 && file_exists(storage_path('app/public/' . $dataMasuk->gambar_celana_1))) {
                Storage::delete('public/' . $dataMasuk->gambar_celana_1);
                $data7 = $request->file('gambar_celana_1')->store('press-kain', 'public');
            }
        }

        if ($request->file('gambar') === null) {
            $fileGambar = $dataMasuk->gambar;
        }
        if ($request->file('gambar_pelatih') === null) {
            $data1 = $dataMasuk->gambar_pelatih;
        }
        if ($request->file('gambar_kiper') === null) {
            $data2 = $dataMasuk->gambar_kiper;
        }
        if ($request->file('gambar_1') === null) {
            $data3 = $dataMasuk->gambar_1;
        }
        if ($request->file('gambar_celana_player') === null) {
            $data4 = $dataMasuk->gambar_celana_player;
        }
        if ($request->file('gambar_celana_pelatih') === null) {
            $data5 = $dataMasuk->gambar_celana_pelatih;
        }
        if ($request->file('gambar_celana_kiper') === null) {
            $data6 = $dataMasuk->gambar_celana_kiper;
        }
        if ($request->file('gambar_celana_1') === null) {
            $data7 = $dataMasuk->gambar_celana_1;
        }

        $dataMasuk->update([
            'penanggung_jawab_id' => $user->id,
            'selesai' => Carbon::now(),
            'kain' => $request->kain,
            'berat' => $request->berat,
            'gambar' => $fileGambar,

            'kain_pelatih' => $request->kain_pelatih,
            'berat_pelatih' => $request->berat_pelatih,
            'gambar_pelatih' => $data1,

            'kain_kiper' => $request->kain_kiper,
            'berat_kiper' => $request->berat_kiper,
            'gambar_kiper' => $data2,

            'kain_1' => $request->kain_1,
            'berat_1' => $request->berat_1,
            'gambar_1' => $data3,

            'kain_celana_player' => $request->kain_celana_player,
            'berat_celana_player' => $request->berat_celana_player,
            'gambar_celana_player' => $data4,

            'kain_celana_pelatih' => $request->kain_celana_pelatih,
            'berat_celana_pelatih' => $request->berat_celana_pelatih,
            'gambar_celana_pelatih' => $data5,

            'kain_celana_kiper' => $request->kain_celana_kiper,
            'berat_celana_kiper' => $request->berat,
            'gambar_celana_kiper' => $data6,

            'kain_celana_1' => $request->kain_celana_1,
            'berat_celana_1' => $request->berat,
            'gambar_celana_1' => $data7,

            'tanda_telah_mengerjakan' => 1
        ]);

        if ($dataMasuk) {
            $laporan = Laporan::where('barang_masuk_presskain_id', $dataMasuk->id)->first();
            if ($laporan) {
                $laporan->update([
                    'status' => 'Cut',
                ]);
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
                ->get();
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
                ->get();
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
                ->get();
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
                ->get();
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

        $layout = BarangMasukDatalayout::where('no_order_id', $dataLk->id)->first();

        // return response()->json($layout);
        view()->share('dataLk', $dataLk->BarangMasukDisainer->nama_tim);

        $pdf = PDF::loadview('component.Mesin.export-data-baju', compact('dataLk', 'layout'));
        $pdf->setPaper('A4', 'potrait');

        // return $pdf->stream('data-baju.pdf');
        $namaTimClean = preg_replace('/[^A-Za-z0-9\-]/', '', $dataLk->BarangMasukDisainer->nama_tim);
        return $pdf->stream($namaTimClean . '.pdf');

    }
}
