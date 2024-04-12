@php
$isActive = request()->routeIs('getIndexCs') ||
$isActive = request()->routeIs('getIndexDesainer') ||
$isActive = request()->routeIs('getIndexLayout') ||
$isActive = request()->routeIs('getIndexMesinAtexco') ||
$isActive = request()->routeIs('getIndexMesinMimaki') ||
$isActive = request()->routeIs('getPressKain') ||
$isActive = request()->routeIs('getLaserCut') ||
$isActive = request()->routeIs('getManualut') ||
$isActive = request()->routeIs('getSortir') ||
$isActive = request()->routeIs('getJahitBaju') ||
$isActive = request()->routeIs('getJahitCelana') ||
$isActive = request()->routeIs('getPressTag') ||
$isActive = request()->routeIs('getPacking')
;
$listData = request()->routeIs('getIndexListDataJenisKerah') ||
$listData = request()->routeIs('getIndexListDataJenisLengan') ||
$listData = request()->routeIs('getIndexListDataJenisCelana');

$activeClass = $isActive ? 'open' : '';
$active = $isActive ? 'active' : '';
$activeClassList = $listData ? 'open' : '';
$activeList = $listData ? 'active' : '';
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a class="app-brand-link">
            <img style="width: 80%" src="{{ asset('assets/assets/img/LogoNevs.png') }}" alt="">
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
            <a href="{{ route('indexHome') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        @if (Auth::user()->roles == 'super_admin')
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Super Admin</span>
        </li>
        <li class="menu-item {{ request()->is('laporan')  ? 'active' : '' }}">
            <a href="{{ route('getIndexLaporan') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div data-i18n="Analytics">Laporan pengerjaan</div>
            </a>
        </li>
        <li
            class="menu-item {{ request()->is('pemabagain-komisi') || request()->is('filtering-pemabagain-komisi*')  ? 'active' : '' }}">
            <a href="{{ route('getPembagianKomisi') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div data-i18n="Analytics">Laporan pembagian komisi</div>
            </a>
        </li>
        <li class="menu-item {{ $activeClass }} {{ $active }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Account Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('costumer-service-admin')  ? 'active' : '' }}">
                    <a href="{{ route('getIndexCs') }}" class="menu-link">
                        <div data-i18n="Account">Costumer Service</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('desainer-admin')  ? 'active' : '' }}">
                    <a href="{{ route('getIndexDesainer') }}" class="menu-link">
                        <div data-i18n="Notifications">Desainer</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('layout-admin')  ? 'active' : '' }}">
                    <a href="{{ route('getIndexLayout') }}" class="menu-link">
                        <div data-i18n="Connections">Layout</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('mesin-atexco-admin')  ? 'active' : '' }}">
                    <a href="{{ route('getIndexMesinAtexco') }}" class="menu-link">
                        <div data-i18n="Connections">Mesin Atxco</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('mesin-mimaki-admin')  ? 'active' : '' }}">
                    <a href="{{ route('getIndexMesinMimaki') }}" class="menu-link">
                        <div data-i18n="Connections">Mesin Mimaki</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('press-kain-admin')  ? 'active' : '' }}">
                    <a href="{{ route('getPressKain') }}" class="menu-link">
                        <div data-i18n="Connections">Press Kain</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('manual-cut-admin')  ? 'active' : '' }}">
                    <a href="{{ route('getManualut') }}" class="menu-link">
                        <div data-i18n="Connections">Cut</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('sortir-admin')  ? 'active' : '' }}">
                    <a href="{{ route('getSortir') }}" class="menu-link">
                        <div data-i18n="Connections">Sortir</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('jahit-baju-admin')  ? 'active' : '' }}">
                    <a href="{{ route('getJahitBaju') }}" class="menu-link">
                        <div data-i18n="Connections">Jahit</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('press-tag-admin')  ? 'active' : '' }}">
                    <a href="{{ route('getPressTag') }}" class="menu-link">
                        <div data-i18n="Connections">Finish</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ $activeClassList }} {{ $activeList }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Lis Data Bahan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('list-data-jenis-kerah') ? 'active' : '' }}">
                    <a href="{{ route('getIndexListDataJenisKerah') }}" class="menu-link">
                        <div data-i18n="Account">Model</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('list-data-jenis-lengan') ? 'active' : '' }}">
                    <a href="{{ route('getIndexListDataJenisLengan') }}" class="menu-link">
                        <div data-i18n="Notifications">Produksi</div>
                    </a>
                </li>
                {{-- <li class="menu-item {{ request()->is('list-data-jenis-celana') ? 'active' : '' }}">
                    <a href="{{ route('getIndexListDataJenisCelana') }}" class="menu-link">
                        <div data-i18n="Connections">Pola celana</div>
                    </a>
                </li> --}}
            </ul>
        </li>
        @endif

        @if (Auth::user()->roles == 'cs')
        @php
        $user = Auth::user();
        $dataMasuk = App\Models\BarangMasukCostumerServices::where('tanda_telah_mengerjakan', 0)->where('cs_id',
        $user->id)->count();
        $dataLk = App\Models\BarangMasukCostumerServices::where('tanda_telah_mengerjakan', 1)->where('cs_id',
        $user->id)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Costumer Services</span>
        </li>
        <li
            class="menu-item {{ request()->is('data-order-disainer') || request()->is('data-order-disainer/LK/*') ? 'active' : '' }}">
            <a href="{{ route('getIndexOrderCsPegawai') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-shopping-bag"></i>
                <div data-i18n="Analytics">Data Order</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{ $dataMasuk
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-order') ? 'active' : '' }}">
            <a href="{{ route('getIndexCsPegawai') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div data-i18n="Analytics">Data Disainer</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-lk') || request()->is('data-lk/edit/*') ? 'active' : '' }}">
            <a href="{{ route('getIndexLkCsPegawai') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data LK</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{ $dataLk
                    }}</span>
            </a>
        </li>
        @endif

        @if (Auth::user()->roles == 'disainer')
        @php
        $user = Auth::user();
        $dataMasuk = App\Models\BarangMasukDisainer::where('tanda_telah_mengerjakan', 0)->where('users_id',
        $user->id)->count();
        $dataFix = App\Models\BarangMasukDisainer::where('tanda_telah_mengerjakan', 1)->where('users_id',
        $user->id)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Disainer</span>
        </li>
        <li
            class="menu-item {{ request()->is('disainer') || request()->is('disainer/create/*') || request()->is('disainer/create-Cs/*') ? 'active' : '' }}">
            <a href="{{ route('getIndexDisainerPegawai') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cloud-download"></i>
                <div data-i18n="Analytics">Data Masuk Disainer</div>
                <span id="dataMasuk" style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{
                    $dataMasuk }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-mesin-disainer-atexco') ? 'active' : '' }}">
            <a href="{{ route('getIndexDataMesinAtexcoPegawai') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Analytics">Data Disainer Mesin Atexco</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-mesin-disainer-mimaki') ? 'active' : '' }}">
            <a href="{{ route('getIndexDataMesinMimakiPegawai') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Analytics">Data Disainer Mesin Mimaki</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-fix-disainer') ? 'active' : '' }}">
            <a href="{{ route('getDataFixDisainerPegawai') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-check-double"></i>
                <div data-i18n="Analytics">Data Fix Disainer</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{ $dataFix
                    }}</span>
            </a>
        </li>
        @endif

        @if ( Auth::user()->roles == 'atexco')
        @php
        $user = Auth::user();
        $dataMasuktest = App\Models\BarangMasukMesin::where('status', 0)->where('nama_mesin_id', $user->id)->count();
        $dataMasuk = App\Models\MesinAtexco::where('tanda_telah_mengerjakan', 0)->count();
        $dataMasukFix = App\Models\MesinAtexco::where('tanda_telah_mengerjakan', 1)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Mesin Atexco</span>
        </li>
        <li
            class="menu-item {{ request()->is('data-masuk-mesin-atexco') || request()->is('data-masuk-mesin-atexco/*') ? 'active' : '' }}">
            <a href="{{ route('getIndexDataMasukMesinAtexco') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Analytics">Data Masuk </div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-danger">{{ $dataMasuk
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('mesin-atexco')  ? 'active' : '' }}">
            <a href="{{ route('getIndexMesinAtexcoPegawai') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Analytics">Data Tes Disainer</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-warning">{{
                    $dataMasuktest
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-masuk-mesin-atexco-fix') ? 'active' : '' }}">
            <a href="{{ route('getIndexDataMasukAtexcoFix') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Analytics">Data Masuk Fix Mesin</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{
                    $dataMasukFix
                    }}</span>
            </a>
        </li>
        @endif

        @if ( Auth::user()->roles == 'mimaki')
        @php
        $user = Auth::user();
        $dataMasuktest = App\Models\BarangMasukMesin::where('status', 0)->where('nama_mesin_id', $user->id)->count();
        $dataMasuk = App\Models\MesinMimaki::where('tanda_telah_mengerjakan', 0)->count();
        $dataMasukFix = App\Models\MesinMimaki::where('tanda_telah_mengerjakan', 1)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Mesin Mimaki</span>
        </li>
        <li
            class="menu-item {{ request()->is('data-masuk-mesin-mimaki') || request()->is('data-masuk-mesin-mimaki/*') ? 'active' : '' }}">
            <a href="{{ route('getIndexDataMasukMimaki') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Analytics">Data Masuk</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-danger">{{ $dataMasuk
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('mesin-mimaki') ? 'active' : '' }}">
            <a href="{{ route('getIndexMesinMimakiPegawai') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Analytics">Data Tes Disainer</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-warning">{{ $dataMasuktest
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-masuk-mesin-mimaki-fix') ? 'active' : '' }}">
            <a href="{{ route('getIndexDataMasukMimakiFix') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Analytics">Data Masuk Fix Mesin</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{
                    $dataMasukFix
                    }}</span>
            </a>
        </li>
        @endif

        @if ( Auth::user()->roles == 'layout')
        @php
        $user = Auth::user();
        $dataMasuk = App\Models\BarangMasukDatalayout::where('tanda_telah_mengerjakan', 0)->where('users_layout_id',
        $user->id)->count();
        $dataFix = App\Models\BarangMasukDatalayout::where('tanda_telah_mengerjakan', 1)->where('users_layout_id',
        $user->id)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Layout</span>
        </li>
        <li
            class="menu-item {{ request()->is('data-Lk-Layout') || request()->is('create-laporan-lk/*') ? 'active' : '' }}">
            <a href="{{ route('getIndexLkLayoutPegawai') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data LK</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-danger">{{ $dataMasuk
                    }}</span>
            </a>
        </li>
        <li
            class="menu-item {{ request()->is('laporan-Lk-Layout') || request()->is('show-laporan-Lk-Layout/*')  ? 'active' : '' }}">
            <a href="{{ route('getIndexLaporanLk') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Laporan data Lk</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{ $dataFix
                    }}</span>
            </a>
        </li>
        @endif

        @if ( Auth::user()->roles == 'pres_kain')
        @php
        $user = Auth::user();
        $dataMasuk = App\Models\DataPressKain::where('tanda_telah_mengerjakan', 0)->count();
        $dataMasukFix = App\Models\DataPressKain::where('tanda_telah_mengerjakan', 1)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Press Kain</span>
        </li>
        <li
            class="menu-item {{ request()->is('data-masuk-press-kain') || request()->is('data-masuk-press-kain/*') ? 'active' : '' }}">
            <a href="{{ route('getindexDataMasukPress') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Masuk</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-danger">{{ $dataMasuk
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-masuk-press-kain-fix') ? 'active' : '' }}">
            <a href="{{ route('getindexDataMasukPressFix') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Fix</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{ $dataMasukFix
                    }}</span>
            </a>
        </li>
        @endif

        @if ( Auth::user()->roles == 'cut')
        @php
        $user = Auth::user();
        $dataMasuk = App\Models\Cut::where('tanda_telah_mengerjakan', 0)->count();
        $dataMasukFix = App\Models\Cut::where('tanda_telah_mengerjakan', 1)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Cut</span>
        </li>
        <li
            class="menu-item {{ request()->is('data-masuk-cut') || request()->is('data-masuk-cut/*') ? 'active' : '' }}">
            <a href="{{ route('getindexDataMasukCut') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Masuk</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-danger">{{ $dataMasuk
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-masuk-cut-fix') ? 'active' : '' }}">
            <a href="{{ route('getindexDataMasukCutFix') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Fix</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{
                    $dataMasukFix
                    }}</span>
            </a>
        </li>
        @endif


        {{-- @if ( Auth::user()->roles == 'laser_cut')
        @php
        $user = Auth::user();
        $dataMasuk = App\Models\DataLaserCut::where('tanda_telah_mengerjakan', 0)->count();
        $dataMasukFix = App\Models\DataLaserCut::where('tanda_telah_mengerjakan', 1)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">laser Cut</span>
        </li>
        <li
            class="menu-item {{ request()->is('data-masuk-laser-cut') || request()->is('data-masuk-laser-cut/*') ? 'active' : '' }}">
            <a href="{{ route('getIndexLaserCut') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Masuk</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-danger">{{ $dataMasuk
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-masuk-laser-cut-fix') ? 'active' : '' }}">
            <a href="{{ route('getIndexFixLaserCut') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Fix</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{
                    $dataMasukFix
                    }}</span>
            </a>
        </li>
        @endif

        @if ( Auth::user()->roles == 'manual_cut')
        @php
        $user = Auth::user();
        $dataMasuk = App\Models\DataManualCut::where('tanda_telah_mengerjakan', 0)->count();
        $dataMasukFix = App\Models\DataManualCut::where('tanda_telah_mengerjakan', 1)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Manual Cut</span>
        </li>
        <li
            class="menu-item {{ request()->is('data-masuk-manual-cut') || request()->is('data-masuk-manual-cut/*') ? 'active' : '' }}">
            <a href="{{ route('getIndexManualCut') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Masuk</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-danger">{{ $dataMasuk
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-masuk-manual-cut-fix') ? 'active' : '' }}">
            <a href="{{ route('getIndexFixManualCut') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Fix</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{
                    $dataMasukFix
                    }}</span>
            </a>
        </li>
        @endif --}}

        @if ( Auth::user()->roles == 'sortir')
        @php
        $user = Auth::user();
        $dataMasuk = App\Models\DataSortir::where('tanda_telah_mengerjakan', 0)->count();
        $dataMasukFix = App\Models\DataSortir::where('tanda_telah_mengerjakan', 1)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Sortir</span>
        </li>
        <li
            class="menu-item {{ request()->is('data-masuk-manual-cut') || request()->is('data-masuk-manual-cut/*') ? 'active' : '' }}">
            <a href="{{ route('getIndexSortir') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Masuk</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-danger">{{ $dataMasuk
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-masuk-manual-cut-fix') ? 'active' : '' }}">
            <a href="{{ route('getIndexFixSortir') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Fix</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{
                    $dataMasukFix
                    }}</span>
            </a>
        </li>
        @endif


        @if ( Auth::user()->roles == 'jahit')
        @php
        $user = Auth::user();
        $dataMasuk = App\Models\Jahit::where('tanda_telah_mengerjakan', 0)->count();
        $dataMasukFix = App\Models\Jahit::where('tanda_telah_mengerjakan', 1)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Jahit</span>
        </li>
        <li
            class="menu-item {{ request()->is('data-masuk-jahit') || request()->is('data-masuk-jahit-serah/*') || request()->is('data-masuk-jahit-terima/*') ? 'active' : '' }}">
            <a href="{{ route('getIndexJahit') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Masuk</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-danger">{{ $dataMasuk
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-masuk-jahit-fix') ? 'active' : '' }}">
            <a href="{{ route('getIndexFixJahit') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Fix</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{
                    $dataMasukFix
                    }}</span>
            </a>
        </li>
        @endif

        @if ( Auth::user()->roles == 'finis')
        @php
        $user = Auth::user();
        $dataMasuk = App\Models\Finish::where('tanda_telah_mengerjakan', 0)->count();
        $dataMasukFix = App\Models\Finish::where('tanda_telah_mengerjakan', 1)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Finish</span>
        </li>
        <li
            class="menu-item {{ request()->is('data-masuk-finis') || request()->is('data-masuk-finis/*') ? 'active' : '' }}">
            <a href="{{ route('getIndexFinis') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Masuk</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-danger">{{ $dataMasuk
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-masuk-finis-fix') ? 'active' : '' }}">
            <a href="{{ route('getIndexFixFinis') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Fix</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{
                    $dataMasukFix
                    }}</span>
            </a>
        </li>
        @endif
        {{-- @if ( Auth::user()->roles == 'jahit_baju')
        @php
        $user = Auth::user();
        $dataMasuk = App\Models\DataJahitBaju::where('tanda_telah_mengerjakan', 0)->count();
        $dataMasukFix = App\Models\DataJahitBaju::where('tanda_telah_mengerjakan', 1)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Jahit baju</span>
        </li>
        <li
            class="menu-item {{ request()->is('data-masuk-jahit-baju') || request()->is('data-masuk-jahit-baju/*') ? 'active' : '' }}">
            <a href="{{ route('getIndexJahitBaju') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Masuk</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-danger">{{ $dataMasuk
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-masuk-jahit-baju-fix') ? 'active' : '' }}">
            <a href="{{ route('getIndexFixJahitBaju') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Fix</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{
                    $dataMasukFix
                    }}</span>
            </a>
        </li>
        @endif

        @if ( Auth::user()->roles == 'jahit_celana')
        @php
        $user = Auth::user();
        $dataMasuk = App\Models\DataJahitCelana::where('tanda_telah_mengerjakan', 0)->count();
        $dataMasukFix = App\Models\DataJahitCelana::where('tanda_telah_mengerjakan', 1)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Jahit Celana</span>
        </li>
        <li
            class="menu-item {{ request()->is('data-masuk-jahit-celana') || request()->is('data-masuk-jahit-celana/*') ? 'active' : '' }}">
            <a href="{{ route('getIndexJahitCelana') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Masuk</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-danger">{{ $dataMasuk
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-masuk-jahit-celana-fix') ? 'active' : '' }}">
            <a href="{{ route('getIndexFixJahitCelana') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Fix</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{
                    $dataMasukFix
                    }}</span>
            </a>
        </li>
        @endif

        @if ( Auth::user()->roles == 'press_tag')
        @php
        $user = Auth::user();
        $dataMasuk = App\Models\DataPressTagSize::where('tanda_telah_mengerjakan', 0)->count();
        $dataMasukFix = App\Models\DataPressTagSize::where('tanda_telah_mengerjakan', 1)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Press Tag</span>
        </li>
        <li
            class="menu-item {{ request()->is('data-masuk-press-tag') || request()->is('data-masuk-press-tag/*') ? 'active' : '' }}">
            <a href="{{ route('getIndexPressTag') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Masuk</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-danger">{{ $dataMasuk
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-masuk-press-tag-fix') ? 'active' : '' }}">
            <a href="{{ route('getIndexFixPressTag') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Fix</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{
                    $dataMasukFix
                    }}</span>
            </a>
        </li>
        @endif

        @if ( Auth::user()->roles == 'packing')
        @php
        $user = Auth::user();
        $dataMasuk = App\Models\DataPacking::where('tanda_telah_mengerjakan', 0)->count();
        $dataMasukFix = App\Models\DataPacking::where('tanda_telah_mengerjakan', 1)->count();
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">PACKING</span>
        </li>
        <li
            class="menu-item {{ request()->is('data-masuk-packing') || request()->is('data-masuk-packing/*') ? 'active' : '' }}">
            <a href="{{ route('getIndexPacking') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Masuk</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-danger">{{ $dataMasuk
                    }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->is('data-masuk-packing-fix') ? 'active' : '' }}">
            <a href="{{ route('getIndexFixPacking') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Data Fix</div>
                <span style="margin-left: 10px; margin-bottom: 20px;" class="badge bg-label-success">{{
                    $dataMasukFix
                    }}</span>
            </a>
        </li>
        @endif --}}
    </ul>
</aside>
