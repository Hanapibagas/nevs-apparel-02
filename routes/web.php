<?php

use App\Http\Controllers\Cs\CostumerServicesController;
use App\Http\Controllers\Disainer\DataMesinController;
use App\Http\Controllers\Disainer\DisainerController;
use App\Http\Controllers\Disainer\ListDataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JahitBaju\JahitBajuController;
use App\Http\Controllers\JahitCelana\JahitCelanaController;
use App\Http\Controllers\LaserCut\LaserCutController;
use App\Http\Controllers\Layout\LayoutController;
use App\Http\Controllers\ManualCut\ManualCutController;
use App\Http\Controllers\Mesin\AtexcoController;
use App\Http\Controllers\Mesin\MimakiController;
use App\Http\Controllers\Packing\PackingController;
use App\Http\Controllers\PressKain\PressKainController;
use App\Http\Controllers\Cut\CutController;
use App\Http\Controllers\Jahit\JahitController;
use App\Http\Controllers\Finis\FinisController;
use App\Http\Controllers\PressTag\PressTagController;
use App\Http\Controllers\Sortir\SortirController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/migrate-fresh-seed', function () {
    Artisan::call('migrate:freshandseed');
    return 'Database migrated fresh and seeded successfully!';
});


Route::middleware(['auth', 'checkroll:super_admin,jahit,finis,cut,disainer,layout,cs,atexco,mimaki,pres_kain,laser_cut,manual_cut,sortir,jahit_baju,jahit_celana,press_tag,packing'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('indexHome');
    Route::post('/filtering-ahit', [HomeController::class, 'fiterTotaljahit'])->name('fiterTotaljahit');

    // route admin cs
    Route::get('/laporan', [HomeController::class, 'getLaporan'])->name('getIndexLaporan');
    Route::get('/pemabagain-komisi', [HomeController::class, 'getPembagianKomisi'])->name('getPembagianKomisi');
    Route::get('/filtering-pemabagain-komisi', [HomeController::class, 'getFilterPembagianKomisi'])->name('getFilterPembagianKomisi');

    Route::get('/costumer-service-admin', [HomeController::class, 'getCostumerSevices'])->name('getIndexCs');
    Route::post('/costumer-service-admin/update', [HomeController::class, 'postUpdatePirmission'])->name('postPirmission');
    Route::post('/costumer-service-admin/createCs', [HomeController::class, 'postPegawaiCs'])->name('postCreateCs');
    Route::post('/costumer-service-admin/createDesainer', [HomeController::class, 'postPegawaiDesainer'])->name('postCreateDesainer');
    Route::post('/costumer-service-admin/createLayout', [HomeController::class, 'postPegawaiLayout'])->name('postCreateLayout');

    // route admin disainer
    Route::get('/desainer-admin', [HomeController::class, 'getDesainer'])->name('getIndexDesainer');
    Route::get('/layout-admin', [HomeController::class, 'getLayout'])->name('getIndexLayout');
    Route::get('/mesin-mimaki-admin', [HomeController::class, 'getMesinMimaki'])->name('getIndexMesinMimaki');
    Route::get('/mesin-atexco-admin', [HomeController::class, 'getMesinAtexco'])->name('getIndexMesinAtexco');
    Route::get('/press-kain-admin', [HomeController::class, 'getPressKain'])->name('getPressKain');
    Route::get('/laser-cut-admin', [HomeController::class, 'getLaserCut'])->name('getLaserCut');
    Route::get('/manual-cut-admin', [HomeController::class, 'getManualut'])->name('getManualut');
    Route::get('/sortir-admin', [HomeController::class, 'getSortir'])->name('getSortir');
    Route::get('/jahit-baju-admin', [HomeController::class, 'getJahitBaju'])->name('getJahitBaju');
    Route::get('/jahit-celana-admin', [HomeController::class, 'getJahitCelana'])->name('getJahitCelana');
    Route::get('/press-tag-admin', [HomeController::class, 'getPressTag'])->name('getPressTag');
    Route::get('/packing-admin', [HomeController::class, 'getPacking'])->name('getPacking');

    // list data
    Route::get('/list-data-jenis-kerah', [ListDataController::class, 'getIndexLisDataJenisKerah'])->name('getIndexListDataJenisKerah');
    Route::post('/list-data-jenis-kerah/create', [ListDataController::class, 'postDataJenisKerah'])->name('getCreateistDataJenisKerah');
    Route::put('/list-data-jenis-kerah/update/{id}', [ListDataController::class, 'putDataJenisKerah'])->name('putListDataJenisKerah');
    Route::delete('/list-data-jenis-kerah/delete/{id}', [ListDataController::class, 'deletJenisDatakerah'])->name('deleteListDataJenisKerah');
    //
    Route::get('/list-data-jenis-lengan', [ListDataController::class, 'getIndexLisDataJenisLengan'])->name('getIndexListDataJenisLengan');
    Route::post('/list-data-jenis-lengan/create', [ListDataController::class, 'postDataJenisLengan'])->name('getCreateistDataJenisLengan');
    Route::put('/list-data-jenis-lengan/update/{id}', [ListDataController::class, 'putDataJenisLengan'])->name('putListDataJenisLengan');
    Route::delete('/list-data-jenis-lengan/delete/{id}', [ListDataController::class, 'deletJenisDataLengan'])->name('deleteListDataJenisLengan');
    //
    Route::get('/list-data-jenis-celana', [ListDataController::class, 'getIndexLisDataJenisCelana'])->name('getIndexListDataJenisCelana');
    Route::post('/list-data-jenis-celana/create', [ListDataController::class, 'postDataJenisCelana'])->name('getCreateistDataJenisCelana');
    Route::put('/list-data-jenis-celana/update/{id}', [ListDataController::class, 'putDataJenisCelana'])->name('putListDataJenisCelana');
    Route::delete('/list-data-jenis-celana/delete/{id}', [ListDataController::class, 'deletJenisDataCelana'])->name('deleteListDataJenisCelana');
});

Route::middleware(['auth', 'checkroll:cs'])->group(function () {
    // route pegawai cs
    Route::get('/data-order-disainer', [CostumerServicesController::class, 'getIndexOrderCs'])->name('getIndexOrderCsPegawai');
    Route::get('/data-order', [CostumerServicesController::class, 'getIndexCs'])->name('getIndexCsPegawai');
    Route::get('/data-lk', [CostumerServicesController::class, 'getIndexLkCs'])->name('getIndexLkCsPegawai');
    Route::get('/data-lk/edit/{id}', [CostumerServicesController::class, 'puUpdateLK'])->name('getEditIndexLkCsPegawai');
    Route::post('costumer-service/todisainer', [CostumerServicesController::class, 'postToTimDisainer'])->name('postKeTimDisainerPegawai');
    Route::get('/data-order-disainer/LK/{id}', [CostumerServicesController::class, 'createLK'])->name('getCreateToLkPegawai');
    Route::put('/data-lk/update/{id}', [CostumerServicesController::class, 'putDataLkFix'])->name('putDataLkPegawai');
    Route::put('/data-lk/updateLK/{id}', [CostumerServicesController::class, 'putDataLk'])->name('putDataLkSajaPegawai');

    Route::get('cetak-data-lk/{id}', [CostumerServicesController::class, 'cetakDataLk'])->name('getCetakDataLk');
});

Route::middleware(['auth', 'checkroll:disainer'])->group(function () {
    // route pegawai disainer
    Route::get('/disainer', [DisainerController::class, 'getIndexUserDisainer'])->name('getIndexDisainerPegawai');
    Route::get('/disainer/create/{nama_tim}', [DisainerController::class, 'getCreateToTeamMesin'])->name('getCreateToTeamMesinPegawai');
    Route::get('/disainer/update/{id}', [DisainerController::class, 'getUpdateToTeamMesin'])->name('getUpdateToTeamMesin');
    Route::put('/disainer/update-data-mesin/{id}', [DisainerController::class, 'putUpdateToTeamMesin'])->name('putUpdateToTeamMesin');
    Route::get('/disainer/create-Cs/{nama_tim}', [DisainerController::class, 'getCreateToTeamCs'])->name('getCreateToTeamCsPegawai');
    Route::post('/disainer/post-tim-mesin/{nama_tim}', [DisainerController::class, 'postToTeamMesin'])->name('postToTeamMesinPegawai');
    Route::post('/disainer/post-Cs/{nama_tim}', [DisainerController::class, 'postToCustomerServices'])->name('postToCsPegawai');
    Route::get('/data-fix-disainer', [DisainerController::class, 'getDataFixDisainer'])->name('getDataFixDisainerPegawai');

    // data mesin
    Route::get('/data-mesin-disainer-atexco', [DataMesinController::class, 'getDataMesinAtexco'])->name('getIndexDataMesinAtexcoPegawai');
    Route::get('/data-mesin-disainer-mimaki', [DataMesinController::class, 'getDataMesinMimaki'])->name('getIndexDataMesinMimakiPegawai');
});

Route::middleware(['auth', 'checkroll:atexco'])->group(function () {
    Route::get('/mesin-atexco', [AtexcoController::class, 'getIndexAtexco'])->name('getIndexMesinAtexcoPegawai');
    Route::get('/data-masuk-mesin-atexco', [AtexcoController::class, 'getIndexDataMasukAtexco'])->name('getIndexDataMasukMesinAtexco');
    Route::get('/data-masuk-mesin-atexco/{id}', [AtexcoController::class, 'getInputLaporan'])->name('getInputLaporanAtxco');
    Route::put('/data-masuk-mesin-atexco/{id}', [AtexcoController::class, 'putLaporanMesin'])->name('putLaporanMesinAtexco');
    Route::get('/data-masuk-mesin-atexco-fix', [AtexcoController::class, 'getIndexDataMasukAtexcoFix'])->name('getIndexDataMasukAtexcoFix');
    Route::get('/show-data-lk-atexco/{id}', [AtexcoController::class, 'cetakDataLk'])->name('getCetakDataLkAtxco');

    Route::put('/mesin-atxco/{id}', [AtexcoController::class, 'putFeedBackToDisainer'])->name('putFeedbackByAtexcoPegawai');
});

Route::middleware(['auth', 'checkroll:mimaki'])->group(function () {
    Route::get('/mesin-mimaki', [MimakiController::class, 'getIndexMimaki'])->name('getIndexMesinMimakiPegawai');
    Route::get('/data-masuk-mesin-mimaki', [MimakiController::class, 'getIndexDataMasukMimaki'])->name('getIndexDataMasukMimaki');
    Route::get('/data-masuk-mesin-mimaki/{id}', [MimakiController::class, 'getInputLaporan'])->name('getInputLaporanMimaki');
    Route::put('/data-masuk-mesin-mimaki/{id}', [MimakiController::class, 'putLaporanMesin'])->name('putLaporanMesin');
    Route::get('/data-masuk-mesin-mimaki-fix', [MimakiController::class, 'getIndexDataMasukMimakiFix'])->name('getIndexDataMasukMimakiFix');
    Route::get('/show-data-lk-mimaki/{id}', [MimakiController::class, 'cetakDataLk'])->name('getCetakDataLkMimaki');

    Route::put('/mesin-mimaki/{id}', [MimakiController::class, 'putFeedBackToDisainer'])->name('putFeedbackByMimakiPegawai');
});

Route::middleware(['auth', 'checkroll:layout'])->group(function () {
    Route::get('/data-Lk-Layout', [LayoutController::class, 'getIndexLkCs'])->name('getIndexLkLayoutPegawai');
    Route::get('/create-laporan-lk/{id}', [LayoutController::class, 'createLaporanLk'])->name('getCreateLaporanLkLayout');

    Route::get('/laporan-Lk-Layout', [LayoutController::class, 'getIndexLaporanLk'])->name('getIndexLaporanLk');
    Route::put('/kirim-laporan-lk/{id}', [LayoutController::class, 'putLaporanLs'])->name('putLaporanLs');
    Route::get('cetak-data-lk-fix/{id}', [LayoutController::class, 'cetakDataLk'])->name('getCetakDataLkLayout');
});

Route::middleware(['auth', 'checkroll:pres_kain'])->group(function () {
    Route::get('/data-masuk-press-kain', [PressKainController::class, 'getindexDataMasukPress'])->name('getindexDataMasukPress');
    Route::get('/data-masuk-press-kain/{id}', [PressKainController::class, 'getInputLaporan'])->name('getInputLaporanPresKain');
    Route::put('/data-masuk-press-kain/{id}', [PressKainController::class, 'putLaporan'])->name('putLaporanPreskain');
    Route::get('/data-masuk-press-kain-fix', [PressKainController::class, 'getindexDataMasukPressFix'])->name('getindexDataMasukPressFix');
    Route::get('/show-data-lk-presskain/{id}', [PressKainController::class, 'cetakDataLk'])->name('getCetakDataLkPressKain');
});

Route::middleware(['auth', 'checkroll:cut'])->group(function () {
    Route::get('/data-masuk-cut', [CutController::class, 'getindexDataMasukPress'])->name('getindexDataMasukCut');
    Route::get('/data-masuk-cut/{id}', [CutController::class, 'getInputLaporan'])->name('getInputLaporanCut');
    Route::put('/data-masuk-cut/{id}', [CutController::class, 'putLaporan'])->name('putLaporanCut');
    Route::get('/data-masuk-cut-fix', [CutController::class, 'getindexDataMasukPressFix'])->name('getindexDataMasukCutFix');
    Route::get('/show-data-lk-cut/{id}', [CutController::class, 'cetakDataLk'])->name('getCetakDataLkCut');
});

Route::middleware(['auth', 'checkroll:laser_cut'])->group(function () {
    Route::get('/data-masuk-laser-cut', [LaserCutController::class, 'getIndex'])->name('getIndexLaserCut');
    Route::get('/data-masuk-laser-cut/{id}', [LaserCutController::class, 'getInputLaporan'])->name('getInputLaporanLaserCut');
    Route::put('/data-masuk-laser-cut/{id}', [LaserCutController::class, 'putLaporan'])->name('putLaporanLaserCut');
    Route::get('/data-masuk-laser-cut-fix', [LaserCutController::class, 'getIndexFix'])->name('getIndexFixLaserCut');
});

Route::middleware(['auth', 'checkroll:manual_cut'])->group(function () {
    Route::get('/data-masuk-manual-cut', [ManualCutController::class, 'getIndex'])->name('getIndexManualCut');
    Route::get('/data-masuk-manual-cut/{id}', [ManualCutController::class, 'getInputLaporan'])->name('getInputLaporanManualCut');
    Route::put('/data-masuk-manual-cut/{id}', [ManualCutController::class, 'putLaporan'])->name('putLaporanManualCut');
    Route::get('/data-masuk-manual-cut-fix', [ManualCutController::class, 'getIndexFix'])->name('getIndexFixManualCut');
});

Route::middleware(['auth', 'checkroll:sortir'])->group(function () {
    Route::get('/data-masuk-sortir', [SortirController::class, 'getIndex'])->name('getIndexSortir');
    Route::get('/data-masuk-sortir/{id}', [SortirController::class, 'getInputLaporan'])->name('getInputLaporanSortir');
    Route::put('/data-masuk-sortir/{id}', [SortirController::class, 'putLaporan'])->name('putLaporanSortir');
    Route::get('/data-masuk-sortir-fix', [SortirController::class, 'getIndexFix'])->name('getIndexFixSortir');
    Route::get('/show-data-lk-sortir/{id}', [SortirController::class, 'cetakDataLk'])->name('getCetakDataLkSortir');
});

Route::middleware(['auth', 'checkroll:jahit'])->group(function () {
    Route::get('/data-masuk-jahit', [JahitController::class, 'getIndex'])->name('getIndexJahit');
    Route::get('/data-masuk-jahit-serah/{id}', [JahitController::class, 'getInputLaporan'])->name('getInputLaporanJahit');
    Route::get('/data-masuk-jahit-terima/{id}', [JahitController::class, 'getInputLaporanSerah'])->name('getInputLaporanJahitTerima');
    Route::put('/data-masuk-jahit/{id}', [JahitController::class, 'putLaporan'])->name('putLaporanJahit');
    Route::put('/data-masuk-jahit-terima/{id}', [JahitController::class, 'putLaporanSerahTerima'])->name('putLaporanJahitTerima');
    Route::get('/data-masuk-jahit-fix', [JahitController::class, 'getIndexFix'])->name('getIndexFixJahit');
    Route::get('/show-data-lk-jahit/{id}', [JahitController::class, 'cetakDataLk'])->name('getCetakDataLkJahit');
});

Route::middleware(['auth', 'checkroll:finis'])->group(function () {
    Route::get('/data-masuk-finis', [FinisController::class, 'getIndex'])->name('getIndexFinis');
    Route::get('/data-masuk-finis/{id}', [FinisController::class, 'getInputLaporan'])->name('getInputLaporanFinis');
    Route::put('/data-masuk-finis/{id}', [FinisController::class, 'putLaporan'])->name('putLaporanFinis');
    Route::get('/data-masuk-finis-fix', [FinisController::class, 'getIndexFix'])->name('getIndexFixFinis');
    Route::get('/show-data-lk-finis/{id}', [FinisController::class, 'cetakDataLk'])->name('getCetakDataLkFinis');
});

Route::middleware(['auth', 'checkroll:jahit_baju'])->group(function () {
    Route::get('/data-masuk-jahit-baju', [JahitBajuController::class, 'getIndex'])->name('getIndexJahitBaju');
    Route::get('/data-masuk-jahit-baju/{id}', [JahitBajuController::class, 'getInputLaporan'])->name('getInputLaporanJahitBaju');
    Route::put('/data-masuk-jahit-baju/{id}', [JahitBajuController::class, 'putLaporan'])->name('putLaporanJahitBaju');
    Route::get('/data-masuk-jahit-baju-fix', [JahitBajuController::class, 'getIndexFix'])->name('getIndexFixJahitBaju');
});

Route::middleware(['auth', 'checkroll:jahit_celana'])->group(function () {
    Route::get('/data-masuk-jahit-celana', [JahitCelanaController::class, 'getIndex'])->name('getIndexJahitCelana');
    Route::get('/data-masuk-jahit-celana/{id}', [JahitCelanaController::class, 'getInputLaporan'])->name('getInputLaporanJahitCelana');
    Route::put('/data-masuk-jahit-celana/{id}', [JahitCelanaController::class, 'putLaporan'])->name('putLaporanJahitCelana');
    Route::get('/data-masuk-jahit-celana-fix', [JahitCelanaController::class, 'getIndexFix'])->name('getIndexFixJahitCelana');
});

Route::middleware(['auth', 'checkroll:press_tag'])->group(function () {
    Route::get('/data-masuk-press-tag', [PressTagController::class, 'getIndex'])->name('getIndexPressTag');
    Route::get('/data-masuk-press-tag/{id}', [PressTagController::class, 'getInputLaporan'])->name('getInputLaporanPressTag');
    Route::put('/data-masuk-press-tag/{id}', [PressTagController::class, 'putLaporan'])->name('putLaporanPressTag');
    Route::get('/data-masuk-press-tag-fix', [PressTagController::class, 'getIndexFix'])->name('getIndexFixPressTag');
});

Route::middleware(['auth', 'checkroll:packing'])->group(function () {
    Route::get('/data-masuk-packing', [PackingController::class, 'getIndex'])->name('getIndexPacking');
    Route::get('/data-masuk-packing/{id}', [PackingController::class, 'getInputLaporan'])->name('getInputLaporanPacking');
    Route::put('/data-masuk-packing/{id}', [PackingController::class, 'putLaporan'])->name('putLaporanPacking');
    Route::get('/data-masuk-packing-fix', [PackingController::class, 'getIndexFix'])->name('getIndexFixPacking');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
