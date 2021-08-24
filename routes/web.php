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

    Route::get('admin/profiling','ProfilingController@dashboard');
    Route::get('admin/profiling/load','ProfilingController@loadData');
});

