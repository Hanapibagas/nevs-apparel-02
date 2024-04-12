<?php

namespace App\Http\Controllers\Cs;

use App\Http\Controllers\Controller;
use App\Models\BarangMasukCostumerServices;
use App\Models\BarangMasukDatalayout;
use App\Models\BarangMasukDisainer;
use App\Models\Cut;
use App\Models\DataJahitBaju;
use App\Models\DataJahitCelana;
use App\Models\DataLaserCut;
use App\Models\DataManualCut;
use App\Models\DataPacking;
use App\Models\DataPressKain;
use App\Models\DataPressTagSize;
use App\Models\DataSortir;
use App\Models\Finish;
use App\Models\Jahit;
use App\Models\KeraBaju;
use App\Models\Laporan;
use App\Models\MesinAtexco;
use App\Models\MesinMimaki;
use App\Models\PolaCeleana;
use App\Models\PolaLengan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Storage;

class CostumerServicesController extends Controller
{
    public function getIndexOrderCs()
    {
        $user = Auth::user();
        $oderCs = BarangMasukCostumerServices::where('cs_id', $user->id)
            ->with('BarangMasukDisainer', 'Users')
            ->where('tanda_telah_mengerjakan', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('component.Cs.costumer-service-order-pegawai.index', compact('oderCs'));
    }

    public function getIndexLkCs()
    {
        $user = Auth::user();
        $oderCs = BarangMasukCostumerServices::where('cs_id', $user->id)
            ->with(
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
            )
            ->where('tanda_telah_mengerjakan', 1)
            // ->orderBy('updated_at', 'desc')
            ->get();

        // return response()->json($oderCs);
        return view('component.Cs.costumer-service-lk-pegawai.index', compact('oderCs'));
    }

    public function getIndexCs()
    {
        $auth = Auth::user();
        $users = User::where('roles', 'disainer')->get();
        $disainer = BarangMasukDisainer::where('nama_cs', $auth->id)->with('Users', 'DataMesin')->get();

        $userCounts = [];
        foreach ($users as $user) {
            $userId = $user->id;
            $barangMasukCount = BarangMasukDisainer::where('users_id', $userId)
                ->where('tanda_telah_mengerjakan', 0)
                ->count();
            $userCounts[$userId] = $barangMasukCount;
        }

        return view('component.Cs.costumer-service-pegawai.index', compact('users', 'userCounts', 'disainer'));
    }

    public function postToTimDisainer(Request $request)
    {

        $user = Auth::user();
        BarangMasukDisainer::create([
            'nama_cs' => $user->id,
            'nama_tim' => $request->input('nama_tim'),
            'users_id' => $request->input('users_id')
        ]);

        return redirect()->back()->with('success', 'Data anda telah terkirim ke tim disainer');
    }

    public function createLK($id)
    {
        $users = User::where('roles', 'layout')->get();
        $userCounts = [];
        foreach ($users as $user) {
            $userId = $user->id;
            $barangMasukCount = BarangMasukCostumerServices::where('layout_id', $userId)
                ->where('tanda_telah_mengerjakan', 1)
                ->count();
            $userCounts[$userId] = $barangMasukCount;
        }
        $oderCs = BarangMasukCostumerServices::with('BarangMasukDisainer', 'Gambar', 'Users', 'UsersOrder')->find($id);

        $kera = KeraBaju::where('id', '>', 1)->get();
        $lengan = PolaLengan::where('id', '>', 1)->get();
        $celana = PolaCeleana::all();

        // return response()->json($oderCs);
        return view('component.Cs.costumer-service-order-pegawai.create', compact('oderCs', 'users', 'userCounts', 'kera', 'lengan', 'celana'));
    }

    public function puUpdateLK($id)
    {
        $users = User::where('roles', 'layout')->get();
        $userCounts = [];
        foreach ($users as $user) {
            $userId = $user->id;
            $barangMasukCount = BarangMasukCostumerServices::where('layout_id', $userId)
                ->where('tanda_telah_mengerjakan', 0)
                ->count();
            $userCounts[$userId] = $barangMasukCount;
        }
        $oderCs = BarangMasukCostumerServices::with(
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
        )->find($id);

        $kera = KeraBaju::where('id', '>', 1)->get();
        $lengan = PolaLengan::where('id', '>', 1)->get();
        // return response()->json($lengan);
        $celana = PolaCeleana::all();

        return view('component.Cs.costumer-service-lk-pegawai.update', compact('oderCs', 'users', 'userCounts', 'kera', 'lengan', 'celana'));
    }

    public function putDataLk(Request $request, $id)
    {
        $lk = BarangMasukCostumerServices::find($id);

        $tanggal_masuk = \Carbon\Carbon::parse($lk->tanggal_masuk);
        $deadline = \Carbon\Carbon::parse($request->deadline);
        $total_hari = $tanggal_masuk->diffInDays($deadline);
        for ($date = clone $tanggal_masuk; $date->lte($deadline); $date->addDay()) {
            if ($date->dayOfWeek === Carbon::SUNDAY) {
                $total_hari--;
            }
        }

        if ($total_hari >= 1 && $total_hari <= 8) {
            $keterangan = "Express";
        } else {
            $keterangan = "Normal";
        }

        $lk->update([
            'tanggal_jahit' => $request->tanggal_jahit,
            'nama_penjahit' => $request->nama_penjahit,
            'no_nota' => $request->no_nota,
            'kota_produksi' => $request->kota_produksi,

            'layout_id' => $request->layout_id,
            'jenis_produksi' => $request->jenis_produksi,
            'pola' => $request->pola,
            'deadline' => $request->deadline,
            'ket_hari' => $keterangan,

            // baju player
            'total_baju_player' => $request->total_baju_player,
            'jenis_sablon_baju_player' => $request->jenis_sablon_baju_player,
            'kera_baju_player_id' => $request->kera_baju_player_id,
            'pola_lengan_player_id' => $request->pola_lengan_player_id,
            'jenis_kain_baju_player' => $request->jenis_kain_baju_player,
            'ket_kumis_baju_player' => $request->ket_kumis_baju_player,
            'ket_bantalan_baju_player' => $request->ket_bantalan_baju_player,
            'ket_celana_player' => $request->ket_celana_player,
            'ket_tambahan_baju_player' => $request->ket_tambahan_baju_player,
            'keterangan_baju_pelayer' => $request->keterangan_baju_pelayer,

            // baju pelatih
            'total_baju_pelatih' => $request->total_baju_pelatih,
            'kerah_baju_pelatih_id' => $request->kerah_baju_pelatih_id,
            'pola_lengan_pelatih_id' => $request->pola_lengan_pelatih_id,
            'jenis_kain_baju_pelatih' => $request->jenis_kain_baju_pelatih,
            'ket_kumis_baju_pelatih' => $request->ket_kumis_baju_pelatih,
            'ket_bantalan_baju_pelatih' => $request->ket_bantalan_baju_pelatih,
            'ket_celana_pelatih' => $request->ket_celana_pelatih,
            'ket_tambahan_baju_pelatih' => $request->ket_tambahan_baju_pelatih,
            'keterangan_baju_pelatih' => $request->keterangan_baju_pelatih,

            // baju kiper
            'total_baju_kiper' => $request->total_baju_kiper,
            'kerah_baju_kiper_id' => $request->kerah_baju_kiper_id,
            'pola_lengan_kiper_id' => $request->pola_lengan_kiper_id,
            'jenis_kain_baju_kiper' => $request->jenis_kain_baju_kiper,
            'ket_kumis_baju_kiper' => $request->ket_kumis_baju_kiper,
            'ket_bantalan_baju_kiper' => $request->ket_bantalan_baju_kiper,
            'ket_celana_kiper' => $request->ket_celana_kiper,
            'ket_tambahan_baju_kiper' => $request->ket_tambahan_baju_kiper,
            'keterangan_baju_kiper' => $request->keterangan_baju_kiper,

            // baju player 1
            'total_baju_1' => $request->total_baju_1,
            'kerah_baju_1_id' => $request->kerah_baju_1_id,
            'pola_lengan_1_id' => $request->pola_lengan_1_id,
            'jenis_kain_baju_1' => $request->jenis_kain_baju_1,
            'ket_kumis_baju_1' => $request->ket_kumis_baju_1,
            'ket_bantalan_baju_1' => $request->ket_bantalan_baju_1,
            'ket_celana_1' => $request->ket_celana_1,
            'ket_tambahan_baju_1' => $request->ket_tambahan_baju_1,
            'keterangan_baju_1' => $request->keterangan_baju_1,

            // celana player
            'total_celana_player' => $request->total_celana_player,
            'kerah_celana_player_id' => $request->kerah_celana_player_id,
            'jenis_sablon_celana_player' => $request->jenis_sablon_celana_player,
            'jenis_kain_celana_player' => $request->jenis_kain_celana_player,
            'pola_celana_player_id' => $request->pola_celana_player_id,
            'kain_celana_player' => $request->kain_celana_player,
            'ket_warna_kain_celana_player' => $request->ket_warna_kain_celana_player,
            'ket_bis_celana_celana_player' => $request->ket_bis_celana_celana_player,
            'ket_tambahan_celana_player' => $request->ket_tambahan_celana_player,
            'keterangan_celana_pelayer' => $request->keterangan_celana_pelayer,

            // celana pelatih
            'total_celana_pelatih' => $request->total_celana_pelatih,
            'kerah_celana_pelatih_id' => $request->kerah_celana_pelatih_id,
            'jenis_sablon_celana_pelatih' => $request->jenis_sablon_celana_pelatih,
            'pola_celana_pelatih_id' => $request->pola_celana_pelatih_id,
            'jenis_kain_celana_pelatih' => $request->jenis_kain_celana_pelatih,
            'ket_warna_kain_celana_pelatih' => $request->ket_warna_kain_celana_pelatih,
            'ket_bis_celana_celana_pelatih' => $request->ket_bis_celana_celana_pelatih,
            'ket_tambahan_celana_pelatih' => $request->ket_tambahan_celana_pelatih,
            'keterangan_celana_pelatih' => $request->keterangan_celana_pelatih,

            // celana kiper
            'total_celana_kiper' => $request->total_celana_kiper,
            'kerah_celana_kiper_id' => $request->kerah_celana_kiper_id,
            'jenis_sablon_celana_kiper' => $request->jenis_sablon_celana_kiper,
            'pola_celana_kiper_id' => $request->pola_celana_kiper_id,
            'jenis_kain_celana_kiper' => $request->jenis_kain_celana_kiper,
            'ket_warna_kain_celana_kiper' => $request->ket_warna_kain_celana_kiper,
            'ket_bis_celana_celana_kiper' => $request->ket_bis_celana_celana_kiper,
            'ket_tambahan_celana_kiper' => $request->ket_tambahan_celana_kiper,
            'keterangan_celana_kiper' => $request->keterangan_celana_kiper,

            // celana 1
            'total_celana_1' => $request->total_celana_1,
            'kerah_celana_1_id' => $request->kerah_celana_1_id,
            'jenis_sablon_celana_1' => $request->jenis_sablon_celana_1,
            'pola_celana_1_id' => $request->pola_celana_1_id,
            'jenis_kain_celana_1' => $request->jenis_kain_celana_1,
            'ket_warna_kain_celana_1' => $request->ket_warna_kain_celana_1,
            'ket_bis_celana_celana_1' => $request->ket_bis_celana_celana_1,
            'ket_tambahan_celana_1' => $request->ket_tambahan_celana_1,
            'keterangan_celana_1' => $request->keterangan_celana_1,

            'keterangan_lengkap' => $request->keterangan_lengkap,

            'aksi' => '1',
            'tanda_telah_mengerjakan' => '1',
        ]);

        return redirect()->route('getIndexLkCsPegawai')->with('success', 'Selamat data yang input berhasil!');
    }

    public function putDataLkFix(Request $request, $id)
    {
        $lk = BarangMasukCostumerServices::find($id);

        $tanggal_masuk = \Carbon\Carbon::parse($lk->tanggal_masuk);
        $deadline = \Carbon\Carbon::parse($request->deadline);
        $total_hari = $tanggal_masuk->diffInDays($deadline);
        for ($date = clone $tanggal_masuk; $date->lte($deadline); $date->addDay()) {
            if ($date->dayOfWeek === Carbon::SUNDAY) {
                $total_hari--;
            }
        }

        if ($total_hari >= 1 && $total_hari <= 8) {
            $keterangan = "Express";
        } else {
            $keterangan = "Normal";
        }

        $lk->update([
            'tanggal_jahit' => $request->tanggal_jahit,
            'nama_penjahit' => $request->nama_penjahit,
            'no_nota' => $request->no_nota,
            'kota_produksi' => $request->kota_produksi,

            'layout_id' => $request->layout_id,
            'jenis_produksi' => $request->jenis_produksi,
            'pola' => $request->pola,
            'deadline' => $request->deadline,
            'ket_hari' => $keterangan,

            // baju player
            'total_baju_player' => $request->total_baju_player,
            'jenis_sablon_baju_player' => $request->jenis_sablon_baju_player,
            'kera_baju_player_id' => $request->kera_baju_player_id,
            'pola_lengan_player_id' => $request->pola_lengan_player_id,
            'jenis_kain_baju_player' => $request->jenis_kain_baju_player,
            'ket_kumis_baju_player' => $request->ket_kumis_baju_player,
            'ket_bantalan_baju_player' => $request->ket_bantalan_baju_player,
            'ket_celana_player' => $request->ket_celana_player,
            'ket_tambahan_baju_player' => $request->ket_tambahan_baju_player,
            'keterangan_baju_pelayer' => $request->keterangan_baju_pelayer,

            // baju pelatih
            'total_baju_pelatih' => $request->total_baju_pelatih,
            'kerah_baju_pelatih_id' => $request->kerah_baju_pelatih_id,
            'jenis_sablon_baju_pelatih' => $request->jenis_sablon_baju_pelatih,
            'pola_lengan_pelatih_id' => $request->pola_lengan_pelatih_id,
            'jenis_kain_baju_pelatih' => $request->jenis_kain_baju_pelatih,
            'ket_kumis_baju_pelatih' => $request->ket_kumis_baju_pelatih,
            'ket_bantalan_baju_pelatih' => $request->ket_bantalan_baju_pelatih,
            'ket_celana_pelatih' => $request->ket_celana_pelatih,
            'ket_tambahan_baju_pelatih' => $request->ket_tambahan_baju_pelatih,
            'keterangan_baju_pelatih' => $request->keterangan_baju_pelatih,

            // baju kiper
            'total_baju_kiper' => $request->total_baju_kiper,
            'kerah_baju_kiper_id' => $request->kerah_baju_kiper_id,
            'pola_lengan_kiper_id' => $request->pola_lengan_kiper_id,
            'jenis_kain_baju_kiper' => $request->jenis_kain_baju_kiper,
            'jenis_sablon_baju_kiper' => $request->jenis_sablon_baju_kiper,
            'ket_kumis_baju_kiper' => $request->ket_kumis_baju_kiper,
            'ket_bantalan_baju_kiper' => $request->ket_bantalan_baju_kiper,
            'ket_celana_kiper' => $request->ket_celana_kiper,
            'ket_tambahan_baju_kiper' => $request->ket_tambahan_baju_kiper,
            'keterangan_baju_kiper' => $request->keterangan_baju_kiper,

            // baju player 1
            'total_baju_1' => $request->total_baju_1,
            'kerah_baju_1_id' => $request->kerah_baju_1_id,
            'pola_lengan_1_id' => $request->pola_lengan_1_id,
            'jenis_kain_baju_1' => $request->jenis_kain_baju_1,
            'jenis_sablon_baju_1' => $request->jenis_sablon_baju_1,
            'ket_kumis_baju_1' => $request->ket_kumis_baju_1,
            'ket_bantalan_baju_1' => $request->ket_bantalan_baju_1,
            'ket_celana_1' => $request->ket_celana_1,
            'ket_tambahan_baju_1' => $request->ket_tambahan_baju_1,
            'keterangan_baju_1' => $request->keterangan_baju_1,

            // celana player
            'total_celana_player' => $request->total_celana_player,
            'kerah_celana_player_id' => $request->kerah_celana_player_id,
            'jenis_sablon_celana_player' => $request->jenis_sablon_celana_player,
            'jenis_kain_celana_player' => $request->jenis_kain_celana_player,
            'pola_celana_player_id' => $request->pola_celana_player_id,
            'kain_celana_player' => $request->kain_celana_player,
            'ket_warna_kain_celana_player' => $request->ket_warna_kain_celana_player,
            'ket_bis_celana_celana_player' => $request->ket_bis_celana_celana_player,
            'ket_tambahan_celana_player' => $request->ket_tambahan_celana_player,
            'keterangan_celana_pelayer' => $request->keterangan_celana_pelayer,

            // celana pelatih
            'total_celana_pelatih' => $request->total_celana_pelatih,
            'kerah_celana_pelatih_id' => $request->kerah_celana_pelatih_id,
            'jenis_sablon_celana_pelatih' => $request->jenis_sablon_celana_pelatih,
            'pola_celana_pelatih_id' => $request->pola_celana_pelatih_id,
            'jenis_kain_celana_pelatih' => $request->jenis_kain_celana_pelatih,
            'ket_warna_kain_celana_pelatih' => $request->ket_warna_kain_celana_pelatih,
            'ket_bis_celana_celana_pelatih' => $request->ket_bis_celana_celana_pelatih,
            'ket_tambahan_celana_pelatih' => $request->ket_tambahan_celana_pelatih,
            'keterangan_celana_pelatih' => $request->keterangan_celana_pelatih,

            // celana kiper
            'total_celana_kiper' => $request->total_celana_kiper,
            'kerah_celana_kiper_id' => $request->kerah_celana_kiper_id,
            'jenis_sablon_celana_kiper' => $request->jenis_sablon_celana_kiper,
            'pola_celana_kiper_id' => $request->pola_celana_kiper_id,
            'jenis_kain_celana_kiper' => $request->jenis_kain_celana_kiper,
            'ket_warna_kain_celana_kiper' => $request->ket_warna_kain_celana_kiper,
            'ket_bis_celana_celana_kiper' => $request->ket_bis_celana_celana_kiper,
            'ket_tambahan_celana_kiper' => $request->ket_tambahan_celana_kiper,
            'keterangan_celana_kiper' => $request->keterangan_celana_kiper,

            // celana 1
            'total_celana_1' => $request->total_celana_1,
            'kerah_celana_1_id' => $request->kerah_celana_1_id,
            'jenis_sablon_celana_1' => $request->jenis_sablon_celana_1,
            'pola_celana_1_id' => $request->pola_celana_1_id,
            'jenis_kain_celana_1' => $request->jenis_kain_celana_1,
            'ket_warna_kain_celana_1' => $request->ket_warna_kain_celana_1,
            'ket_bis_celana_celana_1' => $request->ket_bis_celana_celana_1,
            'ket_tambahan_celana_1' => $request->ket_tambahan_celana_1,
            'keterangan_celana_1' => $request->keterangan_celana_1,

            'keterangan_lengkap' => $request->keterangan_lengkap,

            'aksi' => '1',
            'tanda_telah_mengerjakan' => '1',
        ]);

        // return response()->json($lk);

        $createDate = clone $tanggal_masuk;
        if ($tanggal_masuk->dayOfWeek === Carbon::SATURDAY) {
            $createDate->addDay(2);
        } elseif ($tanggal_masuk->dayOfWeek >= Carbon::MONDAY && $tanggal_masuk->dayOfWeek <= Carbon::FRIDAY) {
            $createDate->addDay();
        }

        $createDate2 = clone $tanggal_masuk;
        if ($tanggal_masuk->dayOfWeek === Carbon::MONDAY) {
            $createDate2->addDay(2);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::TUESDAY) {
            $createDate2->addDay(2);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::WEDNESDAY) {
            $createDate2->addDay(2);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::THURSDAY) {
            $createDate2->addDay(2);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::FRIDAY) {
            $createDate2->addDay(3);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::SATURDAY) {
            $createDate2->addDay(3);
        }

        $createDate3 = clone $tanggal_masuk;
        if ($tanggal_masuk->dayOfWeek === Carbon::MONDAY) {
            $createDate3->addDay(3);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::TUESDAY) {
            $createDate3->addDay(3);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::WEDNESDAY) {
            $createDate3->addDay(3);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::THURSDAY) {
            $createDate3->addDay(4);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::FRIDAY) {
            $createDate3->addDay(4);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::SATURDAY) {
            $createDate3->addDay(4);
        }

        $createDate4 = clone $tanggal_masuk;
        if ($tanggal_masuk->dayOfWeek === Carbon::MONDAY) {
            $createDate4->addDay(4);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::TUESDAY) {
            $createDate4->addDay(4);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::WEDNESDAY) {
            $createDate4->addDay(5);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::THURSDAY) {
            $createDate4->addDay(5);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::FRIDAY) {
            $createDate4->addDay(5);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::SATURDAY) {
            $createDate4->addDay(5);
        }

        $createDate5 = clone $tanggal_masuk;
        if ($tanggal_masuk->dayOfWeek === Carbon::MONDAY) {
            $createDate5->addDay(5);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::TUESDAY) {
            $createDate5->addDay(6);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::WEDNESDAY) {
            $createDate5->addDay(6);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::THURSDAY) {
            $createDate5->addDay(6);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::FRIDAY) {
            $createDate5->addDay(6);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::SATURDAY) {
            $createDate5->addDay(6);
        }

        $createDate6 = clone $tanggal_masuk;
        if ($tanggal_masuk->dayOfWeek === Carbon::MONDAY) {
            $createDate6->addDay(7);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::TUESDAY) {
            $createDate6->addDay(7);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::WEDNESDAY) {
            $createDate6->addDay(7);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::THURSDAY) {
            $createDate6->addDay(7);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::FRIDAY) {
            $createDate6->addDay(7);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::SATURDAY) {
            $createDate6->addDay(7);
        }

        $createDate7 = clone $tanggal_masuk;
        if ($tanggal_masuk->dayOfWeek === Carbon::MONDAY) {
            $createDate7->addDay(8);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::TUESDAY) {
            $createDate7->addDay(8);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::WEDNESDAY) {
            $createDate7->addDay(8);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::THURSDAY) {
            $createDate7->addDay(8);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::FRIDAY) {
            $createDate7->addDay(8);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::SATURDAY) {
            $createDate7->addDay(9);
        }

        $createDate8 = clone $tanggal_masuk;
        if ($tanggal_masuk->dayOfWeek === Carbon::MONDAY) {
            $createDate8->addDay(9);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::TUESDAY) {
            $createDate8->addDay(9);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::WEDNESDAY) {
            $createDate8->addDay(9);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::THURSDAY) {
            $createDate8->addDay(9);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::FRIDAY) {
            $createDate8->addDay(10);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::SATURDAY) {
            $createDate8->addDay(10);
        }

        $createDate9 = clone $tanggal_masuk;
        if ($tanggal_masuk->dayOfWeek === Carbon::MONDAY) {
            $createDate9->addDay(10);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::TUESDAY) {
            $createDate9->addDay(10);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::WEDNESDAY) {
            $createDate9->addDay(10);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::THURSDAY) {
            $createDate9->addDay(11);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::FRIDAY) {
            $createDate9->addDay(11);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::SATURDAY) {
            $createDate9->addDay(11);
        }

        $createDate10 = clone $tanggal_masuk;
        if ($tanggal_masuk->dayOfWeek === Carbon::MONDAY) {
            $createDate10->addDay(11);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::TUESDAY) {
            $createDate10->addDay(11);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::WEDNESDAY) {
            $createDate10->addDay(12);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::THURSDAY) {
            $createDate10->addDay(12);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::FRIDAY) {
            $createDate10->addDay(12);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::SATURDAY) {
            $createDate10->addDay(12);
        }

        $createDate11 = clone $tanggal_masuk;
        if ($tanggal_masuk->dayOfWeek === Carbon::MONDAY) {
            $createDate11->addDay(12);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::TUESDAY) {
            $createDate11->addDay(13);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::WEDNESDAY) {
            $createDate11->addDay(13);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::THURSDAY) {
            $createDate11->addDay(13);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::FRIDAY) {
            $createDate11->addDay(13);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::SATURDAY) {
            $createDate11->addDay(13);
        }

        $createDate12 = clone $tanggal_masuk;
        if ($tanggal_masuk->dayOfWeek === Carbon::MONDAY) {
            $createDate12->addDay(14);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::TUESDAY) {
            $createDate12->addDay(14);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::WEDNESDAY) {
            $createDate12->addDay(14);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::THURSDAY) {
            $createDate12->addDay(14);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::FRIDAY) {
            $createDate12->addDay(14);
        } elseif ($tanggal_masuk->dayOfWeek === Carbon::SATURDAY) {
            $createDate12->addDay(14);
        }

        if ($total_hari == 1) {
            $barangMasukDataLayout = BarangMasukDatalayout::create([
                'users_layout_id' => $lk->layout_id,
                'no_order_id' => $lk->id,
                'deadline' => $createDate->format('Y-m-d'),
            ]);
            $mesinAtexco = null;
            $mesinMimaki = null;
            if ($lk->jenis_mesin == 'atexco') {
                $mesinAtexco = MesinAtexco::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $mesinMimaki = MesinMimaki::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            }
            if ($lk->jenis_mesin == 'atexco') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_atexco_id' => $mesinAtexco->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_mimaki_id' => $mesinMimaki->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            }
            $dataCut = Cut::create([
                'no_order_id' => $lk->id,
                'press_kain_id' => $dataPressKain->id,
                'deadline' => $createDate->format('Y-m-d'),
            ]);
            $dataSortit = DataSortir::create([
                'no_order_id' => $lk->id,
                'manual_cut_id' => $dataCut->id,
                'deadline' => $createDate->format('Y-m-d'),
            ]);
            $dataJahit = Jahit::create([
                'no_order_id' => $lk->id,
                'sortir_id' => $dataSortit->id,
                'deadline' => $createDate->format('Y-m-d'),
            ]);
            $dataFinis = Finish::create([
                'no_order_id' => $lk->id,
                'jahit_baju_id' => $dataJahit->id,
                'deadline' => $createDate->format('Y-m-d'),
            ]);
            if ($mesinAtexco || $mesinMimaki) {
                Laporan::create([
                    'barang_masuk_costumer_services_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'barang_masuk_mesin_atexco_id' => $mesinAtexco ? $mesinAtexco->id : null,
                    'barang_masuk_mesin_mimaki_id' => $mesinMimaki ? $mesinMimaki->id : null,
                    'barang_masuk_presskain_id' => $dataPressKain->id,
                    'cut_id' => $dataCut->id,
                    'barang_masuk_sortir_id' => $dataSortit->id,
                    'jahit_id' => $dataJahit->id,
                    'finis_id' => $dataFinis->id,
                ]);
            }
        } elseif ($total_hari == 2) {
            $barangMasukDataLayout = BarangMasukDatalayout::create([
                'users_layout_id' => $lk->layout_id,
                'no_order_id' => $lk->id,
                'deadline' => $createDate->format('Y-m-d'),
            ]);
            $mesinAtexco = null;
            $mesinMimaki = null;
            if ($lk->jenis_mesin == 'atexco') {
                $mesinAtexco = MesinAtexco::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $mesinMimaki = MesinMimaki::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            }
            if ($lk->jenis_mesin == 'atexco') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_atexco_id' => $mesinAtexco->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_mimaki_id' => $mesinMimaki->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            }
            $dataCut = Cut::create([
                'no_order_id' => $lk->id,
                'press_kain_id' => $dataPressKain->id,
                'deadline' => $createDate->format('Y-m-d'),
            ]);
            $dataSortit = DataSortir::create([
                'no_order_id' => $lk->id,
                'manual_cut_id' => $dataCut->id,
                'deadline' => $createDate2->format('Y-m-d'),
            ]);
            $dataJahit = Jahit::create([
                'no_order_id' => $lk->id,
                'sortir_id' => $dataSortit->id,
                'deadline' => $createDate2->format('Y-m-d'),
            ]);
            $dataFinis = Finish::create([
                'no_order_id' => $lk->id,
                'jahit_baju_id' => $dataJahit->id,
                'deadline' => $createDate2->format('Y-m-d'),
            ]);
            if ($mesinAtexco || $mesinMimaki) {
                Laporan::create([
                    'barang_masuk_costumer_services_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'barang_masuk_mesin_atexco_id' => $mesinAtexco ? $mesinAtexco->id : null,
                    'barang_masuk_mesin_mimaki_id' => $mesinMimaki ? $mesinMimaki->id : null,
                    'barang_masuk_presskain_id' => $dataPressKain->id,
                    'cut_id' => $dataCut->id,
                    'barang_masuk_sortir_id' => $dataSortit->id,
                    'jahit_id' => $dataJahit->id,
                    'finis_id' => $dataFinis->id,
                ]);
            }
        } elseif ($total_hari == 3) {
            $barangMasukDataLayout = BarangMasukDatalayout::create([
                'users_layout_id' => $lk->layout_id,
                'no_order_id' => $lk->id,
                'deadline' => $createDate->format('Y-m-d'),
            ]);
            $mesinAtexco = null;
            $mesinMimaki = null;
            if ($lk->jenis_mesin == 'atexco') {
                $mesinAtexco = MesinAtexco::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate2->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $mesinMimaki = MesinMimaki::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate2->format('Y-m-d'),
                ]);
            }
            if ($lk->jenis_mesin == 'atexco') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_atexco_id' => $mesinAtexco->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_mimaki_id' => $mesinMimaki->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            }
            $dataCut = Cut::create([
                'no_order_id' => $lk->id,
                'press_kain_id' => $dataPressKain->id,
                'deadline' => $createDate2->format('Y-m-d'),
            ]);
            $dataSortit = DataSortir::create([
                'no_order_id' => $lk->id,
                'manual_cut_id' => $dataCut->id,
                'deadline' => $createDate3->format('Y-m-d'),
            ]);
            $dataJahit = Jahit::create([
                'no_order_id' => $lk->id,
                'sortir_id' => $dataSortit->id,
                'deadline' => $createDate3->format('Y-m-d'),
            ]);
            $dataFinis = Finish::create([
                'no_order_id' => $lk->id,
                'jahit_baju_id' => $dataJahit->id,
                'deadline' => $createDate3->format('Y-m-d'),
            ]);
            if ($mesinAtexco || $mesinMimaki) {
                Laporan::create([
                    'barang_masuk_costumer_services_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'barang_masuk_mesin_atexco_id' => $mesinAtexco ? $mesinAtexco->id : null,
                    'barang_masuk_mesin_mimaki_id' => $mesinMimaki ? $mesinMimaki->id : null,
                    'barang_masuk_presskain_id' => $dataPressKain->id,
                    'cut_id' => $dataCut->id,
                    'barang_masuk_sortir_id' => $dataSortit->id,
                    'jahit_id' => $dataJahit->id,
                    'finis_id' => $dataFinis->id,
                ]);
            }
        } elseif ($total_hari == 4) {
            $barangMasukDataLayout = BarangMasukDatalayout::create([
                'users_layout_id' => $lk->layout_id,
                'no_order_id' => $lk->id,
                'deadline' => $createDate->format('Y-m-d'),
            ]);

            $mesinAtexco = null;
            $mesinMimaki = null;
            if ($lk->jenis_mesin == 'atexco') {
                $mesinAtexco = MesinAtexco::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate2->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $mesinMimaki = MesinMimaki::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate2->format('Y-m-d'),
                ]);
            }
            if ($lk->jenis_mesin == 'atexco') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_atexco_id' => $mesinAtexco->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_mimaki_id' => $mesinMimaki->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            }
            $dataCut = Cut::create([
                'no_order_id' => $lk->id,
                'press_kain_id' => $dataPressKain->id,
                'deadline' => $createDate3->format('Y-m-d'),
            ]);
            $dataSortit = DataSortir::create([
                'no_order_id' => $lk->id,
                'manual_cut_id' => $dataCut->id,
                'deadline' => $createDate3->format('Y-m-d'),
            ]);
            $dataJahit = Jahit::create([
                'no_order_id' => $lk->id,
                'sortir_id' => $dataSortit->id,
                'deadline' => $createDate4->format('Y-m-d'),
            ]);
            $dataFinis = Finish::create([
                'no_order_id' => $lk->id,
                'jahit_baju_id' => $dataJahit->id,
                'deadline' => $createDate4->format('Y-m-d'),
            ]);
            if ($mesinAtexco || $mesinMimaki) {
                Laporan::create([
                    'barang_masuk_costumer_services_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'barang_masuk_mesin_atexco_id' => $mesinAtexco ? $mesinAtexco->id : null,
                    'barang_masuk_mesin_mimaki_id' => $mesinMimaki ? $mesinMimaki->id : null,
                    'barang_masuk_presskain_id' => $dataPressKain->id,
                    'cut_id' => $dataCut->id,
                    'barang_masuk_sortir_id' => $dataSortit->id,
                    'jahit_id' => $dataJahit->id,
                    'finis_id' => $dataFinis->id,
                ]);
            }
        } elseif ($total_hari == 5) {
            $barangMasukDataLayout = BarangMasukDatalayout::create([
                'users_layout_id' => $lk->layout_id,
                'no_order_id' => $lk->id,
                'deadline' => $createDate->format('Y-m-d'),
            ]);
            $mesinAtexco = null;
            $mesinMimaki = null;
            if ($lk->jenis_mesin == 'atexco') {
                $mesinAtexco = MesinAtexco::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate2->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $mesinMimaki = MesinMimaki::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate2->format('Y-m-d'),
                ]);
            }
            if ($lk->jenis_mesin == 'atexco') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_atexco_id' => $mesinAtexco->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_mimaki_id' => $mesinMimaki->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            }
            $dataCut = Cut::create([
                'no_order_id' => $lk->id,
                'press_kain_id' => $dataPressKain->id,
                'deadline' => $createDate3->format('Y-m-d'),
            ]);
            $dataSortit = DataSortir::create([
                'no_order_id' => $lk->id,
                'manual_cut_id' => $dataCut->id,
                'deadline' => $createDate4->format('Y-m-d'),
            ]);
            $dataJahit = Jahit::create([
                'no_order_id' => $lk->id,
                'sortir_id' => $dataSortit->id,
                'deadline' => $createDate5->format('Y-m-d'),
            ]);
            $dataFinis = Finish::create([
                'no_order_id' => $lk->id,
                'jahit_baju_id' => $dataJahit->id,
                'deadline' => $createDate5->format('Y-m-d'),
            ]);
            if ($mesinAtexco || $mesinMimaki) {
                Laporan::create([
                    'barang_masuk_costumer_services_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'barang_masuk_mesin_atexco_id' => $mesinAtexco ? $mesinAtexco->id : null,
                    'barang_masuk_mesin_mimaki_id' => $mesinMimaki ? $mesinMimaki->id : null,
                    'barang_masuk_presskain_id' => $dataPressKain->id,
                    'cut_id' => $dataCut->id,
                    'barang_masuk_sortir_id' => $dataSortit->id,
                    'jahit_id' => $dataJahit->id,
                    'finis_id' => $dataFinis->id,
                ]);
            }
        } elseif ($total_hari == 6) {
            $barangMasukDataLayout = BarangMasukDatalayout::create([
                'users_layout_id' => $lk->layout_id,
                'no_order_id' => $lk->id,
                'deadline' => $createDate->format('Y-m-d'),
            ]);
            $mesinAtexco = null;
            $mesinMimaki = null;
            if ($lk->jenis_mesin == 'atexco') {
                $mesinAtexco = MesinAtexco::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate2->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $mesinMimaki = MesinMimaki::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate2->format('Y-m-d'),
                ]);
            }
            if ($lk->jenis_mesin == 'atexco') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_atexco_id' => $mesinAtexco->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_mimaki_id' => $mesinMimaki->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            }
            $dataCut = Cut::create([
                'no_order_id' => $lk->id,
                'press_kain_id' => $dataPressKain->id,
                'deadline' => $createDate3->format('Y-m-d'),
            ]);
            $dataSortit = DataSortir::create([
                'no_order_id' => $lk->id,
                'manual_cut_id' => $dataCut->id,
                'deadline' => $createDate5->format('Y-m-d'),
            ]);
            $dataJahit = Jahit::create([
                'no_order_id' => $lk->id,
                'sortir_id' => $dataSortit->id,
                'deadline' => $createDate6->format('Y-m-d'),
            ]);
            $dataFinis = Finish::create([
                'no_order_id' => $lk->id,
                'jahit_baju_id' => $dataJahit->id,
                'deadline' => $createDate6->format('Y-m-d'),
            ]);
            if ($mesinAtexco || $mesinMimaki) {
                Laporan::create([
                    'barang_masuk_costumer_services_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'barang_masuk_mesin_atexco_id' => $mesinAtexco ? $mesinAtexco->id : null,
                    'barang_masuk_mesin_mimaki_id' => $mesinMimaki ? $mesinMimaki->id : null,
                    'barang_masuk_presskain_id' => $dataPressKain->id,
                    'cut_id' => $dataCut->id,
                    'barang_masuk_sortir_id' => $dataSortit->id,
                    'jahit_id' => $dataJahit->id,
                    'finis_id' => $dataFinis->id,
                ]);
            }
        } elseif ($total_hari == 7) {
            $barangMasukDataLayout = BarangMasukDatalayout::create([
                'users_layout_id' => $lk->layout_id,
                'no_order_id' => $lk->id,
                'deadline' => $createDate->format('Y-m-d'),
            ]);

            $mesinAtexco = null;
            $mesinMimaki = null;
            if ($lk->jenis_mesin == 'atexco') {
                $mesinAtexco = MesinAtexco::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate2->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $mesinMimaki = MesinMimaki::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate2->format('Y-m-d'),
                ]);
            }
            if ($lk->jenis_mesin == 'atexco') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_atexco_id' => $mesinAtexco->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_mimaki_id' => $mesinMimaki->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            }
            $dataCut = Cut::create([
                'no_order_id' => $lk->id,
                'press_kain_id' => $dataPressKain->id,
                'deadline' => $createDate4->format('Y-m-d'),
            ]);
            $dataSortit = DataSortir::create([
                'no_order_id' => $lk->id,
                'manual_cut_id' => $dataCut->id,
                'deadline' => $createDate5->format('Y-m-d'),
            ]);
            $dataJahit = Jahit::create([
                'no_order_id' => $lk->id,
                'sortir_id' => $dataSortit->id,
                'deadline' => $createDate7->format('Y-m-d'),
            ]);
            $dataFinis = Finish::create([
                'no_order_id' => $lk->id,
                'jahit_baju_id' => $dataJahit->id,
                'deadline' => $createDate7->format('Y-m-d'),
            ]);
            if ($mesinAtexco || $mesinMimaki) {
                Laporan::create([
                    'barang_masuk_costumer_services_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'barang_masuk_mesin_atexco_id' => $mesinAtexco ? $mesinAtexco->id : null,
                    'barang_masuk_mesin_mimaki_id' => $mesinMimaki ? $mesinMimaki->id : null,
                    'barang_masuk_presskain_id' => $dataPressKain->id,
                    'cut_id' => $dataCut->id,
                    'barang_masuk_sortir_id' => $dataSortit->id,
                    'jahit_id' => $dataJahit->id,
                    'finis_id' => $dataFinis->id,
                ]);
            }
        } elseif ($total_hari == 8) {
            $barangMasukDataLayout = BarangMasukDatalayout::create([
                'users_layout_id' => $lk->layout_id,
                'no_order_id' => $lk->id,
                'deadline' => $createDate2->format('Y-m-d'),
            ]);
            $mesinAtexco = null;
            $mesinMimaki = null;
            if ($lk->jenis_mesin == 'atexco') {
                $mesinAtexco = MesinAtexco::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate3->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $mesinMimaki = MesinMimaki::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate3->format('Y-m-d'),
                ]);
            }
            if ($lk->jenis_mesin == 'atexco') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_atexco_id' => $mesinAtexco->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_mimaki_id' => $mesinMimaki->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            }
            $dataCut = Cut::create([
                'no_order_id' => $lk->id,
                'press_kain_id' => $dataPressKain->id,
                'deadline' => $createDate5->format('Y-m-d'),
            ]);
            $dataSortit = DataSortir::create([
                'no_order_id' => $lk->id,
                'manual_cut_id' => $dataCut->id,
                'deadline' => $createDate6->format('Y-m-d'),
            ]);
            $dataJahit = Jahit::create([
                'no_order_id' => $lk->id,
                'sortir_id' => $dataSortit->id,
                'deadline' => $createDate8->format('Y-m-d'),
            ]);
            $dataFinis = Finish::create([
                'no_order_id' => $lk->id,
                'jahit_baju_id' => $dataJahit->id,
                'deadline' => $createDate8->format('Y-m-d'),
            ]);
            if ($mesinAtexco || $mesinMimaki) {
                Laporan::create([
                    'barang_masuk_costumer_services_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'barang_masuk_mesin_atexco_id' => $mesinAtexco ? $mesinAtexco->id : null,
                    'barang_masuk_mesin_mimaki_id' => $mesinMimaki ? $mesinMimaki->id : null,
                    'barang_masuk_presskain_id' => $dataPressKain->id,
                    'cut_id' => $dataCut->id,
                    'barang_masuk_sortir_id' => $dataSortit->id,
                    'jahit_id' => $dataJahit->id,
                    'finis_id' => $dataFinis->id,
                ]);
            }
        } elseif ($total_hari == 9) {
            $barangMasukDataLayout = BarangMasukDatalayout::create([
                'users_layout_id' => $lk->layout_id,
                'no_order_id' => $lk->id,
                'deadline' => $createDate2->format('Y-m-d'),
            ]);

            $mesinAtexco = null;
            $mesinMimaki = null;
            if ($lk->jenis_mesin == 'atexco') {
                $mesinAtexco = MesinAtexco::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate3->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $mesinMimaki = MesinMimaki::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate3->format('Y-m-d'),
                ]);
            }
            if ($lk->jenis_mesin == 'atexco') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_atexco_id' => $mesinAtexco->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_mimaki_id' => $mesinMimaki->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            }
            $dataCut = Cut::create([
                'no_order_id' => $lk->id,
                'press_kain_id' => $dataPressKain->id,
                'deadline' => $createDate5->format('Y-m-d'),
            ]);
            $dataSortit = DataSortir::create([
                'no_order_id' => $lk->id,
                'manual_cut_id' => $dataCut->id,
                'deadline' => $createDate6->format('Y-m-d'),
            ]);
            $dataJahit = Jahit::create([
                'no_order_id' => $lk->id,
                'sortir_id' => $dataSortit->id,
                'deadline' => $createDate8->format('Y-m-d'),
            ]);
            $dataFinis = Finish::create([
                'no_order_id' => $lk->id,
                'jahit_baju_id' => $dataJahit->id,
                'deadline' => $createDate9->format('Y-m-d'),
            ]);
            if ($mesinAtexco || $mesinMimaki) {
                Laporan::create([
                    'barang_masuk_costumer_services_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'barang_masuk_mesin_atexco_id' => $mesinAtexco ? $mesinAtexco->id : null,
                    'barang_masuk_mesin_mimaki_id' => $mesinMimaki ? $mesinMimaki->id : null,
                    'barang_masuk_presskain_id' => $dataPressKain->id,
                    'cut_id' => $dataCut->id,
                    'barang_masuk_sortir_id' => $dataSortit->id,
                    'jahit_id' => $dataJahit->id,
                    'finis_id' => $dataFinis->id,
                ]);
            }
        } elseif ($total_hari == 10) {
            $barangMasukDataLayout = BarangMasukDatalayout::create([
                'users_layout_id' => $lk->layout_id,
                'no_order_id' => $lk->id,
                'deadline' => $createDate2->format('Y-m-d'),
            ]);
            $mesinAtexco = null;
            $mesinMimaki = null;
            if ($lk->jenis_mesin == 'atexco') {
                $mesinAtexco = MesinAtexco::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate3->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $mesinMimaki = MesinMimaki::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate3->format('Y-m-d'),
                ]);
            }
            if ($lk->jenis_mesin == 'atexco') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_atexco_id' => $mesinAtexco->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_mimaki_id' => $mesinMimaki->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            }
            $dataCut = Cut::create([
                'no_order_id' => $lk->id,
                'press_kain_id' => $dataPressKain->id,
                'deadline' => $createDate5->format('Y-m-d'),
            ]);
            $dataSortit = DataSortir::create([
                'no_order_id' => $lk->id,
                'manual_cut_id' => $dataCut->id,
                'deadline' => $createDate6->format('Y-m-d'),
            ]);
            $dataJahit = Jahit::create([
                'no_order_id' => $lk->id,
                'sortir_id' => $dataSortit->id,
                'deadline' => $createDate9->format('Y-m-d'),
            ]);
            $dataFinis = Finish::create([
                'no_order_id' => $lk->id,
                'jahit_baju_id' => $dataJahit->id,
                'deadline' => $createDate10->format('Y-m-d'),
            ]);
            if ($mesinAtexco || $mesinMimaki) {
                Laporan::create([
                    'barang_masuk_costumer_services_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'barang_masuk_mesin_atexco_id' => $mesinAtexco ? $mesinAtexco->id : null,
                    'barang_masuk_mesin_mimaki_id' => $mesinMimaki ? $mesinMimaki->id : null,
                    'barang_masuk_presskain_id' => $dataPressKain->id,
                    'cut_id' => $dataCut->id,
                    'barang_masuk_sortir_id' => $dataSortit->id,
                    'jahit_id' => $dataJahit->id,
                    'finis_id' => $dataFinis->id,
                ]);
            }
        } elseif ($total_hari == 11) {
            $barangMasukDataLayout = BarangMasukDatalayout::create([
                'users_layout_id' => $lk->layout_id,
                'no_order_id' => $lk->id,
                'deadline' => $createDate3->format('Y-m-d'),
            ]);

            $mesinAtexco = null;
            $mesinMimaki = null;
            if ($lk->jenis_mesin == 'atexco') {
                $mesinAtexco = MesinAtexco::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate4->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $mesinMimaki = MesinMimaki::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate4->format('Y-m-d'),
                ]);
            }
            if ($lk->jenis_mesin == 'atexco') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_atexco_id' => $mesinAtexco->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_mimaki_id' => $mesinMimaki->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            }
            $dataCut = Cut::create([
                'no_order_id' => $lk->id,
                'press_kain_id' => $dataPressKain->id,
                'deadline' => $createDate6->format('Y-m-d'),
            ]);
            $dataSortit = DataSortir::create([
                'no_order_id' => $lk->id,
                'manual_cut_id' => $dataCut->id,
                'deadline' => $createDate7->format('Y-m-d'),
            ]);
            $dataJahit = Jahit::create([
                'no_order_id' => $lk->id,
                'sortir_id' => $dataSortit->id,
                'deadline' => $createDate10->format('Y-m-d'),
            ]);
            $dataFinis = Finish::create([
                'no_order_id' => $lk->id,
                'jahit_baju_id' => $dataJahit->id,
                'deadline' => $createDate11->format('Y-m-d'),
            ]);
            if ($mesinAtexco || $mesinMimaki) {
                Laporan::create([
                    'barang_masuk_costumer_services_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'barang_masuk_mesin_atexco_id' => $mesinAtexco ? $mesinAtexco->id : null,
                    'barang_masuk_mesin_mimaki_id' => $mesinMimaki ? $mesinMimaki->id : null,
                    'barang_masuk_presskain_id' => $dataPressKain->id,
                    'cut_id' => $dataCut->id,
                    'barang_masuk_sortir_id' => $dataSortit->id,
                    'jahit_id' => $dataJahit->id,
                    'finis_id' => $dataFinis->id,
                ]);
            }
        } elseif ($total_hari >= 12 && $total_hari <= 9999) {
            $barangMasukDataLayout = BarangMasukDatalayout::create([
                'users_layout_id' => $lk->layout_id,
                'no_order_id' => $lk->id,
                'deadline' => $createDate3->format('Y-m-d'),
            ]);
            $mesinAtexco = null;
            $mesinMimaki = null;
            if ($lk->jenis_mesin == 'atexco') {
                $mesinAtexco = MesinAtexco::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate4->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $mesinMimaki = MesinMimaki::create([
                    'no_order_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'nama_mesin' => $lk->jenis_mesin,
                    'deadline' => $createDate4->format('Y-m-d'),
                ]);
            }
            if ($lk->jenis_mesin == 'atexco') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_atexco_id' => $mesinAtexco->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            } elseif ($lk->jenis_mesin == 'mimaki') {
                $dataPressKain = DataPressKain::create([
                    'no_order_id' => $lk->id,
                    'mesin_mimaki_id' => $mesinMimaki->id,
                    'deadline' => $createDate->format('Y-m-d'),
                ]);
            }
            $dataCut = Cut::create([
                'no_order_id' => $lk->id,
                'press_kain_id' => $dataPressKain->id,
                'deadline' => $createDate6->format('Y-m-d'),
            ]);
            $dataSortit = DataSortir::create([
                'no_order_id' => $lk->id,
                'manual_cut_id' => $dataCut->id,
                'deadline' => $createDate7->format('Y-m-d'),
            ]);
            $dataJahit = Jahit::create([
                'no_order_id' => $lk->id,
                'sortir_id' => $dataSortit->id,
                'deadline' => $createDate10->format('Y-m-d'),
            ]);
            $dataFinis = Finish::create([
                'no_order_id' => $lk->id,
                'jahit_baju_id' => $dataJahit->id,
                'deadline' => $createDate12->format('Y-m-d'),
            ]);
            if ($mesinAtexco || $mesinMimaki) {
                Laporan::create([
                    'barang_masuk_costumer_services_id' => $lk->id,
                    'barang_masuk_layout_id' => $barangMasukDataLayout->id,
                    'barang_masuk_mesin_atexco_id' => $mesinAtexco ? $mesinAtexco->id : null,
                    'barang_masuk_mesin_mimaki_id' => $mesinMimaki ? $mesinMimaki->id : null,
                    'barang_masuk_presskain_id' => $dataPressKain->id,
                    'cut_id' => $dataCut->id,
                    'barang_masuk_sortir_id' => $dataSortit->id,
                    'jahit_id' => $dataJahit->id,
                    'finis_id' => $dataFinis->id,
                ]);
            }
        }

        return redirect()->route('getIndexLkCsPegawai')->with('success', 'Selamat data yang input berhasil!');
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
            'Celana1',
            'Gambar'
        )->findOrFail($id);

        // return response()->json($dataLk);
        view()->share('dataLk', $dataLk->BarangMasukDisainer->nama_tim);

        $pdf = PDF::loadview('component.Cs.costumer-service-lk-pegawai.export-data-baju', compact('dataLk'));
        // $pdf->setPaper('A4', 'landscape');
        $pdf->setPaper('A4', 'potrait');

        $namaTimClean = preg_replace('/[^A-Za-z0-9\-]/', '', $dataLk->BarangMasukDisainer->nama_tim);
        return $pdf->stream($namaTimClean . '.pdf');
    }
}
