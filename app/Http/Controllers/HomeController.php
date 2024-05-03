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
use App\Models\MesinAtexco;
use App\Models\MesinMimaki;
use App\Models\PasswordUser;
use App\Models\PembagianKomisi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        // Looping untuk setiap tanggal dalam bulan ini
        for ($i = 1; $i <= 31; $i++) {
            $deadline = $tahun . '-' . $bulan . '-' . str_pad($i, 2, '0', STR_PAD_LEFT); // Format tanggal

            $jahits = Jahit::whereDate('deadline', $deadline)->get();
            $total_semua = 0;

            foreach ($jahits as $jahit) {
                $barangMasuk = $jahit->barangMasukCs()->first();

                if ($barangMasuk) {
                    $total_semua += $barangMasuk->total_baju_player ?? 0;
                    $total_semua += $barangMasuk->total_baju_pelatih ?? 0;
                    $total_semua += $barangMasuk->total_baju_kiper ?? 0;
                    $total_semua += $barangMasuk->total_baju_1 ?? 0;
                    $total_semua += $barangMasuk->total_celana_player ?? 0;
                    $total_semua += $barangMasuk->total_celana_pelatih ?? 0;
                    $total_semua += $barangMasuk->total_celana_kiper ?? 0;
                    $total_semua += $barangMasuk->total_celana_1 ?? 0;
                }
            }

            // Menambahkan data ke array
            $dates[] = $deadline;
            $totals[] = $total_semua;
        }

        // return response()->json($total_semua);

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
            'password_user' => $request->password_user
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
            'password_user' => $request->password_user
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
            'password_user' => $request->password_user
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
        $laporanDataMimaki = [];
        $laporanDataPressKain = [];
        $laporanDataLaserCut = [];
        $laporanDataManualCut = [];
        $laporanDataSortir = [];
        $laporanDataJahit = [];
        $laporanDataFinis = [];

        foreach ($laporans as $laporan) {
            $item = $laporan->BarangMasukLayout;
            $itemAtexco = $laporan->BarangMasukMesinAtexco;
            $itemMimaki = $laporan->BarangMasukMesinMimaki;
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
                        'foto' => $itemFinis->foto,
                    ];
                } elseif ($itemFinis->lk_pelatih_id) {
                    $laporanDataFinis['pelatih'][] = [
                        'id' => $itemFinis->id,
                        'deadline' => $itemFinis->deadline,
                        'selesai' => $itemFinis->selesai,
                        'foto_pelatih' => $itemFinis->foto_pelatih,
                    ];
                } elseif ($itemFinis->lk_kiper_id) {
                    $laporanDataFinis['kiper'][] = [
                        'id' => $itemFinis->id,
                        'deadline' => $itemFinis->deadline,
                        'selesai' => $itemFinis->selesai,
                        'foto_kiper' => $itemFinis->foto_kiper,
                    ];
                } elseif ($itemFinis->lk_1_id) {
                    $laporanDataFinis['lk_1'][] = [
                        'id' => $itemFinis->id,
                        'deadline' => $itemFinis->deadline,
                        'selesai' => $itemFinis->selesai,
                        'foto_1' => $itemFinis->foto_1,
                    ];
                } elseif ($itemFinis->lk_celana_player_id) {
                    $laporanDataFinis['celana_player'][] = [
                        'id' => $itemFinis->id,
                        'deadline' => $itemFinis->deadline,
                        'selesai' => $itemFinis->selesai,
                        'foto_celana_pelayer' => $itemFinis->foto_celana_pelayer,
                    ];
                } elseif ($itemFinis->lk_celana_pelatih_id) {
                    $laporanDataFinis['celana_pelatih'][] = [
                        'id' => $itemFinis->id,
                        'deadline' => $itemFinis->deadline,
                        'selesai' => $itemFinis->selesai,
                        'foto_celana_pelatih' => $itemFinis->foto_celana_pelatih,
                    ];
                } elseif ($itemFinis->lk_celana_kiper_id) {
                    $laporanDataFinis['celana_kiper'][] = [
                        'id' => $itemFinis->id,
                        'deadline' => $itemFinis->deadline,
                        'selesai' => $itemFinis->selesai,
                        'foto_celana_kiper' => $itemFinis->foto_celana_kiper,
                    ];
                } elseif ($itemFinis->lk_celana_1_id) {
                    $laporanDataFinis['celana_1'][] = [
                        'id' => $itemFinis->id,
                        'deadline' => $itemFinis->deadline,
                        'selesai' => $itemFinis->selesai,
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
                        'foto' => $itemJahit->foto,
                    ];
                } elseif ($itemJahit->lk_pelatih_id) {
                    $laporanDataJahit['pelatih'][] = [
                        'id' => $itemJahit->id,
                        'deadline' => $itemJahit->deadline,
                        'selesai' => $itemJahit->selesai,
                        'leher_pelatih' => $itemJahit->leher_pelatih,
                        'pola_badan_pelatih' => $itemJahit->pola_badan_pelatih,
                        'foto_pelatih' => $itemJahit->foto_pelatih,
                    ];
                } elseif ($itemJahit->lk_kiper_id) {
                    $laporanDataJahit['kiper'][] = [
                        'id' => $itemJahit->id,
                        'deadline' => $itemJahit->deadline,
                        'selesai' => $itemJahit->selesai,
                        'leher_kiper' => $itemJahit->leher_kiper,
                        'pola_badan_kiper' => $itemJahit->pola_badan_kiper,
                        'foto_kiper' => $itemJahit->foto_kiper,
                    ];
                } elseif ($itemJahit->lk_1_id) {
                    $laporanDataJahit['lk_1'][] = [
                        'id' => $itemJahit->id,
                        'deadline' => $itemJahit->deadline,
                        'selesai' => $itemJahit->selesai,
                        'leher_1' => $itemJahit->leher_1,
                        'pola_badan_1' => $itemJahit->pola_badan_1,
                        'foto_1' => $itemJahit->foto_1,
                    ];
                } elseif ($itemJahit->lk_celana_player_id) {
                    $laporanDataJahit['celana_player'][] = [
                        'id' => $itemJahit->id,
                        'deadline' => $itemJahit->deadline,
                        'selesai' => $itemJahit->selesai,
                        'leher_celana_pelayer' => $itemJahit->leher_celana_pelayer,
                        'pola_badan_celana_pelayer' => $itemJahit->pola_badan_celana_pelayer,
                        'foto_celana_pelayer' => $itemJahit->foto_celana_pelayer,
                    ];
                } elseif ($itemJahit->lk_celana_pelatih_id) {
                    $laporanDataJahit['celana_pelatih'][] = [
                        'id' => $itemJahit->id,
                        'deadline' => $itemJahit->deadline,
                        'selesai' => $itemJahit->selesai,
                        'leher_celana_pelatih' => $itemJahit->leher_celana_pelatih,
                        'pola_badan_celana_pelatih' => $itemJahit->pola_badan_celana_pelatih,
                        'foto_celana_pelatih' => $itemJahit->foto_celana_pelatih,
                    ];
                } elseif ($itemJahit->lk_celana_kiper_id) {
                    $laporanDataJahit['celana_kiper'][] = [
                        'id' => $itemJahit->id,
                        'deadline' => $itemJahit->deadline,
                        'selesai' => $itemJahit->selesai,
                        'leher_celana_kiper' => $itemJahit->leher_celana_kiper,
                        'pola_badan_celana_kiper' => $itemJahit->pola_badan_celana_kiper,
                        'foto_celana_kiper' => $itemJahit->foto_celana_kiper,
                    ];
                } elseif ($itemJahit->lk_celana_1_id) {
                    $laporanDataJahit['celana_1'][] = [
                        'id' => $itemJahit->id,
                        'deadline' => $itemJahit->deadline,
                        'selesai' => $itemJahit->selesai,
                        'leher_celana_1' => $itemJahit->leher_celana_1,
                        'pola_badan_celana_1' => $itemJahit->pola_badan_celana_1,
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
                        'bahan' => $itemSortir->bahan,
                        'foto' => $itemSortir->foto,
                    ];
                } elseif ($itemSortir->lk_pelatih_id) {
                    $laporanDataSortir['pelatih'][] = [
                        'id' => $itemSortir->id,
                        'deadline' => $itemSortir->deadline,
                        'selesai' => $itemSortir->selesai,
                        'no_error_pelatih' => $itemSortir->no_error_pelatih,
                        'panjang_kertas_pelatih' => $itemSortir->panjang_kertas_pelatih,
                        'berat_pelatih' => $itemSortir->berat_pelatih,
                        'bahan_pelatih' => $itemSortir->bahan_pelatih,
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
                        'bahan_kiper' => $itemSortir->bahan_kiper,
                        'foto_kiper' => $itemSortir->foto_kiper,
                    ];
                } elseif ($itemSortir->lk_1_id) {
                    $laporanDataSortir['lk_1'][] = [
                        'id' => $itemSortir->id,
                        'deadline' => $itemSortir->deadline,
                        'selesai' => $itemSortir->selesai,
                        'no_error_1' => $itemSortir->no_error_1,
                        'panjang_kertas_1' => $itemSortir->panjang_kertas_1,
                        'berat_1' => $itemSortir->berat_1,
                        'bahan_1' => $itemSortir->bahan_1,
                        'foto_1' => $itemSortir->foto_1,
                    ];
                } elseif ($itemSortir->lk_celana_player_id) {
                    $laporanDataSortir['celana_player'][] = [
                        'id' => $itemSortir->id,
                        'deadline' => $itemSortir->deadline,
                        'selesai' => $itemSortir->selesai,
                        'no_error_celana_pelayer' => $itemSortir->no_error_celana_pelayer,
                        'panjang_kertas_celana_pelayer' => $itemSortir->panjang_kertas_celana_pelayer,
                        'berat_celana_pelayer' => $itemSortir->berat_celana_pelayer,
                        'bahan_celana_pelayer' => $itemSortir->bahan_celana_pelayer,
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
                        'berat_celana_kiper' => $itemSortir->berat_celana_kiper,
                        'bahan_celana_kiper' => $itemSortir->bahan_celana_kiper,
                        'foto_celana_kiper' => $itemSortir->foto_celana_kiper,
                    ];
                } elseif ($itemSortir->lk_celana_1_id) {
                    $laporanDataSortir['celana_1'][] = [
                        'id' => $itemSortir->id,
                        'deadline' => $itemSortir->deadline,
                        'selesai' => $itemSortir->selesai,
                        'no_error_celana_1' => $itemSortir->no_error_celana_1,
                        'panjang_kertas_celana_1' => $itemSortir->panjang_kertas_celana_1,
                        'berat_celana_1' => $itemSortir->berat_celana_1,
                        'bahan_celana_1' => $itemSortir->bahan_celana_1,
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
                        'file_foto' => $itemManualCut->file_foto,
                    ];
                } elseif ($itemManualCut->lk_pelatih_id) {
                    $laporanDataManualCut['pelatih'][] = [
                        'id' => $itemManualCut->id,
                        'deadline' => $itemManualCut->deadline,
                        'selesai' => $itemManualCut->selesai,
                        'file_foto_pelatih' => $itemManualCut->file_foto_pelatih,
                    ];
                } elseif ($itemManualCut->lk_kiper_id) {
                    $laporanDataManualCut['kiper'][] = [
                        'id' => $itemManualCut->id,
                        'deadline' => $itemManualCut->deadline,
                        'selesai' => $itemManualCut->selesai,
                        'file_foto_kiper' => $itemManualCut->file_foto_kiper,
                    ];
                } elseif ($itemManualCut->lk_1_id) {
                    $laporanDataManualCut['lk_1'][] = [
                        'id' => $itemManualCut->id,
                        'deadline' => $itemManualCut->deadline,
                        'selesai' => $itemManualCut->selesai,
                        'file_foto_1' => $itemManualCut->file_foto_1,
                    ];
                } elseif ($itemManualCut->lk_celana_player_id) {
                    $laporanDataManualCut['celana_player'][] = [
                        'id' => $itemManualCut->id,
                        'deadline' => $itemManualCut->deadline,
                        'selesai' => $itemManualCut->selesai,
                        'file_foto_celana_player' => $itemManualCut->file_foto_celana_player,
                    ];
                } elseif ($itemManualCut->lk_celana_pelatih_id) {
                    $laporanDataManualCut['celana_pelatih'][] = [
                        'id' => $itemManualCut->id,
                        'deadline' => $itemManualCut->deadline,
                        'selesai' => $itemManualCut->selesai,
                        'file_foto_celana_pelatih' => $itemManualCut->file_foto_celana_pelatih,
                    ];
                } elseif ($itemManualCut->lk_celana_kiper_id) {
                    $laporanDataManualCut['celana_kiper'][] = [
                        'id' => $itemManualCut->id,
                        'deadline' => $itemManualCut->deadline,
                        'selesai' => $itemManualCut->selesai,
                        'file_foto_celana_kiper' => $itemManualCut->file_foto_celana_kiper,
                    ];
                } elseif ($itemManualCut->lk_celana_1_id) {
                    $laporanDataManualCut['celana_1'][] = [
                        'id' => $itemManualCut->id,
                        'deadline' => $itemManualCut->deadline,
                        'selesai' => $itemManualCut->selesai,
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
                        'file_foto' => $itemLaserCut->file_foto,
                    ];
                } elseif ($itemLaserCut->lk_pelatih_id) {
                    $laporanDataLaserCut['pelatih'][] = [
                        'id' => $itemLaserCut->id,
                        'deadline' => $itemLaserCut->deadline,
                        'selesai' => $itemLaserCut->selesai,
                        'file_foto_pelatih' => $itemLaserCut->file_foto_pelatih,
                    ];
                } elseif ($itemLaserCut->lk_kiper_id) {
                    $laporanDataLaserCut['kiper'][] = [
                        'id' => $itemLaserCut->id,
                        'deadline' => $itemLaserCut->deadline,
                        'selesai' => $itemLaserCut->selesai,
                        'file_foto_kiper' => $itemLaserCut->file_foto_kiper,
                    ];
                } elseif ($itemLaserCut->lk_1_id) {
                    $laporanDataLaserCut['lk_1'][] = [
                        'id' => $itemLaserCut->id,
                        'deadline' => $itemLaserCut->deadline,
                        'selesai' => $itemLaserCut->selesai,
                        'file_foto_1' => $itemLaserCut->file_foto_1,
                    ];
                } elseif ($itemLaserCut->lk_celana_player_id) {
                    $laporanDataLaserCut['celana_player'][] = [
                        'id' => $itemLaserCut->id,
                        'deadline' => $itemLaserCut->deadline,
                        'selesai' => $itemLaserCut->selesai,
                        'file_foto_celana_player' => $itemLaserCut->file_foto_celana_player,
                    ];
                } elseif ($itemLaserCut->lk_celana_pelatih_id) {
                    $laporanDataLaserCut['celana_pelatih'][] = [
                        'id' => $itemLaserCut->id,
                        'deadline' => $itemLaserCut->deadline,
                        'selesai' => $itemLaserCut->selesai,
                        'file_foto_celana_pelatih' => $itemLaserCut->file_foto_celana_pelatih,
                    ];
                } elseif ($itemLaserCut->lk_celana_kiper_id) {
                    $laporanDataLaserCut['celana_kiper'][] = [
                        'id' => $itemLaserCut->id,
                        'deadline' => $itemLaserCut->deadline,
                        'selesai' => $itemLaserCut->selesai,
                        'file_foto_celana_kiper' => $itemLaserCut->file_foto_celana_kiper,
                    ];
                } elseif ($itemLaserCut->lk_celana_1_id) {
                    $laporanDataLaserCut['celana_1'][] = [
                        'id' => $itemLaserCut->id,
                        'deadline' => $itemLaserCut->deadline,
                        'selesai' => $itemLaserCut->selesai,
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
                        'berat' => $itemPressKain->berat,
                        'gambar' => $itemPressKain->gambar,
                    ];
                } elseif ($itemPressKain->lk_pelatih_id) {
                    $laporanDataPressKain['pelatih'][] = [
                        'id' => $itemPressKain->id,
                        'deadline' => $itemPressKain->deadline,
                        'selesai' => $itemPressKain->selesai,
                        'kain_pelatih' => $itemPressKain->kain_pelatih,
                        'berat_pelatih' => $itemPressKain->berat_pelatih,
                        'gambar_pelatih' => $itemPressKain->gambar_pelatih,
                    ];
                } elseif ($itemPressKain->lk_kiper_id) {
                    $laporanDataPressKain['kiper'][] = [
                        'id' => $itemPressKain->id,
                        'deadline' => $itemPressKain->deadline,
                        'selesai' => $itemPressKain->selesai,
                        'kain_kiper' => $itemPressKain->kain_kiper,
                        'berat_kiper' => $itemPressKain->berat_kiper,
                        'gambar_kiper' => $itemPressKain->gambar_kiper,
                    ];
                } elseif ($itemPressKain->lk_1_id) {
                    $laporanDataPressKain['lk_1'][] = [
                        'id' => $itemPressKain->id,
                        'deadline' => $itemPressKain->deadline,
                        'selesai' => $itemPressKain->selesai,
                        'kain_1' => $itemPressKain->kain_1,
                        'berat_1' => $itemPressKain->berat_1,
                        'gambar_1' => $itemPressKain->gambar_1,
                    ];
                } elseif ($itemPressKain->lk_celana_player_id) {
                    $laporanDataPressKain['celana_player'][] = [
                        'id' => $itemPressKain->id,
                        'deadline' => $itemPressKain->deadline,
                        'selesai' => $itemPressKain->selesai,
                        'kain_celana_player' => $itemPressKain->kain_celana_player,
                        'berat_celana_player' => $itemPressKain->berat_celana_player,
                        'gambar_celana_player' => $itemPressKain->gambar_celana_player,
                    ];
                } elseif ($itemPressKain->lk_celana_pelatih_id) {
                    $laporanDataPressKain['celana_pelatih'][] = [
                        'id' => $itemPressKain->id,
                        'deadline' => $itemPressKain->deadline,
                        'selesai' => $itemPressKain->selesai,
                        'kain_celana_pelatih' => $itemPressKain->kain_celana_pelatih,
                        'berat_celana_pelatih' => $itemPressKain->berat_celana_pelatih,
                        'gambar_celana_pelatih' => $itemPressKain->gambar_celana_pelatih,
                    ];
                } elseif ($itemPressKain->lk_celana_kiper_id) {
                    $laporanDataPressKain['celana_kiper'][] = [
                        'id' => $itemPressKain->id,
                        'deadline' => $itemPressKain->deadline,
                        'selesai' => $itemPressKain->selesai,
                        'kain_celana_kiper' => $itemPressKain->kain_celana_kiper,
                        'berat_celana_kiper' => $itemPressKain->berat_celana_kiper,
                        'gambar_celana_kiper' => $itemPressKain->gambar_celana_kiper,
                    ];
                } elseif ($itemPressKain->lk_celana_1_id) {
                    $laporanDataPressKain['celana_1'][] = [
                        'id' => $itemPressKain->id,
                        'deadline' => $itemPressKain->deadline,
                        'selesai' => $itemPressKain->selesai,
                        'kain_celana_1' => $itemPressKain->kain_celana_1,
                        'berat_celana_1' => $itemPressKain->berat_celana_1,
                        'gambar_celana_1' => $itemPressKain->gambar_celana_1,
                    ];
                }
            }

            if ($itemMimaki) {
                // mimaki
                if ($itemMimaki->lk_player_id) {
                    $laporanDataMimaki['player'][] = [
                        'id' => $itemMimaki->id,
                        'deadline' => $itemMimaki->deadline,
                        'selesai' => $itemMimaki->selesai,
                        'file_foto' => $itemMimaki->file_foto,
                        'penanggung_jawab_id' => $itemMimaki->UserMesinAtexco->name,
                    ];
                } elseif ($itemMimaki->lk_pelatih_id) {
                    $laporanDataMimaki['pelatih'][] = [
                        'id' => $itemMimaki->id,
                        'deadline' => $itemMimaki->deadline,
                        'selesai' => $itemMimaki->selesai,
                        'file_foto_pelatih' => $itemMimaki->file_foto_pelatih,
                        'penanggung_jawab_id' => $itemMimaki->UserMesinAtexco->name,
                    ];
                } elseif ($itemMimaki->lk_kiper_id) {
                    $laporanDataMimaki['kiper'][] = [
                        'id' => $itemMimaki->id,
                        'deadline' => $itemMimaki->deadline,
                        'selesai' => $itemMimaki->selesai,
                        'file_foto_kiper' => $itemMimaki->file_foto_kiper,
                        'penanggung_jawab_id' => $itemMimaki->UserMesinAtexco->name,
                    ];
                } elseif ($itemMimaki->lk_1_id) {
                    $laporanDataMimaki['lk_1'][] = [
                        'id' => $itemMimaki->id,
                        'deadline' => $itemMimaki->deadline,
                        'selesai' => $itemMimaki->selesai,
                        'file_foto_1' => $itemMimaki->file_foto_1,
                        'penanggung_jawab_id' => $itemMimaki->UserMesinAtexco->name,
                    ];
                } elseif ($itemMimaki->lk_celana_player_id) {
                    $laporanDataMimaki['celana_player'][] = [
                        'id' => $itemMimaki->id,
                        'deadline' => $itemMimaki->deadline,
                        'selesai' => $itemMimaki->selesai,
                        'file_foto_celana_player' => $itemMimaki->file_foto_celana_player,
                        'penanggung_jawab_id' => $itemMimaki->UserMesinAtexco->name,
                    ];
                } elseif ($itemMimaki->lk_celana_pelatih_id) {
                    $laporanDataMimaki['celana_pelatih'][] = [
                        'id' => $itemMimaki->id,
                        'deadline' => $itemMimaki->deadline,
                        'selesai' => $itemMimaki->selesai,
                        'file_foto_celana_pelatih' => $itemMimaki->file_foto_celana_pelatih,
                        'penanggung_jawab_id' => $itemMimaki->UserMesinAtexco->name,
                    ];
                } elseif ($itemMimaki->lk_celana_kiper_id) {
                    $laporanDataMimaki['celana_kiper'][] = [
                        'id' => $itemMimaki->id,
                        'deadline' => $itemMimaki->deadline,
                        'selesai' => $itemMimaki->selesai,
                        'file_foto_celana_kiper' => $itemMimaki->file_foto_celana_kiper,
                        'penanggung_jawab_id' => $itemMimaki->UserMesinAtexco->name,
                    ];
                } elseif ($itemMimaki->lk_celana_1_id) {
                    $laporanDataMimaki['celana_1'][] = [
                        'id' => $itemMimaki->id,
                        'deadline' => $itemMimaki->deadline,
                        'selesai' => $itemMimaki->selesai,
                        'file_foto_celana_1' => $itemMimaki->file_foto_celana_1,
                        'penanggung_jawab_id' => $itemMimaki->UserMesinAtexco->name,
                    ];
                }
            }

            if ($itemAtexco) {
                // atexco
                if ($itemAtexco->lk_player_id) {
                    $laporanDataAtexco['player'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto' => $itemAtexco->file_foto,
                        'penanggung_jawab_id' => $itemAtexco->UserMesinAtexco->name,
                    ];
                } elseif ($itemAtexco->lk_pelatih_id) {
                    $laporanDataAtexco['pelatih'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto_pelatih' => $itemAtexco->file_foto_pelatih,
                        'penanggung_jawab_id' => $itemAtexco->UserMesinAtexco->name,
                    ];
                } elseif ($itemAtexco->lk_kiper_id) {
                    $laporanDataAtexco['kiper'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto_kiper' => $itemAtexco->file_foto_kiper,
                        'penanggung_jawab_id' => $itemAtexco->UserMesinAtexco->name,
                    ];
                } elseif ($itemAtexco->lk_1_id) {
                    $laporanDataAtexco['lk_1'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto_1' => $itemAtexco->file_foto_1,
                        'penanggung_jawab_id' => $itemAtexco->UserMesinAtexco->name,
                    ];
                } elseif ($itemAtexco->lk_celana_player_id) {
                    $laporanDataAtexco['celana_player'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto_celana_player' => $itemAtexco->file_foto_celana_player,
                        'penanggung_jawab_id' => $itemAtexco->UserMesinAtexco->name,
                    ];
                } elseif ($itemAtexco->lk_celana_pelatih_id) {
                    $laporanDataAtexco['celana_pelatih'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto_celana_pelatih' => $itemAtexco->file_foto_celana_pelatih,
                        'penanggung_jawab_id' => $itemAtexco->UserMesinAtexco->name,
                    ];
                } elseif ($itemAtexco->lk_celana_kiper_id) {
                    $laporanDataAtexco['celana_kiper'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto_celana_kiper' => $itemAtexco->file_foto_celana_kiper,
                        'penanggung_jawab_id' => $itemAtexco->UserMesinAtexco->name,
                    ];
                } elseif ($itemAtexco->lk_celana_1_id) {
                    $laporanDataAtexco['celana_1'][] = [
                        'id' => $itemAtexco->id,
                        'deadline' => $itemAtexco->deadline,
                        'selesai' => $itemAtexco->selesai,
                        'file_foto_celana_1' => $itemAtexco->file_foto_celana_1,
                        'penanggung_jawab_id' => $itemAtexco->UserMesinAtexco->name,
                    ];
                }
            }

            if ($item) {
                // layout
                if ($item->lk_player_id) {
                    $laporanData['player'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'users_layout_id' => $item->UserLayout->name,
                        'panjang_kertas_palayer' => $item->panjang_kertas_palayer,
                        'poly_player' => $item->poly_player,
                    ];
                } elseif ($item->lk_pelatih_id) {
                    $laporanData['pelatih'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'users_layout_id' => $item->UserLayout->name,
                        'panjang_kertas_pelatih' => $item->panjang_kertas_pelatih,
                        'poly_pelatih' => $item->poly_pelatih,
                    ];
                } elseif ($item->lk_kiper_id) {
                    $laporanData['kiper'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'users_layout_id' => $item->UserLayout->name,
                        'panjang_kertas_kiper' => $item->panjang_kertas_kiper,
                        'poly_kiper' => $item->poly_kiper,
                    ];
                } elseif ($item->lk_1_id) {
                    $laporanData['lk_1'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'users_layout_id' => $item->UserLayout->name,
                        'panjang_kertas_1' => $item->panjang_kertas_1,
                        'poly_1' => $item->poly_1,
                    ];
                } elseif ($item->lk_celana_player_id) {
                    $laporanData['celana_player'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'users_layout_id' => $item->UserLayout->name,
                        'panjang_kertas_celana_pelayer' => $item->panjang_kertas_celana_pelayer,
                        'poly_celana_pelayer' => $item->poly_celana_pelayer,
                    ];
                } elseif ($item->lk_celana_pelatih_id) {
                    $laporanData['celana_pelatih'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'users_layout_id' => $item->UserLayout->name,
                        'panjang_kertas_celana_pelatih' => $item->panjang_kertas_celana_pelatih,
                        'poly_celana_pelatih' => $item->poly_celana_pelatih,
                    ];
                } elseif ($item->lk_celana_kiper_id) {
                    $laporanData['celana_kiper'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'users_layout_id' => $item->UserLayout->name,
                        'panjang_kertas_celana_kiper' => $item->panjang_kertas_celana_kiper,
                        'poly_celana_kiper' => $item->poly_celana_kiper,
                    ];
                } elseif ($item->lk_celana_1_id) {
                    $laporanData['celana_1'][] = [
                        'id' => $item->id,
                        'deadline' => $item->deadline,
                        'selesai' => $item->selesai,
                        'users_layout_id' => $item->UserLayout->name,
                        'panjang_kertas_celana_1' => $item->panjang_kertas_celana_1,
                        'poly_celana_1' => $item->poly_celana_1,
                    ];
                }
            }
        }

        // return response()->json($laporanDataJahit);

        return view('component.Admin.laporan-pengerjaan.details', compact(
            'laporans',
            'laporanDataSortir',
            'laporanDataFinis',
            'laporanDataJahit',
            'laporanData',
            'laporanDataManualCut',
            'laporanDataLaserCut',
            'laporanDataAtexco',
            'laporanDataMimaki',
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
            $user = User::findOrFail($request->id[$i]);
            $user->update([
                'permission_edit' => $edit,
                'permission_hapus' => $hapus,
                'permission_create' => $create,
                'permission_show' => $show
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

        $passwordUser = PasswordUser::find($user->id);

        $passwordUser->update([
            'password_user' => $request->password_user
        ]);
        // return response()->json($passwordUser);

        $user->password = Hash::make($request->password);

        $user->save();

        return redirect()->back()->with('success', 'Permission telah diperbarui.');
    }
}
