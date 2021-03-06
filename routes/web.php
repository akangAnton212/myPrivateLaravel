<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

//buat regis
Route::get('/daftar', 'ControllerRegister@index')->name('daftar');
Route::post('/daftarSimpan', 'ControllerRegister@daftarSimpan')->name('daftarSimpan');

Route::get('/', 'ControllerLogin@index')->name('login');

Route::get('/akang', 'ControllerHome@Index_get');
Route::get('/toko', 'ControllerToko@index');

//login
Route::post('/loginPost', 'ControllerLogin@postLogin')->name('postLogin');
Route::get('/signOut', 'ControllerLogin@signOut')->name('signOut');

//buat toko
Route::get('/buatToko', 'ControllerToko@buatToko')->name('MyToko');
Route::get('/cekToko', 'ControllerToko@cekToko')->name('cekToko');
Route::post('/buatTokoPost', 'ControllerToko@buatTokoPost')->name('buatToko');
//pengaturan
Route::get('/pengaturan', 'ControllerToko@pengaturanToko')->name('pengaturanToko');

//tambah barang
Route::get('/listBarang', 'ControllerBarang@index')->name('listBarang');
Route::get('/lisBarang', 'ControllerBarang@listBarang')->name('lisBarang');
Route::post('/barangPost', 'ControllerBarang@tambahBarang')->name('barangPost');
Route::post('/barangEdit', 'ControllerBarang@barangEdit')->name('barangEdit');
Route::post('/barangDetail', 'ControllerBarang@barangDetail')->name('barangDetail');
Route::post('/galery', 'ControllerBarang@galery')->name('galery');
Route::post('/hapusFoto', 'ControllerBarang@hapusFoto')->name('hapusFoto');
Route::post('/hapusBarang', 'ControllerBarang@hapusBarang')->name('hapusBarang'); 

//buat list satuan
Route::get('/listSatuan', 'ControllerBarang@satuan')->name('satuan');
Route::get('/listSatuanEdit/{id}', 'ControllerBarang@satuanEdit');

