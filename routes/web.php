<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::group(['middleware' => ['web']], function () {
Route::get('/','FormController@index');
Route::post('/register','FormController@register');
Route::post('/getnumber','FormController@getNumber');

//Minipack
Route::get('/minipack','FormMinipackController@index');
Route::get('/mola','FormMinipackController@mola');
Route::get('/myih','FormMinipackController@myih');
Route::post('/register_minipack','FormMinipackController@register');
Route::post('/getnumber_minipack','FormMinipackController@getNumber');
// });
//Stb Tambahan
Route::get('/stb','StbController@index');
Route::post('/register_stb','StbController@register');
Route::post('/getnumber_stb','StbController@getNumber');

//Indihome TV
Route::get('/indihome/tv','IndihomeTvController@index');
Route::post('/register_indihometv','IndihomeTvController@register');
Route::post('/getnumber_indihometv','IndihomeTvController@getNumber');

Route::get('/redeem','RedeemController@index');
Route::post('/registrasi_redeem','RedeemController@register');
Route::post('/getnumber_redeem','RedeemController@getNumber');

Route::get('/redeem_plasa','RedeemController@index_redeem_plasa');
Route::post('/registrasi_redeem_plasa','RedeemController@register_plasa');
Route::get('/getwitel_redeem','RedeemController@getWitel');

Route::get('/profiling','ProfilingController@index');
Route::post('/register_profiling','ProfilingController@register');
Route::post('/getnumber_profiling','ProfilingController@getNumber');

Route::get('/login','LoginController@login');
Route::post('/dologin','LoginController@doLogin');
Route::get('/dologout','LoginController@doLogout');

Route::get('showuser','FormController@showuser');

Route::group(['middleware' => ['authlogin','web']],function(){
    Route::get('/dashboard','LoginController@index');

    Route::get('/obc','ObcController@index');
    Route::get('/obc/load','ObcController@loadData');
    Route::get('/obc/edit/{id}','ObcController@edit');
    Route::post('/obc/update/{id}','ObcController@update');

    Route::get('/oplang','OplangController@index');
    Route::get('/oplang/load','OplangController@loadData');
    Route::get('/oplang/edit/{id}','OplangController@edit');
    Route::post('/oplang/update/{id}','OplangController@update');

    Route::get('admin/itv','IndihomeTvController@dashboard');
    Route::get('admin/itv/load','IndihomeTvController@loadData');
    Route::post('admin/itv/update/{id}','IndihomeTvController@update');
    Route::get('admin/itv/edit/{id}','IndihomeTvController@edit');

    Route::get('admin/stb','StbController@dashboard');
    Route::get('admin/stb/load','StbController@loadData');
    Route::post('admin/stb/update/{id}','StbController@update');
    Route::get('admin/stb/edit/{id}','StbController@edit');

    Route::get('admin/redeem','RedeemController@dashboard');
    Route::get('admin/redeem/load','RedeemController@loadData');
    Route::post('admin/redeem/update/{id}','RedeemController@update');
    Route::get('admin/redeem/edit/{id}','RedeemController@edit');
    Route::get('admin/redeem/report','RedeemController@report');
    Route::get('admin/redeem/report/load','RedeemController@report_load');
    Route::get('admin/redeem/report/total','RedeemController@report_total');

    Route::get('admin/profiling','ProfilingController@dashboard');
    Route::get('admin/profiling/load','ProfilingController@loadData');

    Route::get('inv/item','InventoryController@item');
    Route::get('inv/item/load','InventoryController@loadData');
    Route::post('inv/item/insert','InventoryController@insertItem');
    Route::get('inv/item/edit/{id}','InventoryController@editItem');
    Route::post('inv/item/update/{id}','InventoryController@updateItem');
    Route::get('inv/item/delete/{id}','InventoryController@deleteItem');

    Route::get('inv/transaksi','InventoryController@transaksi');
    Route::get('inv/transaksi/load','InventoryController@loadDataTransaksi');
    Route::get('inv/transaksi/create','InventoryController@insertTransaksi');
    Route::get('inv/transaksi/delete/{id}','InventoryController@deleteTransaksi');
    Route::get('inv/transaksi/update/status/{id}','InventoryController@updateStatus');
    Route::get('inv/transaksi/detail','InventoryController@detailTransaksi');

    Route::get('inv/transaksi/detail/load','InventoryController@loadDataDetailTransaksi');
    Route::post('inv/transaksi/detail/insert','InventoryController@insertDetail');
    Route::get('inv/transaksi/detail/delete/{id}','InventoryController@deleteDetail');

    Route::get('inv/report','InventoryController@reportItem');
    Route::get('inv/report/load','InventoryController@loadDataReport');
    Route::get('inv/report/detail/{id}','InventoryController@reportItemDetail');
    Route::get('inv/report/load/detail/{id}','InventoryController@loadDataReportDetail');

    Route::get('inv/report/hvc','InventoryController@reportHvcPage');
    Route::get('inv/report/hvc/load','InventoryController@reportHvc');
    Route::get('inv/report/hvc/detail/{id}','InventoryController@reportHvcDetailPage');
    Route::get('inv/report/hvc/load/detail/{id}','InventoryController@reportHvcDetail');

    Route::get('inv/report/fetch/stok','InventoryController@getStokAkhir');

    Route::get('inv/report/plasa','InventoryController@stokPlasaPage');
    Route::get('inv/report/plasa/stok','InventoryController@stokPlasa');
    Route::get('inv/report/plasa/load/detail/{plasa}','InventoryController@stokPlasaDetailLoad');
    Route::get('inv/report/plasa/detail/{plasa}','InventoryController@stokPlasaPageDetail');
});
Route::post('kcontact/generate/do','FormController@generateKcontact');
Route::get('kcontact/generate','FormController@kcontactPage');
//CC FORM
Route::get('cc','CombatChurnController@index');
Route::get('cc/create','CombatChurnController@create');
Route::post('cc/insert','CombatChurnController@insert');
Route::get('cc/delete/{id}','CombatChurnController@destroy');
Route::get('cc/load','CombatChurnController@loadData');
Route::get('cc/search','CombatChurnController@getDataPelanggan');
Route::get('cc/chart','CombatChurnController@chart');
Route::get('cc/game','CombatChurnController@game');
Route::get('cc/load/game','CombatChurnController@loadDataGame');
Route::get('cc/game/evidence/{kelompok}','CombatChurnController@getEvidence');
