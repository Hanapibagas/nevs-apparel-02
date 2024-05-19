<?php

namespace App\Http\Controllers;

use App\Models\BarangMasukCostumerServices;
use App\Models\BarangMasukDatalayout;
use App\Models\BarangMasukDisainer;
use App\Models\Cut;
use App\Models\DataPressKain;
use App\Models\DataSortir;
use App\Models\Finish;
use App\Models\Jahit;
use App\Models\Laporan;
use App\Models\LaporanCetakCutPolos;
use App\Models\LaporanCetakPresskain;
use App\Models\LaporanCetakSortir;
use App\Models\LaporanKainLayout;
use App\Models\LaporanKainSortir;
use App\Models\MesinAtexco;
use App\Models\MesinMimaki;
use App\Models\PasswordUser;
use App\Models\PembagianKomisi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PDF;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // admin
        $dashboardMakassar = Laporan::whereHas('BarangMasukCs', function ($query) {
            $query->where('kota_produksi', 'Makassar');
        })
            ->selectRaw('count(*) as total, MONTH(created_at) as month')
            ->groupByRaw('MONTH(created_at)')
            ->get();
        $dashboardBandung = Laporan::whereHas('BarangMasukCs', function ($query) {
            $query->where('kota_produksi', 'Bandung');
        })
            ->selectRaw('count(*) as total, MONTH(created_at) as month')
            ->groupByRaw('MONTH(created_at)')
            ->get();
        $dashboardSurabaya = Laporan::whereHas('BarangMasukCs', function ($query) {
            $query->where('kota_produksi', 'Surabaya');
        })
            ->selectRaw('count(*) as total, MONTH(created_at) as month')
            ->groupByRaw('MONTH(created_at)')
            ->get();
        $dashboardJakarta = Laporan::whereHas('BarangMasukCs', function ($query) {
            $query->where('kota_produksi', 'Jakarta');
        })
            ->selectRaw('count(*) as total, MONTH(created_at) as month')
            ->groupByRaw('MONTH(created_at)')
            ->get();

        // cs
        $user = Auth::user();
        $dataMasuk = BarangMasukCostumerServices::where('cs_id', $user->id)
            ->selectRaw('count(*) as total, MONTH(created_at) as month')
            ->groupByRaw('MONTH(created_at)')
            ->get();
        $dataMasukDisainer = BarangMasukDisainer::where('users_id', $user->id)
            ->selectRaw('count(*) as total, MONTH(created_at) as month')
            ->groupByRaw('MONTH(created_at)')
            ->get();
        $dataMasuklayout = BarangMasukDatalayout::where('users_layout_id', $user->id)
            ->selectRaw('count(*) as total, MONTH(created_at) as month')
            ->groupByRaw('MONTH(created_at)')
            ->get();
        $dataMasukAtexco = MesinAtexco::selectRaw('count(*) as total, MONTH(created_at) as month')
            ->groupByRaw('MONTH(created_at)')
            ->get();
        $dataMasukMimaki = MesinMimaki::selectRaw('count(*) as total, MONTH(created_at) as month')
            ->groupByRaw('MONTH(created_at)')
            ->get();
        $dataMasukPressKain = DataPressKain::selectRaw('count(*) as total, MONTH(created_at) as month')
            ->groupByRaw('MONTH(created_at)')
            ->get();
        $dataMasukCut = Cut::selectRaw('count(*) as total, MONTH(created_at) as month')
            ->groupByRaw('MONTH(created_at)')
            ->get();
        $dataMasukSortir = DataSortir::selectRaw('count(*) as total, MONTH(created_at) as month')
            ->groupByRaw('MONTH(created_at)')
            ->get();
        $dataMasukjahit = Jahit::selectRaw('count(*) as total, MONTH(created_at) as month')
            ->groupByRaw('MONTH(created_at)')
            ->get();
        $dataMasukFinis = Finish::selectRaw('count(*) as total, MONTH(created_at) as month')
            ->groupByRaw('MONTH(created_at)')
            ->get();

        // return response()->json($dataMasukAtexco);

        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');

        $dates = [];
        $totals = [];
        $totalsByCity = [];

        for ($i = 1; $i <= 31; $i++) {
            $deadline = $tahun . '-' . $bulan . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);

            $jahits = Jahit::with('BarangMasukCs')->whereDate('deadline', $deadline)->get();
            $total_semua = 0;
            $totalsByCityForDay = [];

            foreach ($jahits as $jahit) {
                $barangMasuk = $jahit->barangMasukCs()->first();

                if ($barangMasuk) {
                    $total_baju = ($barangMasuk->total_baju_player ?? 0) +
                        ($barangMasuk->total_baju_pelatih ?? 0) +
                        ($barangMasuk->total_baju_kiper ?? 0) +
                        ($barangMasuk->total_baju_1 ?? 0);

                    $total_celana = ($barangMasuk->total_celana_player ?? 0) +
                        ($barangMasuk->total_celana_pelatih ?? 0) +
                        ($barangMasuk->total_celana_kiper ?? 0) +
                        ($barangMasuk->total_celana_1 ?? 0);

                    $total_semua += $total_baju + $total_celana;

                    $kota_produksi = $barangMasuk->kota_produksi ?? 'Unknown';
                    if (!isset($totalsByCityForDay[$kota_produksi])) {
                        $totalsByCityForDay[$kota_produksi] = 0;
                    }

                    $totalsByCityForDay[$kota_produksi] += $total_baju + $total_celana;
                }
            }

            $dates[] = $deadline;
            $totals[] = $total_semua;

            foreach ($totalsByCityForDay as $city => $total) {
                if (!isset($totalsByCity[$city])) {
                    $totalsByCity[$city] = [];
                }
                $totalsByCity[$city][] = [
                    'date' => $deadline,
                    'total' => $total
                ];
            }
        }

        return view('component.dashboard', compact(
            'dashboardMakassar',
            'dashboardBandung',
            'dashboardSurabaya',
            'dashboardJakarta',
            'dataMasuk',
            'dataMasukDisainer',
            'dataMasuklayout',
            'dataMasukAtexco',
            'dataMasukMimaki',
            'dataMasukPressKain',
            'dataMasukCut',
            'dataMasukSortir',
            'dataMasukjahit',
            'dataMasukFinis',
            'total_semua',
            'dates',
            'totals',
            'totalsByCity'
        ));
    }

    public function fiterTotaljahit(Request $request)
    {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');
        $tanggal = $request->input('tanggal');

        $jahits = Jahit::whereYear('deadline', $tahun)
            ->whereMonth('deadline', $bulan)
            ->whereDay('deadline', $tanggal)
            ->get();

        $total_semua = 0;

        foreach ($jahits as $jahit) {
            $barangMasuk = $jahit->barangMasukCs()->first();

            if ($barangMasuk) {
                $total_baju_player = $barangMasuk->total_baju_player ?? 0;
                $total_baju_pelatih = $barangMasuk->total_baju_pelatih ?? 0;
                $total_baju_kiper = $barangMasuk->total_baju_kiper ?? 0;
                $total_baju_1 = $barangMasuk->total_baju_1 ?? 0;
                $total_celana_player = $barangMasuk->total_celana_player ?? 0;
                $total_celana_pelatih = $barangMasuk->total_celana_pelatih ?? 0;
                $total_celana_kiper = $barangMasuk->total_celana_kiper ?? 0;
                $total_celana_1 = $barangMasuk->total_celana_1 ?? 0;

                $total_semua += $total_baju_player + $total_baju_pelatih + $total_baju_kiper +
                    $total_baju_1 + $total_celana_player + $total_celana_pelatih +
                    $total_celana_kiper + $total_celana_1;
            }
        }

        return redirect()->route('indexHome');
    }

    public function getCostumerSevices()
    {
        $userCs = User::with('PasswordUser')->where('roles', 'cs')->get();
        // return response()->json($userCs);

        return view('component.Admin.costumer-service-admin.index', compact('userCs'));
    }

    public function getAdmin()
    {
        $userLaytout = User::with('PasswordUser')->where('roles', 'admin')->get();
        // return response()->json($userCs);

        return view('component.Admin.admin-admin.index', compact('userLaytout'));
    }

    public function getDesainer()
    {
        $userDesainer = User::with('PasswordUser')->where('roles', 'disainer')->get();

        return view('component.Admin.desainer-admin.index', compact('userDesainer'));
    }

    public function getLayout()
    {
        $userLaytout = User::with('PasswordUser')->where('roles', 'layout')->get();

        return view('component.Admin.layout-admin.index', compact('userLaytout'));
    }

    public function getMesinAtexco()
    {
        $userMesinAtexco = User::with('PasswordUser')->where('roles', 'atexco')->get();

        return view('component.Admin.mesin-atexco-admin.index', compact('userMesinAtexco'));
    }

    public function getMesinMimaki()
    {
        $userMimaki = User::with('PasswordUser')->where('roles', 'mimaki')->get();

        return view('component.Admin.mesin-mimaki-admin.index', compact('userMimaki'));
    }

    public function getPressKain()
    {
        $userPresKain = User::with('PasswordUser')->where('roles', 'pres_kain')->get();

        return view('component.Admin.press-kain-admin.index', compact('userPresKain'));
    }

    public function getLaserCut()
    {
        $userLaserCut = User::with('PasswordUser')->where('roles', 'laser_cut')->get();

        return view('component.Admin.laser-cut-admin.index', compact('userLaserCut'));
    }

    public function getManualut()
    {
        $userManuakCut = User::with('PasswordUser')->where('roles', 'manual_cut')->get();

        return view('component.Admin.manual-cut-admin.index', compact('userManuakCut'));
    }

    public function getSortir()
    {
        $userSortir = User::with('PasswordUser')->where('roles', 'sortir')->get();

        return view('component.Admin.sortir-admin.index', compact('userSortir'));
    }

    public function getJahitBaju()
    {
        $userJahitBaju = User::with('PasswordUser')->where('roles', 'jahit')->get();

        return view('component.Admin.jahit-baju-admin.index', compact('userJahitBaju'));
    }

    public function getJahitCelana()
    {
        $userJahitCelana = User::with('PasswordUser')->where('roles', 'jahit_celana')->get();

        return view('component.Admin.jahit-celana-admin.index', compact('userJahitCelana'));
    }

    public function getPressTag()
    {
        $userPressTag = User::with('PasswordUser')->where('roles', 'finis')->get();

        return view('component.Admin.pres-tag-admin.index', compact('userPressTag'));
    }

    public function getPacking()
    {
        $userPacking = User::with('PasswordUser')->where('roles', 'packing')->get();

        return view('component.Admin.packing-admin.index', compact('userPacking'));
    }

    public function postPegawaiCs(Request $request)
    {
        $email = $request->input('email');
        if (User::where('email', $email)->exists()) {
            return redirect()->back()->with('error', 'Email Pegawai sudah ada mohon buat yang berbeda.');
        }

        $user =  User::create([
            'name' => $request->input('name'),
            'asal_kota' => $request->input('asal_kota'),
            'email' => $email,
            'roles' => $request->input('roles'),
            'password' => bcrypt('12345678')
        ]);

        PasswordUser::create([
            'user' => $user->id,
            'password' => $request->password
        ]);

        return redirect()->back()->with('success', 'Data pegawai telah ditambah.');
    }

    public function postPegawaiDesainer(Request $request)
    {
        $email = $request->input('email');
        if (User::where('email', $email)->exists()) {
            return redirect()->back()->with('error', 'Email Pegawai sudah ada mohon buat yang berbeda.');
        }

        $user =  User::create([
            'name' => $request->input('name'),
            'asal_kota' => $request->input('asal_kota'),
            'email' => $email,
            'roles' => $request->input('roles'),
            'password' => bcrypt('12345678')
        ]);

        PasswordUser::create([
            'user' => $user->id,
            'password' => $request->password
        ]);

        return redirect()->back()->with('success', 'Data pegawai telah ditambah.');
    }

    public function postPegawaiLayout(Request $request)
    {
        $email = $request->input('email');
        if (User::where('email', $email)->exists()) {
            return redirect()->back()->with('error', 'Email Pegawai sudah ada mohon buat yang berbeda.');
        }

        $user =  User::create([
            'name' => $request->input('name'),
            'asal_kota' => $request->input('asal_kota'),
            'email' => $email,
            'roles' => $request->input('roles'),
            'password' => bcrypt('12345678')
        ]);

        PasswordUser::create([
            'user' => $user->id,
            'password' => $request->password
        ]);

        return redirect()->back()->with('success', 'Data pegawai telah ditambah.');
    }

    public function getLaporan()
    {
        $laporans = Laporan::with(
            'BarangMasukCs.UsersOrder',
            'BarangMasukCs.Users',
            'BarangMasukCs.UsersLk',
            'BarangMasukCs.BarangMasukDisainer',
            'BarangMasukLayout',
            'BarangMasukMesinAtexco',
            'BarangMasukMesinMimaki',
            'BarangMasukPressKain',
            'BarangMasukLaserCut',
            'BarangMasukManualcut',
            'BarangMasukSortir',
            'BarangMasukJahitBaju',
            'BarangMasukPressTag',
        )
            ->get()
            ->groupBy('barang_masuk_costumer_services_id')
            ->map(function ($group) {
                return $group->first();
            });
        $laporans = $laporans->values()->all();

        // return response()->json($laporans);
        return view('component.Admin.laporan-pengerjaan.index', compact('laporans'));
    }

    public function getDetailLaporan($id)
    {
        $laporans = Laporan::with(
            'BarangMasukLayout',
            'BarangMasukMesinAtexco',
            'BarangMasukMesinMimaki',
            'BarangMasukPressKain',
            'BarangMasukLaserCut',
            'BarangMasukManualcut',
            'BarangMasukSortir',
            'BarangMasukJahitBaju',
            'BarangMasukPressTag',
        )->where('barang_masuk_costumer_services_id', $id)->get();

        $laporanData = [];
        $laporanDataAtexco = [];
        // $laporanDataMimaki = [];
        $laporanDataPressKain = [];
        $laporanDataLaserCut = [];
        $laporanDataManualCut = [];
        $laporanDataSortir = [];
        $laporanDataJahit = [];
        $laporanDataFinis = [];

        foreach ($laporans as $laporan) {
            $item = $laporan->BarangMasukLayout;
            $itemAtexco = $laporan->BarangMasukMesinAtexco;
            // $itemMimaki = $laporan->BarangMasukMesinMimaki;
            $itemPressKain = $laporan->BarangMasukPressKain;
            $itemLaserCut = $laporan->BarangMasukLaserCut;
            $itemManualCut = $laporan->BarangMasukManualcut;
            $itemSortir = $laporan->BarangMasukSortir;
            $itemJahit = $laporan->BarangMasukJahitBaju;
            $itemFinis = $laporan->BarangMasukPressTag;

            if ($itemFinis) {
                // manual cut
                if ($itemFinis->lk_player_id) {
                    $laporanDataFinis['player'][] = [
                        'id' => $itemFinis->id,
                        'deadline' => $itemFinis->deadline,
                        'selesai' => $itemFinis->selesai,
                        'keterangan' => $itemFinis->keterangan,
                        'foto' => $itemFinis->foto,
                    ];
                } elseif ($itemFinis->lk_pelatih_id) {
                    $laporanDataFinis['pelatih'][] = [
                        'id' => $itemFinis->id,
                        'deadline' => $itemFinis->deadline,
                        'selesai' => $itemFinis->selesai,
                        'keterangan2' => $itemFinis->keterangan2,
                        'foto_pelatih' => $itemFinis->foto_pelatih,
                    ];
                } elseif ($itemFinis->lk_kiper_id) {
                    $laporanDataFinis['kiper'][] = [
                        'id' => $itemFinis->id,
                        'deadline' => $itemFinis->deadline,
                        'selesai' => $itemFinis->selesai,
                        'keterangan3' => $itemFinis->keterangan3,
                        'foto_kiper' => $itemFinis->foto_kiper,
                    ];
                } elseif ($itemFinis->lk_1_id) {
                    $laporanDataFinis['lk_1'][] = [
                        'id' => $itemFinis->id,
                        'deadline' => $itemFinis->deadline,
                        'selesai' => $itemFinis->selesai,
                        'keterangan4' => $itemFinis->keterangan4,
                        'foto_1' => $itemFinis->foto_1,
                    ];
                } elseif ($itemFinis->lk_celana_player_id) {
                    $laporanDataFinis['celana_player'][] = [
                        'id' => $itemFinis->id,
                        'deadline' => $itemFinis->deadline,
                        'selesai' => $itemFinis->selesai,
                        'keterangan5' => $itemFinis->keterangan5,
                        'foto_celana_pelayer' => $itemFinis->foto_celana_pelayer,
                    ];
                } elseif ($itemFinis->lk_celana_pelatih_id) {
                    $laporanDataFinis['celana_pelatih'][] = [
                        'id' => $itemFinis->id,
                        'deadline' => $itemFinis->deadline,
                        'selesai' => $itemFinis->selesai,
                        'keterangan6' => $itemFinis->keterangan6,
                        'foto_celana_pelatih' => $itemFinis->foto_celana_pelatih,
                    ];
                } elseif ($itemFinis->lk_celana_kiper_id) {
                    $laporanDataFinis['celana_kiper'][] = [
                        'id' => $itemFinis->id,
                        'deadline' => $itemFinis->deadline,
                        'selesai' => $itemFinis->selesai,
                        'keterangan7' => $itemFinis->keterangan7,
                        'foto_celana_kiper' => $itemFinis->foto_celana_kiper,
                    ];
                } elseif ($itemFinis->lk_celana_1_id) {
                    $laporanDataFinis['celana_1'][] = [
                        'id' => $itemFinis->id,
                        'deadline' => $itemFinis->deadline,
                        'selesai' => $itemFinis->selesai,
                        'keterangan8' => $itemFinis->keterangan8,
                        'foto_celana_1' => $itemFinis->foto_celana_1,
                    ];
                }
            }

            if ($itemJahit) {
                // manual cut
                if ($itemJahit->lk_player_id) {
                    $laporanDataJahit['player'][] = [
                        'id' => $itemJahit->id,
                        'deadline' => $itemJahit->deadline,
                        'selesai' => $itemJahit->selesai,
                        'leher' => $itemJahit->leher,
                        'pola_badan' => $itemJahit->pola_badan,
                        'keterangan' => $itemJahit->keterangan,
                        'foto' => $itemJahit->foto,
                    ];
                } elseif ($itemJahit->lk_pelatih_id) {
                    $laporanDataJahit['pelatih'][] = [
                        'id' => $itemJahit->id,
                        'deadline' => $itemJahit->deadline,
                        'selesai' => $itemJahit->selesai,
                        'leher_pelatih' => $itemJahit->leher_pelatih,
                        'pola_badan_pelatih' => $itemJahit->pola_badan_pelatih,
                        'keterangan2' => $itemJahit->keterangan2,
                        'foto_pelatih' => $itemJahit->foto_pelatih,
                    ];
                } elseif ($itemJahit->lk_kiper_id) {
                    $laporanDataJahit['kiper'][] = [
                        'id' => $itemJahit->id,
                        'deadline' => $itemJahit->deadline,
                        'selesai' => $itemJahit->selesai,
                        'leher_kiper' => $itemJahit->leher_kiper,
                        'pola_badan_kiper' => $itemJahit->pola_badan_kiper,
                        'keterangan3' => $itemJahit->keterangan3,
                        'foto_kiper' => $itemJahit->foto_kiper,
                    ];
                } elseif ($itemJahit->lk_1_id) {
                    $laporanDataJahit['lk_1'][] = [
                        'id' => $itemJahit->id,
                        'deadline' => $itemJahit->deadline,
                        'selesai' => $itemJahit->selesai,
                        'leher_1' => $itemJahit->leher_1,
                        'pola_badan_1' => $itemJahit->pola_badan_1,
                        'keterangan4' => $itemJahit->keterangan4,
                        'foto_1' => $itemJahit->foto_1,
                    ];
                } elseif ($itemJahit->lk_celana_player_id) {
                    $laporanDataJahit['celana_player'][] = [
                        'id' => $itemJahit->id,
                        'deadline' => $itemJahit->deadline,
                        'selesai' => $itemJahit->selesai,
                        'leher_celana_pelayer' => $itemJahit->leher_celana_pelayer,
                        'pola_badan_celana_pelayer' => $itemJahit->pola_badan_celana_pelayer,
                        'keterangan5' => $itemJahit->keterangan5,
                        'foto_celana_pelayer' => $itemJahit->foto_celana_pelayer,
                    ];
                } elseif ($itemJahit->lk_celana_pelatih_id) {
                    $laporanDataJahit['celana_pelatih'][] = [
                        'id' => $itemJahit->id,
                        'deadline' => $itemJahit->deadline,
                        'selesai' => $itemJahit->selesai,
                        'leher_celana_pelatih' => $itemJahit->leher_celana_pelatih,
                        'pola_badan_celana_pelatih' => $itemJahit->pola_badan_celana_pelatih,
                        'keterangan6' => $itemJahit->keterangan6,
                        'foto_celana_pelatih' => $itemJahit->foto_celana_pelatih,
                    ];
                } elseif ($itemJahit->lk_celana_kiper_id) {
                    $laporanDataJahit['celana_kiper'][] = [
                        'id' => $itemJahit->id,
                        'deadline' => $itemJahit->deadline,
                        'selesai' => $itemJahit->selesai,
                        'leher_celana_kiper' => $itemJahit->leher_celana_kiper,
                        'pola_badan_celana_kiper' => $itemJahit->pola_badan_celana_kiper,
                        'keterangan7' => $itemJahit->keterangan7,
                        'foto_celana_kiper' => $itemJahit->foto_celana_kiper,
                    ];
                } elseif ($itemJahit->lk_celana_1_id) {
                    $laporanDataJahit['celana_1'][] = [
                        'id' => $itemJahit->id,
                        'deadline' => $itemJahit->deadline,
                        'selesai' => $itemJahit->selesai,
                        'leher_celana_1' => $itemJahit->leher_celana_1,
                        'pola_badan_celana_1' => $itemJahit->pola_badan_celana_1,
                        'keterangan8' => $itemJahit->keterangan8,
                        'foto_celana_1' => $itemJahit->foto_celana_1,
                    ];
                }
            }

            if ($itemSortir) {
                // manual cut
                if ($itemSortir->lk_player_id) {
                    $laporanDataSortir['player'][] = [
                        'id' => $itemSortir->id,
                        'deadline' => $itemSortir->deadline,
                        'selesai' => $itemSortir->selesai,
                        'no_error' => $itemSortir->no_error,
                        'panjang_kertas' => $itemSortir->panjang_kertas,
                        'berat' => $itemSortir->berat,
                        'kertas_id' => $itemSortir->Kertas->nama,
                        'cetak_id' => $itemSortir->Kain->nama,
                        'bahan' => $itemSortir->bahan,
                        'keterangan' => $itemSortir->keterangan,
                        'foto' => $itemSortir->foto,
                    ];
                } elseif ($itemSortir->lk_pelatih_id) {
                    $laporanDataSortir['pelatih'][] = [
                        'id' => $itemSortir->id,
                        'deadline' => $itemSortir->deadline,
                        'selesai' => $itemSortir->selesai,
                        'no_error_pelatih' => $itemSortir->no_error_pelatih,
                        'panjang_kertas_pelatih' => $itemSortir->panjang_kertas_pelatih,
                        'kertas_id' => $itemSortir->Kertas->nama,
                        'cetak_id' => $itemSortir->Kain->nama,
                        'berat_pelatih' => $itemSortir->berat_pelatih,
                        'bahan_pelatih' => $itemSortir->bahan_pelatih,
                        'keterangan2' => $itemSortir->keterangan2,
                        'foto_pelatih' => $itemSortir->foto_pelatih,
                    ];
                } elseif ($itemSortir->lk_kiper_id) {
                    $laporanDataSortir['kiper'][] = [
                        'id' => $itemSortir->id,
                        'deadline' => $itemSortir->deadline,
                        'selesai' => $itemSortir->selesai,
                        'no_error_kiper' => $itemSortir->no_error_kiper,
                        'panjang_kertas_kiper' => $itemSortir->panjang_kertas_kiper,
                        'berat_kiper' => $itemSortir->berat_kiper,
                        'kertas_id' => $itemSortir->Kertas->nama,
                        'cetak_id' => $itemSortir->Kain->nama,
                        'bahan_kiper' => $itemSortir->bahan_kiper,
                        'keterangan3' => $itemSortir->bahan_kiper,
                        'foto_kiper' => $itemSortir->foto_kiper,
                    ];
                } elseif ($itemSortir->lk_1_id) {
                    $laporanDataSortir['lk_1'][] = [
                        'id' => $itemSortir->id,
                        'deadline' => $itemSortir->deadline,
                        'selesai' => $itemSortir->selesai,
                        'kertas_id' => $itemSortir->Kertas->nama,
                        'cetak_id' => $itemSortir->Kain->nama,
                        'no_error_1' => $itemSortir->no_error_1,
                        'panjang_kertas_1' => $itemSortir->panjang_kertas_1,
                        'berat_1' => $itemSortir->berat_1,
                        'bahan_1' => $itemSortir->bahan_1,
                        'keterangan4' => $itemSortir->keterangan4,
                        'foto_1' => $itemSortir->foto_1,
                    ];
                } elseif ($itemSortir->lk_celana_player_id) {
                    $laporanDataSortir['celana_player'][] = [
                        'id' => $itemSortir->id,
                        'deadline' => $itemSortir->deadline,
                        'selesai' => $itemSortir->selesai,
                        'no_error_celana_pelayer' => $itemSortir->no_error_celana_pelayer,
                        'kertas_id' => $itemSortir->Kertas->nama,
                        'cetak_id' => $itemSortir->Kain->nama,
                        'panjang_kertas_celana_pelayer' => $itemSortir->panjang_kertas_celana_pelayer,
                        'berat_celana_pelayer' => $itemSortir->berat_celana_pelayer,
                        'bahan_celana_pelayer' => $itemSortir->bahan_celana_pelayer,
                        'keterangan5' => $itemSortir->keterangan5,
                        'foto_celana_pelayer' => $itemSortir->foto_celana_pelayer,
                    ];
                } elseif ($itemSortir->lk_celana_pelatih_id) {
                    $laporanDataSortir['celana_pelatih'][] = [
                        'id' => $itemSortir->id,
                        'deadline' => $itemSortir->deadline,
                        'selesai' => $itemSortir->selesai,
                        'no_error_celana_pelatih' => $itemSortir->no_error_celana_pelatih,
                        'panjang_kertas_celana_pelatih' => $itemSortir->panjang_kertas_celana_pelatih,
                        'berat_celana_pelatih' => $itemSortir->berat_celana_pelatih,
                        'kertas_id' => $itemSortir->Kertas->nama,
                        'cetak_id' => $itemSortir->Kain->nama,
                        'keterangan6' => $itemSortir->keterangan6,
                        'bahan_celana_pelatih' => $itemSortir->bahan_celana_pelatih,
                        'foto_celana_pelatih' => $itemSortir->foto_celana_pelatih,
                    ];
                } elseif ($itemSortir->lk_celana_kiper_id) {
                    $laporanDataSortir['celana_kiper'][] = [
                        'id' => $itemSortir->id,
                        'deadline' => $itemSortir->deadline,
                        'selesai' => $itemSortir->selesai,
                        'no_error_celana_kiper' => $itemSortir->no_error_celana_kiper,
                        'panjang_kertas_celana_kiper' => $itemSortir->panjang_kertas_celana_kiper,
                        'kertas_id' => $itemSortir->Kertas->nama,
                        'cetak_id' => $itemSortir->Kain->nama,
                        'berat_celana_kiper' => $itemSortir->berat_celana_kiper,
                        'bahan_celana_kiper' => $itemSortir->bahan_celana_kiper,
                        'keterangan7' => $itemSortir->keterangan7,
                        'foto_celana_kiper' => $itemSortir->foto_celana_kiper,
                    ];
                } elseif ($itemSortir->lk_celana_1_id) {
                    $laporanDataSortir['celana_1'][] = [
                        'id' => $itemSortir->id,
                        'deadline' => $itemSortir->deadline,
                        'selesai' => $itemSortir->selesai,
                        'no_error_celana_1' => $itemSortir->no_error_celana_1,
                        'kertas_id' => $itemSortir->Kertas->nama,
                        'cetak_id' => $itemSortir->Kain->nama,
                        'panjang_kertas_celana_1' => $itemSortir->panjang_kertas_celana_1,
                        'berat_celana_1' => $itemSortir->berat_celana_1,
                        'bahan_celana_1' => $itemSortir->bahan_celana_1,
                        'keterangan8' => $itemSortir->keterangan8,
                        'foto_celana_1' => $itemSortir->foto_celana_1,
                    ];
                }
            }

            if ($itemManualCut) {
                // manual cut
                if ($itemManualCut->lk_player_id) {
                    $laporanDataManualCut['player'][] = [
                        'id' => $itemManualCut->id,
                        'deadline' => $itemManualCut->deadline,
                        'selesai' => $itemManualCut->selesai,
                        'keterangan' => $itemManualCut->keterangan,
                        'kain' => $itemManualCut->kain,
                        'kain_id' => $itemManualCut->Kain->nama,
                        'file_foto' => $itemManualCut->file_foto,
                    ];
                } elseif ($itemManualCut->lk_pelatih_id) {
                    $laporanDataManualCut['pelatih'][] = [
                        'id' => $itemManualCut->id,
                        'deadline' => $itemManualCut->deadline,
                        'selesai' => $itemManualCut->selesai,
                        'keterangan2' => $itemManualCut->keterangan2,
                        'kain_pelatih' => $itemManualCut->kain_pelatih,
                        'kain_id' => $itemManualCut->Kain->nama,
                        'file_foto_pelatih' => $itemManualCut->file_foto_pelatih,
                    ];
                } elseif ($itemManualCut->lk_kiper_id) {
                    $laporanDataManualCut['kiper'][] = [
                        'id' => $itemManualCut->id,
                        'deadline' => $itemManualCut->deadline,
                        'selesai' => $itemManualCut->selesai,
                        'keterangan3' => $itemManualCut->keterangan3,
                        'kain_kiper' => $itemManualCut->kain_kiper,
                        'kain_id' => $itemManualCut->Kain->nama,
                        'file_foto_kiper' => $itemManualCut->file_foto_kiper,
                    ];
                } elseif ($itemManualCut->lk_1_id) {
                    $laporanDataManualCut['lk_1'][] = [
                        'id' => $itemManualCut->id,
                        'deadline' => $itemManualCut->deadline,
                        'selesai' => $itemManualCut->selesai,
                        'keterangan4' => $itemManualCut->keterangan4,
                        'kain_1' => $itemManualCut->kain_1,
                        'kain_id' => $itemManualCut->Kain->nama,
                        'file_foto_1' => $itemManualCut->file_foto_1,
                    ];
                } elseif ($itemManualCut->lk_celana_player_id) {
                    $laporanDataManualCut['celana_player'][] = [
                        'id' => $itemManualCut->id,
                        'deadline' => $itemManualCut->deadline,
                        'selesai' => $itemManualCut->selesai,
                        'keterangan5' => $itemManualCut->keterangan5,
                        'kain_celana_player' => $itemManualCut->kain_celana_player,
                        'kain_id' => $itemManualCut->Kain->nama,
                        'file_foto_celana_player' => $itemManualCut->file_foto_celana_player,
                    ];
                } elseif ($itemManualCut->lk_celana_pelatih_id) {
                    $laporanDataManualCut['celana_pelatih'][] = [
                        'id' => $itemManualCut->id,
                        'deadline' => $itemManualCut->deadline,
                        'selesai' => $itemManualCut->selesai,
                        'keterangan6' => $itemManualCut->keterangan6,
                        'kain_celana_pelatih' => $itemManualCut->kain_celana_pelatih,
                        'kain_id' => $itemManualCut->Kain->nama,
                        'file_foto_celana_pelatih' => $itemManualCut->file_foto_celana_pelatih,
                    ];
                } elseif ($itemManualCut->lk_celana_kiper_id) {
                    $laporanDataManualCut['celana_kiper'][] = [
                        'id' => $itemManualCut->id,
                        'deadline' => $itemManualCut->deadline,
                        'selesai' => $itemManualCut->selesai,
                        'kain_celana_kiper' => $itemManualCut->kain_celana_kiper,
                        'kain_id' => $itemManualCut->Kain->nama,
                        'keterangan7' => $itemManualCut->keterangan7,
                        'file_foto_celana_kiper' => $itemManualCut->file_foto_celana_kiper,
                    ];
                } elseif ($itemManualCut->lk_celana_1_id) {
                    $laporanDataManualCut['celana_1'][] = [
                        'id' => $itemManualCut->id,
                        'deadline' => $itemManualCut->deadline,
                        'selesai' => $itemManualCut->selesai,
                        'kain_celeana_1' => $itemManualCut->kain_celeana_1,
                        'kain_id' => $itemManualCut->Kain->nama,
                        'keterangan8' => $itemManualCut->keterangan8,
                        'file_foto_celana_1' => $itemManualCut->file_foto_celana_1,
                    ];
                }
            }

            if ($itemLaserCut) {
                // press kain
                if ($itemLaserCut->lk_player_id) {
                    $laporanDataLaserCut['player'][] = [
                        'id' => $itemLaserCut->id,
                        'deadline' => $itemLaserCut->deadline,
                        'selesai' => $itemLaserCut->selesai,
                        'keterangan' => $itemLaserCut->keterangan,
                        'keterangan' => $itemLaserCut->keterangan,
                        'file_foto' => $itemLaserCut->file_foto,
                    ];
                } elseif ($itemLaserCut->lk_pelatih_id) {
                    $laporanDataLaserCut['pelatih'][] = [
                        'id' => $itemLaserCut->id,
                        'deadline' => $itemLaserCut->deadline,
                        'selesai' => $itemLaserCut->selesai,
                        'keterangan2' => $itemLaserCut->keterangan2,
                        'file_foto_pelatih' => $itemLaserCut->file_foto_pelatih,
                    ];
                } elseif ($itemLaserCut->lk_kiper_id) {
                    $laporanDataLaserCut['kiper'][] = [
                        'id' => $itemLaserCut->id,
                        'deadline' => $itemLaserCut->deadline,
                        'selesai' => $itemLaserCut->selesai,
                        'keterangan3' => $itemLaserCut->keterangan3,
                        'file_foto_kiper' => $itemLaserCut->file_foto_kiper,
                    ];
                } elseif ($itemLaserCut->lk_1_id) {
                    $laporanDataLaserCut['lk_1'][] = [
                        'id' => $itemLaserCut->id,
                        'deadline' => $itemLaserCut->deadline,
                        'selesai' => $itemLaserCut->selesai,
                        'keterangan4' => $itemLaserCut->keterangan4,
                        'file_foto_1' => $itemLaserCut->file_foto_1,
                    ];
                } elseif ($itemLaserCut->lk_celana_player_id) {
                    $laporanDataLaserCut['celana_player'][] = [
                        'id' => $itemLaserCut->id,
                        'deadline' => $itemLaserCut->deadline,
                        'selesai' => $itemLaserCut->selesai,
                        'keterangan5' => $itemLaserCut->keterangan5,
                        'file_foto_celana_player' => $itemLaserCut->file_foto_celana_player,
                    ];
                } elseif ($itemLaserCut->lk_celana_pelatih_id) {
                    $laporanDataLaserCut['celana_pelatih'][] = [
                        'id' => $itemLaserCut->id,
                        'deadline' => $itemLaserCut->deadline,
                        'selesai' => $itemLaserCut->selesai,
                        'keterangan6' => $itemLaserCut->keterangan6,
                        'file_foto_celana_pelatih' => $itemLaserCut->file_foto_celana_pelatih,
                    ];
                } elseif ($itemLaserCut->lk_celana_kiper_id) {
                    $laporanDataLaserCut['celana_kiper'][] = [
                        'id' => $itemLaserCut->id,
                        'deadline' => $itemLaserCut->deadline,
                        'selesai' => $itemLaserCut->selesai,
                        'keterangan7' => $itemLaserCut->keterangan7,
                        'file_foto_celana_kiper' => $itemLaserCut->file_foto_celana_kiper,
                    ];
                } elseif ($itemLaserCut->lk_celana_1_id) {
                    $laporanDataLaserCut['celana_1'][] = [
                        'id' => $itemLaserCut->id,
                        'deadline' => $itemLaserCut->deadline,
                        'selesai' => $itemLaserCut->selesai,
                        'keterangan8' => $itemLaserCut->keterangan8,
                        'file_foto_celana_1' => $itemLaserCut->file_foto_celana_1,
                    ];
                }
            }

            if ($itemPressKain) {
                // press kain
                if ($itemPressKain->lk_player_id) {
                    $laporanDataPressKain['player'][] = [
                        'id' => $itemPressKain->id,
                        'deadline' => $itemPressKain->deadline,
                        'selesai' => $itemPressKain->selesai,
                        'kain' => $itemPressKain->kain,
                        'kain_id' => $itemPressKain->Kain->nama,
                        'berat' => $itemPressKain->berat,
                        'keterangan' => $itemPressKain->keterangan,
                        'gambar' => $itemPressKain->gambar,
                    ];
                } elseif ($itemPressKain->lk_pelatih_id) {
                    $laporanDataPressKain['pelatih'][] = [
                        'id' => $itemPressKain->id,
                        'deadline' => $itemPressKain->deadline,
                        'selesai' => $itemPressKain->selesai,
                        'kain_pelatih' => $itemPressKain->kain_pelatih,
                        'berat_pelatih' => $itemPressKain->berat_pelatih,
                        'kain_id' => $itemPressKain->Kain->nama,
                        'keterangan2' => $itemPressKain->keterangan2,
                        'gambar_pelatih' => $itemPressKain->gambar_pelatih,
                    ];
                } elseif ($itemPressKain->lk_kiper_id) {
                    $laporanDataPressKain['kiper'][] = [
                        'id' => $itemPressKain->id,
                        'deadline' => $itemPressKain->deadline,
                        'selesai' => $itemPressKain->selesai,
                        'kain_kiper' => $itemPressKain->kain_kiper,
                        'berat_kiper' => $itemPressKain->berat_kiper,
                        'kain_id' => $itemPressKain->Kain->nama,
                        'keterangan3' => $itemPressKain->keterangan3,
                        'gambar_kiper' => $itemPressKain->gambar_kiper,
                    ];
                } elseif ($itemPressKain->lk_1_id) {
                    $laporanDataPressKain['lk_1'][] = [
                        'id' => $itemPressKain->id,
                        'kain_id' => $itemPressKain->Kain->nama,
                        'deadline' => $itemPressKain->deadline,
                        'selesai' => $itemPressKain->selesai,
                        'kain_1' => $itemPressKain->kain_1,
                        'berat_1' => $itemPressKain->berat_1,
                        'keterangan4' => $itemPressKain->keterangan4,
                        'gambar_1' => $itemPressKain->gambar_1,
                    ];
                } elseif ($itemPressKain->lk_celana_player_id) {
                    $laporanDataPressKain['celana_player'][] = [
                        'id' => $itemPressKain->id,
                        'deadline' => $itemPressKain->deadline,
                        'selesai' => $itemPressKain->selesai,
                        'kain_celana_player' => $itemPressKain->kain_celana_player,
                        'berat_celana_player' => $itemPressKain->berat_celana_player,
                        'kain_id' => $itemPressKain->Kain->nama,
                        'keterangan5' => $itemPressKain->keterangan5,
                        'gambar_celana_player' => $itemPressKain->gambar_celana_player,
                    ];
                } elseif ($itemPressKain->lk_celana_pelatih_id) {
                    $laporanDataPressKain['celana_pelatih'][] = [
                        'id' => $itemPressKain->id,
                        'deadline' => $itemPressKain->deadline,
                        'selesai' => $itemPressKain->selesai,
                        'kain_celana_pelatih' => $itemPressKain->kain_celana_pelatih,
                        'berat_celana_pelatih' => $itemPressKain->berat_celana_pelatih,
                        'keterangan6' => $itemPressKain->keterangan6,
                        'gambar_celana_pelatih' => $itemPressKain->gambar_celana_pelatih,
                    ];
                } elseif ($itemPressKain->lk_celana_kiper_id) {
                    $laporanDataPressKain['celana_kiper'][] = [
                        'id' => $itemPressKain->id,
                        'deadline' => $itemPressKain->deadline,
                        'kain_id' => $itemPressKain->Kain->nama,
                        'selesai' => $itemPressKain->selesai,
                        'kain_celana_kiper' => $itemPressKain->kain_celana_kiper,
                        'berat_celana_kiper' => $itemPressKain->berat_celana_kiper,
                        'keterangan7' => $itemPressKain->keterangan7,
                        'gambar_celana_kiper' => $itemPressKain->gambar_celana_kiper,
                    ];
                } elseif ($itemPressKain->lk_celana_1_id) {
                    $laporanDataPressKain['celana_1'][] = [
                        'id' => $itemPressKain->id,
                        'deadline' => $itemPressKain->deadline,
                        'selesai' => $itemPressKain->selesai,
                        'kain_celana_1' => $itemPressKain->kain_celana_1,
                        'berat_celana_1' => $itemPressKain->berat_celana_1,
                        'keterangan8' => $itemPressKain->keterangan8,
                        'kain_id' => $itemPressKain->Kain->nama,
                        'gambar_celana_1' => $itemPressKain->gambar_celana_1,
                    ];
                }
            }

            // if ($itemMimaki) {
            //     // mimaki
            //     if ($itemMimaki->lk_player_id) {
            //         $penanggung_jawab_id  = $itemMimaki->UserMesinAtexco ? $itemMimaki->UserMesinAtexco->name : 'Belum melakukan update data';
            //         $laporanDataMimaki['player'][] = [
            //             'id' => $itemMimaki->id,
            //             'deadline' => $itemMimaki->deadline,
            //             'selesai' => $itemMimaki->selesai,
            //             'file_foto' => $itemMimaki->file_foto,
            //             'penanggung_jawab_id' => $penanggung_jawab_id
            //         ];
            //     } elseif ($itemMimaki->lk_pelatih_id) {
            //         $penanggung_jawab_id  = $itemMimaki->UserMesinAtexco ? $itemMimaki->UserMesinAtexco->name : 'Belum melakukan update data';
            //         $laporanDataMimaki['pelatih'][] = [
            //             'id' => $itemMimaki->id,
            //             'deadline' => $itemMimaki->deadline,
            //             'selesai' => $itemMimaki->selesai,
            //             'file_foto_pelatih' => $itemMimaki->file_foto_pelatih,
            //             'penanggung_jawab_id' =>  $penanggung_jawab_id
            //         ];
            //     } elseif ($itemMimaki->lk_kiper_id) {
            //         $penanggung_jawab_id  = $itemMimaki->UserMesinAtexco ? $itemMimaki->UserMesinAtexco->name : 'Belum melakukan update data';
            //         $laporanDataMimaki['kiper'][] = [
            //             'id' => $itemMimaki->id,
            //             'deadline' => $itemMimaki->deadline,
            //             'selesai' => $itemMimaki->selesai,
            //             'file_foto_kiper' => $itemMimaki->file_foto_kiper,
            //             'penanggung_jawab_id' =>  $penanggung_jawab_id
            //         ];
            //     } elseif ($itemMimaki->lk_1_id) {
            //         $penanggung_jawab_id  = $itemMimaki->UserMesinAtexco ? $itemMimaki->UserMesinAtexco->name : 'Belum melakukan update data';
            //         $laporanDataMimaki['lk_1'][] = [
            //             'id' => $itemMimaki->id,
            //             'deadline' => $itemMimaki->deadline,
            //             'selesai' => $itemMimaki->selesai,
            //             'file_foto_1' => $itemMimaki->file_foto_1,
            //             'penanggung_jawab_id' =>  $penanggung_jawab_id
            //         ];
            //     } elseif ($itemMimaki->lk_celana_player_id) {
            //         $penanggung_jawab_id  = $itemMimaki->UserMesinAtexco ? $itemMimaki->UserMesinAtexco->name : 'Belum melakukan update data';
            //         $laporanDataMimaki['celana_player'][] = [
            //             'id' => $itemMimaki->id,
            //             'deadline' => $itemMimaki->deadline,
            //             'selesai' => $itemMimaki->selesai,
            //             'file_foto_celana_player' => $itemMimaki->file_foto_celana_player,
            //             'penanggung_jawab_id' =>  $penanggung_jawab_id
            //         ];
            //     } elseif ($itemMimaki->lk_celana_pelatih_id) {
            //         $penanggung_jawab_id  = $itemMimaki->UserMesinAtexco ? $itemMimaki->UserMesinAtexco->name : 'Belum melakukan update data';
            //         $laporanDataMimaki['celana_pelatih'][] = [
            //             'id' => $itemMimaki->id,
            //             'deadline' => $itemMimaki->deadline,
            //             'selesai' => $itemMimaki->selesai,
            //             'file_foto_celana_pelatih' => $itemMimaki->file_foto_celana_pelatih,
            //             'penanggung_jawab_id' =>  $penanggung_jawab_id
            //         ];
            //     } elseif ($itemMimaki->lk_celana_kiper_id) {
            //         $penanggung_jawab_id  = $itemMimaki->UserMesinAtexco ? $itemMimaki->UserMesinAtexco->name : 'Belum melakukan update data';
            //         $laporanDataMimaki['celana_kiper'][] = [
            //             'id' => $itemMimaki->id,
            //             'deadline' => $itemMimaki->deadline,
            //             'selesai' => $itemMimaki->selesai,
            //             'file_foto_celana_kiper' => $itemMimaki->file_foto_celana_kiper,
            //             'penanggung_jawab_id' =>  $penanggung_jawab_id
            //         ];
            //     } elseif ($itemMimaki->lk_celana_1_id) {
            //         $penanggung_jawab_id  = $itemMimaki->UserMesinAtexco ? $itemMimaki->UserMesinAtexco->name : 'Belum melakukan update data';
            //         $laporanDataMimaki['celana_1'][] = [
            //             'id' => $itemMimaki->id,
            //             'deadline' => $itemMimaki->deadline,
            //             'selesai' => $itemMimaki->selesai,
            //             'file_foto_celana_1' => $itemMimaki->file_foto_celana_1,
            //             'penanggung_jawab_id' =>  $penanggung_jawab_id
            //         ];
            //     }
            // }

            if ($itemAtexco) {
                // atexco
                if ($itemAtexco->lk_player_id) {
                    $penanggung_jawab_id = $itemAtexco->UserMesinAtexco ? $itemAtexco->UserMesinAtexco->name : 'Belum melakukan update data';
                    $laporanDataAtexco['player'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto' => $itemAtexco->file_foto,
                        'keterangan' => $itemAtexco->keterangan,
                        'penanggung_jawab_id' => $penanggung_jawab_id,
                    ];
                } elseif ($itemAtexco->lk_pelatih_id) {
                    $penanggung_jawab_id = $itemAtexco->UserMesinAtexco ? $itemAtexco->UserMesinAtexco->name : 'Belum melakukan update data';
                    $laporanDataAtexco['pelatih'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto_pelatih' => $itemAtexco->file_foto_pelatih,
                        'keterangan2' => $itemAtexco->keterangan2,
                        'penanggung_jawab_id' => $penanggung_jawab_id,
                    ];
                } elseif ($itemAtexco->lk_kiper_id) {
                    $penanggung_jawab_id = $itemAtexco->UserMesinAtexco ? $itemAtexco->UserMesinAtexco->name : 'Belum melakukan update data';
                    $laporanDataAtexco['kiper'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto_kiper' => $itemAtexco->file_foto_kiper,
                        'keterangan3' => $itemAtexco->keterangan3,
                        'penanggung_jawab_id' => $penanggung_jawab_id,
                    ];
                } elseif ($itemAtexco->lk_1_id) {
                    $penanggung_jawab_id = $itemAtexco->UserMesinAtexco ? $itemAtexco->UserMesinAtexco->name : 'Belum melakukan update data';
                    $laporanDataAtexco['lk_1'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto_1' => $itemAtexco->file_foto_1,
                        'keterangan4' => $itemAtexco->keterangan4,
                        'penanggung_jawab_id' => $penanggung_jawab_id,
                    ];
                } elseif ($itemAtexco->lk_celana_player_id) {
                    $penanggung_jawab_id = $itemAtexco->UserMesinAtexco ? $itemAtexco->UserMesinAtexco->name : 'Belum melakukan update data';
                    $laporanDataAtexco['celana_player'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto_celana_player' => $itemAtexco->file_foto_celana_player,
                        'keterangan5' => $itemAtexco->keterangan5,
                        'penanggung_jawab_id' => $penanggung_jawab_id,
                    ];
                } elseif ($itemAtexco->lk_celana_pelatih_id) {
                    $penanggung_jawab_id = $itemAtexco->UserMesinAtexco ? $itemAtexco->UserMesinAtexco->name : 'Belum melakukan update data';
                    $laporanDataAtexco['celana_pelatih'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto_celana_pelatih' => $itemAtexco->file_foto_celana_pelatih,
                        'keterangan6' => $itemAtexco->keterangan6,
                        'penanggung_jawab_id' => $penanggung_jawab_id,
                    ];
                } elseif ($itemAtexco->lk_celana_kiper_id) {
                    $penanggung_jawab_id = $itemAtexco->UserMesinAtexco ? $itemAtexco->UserMesinAtexco->name : 'Belum melakukan update data';
                    $laporanDataAtexco['celana_kiper'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto_celana_kiper' => $itemAtexco->file_foto_celana_kiper,
                        'keterangan7' => $itemAtexco->keterangan7,
                        'penanggung_jawab_id' => $penanggung_jawab_id,
                    ];
                } elseif ($itemAtexco->lk_celana_1_id) {
                    $penanggung_jawab_id = $itemAtexco->UserMesinAtexco ? $itemAtexco->UserMesinAtexco->name : 'Belum melakukan update data';
                    $laporanDataAtexco['celana_1'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto_celana_1' => $itemAtexco->file_foto_celana_1,
                        'keterangan8' => $itemAtexco->keterangan8,
                        'penanggung_jawab_id' => $penanggung_jawab_id,
                    ];
                }
            }

            if ($item) {
                // layout
                if ($item->lk_player_id) {
                    // $tanda_selesai = $item->selesai ? $item->selesai : 'Bbelum melakukann update'
                    $laporanData['player'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'kertas_id' => $item->Kertas->nama,
                        'keterangan1' => $item->keterangan1,
                        'users_layout_id' => $item->UserLayout->name,
                        'panjang_kertas_palayer' => $item->panjang_kertas_palayer,
                        'poly_player' => $item->poly_player,
                    ];
                } elseif ($item->lk_pelatih_id) {
                    $laporanData['pelatih'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'kertas_id' => $item->Kertas->nama,
                        'keterangan2' => $item->keterangan2,
                        'users_layout_id' => $item->UserLayout->name,
                        'panjang_kertas_pelatih' => $item->panjang_kertas_pelatih,
                        'poly_pelatih' => $item->poly_pelatih,
                    ];
                } elseif ($item->lk_kiper_id) {
                    $laporanData['kiper'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'keterangan3' => $item->keterangan3,
                        'kertas_id' => $item->Kertas->nama,
                        'users_layout_id' => $item->UserLayout->name,
                        'panjang_kertas_kiper' => $item->panjang_kertas_kiper,
                        'poly_kiper' => $item->poly_kiper,
                    ];
                } elseif ($item->lk_1_id) {
                    $laporanData['lk_1'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'keterangan4' => $item->keterangan4,
                        'users_layout_id' => $item->UserLayout->name,
                        'panjang_kertas_1' => $item->panjang_kertas_1,
                        'kertas_id' => $item->Kertas->nama,
                        'poly_1' => $item->poly_1,
                    ];
                } elseif ($item->lk_celana_player_id) {
                    $laporanData['celana_player'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'keterangan5' => $item->keterangan5,
                        'users_layout_id' => $item->UserLayout->name,
                        'kertas_id' => $item->Kertas->nama,
                        'panjang_kertas_celana_pelayer' => $item->panjang_kertas_celana_pelayer,
                        'poly_celana_pelayer' => $item->poly_celana_pelayer,
                    ];
                } elseif ($item->lk_celana_pelatih_id) {
                    $laporanData['celana_pelatih'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'keterangan6' => $item->keterangan6,
                        'kertas_id' => $item->Kertas->nama,
                        'users_layout_id' => $item->UserLayout->name,
                        'panjang_kertas_celana_pelatih' => $item->panjang_kertas_celana_pelatih,
                        'poly_celana_pelatih' => $item->poly_celana_pelatih,
                    ];
                } elseif ($item->lk_celana_kiper_id) {
                    $laporanData['celana_kiper'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'kertas_id' => $item->Kertas->nama,
                        'keterangan7' => $item->keterangan7,
                        'users_layout_id' => $item->UserLayout->name,
                        'panjang_kertas_celana_kiper' => $item->panjang_kertas_celana_kiper,
                        'poly_celana_kiper' => $item->poly_celana_kiper,
                    ];
                } elseif ($item->lk_celana_1_id) {
                    $laporanData['celana_1'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'keterangan8' => $item->keterangan8,
                        'users_layout_id' => $item->UserLayout->name,
                        'panjang_kertas_celana_1' => $item->panjang_kertas_celana_1,
                        'poly_celana_1' => $item->poly_celana_1,
                        'kertas_id' => $item->Kertas->nama,
                    ];
                }
            }
        }

        // return response()->json([
        //     $laporanData,
        //     $laporanDataAtexco,
        //     $laporanDataPressKain,
        //     $laporanDataLaserCut,
        //     $laporanDataManualCut,
        //     $laporanDataSortir,
        //     $laporanDataJahit,
        //     $laporanDataFinis,
        // ]);
        // return response()->json($laporanDataSortir);

        return view('component.Admin.laporan-pengerjaan.details', compact(
            'laporans',
            'laporanDataSortir',
            'laporanDataFinis',
            'laporanDataJahit',
            'laporanData',
            'laporanDataManualCut',
            'laporanDataLaserCut',
            'laporanDataAtexco',
            // 'laporanDataMimaki',
            'laporanDataPressKain'
        ));
    }

    public function postUpdatePirmission(Request $request)
    {
        for ($i = 0; $i < count($request->id); $i++) {
            $data[] = $request->id;
            $edit = $request->permission_edit[$request->id[$i]] == 'on' ? 1 : 0;
            $hapus = $request->permission_hapus[$request->id[$i]] == 'on' ? 1 : 0;
            $create = $request->permission_create[$request->id[$i]] == 'on' ? 1 : 0;
            $show = $request->permission_show[$request->id[$i]] == 'on' ? 1 : 0;
            $nonaktif = $request->non_aktif[$request->id[$i]] == 'on' ? 1 : 0;
            $user = User::findOrFail($request->id[$i]);
            $user->update([
                'permission_edit' => $edit,
                'permission_hapus' => $hapus,
                'permission_create' => $create,
                'permission_show' => $show,
                'non_aktif' => $nonaktif
            ]);
        }

        return redirect()->back()->with('success', 'Permission telah diperbarui.');
    }

    public function getPembagianKomisi()
    {
        return view('component.Admin.pembagian-komisi-pengerjaan.index-filtering');
    }

    public function getFilterPembagianKomisi(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $kotaProduksi = $request->input('kotaProduksi');

        if (empty($bulan) || empty($tahun) || empty($kotaProduksi)) {
            return redirect()->back()->with('error', 'Filtering data yang anda masukkan kurang lengkap !!');
        }

        $pembagianKomisi = PembagianKomisi::with('BarangMasukCs', 'UserLayout')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('kota', $kotaProduksi)
            ->get()
            ->groupBy('user_id');

        $pembagianKomisiFiltered = $pembagianKomisi->map(function ($group) {
            return $group->first()->load('BarangMasukCs', 'UserLayout');
        });

        $totalKomisiPerUser = [];

        foreach ($pembagianKomisi as $user_id => $data) {
            $totalKomisi = 0;
            foreach ($data as $pembagian) {
                $totalKomisi += $pembagian->jumlah_komisi;
            }
            $totalKomisiPerUser[$user_id] = $totalKomisi;
        }

        // return response()->json($totalKomisiPerUser);

        return view('component.Admin.pembagian-komisi-pengerjaan.index', compact('pembagianKomisiFiltered', 'totalKomisiPerUser'))->with('success', 'Filtering data berhasil.');
    }

    public function getUpdatePassword()
    {
        $users = User::findOrFail(Auth::user()->id);
        // return response()->json($users);

        return view('component.Admin.update-passsword.index', compact('users'));
    }

    public function postUpdatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        User::find($user->id);

        $user->password = Hash::make($request->password);

        $userShow = PasswordUser::where('user', $user->id)->first();

        $userShow->update([
            'password' => $request->password
        ]);

        $user->save();

        // return response()->json($userShow);



        return redirect()->back()->with('success', 'Permission telah diperbarui.');
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

        $layout = BarangMasukDatalayout::with('GamarTangkaplayar')->where('barang_masuk_id', $dataLk->BarangMasukDisainer->id)->get();

        view()->share('dataLk', $dataLk->BarangMasukDisainer->nama_tim);

        $pdf = PDF::loadview('component.Mesin.export-data-baju', compact('dataLk', 'layout'));
        $pdf->setPaper('A4', 'potrait');

        // return $pdf->stream('data-baju.pdf');
        $namaTimClean = preg_replace('/[^A-Za-z0-9\-]/', '', $dataLk->BarangMasukDisainer->nama_tim);
        return $pdf->stream($namaTimClean . '.pdf');
    }

    public function getLaporanProduksi(Request $request)
    {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');

        $dates = [];
        $totals = [];
        $totalsByCity = [];

        for ($i = 1; $i <= 31; $i++) {
            $deadline = $tahun . '-' . $bulan . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);

            $jahits = Jahit::with('BarangMasukCs')->whereDate('deadline', $deadline)->get();
            $total_semua = 0;
            $totalsByCityForDay = [];

            foreach ($jahits as $jahit) {
                $barangMasuk = $jahit->barangMasukCs()->first();

                if ($barangMasuk) {
                    $total_baju = ($barangMasuk->total_baju_player ?? 0) +
                        ($barangMasuk->total_baju_pelatih ?? 0) +
                        ($barangMasuk->total_baju_kiper ?? 0) +
                        ($barangMasuk->total_baju_1 ?? 0);

                    $total_celana = ($barangMasuk->total_celana_player ?? 0) +
                        ($barangMasuk->total_celana_pelatih ?? 0) +
                        ($barangMasuk->total_celana_kiper ?? 0) +
                        ($barangMasuk->total_celana_1 ?? 0);

                    $total_semua += $total_baju + $total_celana;

                    $kota_produksi = $barangMasuk->kota_produksi ?? 'Unknown';
                    if (!isset($totalsByCityForDay[$kota_produksi])) {
                        $totalsByCityForDay[$kota_produksi] = 0;
                    }

                    $totalsByCityForDay[$kota_produksi] += $total_baju + $total_celana;
                }
            }

            $dates[] = $deadline;
            $totals[] = $total_semua;

            foreach ($totalsByCityForDay as $city => $total) {
                if (!isset($totalsByCity[$city])) {
                    $totalsByCity[$city] = [];
                }
                $totalsByCity[$city][] = [
                    'date' => $deadline,
                    'total' => $total
                ];
            }
        }

        return view('component.Admin.laporan-produksi.index-filtering', compact(
            'total_semua',
            'dates',
            'totals',
            'totalsByCity'
        ));
    }

    public function getLaporanSemuaProduksi()
    {
        return view('component.Admin.laporan-produksi.index-producksi');
    }

    public function getLaporanKertas(Request $request)
    {
        $dari = $request->input('dari');
        $ke = $request->input('ke');

        $laporanLayout = LaporanKainLayout::select('kertas_id', 'daerah', LaporanCetakPresskain::raw('SUM(total_kertas) as total_kertas'))
            ->whereBetween('created_at', [$dari, $ke])
            ->groupBy('kertas_id', 'daerah')
            ->with('Kertas')
            ->get();

        $laporanSortir = LaporanKainSortir::select('kertas_id', 'daerah', LaporanCetakPresskain::raw('SUM(total_kertas) as total_kertas'))
            ->whereBetween('created_at', [$dari, $ke])
            ->groupBy('kertas_id', 'daerah')
            ->with('Kertas')
            ->get();

        // return response()->json($laporanSortir);

        view()->share('laporan', 'laporan');

        $pdf = PDF::loadview('component.Admin.laporan-produksi.laporan-kertas', compact('laporanLayout', 'dari', 'ke', 'laporanSortir'));
        $pdf->setPaper('A4', 'potrait');

        return $pdf->stream('laporan.pdf');
    }

    public function getLaporanbahankain(Request $request)
    {
        $dari = $request->input('dari');
        $ke = $request->input('ke');

        $data = LaporanCetakPresskain::select('kain_id', 'daerah', LaporanCetakPresskain::raw('SUM(total_kain) as total_kain'))
            ->whereBetween('created_at', [$dari, $ke])
            ->groupBy('kain_id', 'daerah')
            ->with('Kain')
            ->get();

        $cutPolos =  LaporanCetakCutPolos::select('kain_id', 'daerah', LaporanCetakPresskain::raw('SUM(total_kain) as total_kain'))
            ->whereBetween('created_at', [$dari, $ke])
            ->groupBy('kain_id', 'daerah')
            ->with('Kain')
            ->get();


        $sortir = LaporanCetakSortir::select('kain_id', 'daerah', LaporanCetakPresskain::raw('SUM(total_kain) as total_kain'))
            ->whereBetween('created_at', [$dari, $ke])
            ->groupBy('kain_id', 'daerah')
            ->with('Kain')
            ->get();
        // return response()->json($sortir);


        view()->share('laporan', 'laporan');

        $pdf = PDF::loadview('component.Admin.laporan-produksi.laporan-kain', compact('cutPolos', 'data', 'dari', 'ke', 'sortir'));
        $pdf->setPaper('A4', 'potrait');

        return $pdf->stream('laporan.pdf');
    }
}
