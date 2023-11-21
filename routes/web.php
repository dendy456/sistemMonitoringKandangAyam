<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManajemenController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SVMController;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\Chart;
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


Route::get('/main', function () {
    return view('main');
});
Route::get('/home', [HomeController::class, 'index']);
Route::get('/', function () {
    return view('auth.login');
});
Route::resource('user', UserController::class);
Route::resource('manajemen', ManajemenController::class);
Route::get('manajemen/{id}/panen', [ManajemenController::class, 'panen']);


Route::get('klasifikasi',[KlasifikasiController::class, 'index']);

Route::get('cekSuhu', [KlasifikasiController::class, 'ceksuhu'])->name('cekSuhu');
Route::get('cekKelembaban', [KlasifikasiController::class, 'cekkelembaban'])->name('cekKelembaban');

Route::get('cekAmmonia', [KlasifikasiController::class, 'cekammonia'])->name('cekAmmonia');
Route::get('cekKelas', [KlasifikasiController::class, 'cekkelas'])->name('cekKelas');
Route::get('cekGrafik', [KlasifikasiController::class, 'cekgrafik'])->name('cekGrafik');

Auth::routes();

Route::get('login',[LoginController::class, 'login'])->name('login');
Route::post('do-login',[LoginController::class, 'doLogin']);
Route::get('logout',[LoginController::class, 'logout']);

Route::get('monitoring', [ChartController::class ,'index']);
Route::delete('monitoring/destroy/{id}', [ChartController::class ,'destroy']);

Route::get('Search', [ChartController::class ,'search'])->name('Search');
Route::get('Sorting', [ChartController::class ,'sorting'])->name('Sorting');

Route::get('/testing', [ChartController::class ,'testing']);
Route::post('/testing', [ChartController::class ,'testing'])->name('testing');


Route::get('/download/{searchCriteria}', [ChartController::class ,'downloadExcel'])->name('download');



