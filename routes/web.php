<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

Route::get('/', 'SiteController@home');

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authenticate']);

// ----------------------------- Route yang bisa diakses oleh Owner & Admin -------------------------------- //
Route::group(['middleware' => ['auth', 'checkRole:owner,admin']], function () {
    
    // Route Dashboard
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    // Route Data Peserta
    Route::get('peserta', 'PesertaController@index');
    Route::get('peserta/edit/{id}', 'PesertaController@edit');
    Route::put('peserta/update/{id}', 'PesertaController@update');
    Route::delete('peserta/delete/{id}', 'PesertaController@destroy');

    // Route Data Pembicara
    Route::get('pembicara', 'PembicaraController@index');
    Route::post('pembicara/store', 'PembicaraController@store');
    Route::get('pembicara/edit/{id}', 'PembicaraController@edit');
    Route::post('pembicara/update/{id}', 'PembicaraController@update');
    Route::delete('pembicara/delete/{id}', 'PembicaraController@destroy');

    // Route Data Seminar
    Route::get('seminar', 'SeminarController@index');
    Route::post('seminar/store', 'SeminarController@store');
    Route::get('seminar/edit/{id}', 'SeminarController@edit');
    Route::post('seminar/update/{id}', 'SeminarController@update');
    Route::delete('seminar/delete/{id}', 'SeminarController@destroy');
    Route::post('/seminar/remove-pembicara', 'SeminarController@removePembicara');

    // Route Konfirmasi Pembayaran
    Route::get('konfirmasi', 'KonfirmasiController@index');
    Route::get('konfirmasi/edit/{id}', 'KonfirmasiController@edit');
    Route::post('konfirmasi/update/{id}', 'KonfirmasiController@update');
    Route::get('konfirmasi/detail/{id}', 'KonfirmasiController@detailPembayaran');
    
    // Route Report Kehadiran
    Route::get('report', 'ReportController@index');

});

Route::group(['middleware' => ['auth', 'checkRole:owner']], function () {

    // Route Data User
    Route::get('user', 'UserController@index');
    Route::post('user/store', 'UserController@store');
    Route::get('user/edit/{id}', 'UserController@edit');
    Route::post('user/update/{id}', 'UserController@update');
    Route::delete('user/delete/{id}', 'UserController@destroy');
});

// ----------------------------- Route yang bisa diakses oleh semua user tanpa login -------------------------------- //

// Route Meal Attendance (User)
Route::get('peserta/create', 'PesertaController@create');
Route::post('peserta/store', 'PesertaController@store');

// Route Konfirmasi Pembayaran
Route::get('konfirmasi/upload/{id}/{kode_registrasi}', 'KonfirmasiController@uploadBukti');
Route::get('konfirmasi/getInfoPeserta/{id}', 'KonfirmasiController@getInfoPeserta');
Route::post('konfirmasi/updateBuktiPembayaran/{id}/{kode_registrasi}', 'KonfirmasiController@updateBuktiPembayaran');
