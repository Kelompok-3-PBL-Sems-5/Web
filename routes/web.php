<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\kompetensiController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\SertifikasiController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WelcomeController;

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

//url lalu function
// Route::get('d_pelatihan', [LandingController::class, 'd_pelatihan'])->name('landing.d_pelatihan');

Route::resource('/', LandingController::class);

Route::get('/dashboard', [WelcomeController::class, 'index']);


/* Route::get('/prodi', [ProdiController::class, 'index']);
Route::get('/prodi/list', [ProdiController::class, 'list']);  // DataTables AJAX route
Route::get('/prodi/create', [ProdiController::class, 'create']);
Route::post('/prodi', [ProdiController::class, 'store']);
Route::get('/prodi/create_ajax', [ProdiController::class, 'create_ajax']);
Route::post('/prodi/store_ajax', [ProdiController::class, 'store_ajax']);
Route::get('/prodi/{id}', [ProdiController::class, 'show']);
Route::get('/prodi/{id}/edit', [ProdiController::class, 'edit']);
Route::put('/prodi/{id}', [ProdiController::class, 'update']);
Route::put('/prodi/{id}/update_ajax', [ProdiController::class, 'update_ajax']);
Route::delete('/prodi/{id}', [ProdiController::class, 'destroy']);
Route::get('/prodi/{id}/edit_ajax', [ProdiController::class, 'edit_ajax']);
Route::delete('/prodi/{id}/delete_ajax', [ProdiController::class, 'delete_ajax']);
Route::get('/{id}/delete_ajax', [ProdiController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Ajax
Route::delete('/{id}/delete_ajax', [ProdiController::class, 'delete_ajax']); // Untuk hapus data Ajax */


Route::group(['prefix' => 'prodi'], function () {
    Route::get('/', [ProdiController::class, 'index']); // Menampilkan halaman awal kompetensi
    Route::post('/list', [ProdiController::class, 'list']); // Menampilkan data kompetensi dalam bentuk json untuk datatables
    Route::get('/create', [ProdiController::class, 'create']); // Menampilkan halaman form tambah kompetensi
    Route::post('/', [ProdiController::class, 'store']); // Menyimpan data kompetensi baru
    Route::get('/create_ajax', [ProdiController::class, 'create_ajax']); // Menampilkan halaman form tambah kompetensi Ajax
    Route::post('/ajax', [ProdiController::class, 'store_ajax']); // Menyimpan data kompetensi baru Ajax
    Route::get('/import', [ProdiController::class, 'import']); // Ajax form upload excel untuk kompetensi
    Route::post('/import_ajax', [ProdiController::class, 'import_ajax']); // Ajax import excel kompetensi
    Route::get('/export_excel', [ProdiController::class, 'export_excel']); // Export excel kompetensi
    Route::get('/export_pdf', [ProdiController::class, 'export_pdf']); // Export pdf kompetensi
    Route::get('/{id}', [ProdiController::class, 'show']); // Menampilkan detail kompetensi
    Route::get('/{id}/edit', [ProdiController::class, 'edit']); // Menampilkan halaman form edit kompetensi
    Route::put('/{id}', [ProdiController::class, 'update']); // Menyimpan perubahan data kompetensi
    Route::get('/{id}/edit_ajax', [ProdiController::class, 'edit_ajax']); // Menampilkan halaman form edit kompetensi Ajax
    Route::put('/{id}/update_ajax', [ProdiController::class, 'update_ajax']); // Menyimpan perubahan data kompetensi Ajax
    Route::get('/{id}/delete_ajax', [ProdiController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete kompetensi Ajax
    Route::delete('/{id}/delete_ajax', [ProdiController::class, 'delete_ajax']); // Untuk hapus data kompetensi Ajax
    Route::delete('/{id}', [ProdiController::class, 'destroy']); // Menghapus data kompetensi
});



Route::group(['prefix' => 'kompetensi'], function () {
    Route::get('/', [kompetensiController::class, 'index']); // Menampilkan halaman awal kompetensi
    Route::post('/list', [kompetensiController::class, 'list']); // Menampilkan data kompetensi dalam bentuk json untuk datatables
    Route::get('/create', [kompetensiController::class, 'create']); // Menampilkan halaman form tambah kompetensi
    Route::post('/', [kompetensiController::class, 'store']); // Menyimpan data kompetensi baru
    Route::get('/create_ajax', [kompetensiController::class, 'create_ajax']); // Menampilkan halaman form tambah kompetensi Ajax
    Route::post('/ajax', [kompetensiController::class, 'store_ajax']); // Menyimpan data kompetensi baru Ajax
    Route::get('/import', [kompetensiController::class, 'import']); // Ajax form upload excel untuk kompetensi
    Route::post('/import_ajax', [kompetensiController::class, 'import_ajax']); // Ajax import excel kompetensi
    Route::get('/export_excel', [kompetensiController::class, 'export_excel']); // Export excel kompetensi
    Route::get('/export_pdf', [kompetensiController::class, 'export_pdf']); // Export pdf kompetensi
    Route::get('/{id}', [kompetensiController::class, 'show']); // Menampilkan detail kompetensi
    Route::get('/{id}/edit', [kompetensiController::class, 'edit']); // Menampilkan halaman form edit kompetensi
    Route::put('/{id}', [kompetensiController::class, 'update']); // Menyimpan perubahan data kompetensi
    Route::get('/{id}/edit_ajax', [kompetensiController::class, 'edit_ajax']); // Menampilkan halaman form edit kompetensi Ajax
    Route::put('/{id}/update_ajax', [kompetensiController::class, 'update_ajax']); // Menyimpan perubahan data kompetensi Ajax
    Route::get('/{id}/delete_ajax', [kompetensiController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete kompetensi Ajax
    Route::delete('/{id}/delete_ajax', [kompetensiController::class, 'delete_ajax']); // Untuk hapus data kompetensi Ajax
    Route::delete('/{id}', [kompetensiController::class, 'destroy']); // Menghapus data kompetensi
});

Route::group(['prefix' => 'vendor'], function () {
    Route::get('/', [VendorController::class, 'index']); // Menampilkan halaman awal vendor
    Route::post('/list', [VendorController::class, 'list']); // Menampilkan data vendor dalam bentuk json untuk datatables
    Route::get('/create', [VendorController::class, 'create']); // Menampilkan halaman form tambah vendor
    Route::post('/', [VendorController::class, 'store']); // Menyimpan data vendor baru
    Route::get('/create_ajax', [VendorController::class, 'create_ajax']); // Menampilkan halaman form tambah vendor Ajax
    Route::post('/ajax', [VendorController::class, 'store_ajax']); // Menyimpan data vendor baru Ajax
    Route::get('/import', [VendorController::class, 'import']); // Ajax form upload excel untuk vendor
    Route::post('/import_ajax', [VendorController::class, 'import_ajax']); // Ajax import excel vendor
    Route::get('/export_excel', [VendorController::class, 'export_excel']); // Export excel vendor
    Route::get('/export_pdf', [VendorController::class, 'export_pdf']); // Export pdf vendor
    Route::get('/{id}', [VendorController::class, 'show']); // Menampilkan detail vendor
    Route::get('/{id}/edit', [VendorController::class, 'edit']); // Menampilkan halaman form edit vendor
    Route::put('/{id}', [VendorController::class, 'update']); // Menyimpan perubahan data vendor
    Route::get('/{id}/edit_ajax', [VendorController::class, 'edit_ajax']); // Menampilkan halaman form edit vendor Ajax
    Route::put('/{id}/update_ajax', [VendorController::class, 'update_ajax']); // Menyimpan perubahan data vendor Ajax
    Route::get('/{id}/delete_ajax', [VendorController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete vendor Ajax
    Route::delete('/{id}/delete_ajax', [VendorController::class, 'delete_ajax']); // Untuk hapus data vendor Ajax
    Route::delete('/{id}', [VendorController::class, 'destroy']); // Menghapus data vendor
});

Route::group(['prefix' => 'rekomendasi'], function () {
    Route::get('/', [RekomendasiController::class, 'index']); // Menampilkan halaman awal Rekomendasi
    Route::post('/list', [RekomendasiController::class, 'list']); // Menampilkan data Rekomendasi dalam bentuk json untuk datatables
    Route::get('/create', [RekomendasiController::class, 'create']); // Menampilkan halaman form tambah Rekomendasi
    Route::post('/', [RekomendasiController::class, 'store']); // Menyimpan data Rekomendasi baru
    Route::get('/create_ajax', [RekomendasiController::class, 'create_ajax']); // Menampilkan halaman form tambah Rekomendasi Ajax
    Route::post('/ajax', [RekomendasiController::class, 'store_ajax']); // Menyimpan data Rekomendasi baru Ajax
    Route::get('/import', [RekomendasiController::class, 'import']); // Ajax form upload excel untuk Rekomendasi
    Route::post('/import_ajax', [RekomendasiController::class, 'import_ajax']); // Ajax import excel Rekomendasi
    Route::get('/export_excel', [RekomendasiController::class, 'export_excel']); // Export excel Rekomendasi
    Route::get('/export_pdf', [RekomendasiController::class, 'export_pdf']); // Export pdf Rekomendasi
    Route::get('/{id}', [RekomendasiController::class, 'show']); // Menampilkan detail Rekomendasi
    Route::get('/{id}/edit', [RekomendasiController::class, 'edit']); // Menampilkan halaman form edit Rekomendasi
    Route::put('/{id}', [RekomendasiController::class, 'update']); // Menyimpan perubahan data Rekomendasi
    Route::get('/{id}/edit_ajax', [RekomendasiController::class, 'edit_ajax']); // Menampilkan halaman form edit Rekomendasi Ajax
    Route::put('/{id}/update_ajax', [RekomendasiController::class, 'update_ajax']); // Menyimpan perubahan data Rekomendasi Ajax
    Route::get('/{id}/delete_ajax', [RekomendasiController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Rekomendasi Ajax
    Route::delete('/{id}/delete_ajax', [RekomendasiController::class, 'delete_ajax']); // Untuk hapus data Rekomendasi Ajax
    Route::delete('/{id}', [RekomendasiController::class, 'destroy']); // Menghapus data Rekomendasi
});

Route::group(['prefix' => 'data_sertifikasi'], function () {
    Route::get('/', [SertifikasiController::class, 'index']); // Menampilkan halaman awal sertifikasi
    Route::post('/list', [SertifikasiController::class, 'list']); // Menampilkan data sertifikasi dalam bentuk json untuk datatables
    Route::get('/create', [SertifikasiController::class, 'create']); // Menampilkan halaman form tambah sertifikasi
    Route::post('/', [SertifikasiController::class, 'store']); // Menyimpan data sertifikasi baru
    Route::get('/create_ajax', [SertifikasiController::class, 'create_ajax']); // Menampilkan halaman form tambah sertifikasi Ajax
    Route::post('/ajax', [SertifikasiController::class, 'store_ajax']); // Menyimpan data sertifikasi baru Ajax
    Route::get('/import', [SertifikasiController::class, 'import']); // Ajax form upload excel untuk sertifikasi
    Route::post('/import_ajax', [SertifikasiController::class, 'import_ajax']); // Ajax import excel sertifikasi
    Route::get('/export_excel', [SertifikasiController::class, 'export_excel']); // Export excel sertifikasi
    Route::get('/export_pdf', [SertifikasiController::class, 'export_pdf']); // Export pdf sertifikasi
    Route::get('/{id}', [SertifikasiController::class, 'show']); // Menampilkan detail sertifikasi
    Route::get('/{id}/edit', [SertifikasiController::class, 'edit']); // Menampilkan halaman form edit sertifikasi
    Route::put('/{id}', [SertifikasiController::class, 'update']); // Menyimpan perubahan data sertifikasi
    Route::get('/{id}/edit_ajax', [SertifikasiController::class, 'edit_ajax']); // Menampilkan halaman form edit sertifikasi Ajax
    Route::put('/{id}/update_ajax', [SertifikasiController::class, 'update_ajax']); // Menyimpan perubahan data sertifikasi Ajax
    Route::get('/{id}/delete_ajax', [SertifikasiController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete sertifikasi Ajax
    Route::delete('/{id}/delete_ajax', [SertifikasiController::class, 'delete_ajax']); // Untuk hapus data sertifikasi Ajax
    Route::delete('/{id}', [SertifikasiController::class, 'destroy']); // Menghapus data sertifikasi
});