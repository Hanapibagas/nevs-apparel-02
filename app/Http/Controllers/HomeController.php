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
use App\Models\PembagianKomisi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $userCs = User::where('roles', 'cs')->get();

        return view('component.Admin.costumer-service-admin.index', compact('userCs'));
    }

    public function getDesainer()
    {
        $userDesainer = User::where('roles', 'disainer')->get();

        return view('component.Admin.desainer-admin.index', compact('userDesainer'));
    }

    public function getLayout()
    {
        $userLaytout = User::where('roles', 'layout')->get();

        return view('component.Admin.layout-admin.index', compact('userLaytout'));
    }

    public function getMesinAtexco()
    {
        $userMesinAtexco = User::where('roles', 'atexco')->get();

        return view('component.Admin.mesin-atexco-admin.index', compact('userMesinAtexco'));
    }

    public function getMesinMimaki()
    {
        $userMimaki = User::where('roles', 'mimaki')->get();

        return view('component.Admin.mesin-mimaki-admin.index', compact('userMimaki'));
    }

    public function getPressKain()
    {
        $userPresKain = User::where('roles', 'pres_kain')->get();

        return view('component.Admin.press-kain-admin.index', compact('userPresKain'));
    }

    public function getLaserCut()
    {
        $userLaserCut = User::where('roles', 'laser_cut')->get();

        return view('component.Admin.laser-cut-admin.index', compact('userLaserCut'));
    }

    public function getManualut()
    {
        $userManuakCut = User::where('roles', 'cut')->get();

        return view('component.Admin.manual-cut-admin.index', compact('userManuakCut'));
    }

    public function getSortir()
    {
        $userSortir = User::where('roles', 'sortir')->get();

        return view('component.Admin.sortir-admin.index', compact('userSortir'));
    }

    public function getJahitBaju()
    {
        $userJahitBaju = User::where('roles', 'jahit')->get();

        return view('component.Admin.jahit-baju-admin.index', compact('userJahitBaju'));
    }

    public function getJahitCelana()
    {
        $userJahitCelana = User::where('roles', 'jahit_celana')->get();

        return view('component.Admin.jahit-celana-admin.index', compact('userJahitCelana'));
    }

    public function getPressTag()
    {
        $userPressTag = User::where('roles', 'finis')->get();

        return view('component.Admin.pres-tag-admin.index', compact('userPressTag'));
    }

    public function getPacking()
    {
        $userPacking = User::where('roles', 'packing')->get();

        return view('component.Admin.packing-admin.index', compact('userPacking'));
    }

    public function postPegawaiCs(Request $request)
    {
        $email = $request->input('email');
        if (User::where('email', $email)->exists()) {
            return redirect()->back()->with('error', 'Email Pegawai sudah ada mohon buat yang berbeda.');
        }

        User::create([
            'name' => $request->input('name'),
            'asal_kota' => $request->input('asal_kota'),
            'email' => $email,
            'roles' => $request->input('roles'),
            'password' => bcrypt('12345678')
        ]);

        return redirect()->back()->with('success', 'Data pegawai telah ditambah.');
    }

    public function postPegawaiDesainer(Request $request)
    {
        $email = $request->input('email');
        if (User::where('email', $email)->exists()) {
            return redirect()->back()->with('error', 'Email Pegawai sudah ada mohon buat yang berbeda.');
        }

        User::create([
            'name' => $request->input('name'),
            'asal_kota' => $request->input('asal_kota'),
            'email' => $email,
            'roles' => $request->input('roles'),
            'password' => bcrypt('12345678')
        ]);

        return redirect()->back()->with('success', 'Data pegawai telah ditambah.');
    }

    public function postPegawaiLayout(Request $request)
    {
        $email = $request->input('email');
        if (User::where('email', $email)->exists()) {
            return redirect()->back()->with('error', 'Email Pegawai sudah ada mohon buat yang berbeda.');
        }

        User::create([
            'name' => $request->input('name'),
            'asal_kota' => $request->input('asal_kota'),
            'email' => $email,
            'roles' => $request->input('roles'),
            'password' => bcrypt('12345678')
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
            'BarangMasukLayout.UserLayout',
            'BarangMasukMesinAtexco',
            'BarangMasukMesinMimaki',
            'BarangMasukPressKain',
            'BarangMasukLaserCut',
            'BarangMasukLaserCut.UserLaserCut',
            'BarangMasukManualcut',
            'BarangMasukSortir',
            'BarangMasukJahitBaju',
            'BarangMasukJahitCelana',
            'BarangMasukPressTag',
            'BarangMasukPacking',
        )->get();

        // return response()->json($laporans);
        return view('component.Admin.laporan-pengerjaan.index', compact('laporans'));
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
}
