<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dokterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;

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


Route::get('/login1', function () {
    return view('auth.login');
});

Route::get('/register1', function () {
    return view('auth.register');
});

// ~~ Auth ~~
// Login
Route::get('/formlogin', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Register
Route::get('/formregister', [AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ~~ Admin ~~
// dashboard
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin-dashboard');
// dokter
Route::get('/admin-dokter', [AdminController::class, 'dokter'])->name('admin-dokter');
Route::get('/admin-dokter/create', [AdminController::class, 'createDokter'])->name('admin-createDokter');
Route::post('/admin-dokter/store', [AdminController::class, 'storeDokter'])->name('admin-storeDokter');
Route::get('/admin-dokter/{dokter}/edit', [AdminController::class, 'editDokter'])->name('admin-editDokter');
Route::put('/admin-dokter/{dokter}', [AdminController::class, 'updateDokter'])->name('admin-updateDokter');
Route::delete('/dokter/destroy/{dokter}', [AdminController::class, 'destroyDokter'])->name('admin-destroyDokter');
// pasien
Route::get('/admin-pasien', [AdminController::class, 'pasien'])->name('admin-pasien');
Route::get('/admin-pasien/create', [AdminController::class, 'createPasien'])->name('admin-createPasien');
Route::post('/admin-pasien/store', [AdminController::class, 'storePasien'])->name('admin-storePasien');
Route::get('/admin-pasien/{pasien}/edit', [AdminController::class, 'editPasien'])->name('admin-editPasien');
Route::put('/admin-pasien/{pasien}', [AdminController::class, 'updatePasien'])->name('admin-updatePasien');
Route::delete('/pasien/destroy/{pasien}', [AdminController::class, 'destroyPasien'])->name('admin-destroyPasien');
// poliklinik
Route::get('/admin-poli', [AdminController::class, 'poli'])->name('admin-poli');
Route::get('/admin-poli/create', [AdminController::class, 'createPoli'])->name('admin-createPoli');
Route::post('/admin-poli/store', [AdminController::class, 'storePoli'])->name('admin-storePoli');
Route::get('/admin-poli/{poli}/edit', [AdminController::class, 'editPoli'])->name('admin-editPoli');
Route::put('/admin-poli/{poli}', [AdminController::class, 'updatePoli'])->name('admin-updatePoli');
Route::delete('/poli/destroy/{poli}', [AdminController::class, 'destroypoli'])->name('admin-destroyPoli');
// obat
Route::get('/admin-obat', [AdminController::class, 'obat'])->name('admin-obat');
Route::get('/admin-obat/create', [AdminController::class, 'createObat'])->name('admin-createObat');
Route::post('/admin-obat/store', [AdminController::class, 'storeObat'])->name('admin-storeObat');
Route::get('/admin-obat/{obat}/edit', [AdminController::class, 'editObat'])->name('admin-editObat');
Route::put('/admin-obat/{obat}', [AdminController::class, 'updateObat'])->name('admin-updateObat');
Route::delete('/obat/destroy/{obat}', [AdminController::class, 'destroyObat'])->name('admin-destroyObat');


// ~~ Pasien ~~
// dashboard
Route::get('/pasien', [PasienController::class, 'dashboard'])->name('pasien-dashboard');
Route::get('/pasien/poliklinik', [PasienController::class, 'poliklinik'])->name('pasien-poliklinik');
Route::post('/pasien/addDaftarPoli', [PasienController::class, 'addDaftarPoli'])->name('pasien-addDaftarPoli');
Route::get('/pasien/pilihpoli', [PasienController::class, 'pilihpoli'])->name('pasien-pilihpoli');
Route::post('/pasien/politerpilih', [PasienController::class, 'politerpilih'])->name('pasien-politerpilih');
Route::post('/pasien/pilihjadwal', [PasienController::class, 'pilihjadwal'])->name('pasien-pilihjadwal');
Route::post('/submit-daftar-poli', [PasienController::class, 'submitDaftarPoli'])->name('submit-daftar-poli');
