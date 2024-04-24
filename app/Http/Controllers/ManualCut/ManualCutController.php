<?php

namespace App\Http\Controllers\ManualCut;

use App\Http\Controllers\Controller;
use App\Models\DataManualCut;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManualCutController extends Controller
{
    public function getIndex()
    {
        $user = Auth::user();
        if ($user->asal_kota == 'makassar') {
            $dataMasuk = DataManualCut::with('BarangMasukCs', 'BarangMasukLaserCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukLaserCut', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Makassar');
                })
                ->get();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = DataManualCut::with('BarangMasukCs', 'BarangMasukLaserCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukLaserCut', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->get();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = DataManualCut::with('BarangMasukCs', 'BarangMasukLaserCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukLaserCut', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->get();
        } else {
            $dataMasuk = DataManualCut::with('BarangMasukCs', 'BarangMasukLaserCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 0)
                ->whereHas('BarangMasukLaserCut', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->get();
        }

        return view('component.Manual-Cut.index', compact('dataMasuk'));
    }

    public function getInputLaporan($id)
    {
        $dataMasuk = DataManualCut::with('BarangMasukLaserCut')->find($id);
        return view('component.Manual-Cut.cerate-laporan-mesin', compact('dataMasuk'));
    }

    public function putLaporan(Request $request, $id)
    {
        $user = Auth::user();

        if ($request->player_id) {
        }
        if ($request->pelatih_id) {
        }
        if ($request->kiper_id) {
        }
        if ($request->lk1_id) {
        }
        if ($request->celana_player_id) {
        }
        if ($request->celana_pelatih_id) {
        }
        if ($request->celana_kiper_id) {
        }
        if ($request->celana_1_id) {
        }


        $dataMasuk = DataManualCut::find($id);

        $dataMasuk->update([
            'penanggung_jawab_id' => $user->id,
            'selesai' => Carbon::now(),
            'tanda_telah_mengerjakan' => 1
        ]);

        if ($dataMasuk) {

            if ($request->player_id) {
            }
            if ($request->pelatih_id) {
            }
            if ($request->kiper_id) {
            }
            if ($request->lk1_id) {
            }
            if ($request->celana_player_id) {
            }
            if ($request->celana_pelatih_id) {
            }
            if ($request->celana_kiper_id) {
            }
            if ($request->celana_1_id) {
            }
            $laporan = Laporan::where('barang_masuk_manualcut_id', $dataMasuk->id)->first();
            if ($laporan) {
                $laporan->update([
                    'status' => 'Sortir',
                ]);
            }
        }

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
                ->get();
        } elseif ($user->asal_kota == 'jakarta') {
            $dataMasuk = DataManualCut::with('BarangMasukCs', 'BarangMasukLaserCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukLaserCut', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Jakarta');
                })
                ->get();
        } elseif ($user->asal_kota == 'bandung') {
            $dataMasuk = DataManualCut::with('BarangMasukCs', 'BarangMasukLaserCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukLaserCut', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Bandung');
                })
                ->get();
        } else {
            $dataMasuk = DataManualCut::with('BarangMasukCs', 'BarangMasukLaserCut', 'BarangMasukCs.BarangMasukDisainer')
                ->where('tanda_telah_mengerjakan', 1)
                ->whereHas('BarangMasukLaserCut', function ($query) {
                    $query->whereNotNull('selesai');
                })
                ->whereHas('BarangMasukCs', function ($query) use ($user) {
                    $query->where('kota_produksi', 'Surabaya');
                })
                ->get();
        }
        return view('component.Manual-Cut.index-fix', compact('dataMasuk'));
    }
}
