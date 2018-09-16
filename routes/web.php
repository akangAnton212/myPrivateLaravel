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

