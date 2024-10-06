<?php

use App\Http\Controllers\Admin\AdminGuruController;
use App\Http\Controllers\Admin\AdminJenisPelanggaranController;
use App\Http\Controllers\Admin\AdminJurusanController;
use App\Http\Controllers\Admin\AdminKelasController;
use App\Http\Controllers\Admin\AdminLevelController;
use App\Http\Controllers\Admin\AdminNamaPelanggaranController;
use App\Http\Controllers\Admin\AdminPelanggaranController;
use App\Http\Controllers\Admin\AdminSiswaController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ForgotPassword\ForgotPasswordController;
use App\Http\Controllers\Guru\GuruBiodataController;
use App\Http\Controllers\Guru\GuruPelanggaranController;
use App\Http\Controllers\Kepala\KepalaPelanggaranController;
use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\RecoverPassword\RecoverPasswordController;
use App\Http\Controllers\Registrasi\RegistrasiController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\Siswa\SiswaPelanggaranController;
use App\Http\Controllers\Waka\WakaJenisPelanggaranController;
use App\Http\Controllers\Waka\WakaNamaPelanggaranController;
use App\Http\Controllers\Waka\WakaPelanggaranController;
use App\Http\Middleware\CekLevel;
use Illuminate\Support\Facades\Route;

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

//  Landing
Route::get('/', [LandingController::class, 'index']);

//  Login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login-action', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::get('/login-logout', [LoginController::class, 'logout'])->name('login.logout');

// Registrasi
Route::get('/registrasi', [RegistrasiController::class, 'index']);
Route::post('/jquery-registrasisiswa', [RegistrasiController::class, 'jqueryRegistrasiSiswa']);
Route::post('/registrasi-action', [RegistrasiController::class, 'store'])->name('registrasi.store');

// Forgot Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot-password.index');
Route::post('/forgot-password/store', [ForgotPasswordController::class, 'store'])->name('forgot-password.store');

// Recorver Password
Route::get('/recover-password', [RecoverPasswordController::class, 'index'])->name('recover-password.index')->middleware('auth');
Route::post('/recover-password/store', [RecoverPasswordController::class, 'store'])->name('recover-password.store');

Route::group(['middleware' => ['auth', 'verified']], function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Siswa
    Route::get('/edit-biodata/siswa/{id}', [DashboardController::class, 'editbiodatasiswa'])->name('edit-biodatasiswa.editbiodatasiswa');
    Route::post('/siswa-kelas/jquerySiswaKelas', [DashboardController::class, 'jquerySiswaKelas'])->name('siswa-kelas.jquerySiswaKelas');
    Route::post('/edit-biodata/updatesiswa/{id}', [DashboardController::class, 'updatesiswa'])->name('edit-biodataguru.updatesiswa');

    // Setting
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting/updateprofile', [SettingController::class, 'updateprofile'])->name('setting.updateprofile');
    Route::post('/setting/updateemail', [SettingController::class, 'updateemail'])->name('setting.updateemail');
    Route::post('/setting/updatepassword', [SettingController::class, 'updatepassword'])->name('setting.updatepassword');
    Route::post('/setting/updategambar', [SettingController::class, 'updategambar'])->name('setting.updategambar');
    Route::post('/setting/hapusgambar', [SettingController::class, 'hapusgambar'])->name('setting.hapusgambar');

    // Admin
    Route::group(['middleware' => [CekLevel::class . ':1']], function () {

        // Pelanggaran
        Route::get('/data-pelanggaran', [AdminPelanggaranController::class, 'index'])->name('data-pelanggaran.index');
        Route::get('/data-pelanggaran/create', [AdminPelanggaranController::class, 'create'])->name('data-pelanggaran.create');
        Route::get('/data-pelanggaran/edit/{id}', [AdminPelanggaranController::class, 'edit'])->name('data-pelanggaran.edit');
        Route::post('/data-pelanggaran/store', [AdminPelanggaranController::class, 'store'])->name('data-pelanggaran.store');
        Route::post('/data-pelanggaran/update/{id}', [AdminPelanggaranController::class, 'update'])->name('data-pelanggaran.update');
        Route::post('/data-pelanggaran/destroy/{id}', [AdminPelanggaranController::class, 'destroy'])->name('data-pelanggaran.destroy');
        Route::post('/data-pelanggaran/jqueryNamaPelanggaran', [AdminPelanggaranController::class, 'jqueryNamaPelanggaran']);

        // Nama Pelanggaran
        Route::get('/data-namapelanggaran', [AdminNamaPelanggaranController::class, 'index'])->name('data-namapelanggaran.index');
        Route::get('/data-namapelanggaran/create', [AdminNamaPelanggaranController::class, 'create'])->name('data-namapelanggaran.create');
        Route::get('/data-namapelanggaran/edit/{id}', [AdminNamaPelanggaranController::class, 'edit'])->name('data-namapelanggaran.edit');
        Route::post('/data-namapelanggaran/store', [AdminNamaPelanggaranController::class, 'store'])->name('data-namapelanggaran.store');
        Route::post('/data-namapelanggaran/update/{id}', [AdminNamaPelanggaranController::class, 'update'])->name('data-namapelanggaran.update');
        Route::post('/data-namapelanggaran/destroy/{id}', [AdminNamaPelanggaranController::class, 'destroy'])->name('data-namapelanggaran.destroy');

        // Jenis Pelanggaran
        Route::get('/data-jenispelanggaran', [AdminJenisPelanggaranController::class, 'index'])->name('data-jenispelanggaran.index');
        Route::get('/data-jenispelanggaran/create', [AdminJenisPelanggaranController::class, 'create'])->name('data-jenispelanggaran.create');
        Route::get('/data-jenispelanggaran/edit/{id}', [AdminJenisPelanggaranController::class, 'edit'])->name('data-jenispelanggaran.edit');
        Route::post('/data-jenispelanggaran/store', [AdminJenisPelanggaranController::class, 'store'])->name('data-jenispelanggaran.store');
        Route::post('/data-jenispelanggaran/update/{id}', [AdminJenisPelanggaranController::class, 'update'])->name('data-jenispelanggaran.update');
        Route::post('/data-jenispelanggaran/destroy/{id}', [AdminJenisPelanggaranController::class, 'destroy'])->name('data-jenispelanggaran.destroy');

        // Siswa
        Route::get('/data-siswa', [AdminSiswaController::class, 'index'])->name('data-siswa.index');
        Route::get('/data-siswa/create', [AdminSiswaController::class, 'create'])->name('data-siswa.create');
        Route::get('/data-siswa/edit/{id}', [AdminSiswaController::class, 'edit'])->name('data-siswa.edit');
        Route::post('/data-siswa/store', [AdminSiswaController::class, 'store'])->name('data-siswa.store');
        Route::post('/data-siswa/update/{id}', [AdminSiswaController::class, 'update'])->name('data-siswa.update');
        Route::post('/data-siswa/destroy/{id}', [AdminSiswaController::class, 'destroy'])->name('data-siswa.destroy');
        Route::post('/data-siswa/jquerySiswaKelas', [AdminSiswaController::class, 'jquerySiswaKelas'])->name('data-siswa.jquerySiswaKelas');

        // Data Guru
        Route::get('/data-guru', [AdminGuruController::class, 'index'])->name('data-guru.index');
        Route::get('/data-guru/create', [AdminGuruController::class, 'create'])->name('data-guru.create');
        Route::get('/data-guru/edit/{id}', [AdminGuruController::class, 'edit'])->name('data-guru.edit');
        Route::post('/data-guru/store', [AdminGuruController::class, 'store'])->name('data-guru.store');
        Route::post('/data-guru/update/{id}', [AdminGuruController::class, 'update'])->name('data-guru.update');
        Route::post('/data-guru/destroy/{id}', [AdminGuruController::class, 'destroy'])->name('data-guru.destroy');

        // Kelas
        Route::get('/data-kelas', [AdminKelasController::class, 'index'])->name('data-kelas.index');
        Route::get('/data-kelas/create', [AdminKelasController::class, 'create'])->name('data-kelas.create');
        Route::get('/data-kelas/edit/{id}', [AdminKelasController::class, 'edit'])->name('data-kelas.edit');
        Route::post('/data-kelas/store', [AdminKelasController::class, 'store'])->name('data-kelas.store');
        Route::post('/data-kelas/update/{id}', [AdminKelasController::class, 'update'])->name('data-kelas.update');
        Route::post('/data-kelas/destroy/{id}', [AdminKelasController::class, 'destroy'])->name('data-kelas.destroy');

        // Level
        Route::get('/data-level', [AdminLevelController::class, 'index'])->name('data-level.index');
        Route::get('/data-level/create', [AdminLevelController::class, 'create'])->name('data-level.create');
        Route::get('/data-level/edit/{id}', [AdminLevelController::class, 'edit'])->name('data-level.edit');
        Route::post('/data-level/store', [AdminLevelController::class, 'store'])->name('data-level.store');
        Route::post('/data-level/update/{id}', [AdminLevelController::class, 'update'])->name('data-level.update');
        Route::post('/data-level/destroy/{id}', [AdminLevelController::class, 'destroy'])->name('data-level.destroy');

        // Data Jurusan
        Route::get('/data-jurusan', [AdminJurusanController::class, 'index'])->name('data-jurusan.index');
        Route::get('/data-jurusan/create', [AdminJurusanController::class, 'create'])->name('data-jurusan.create');
        Route::get('/data-jurusan/edit/{id}', [AdminJurusanController::class, 'edit'])->name('data-jurusan.edit');
        Route::post('/data-jurusan/store', [AdminJurusanController::class, 'store'])->name('data-jurusan.store');
        Route::post('/data-jurusan/update/{id}', [AdminJurusanController::class, 'update'])->name('data-jurusan.update');
        Route::post('/data-jurusan/destroy/{id}', [AdminJurusanController::class, 'destroy'])->name('data-jurusan.destroy');

        // User Registrasi
        Route::get('/user-registrasi', [AdminUserController::class, 'index'])->name('data-user.index');
        Route::get('/user-registrasi/create', [AdminUserController::class, 'create'])->name('data-user.create');
        Route::get('/user-registrasi/edit/{id}', [AdminUserController::class, 'edit'])->name('data-user.edit');
        Route::post('/user-registrasi/store', [AdminUserController::class, 'store'])->name('data-user.store');
        Route::post('/user-registrasi/update/{id}', [AdminUserController::class, 'update'])->name('data-user.update');
        Route::post('/user-registrasi/destroy/{id}', [AdminUserController::class, 'destroy'])->name('data-user.destroy');
    });

    // Guru
    Route::group(['middleware' => [CekLevel::class . ':2']], function () {
        Route::get('/siswa-pelanggaran', [SiswaPelanggaranController::class, 'index'])->name('siswa-pelanggaran.index');
    });

    // Guru
    Route::group(['middleware' => [CekLevel::class . ':3']], function () {

        // Biodata
        Route::get('/biodata-guru', [GuruBiodataController::class, 'index'])->name('biodata-guru.index');
        Route::get('/biodata-guru/edit/{id}', [GuruBiodataController::class, 'edit'])->name('biodata-guru.edit');
        Route::post('/biodata-guru/update/{id}', [GuruBiodataController::class, 'update'])->name('biodata-guru.update');

        // Pelanggaran
        Route::get('/guru-pelanggaran', [GuruPelanggaranController::class, 'index'])->name('guru-pelanggaran.index');
        Route::get('/guru-pelanggaran/generateexcel', [GuruPelanggaranController::class, 'generateexcel'])->name('guru-pelanggaran.generateexcel');
        Route::get('/guru-pelanggaran/create', [GuruPelanggaranController::class, 'create'])->name('guru-pelanggaran.create');
        Route::get('/guru-pelanggaran/edit/{id}', [GuruPelanggaranController::class, 'edit'])->name('guru-pelanggaran.edit');
        Route::post('/guru-pelanggaran/store', [GuruPelanggaranController::class, 'store'])->name('guru-pelanggaran.store');
        Route::post('/guru-pelanggaran/update/{id}', [GuruPelanggaranController::class, 'update'])->name('guru-pelanggaran.update');
        Route::post('/guru-pelanggaran/destroy/{id}', [GuruPelanggaranController::class, 'destroy'])->name('guru-pelanggaran.destroy');
        Route::post('/guru-pelanggaran/jqueryNamaPelanggaran', [GuruPelanggaranController::class, 'jqueryNamaPelanggaran']);
        Route::post('/guru-pelanggaran/jquerySiswaKelas', [GuruPelanggaranController::class, 'jquerySiswaKelas'])->name('guru-pelanggaran.jquerySiswaKelas');
    });

    // Waka
    Route::group(['middleware' => [CekLevel::class . ':4']], function () {

        // Nama Pelanggaran
        Route::get('/waka-namapelanggaran', [WakaNamaPelanggaranController::class, 'index'])->name('waka-namapelanggaran.index');
        Route::get('/waka-namapelanggaran/create', [WakaNamaPelanggaranController::class, 'create'])->name('waka-namapelanggaran.create');
        Route::get('/waka-namapelanggaran/edit/{id}', [WakaNamaPelanggaranController::class, 'edit'])->name('waka-namapelanggaran.edit');
        Route::post('/waka-namapelanggaran/store', [WakaNamaPelanggaranController::class, 'store'])->name('waka-namapelanggaran.store');
        Route::post('/waka-namapelanggaran/update/{id}', [WakaNamaPelanggaranController::class, 'update'])->name('waka-namapelanggaran.update');
        Route::post('/waka-namapelanggaran/destroy/{id}', [WakaNamaPelanggaranController::class, 'destroy'])->name('waka-namapelanggaran.destroy');

        // Jenis Pelanggaran
        Route::get('/waka-jenispelanggaran', [WakaJenisPelanggaranController::class, 'index'])->name('waka-jenispelanggaran.index');
        Route::get('/waka-jenispelanggaran/create', [WakaJenisPelanggaranController::class, 'create'])->name('waka-jenispelanggaran.create');
        Route::get('/waka-jenispelanggaran/edit/{id}', [WakaJenisPelanggaranController::class, 'edit'])->name('waka-jenispelanggaran.edit');
        Route::post('/waka-jenispelanggaran/store', [WakaJenisPelanggaranController::class, 'store'])->name('waka-jenispelanggaran.store');
        Route::post('/waka-jenispelanggaran/update/{id}', [WakaJenisPelanggaranController::class, 'update'])->name('waka-jenispelanggaran.update');
        Route::post('/waka-jenispelanggaran/destroy/{id}', [WakaJenisPelanggaranController::class, 'destroy'])->name('waka-jenispelanggaran.destroy');

        // Pelanggaran
        Route::get('/waka-pelanggaran', [WakaPelanggaranController::class, 'index'])->name('waka-pelanggaran.index');
        Route::get('/waka-pelanggaran/generateexcel', [WakaPelanggaranController::class, 'generateexcel'])->name('waka-pelanggaran.generateexcel');
        Route::post('/waka-pelanggaran/jqueryNamaPelanggaran', [WakaPelanggaranController::class, 'jqueryNamaPelanggaran']);
        Route::post('/waka-pelanggaran/jquerySiswaKelas', [WakaPelanggaranController::class, 'jquerySiswaKelas'])->name('waka-pelanggaran.jquerySiswaKelas');
    });

    // Kepala
    Route::group(['middleware' => [CekLevel::class . ':5']], function () {
        // Pelanggaran
        Route::get('/kepala-pelanggaran', [KepalaPelanggaranController::class, 'index'])->name('kepala-pelanggaran.index');
        Route::get('/kepala-pelanggaran/generateexcel', [KepalaPelanggaranController::class, 'generateexcel'])->name('kepala-pelanggaran.generateexcel');
        Route::post('/kepala-pelanggaran/jqueryNamaPelanggaran', [KepalaPelanggaranController::class, 'jqueryNamaPelanggaran']);
        Route::post('/kepala-pelanggaran/jquerySiswaKelas', [KepalaPelanggaranController::class, 'jquerySiswaKelas'])->name('kepala-pelanggaran.jquerySiswaKelas');
    });
});
