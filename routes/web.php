<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dokterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatController;


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

// Login
Route::get('/formlogin', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Register
Route::get('/formregister', [AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Menampilkan daftar obat
Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');

// Menampilkan formulir untuk membuat obat baru
Route::get('/obat/create', [ObatController::class, 'create'])->name('obat.create');

// Menyimpan obat baru ke dalam database
Route::post('/obat', [ObatController::class, 'store'])->name('obat.store');

// Menampilkan detail obat
Route::get('/obat/{obat}', [ObatController::class, 'show'])->name('obat.show');

// Menampilkan formulir untuk mengedit obat
Route::get('/obat/{obat}/edit', [ObatController::class, 'edit'])->name('obat.edit');

// Menyimpan perubahan setelah mengedit obat
Route::put('/obat/{obat}', [ObatController::class, 'update'])->name('obat.update');

// Menghapus obat dari database
Route::delete('/obat/{obat}', [ObatController::class, 'destroy'])->name('obat.destroy');

// Menampilkan periksa
Route::get('/periksa', [dokterController::class, 'index'])->name('periksa.index');
Route::get('/riwayat_pasien', [dokterController::class, 'index2'])->name('riwayat_pasien.index');


// Menampilkan riwayat pasien
// Route::get('/riwayat_pasien', function () {
//     return view('riwayat_pasien.index')->name('riwayat_pasien.index');
// });