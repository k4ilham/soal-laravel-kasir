<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\HistoryFakturController;

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

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/history-faktur', [HistoryFakturController::class, 'index'])->name('history-faktur');
Route::get('/load-barang/{fakturId}', [HistoryFakturController::class, 'loadBarang']);
Route::get('/get-kasir/{kode_kasir}', [KasirController::class, 'getKasir']);
Route::get('/get-barang/{kode_barang}', [KasirController::class, 'getBarang']);
Route::post('/invoice/simpan', [KasirController::class, 'simpan']);
