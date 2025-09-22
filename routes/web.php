<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\Mahasiswa\RegisterMahasiswaController;
use App\Http\Controllers\Mahasiswa\HomeMahasiswaController;
use App\Http\Controllers\Mahasiswa\LoginMahasiswaController;
use App\Http\Controllers\Dosen\KelasDosenController;
use App\Http\Controllers\Dosen\TugasDosenController;
use App\Http\Controllers\Mahasiswa\TugasMahasiswaController;
use App\Http\Controllers\MahasiswaController;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});
Route::get('admin/login', [AuthController::class, 'index'])->name('admin.login');
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function (){
    Route::get('home', [HomeController::class, 'index'])->name('admin.home');
    Route::resource('kelas', 'App\Http\Controllers\KelasController');
    Route::resource('matkul', 'App\Http\Controllers\MatkulController');
    Route::resource('dosen', 'App\Http\Controllers\DosenController');
    Route::resource('mahasiswaadmin', 'App\Http\Controllers\MahasiswaController');
    Route::post('/kelas/{id}/inputsiswa', [KelasController::class, 'inputsiswa'])->name('kelas.inputsiswa');
    Route::get('/kelas/{kelas_id}/mahasiswa', [KelasController::class, 'listSiswa'])->name('kelas.listsiswa');
    Route::get('/kelas/{kelas_id}/mahasiswa/{mahasiswa_id}/edit', [KelasController::class, 'editSiswa'])->name('kelas.editsiswa');
    Route::delete('/kelas/{kelas_id}/mahasiswa/{mahasiswa_id}', [KelasController::class, 'removeSiswa'])->name('kelas.removesiswa');
    Route::resource('tugas', 'App\Http\Controllers\TugasController');
Route::get('tugas/{kelas_id}/listtugas', [TugasController::class, 'kelaslist'])->name('tugas.kelaslist');
Route::get('/{id}', [TugasController::class, 'show'])->name('show');
Route::delete('/{id}', [TugasController::class, 'destroy'])->name('destroy');
Route::get('/{id}/jawaban', [TugasController::class, 'jawaban'])->name('jawaban');
Route::post('/{id}/nilai', [TugasController::class, 'beriNilai'])->name('tugas.beriNilai');
});

Auth::routes();

Route::post('admin-login', [AuthController::class, 'login'])->name('login.admin');
Route::get('logout', [AuthController::class, 'logout'])->name('logout.admin');
Route::get('Mahasiswa/login', [LoginMahasiswaController::class, 'index'])->name('mahasiswa.login');


Route::post('login-mahasiswa',[LoginMahasiswaController::class, 'login'])->name('login.mahasiswa');
    Route::get('logout-mahasiswa',[LoginMahasiswaController::class, 'logout'])->name('mahasiswa.logout');
    Route::get('Mahasiswa/register', [RegisterMahasiswaController::class, 'RegisterForm'])->name('show.register');
    Route::post('register-mahasiswa', [RegisterMahasiswaController::class, 'Register'])->name('register.mahasiswa');
    Route::get('Mahasiswa/verify/{token}', [HomeMahasiswaController::class, 'verifMahasiswaRegistration'])->name('mahasiswa.verify');

Route::group(['prefix' => 'Mahasiswa','middleware' => 'mahasiswa'], function () {
    Route::get('home', [HomeMahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::put('/mahasiswa/update-chat-id', [HomeMahasiswaController::class, 'updateChatId'])->name('mahasiswa.updateChatId');
    Route::get('/telegram', [HomeMahasiswaController::class, 'Chatid'])->name('telegram.register');
    Route::resource('kelasmahasiswa', 'App\Http\Controllers\Mahasiswa\KelasMahasiswaController');
    Route::resource('tugasmahasiswa', 'App\Http\Controllers\Mahasiswa\TugasMahasiswaController');
    Route::get('/tugas/{kelas_id}/listtugas', [TugasMahasiswaController::class, 'index'])->name('mahasiswa.tugaslist');
    Route::get('/tugas/{id}/submit', [TugasMahasiswaController::class, 'create'])->name('mahasiswa.tugas.create');
    Route::post('/tugas/{id}/submit', [TugasMahasiswaController::class, 'store'])->name('mahasiswa.tugas.store');
    Route::get('/tugas/{id}/jawaban', [TugasMahasiswaController::class, 'show'])->name('mahasiswa.tugas.show');
    Route::get('/{id}',[TugasMahasiswaController::class, 'destroy'])->name('mahasiswatugas.destroy');

});

Route::get('Dosen/login', [App\Http\Controllers\Dosen\LoginDosenController::class, 'index'])->name('dosen.login');
    Route::post('login-dosen', [App\Http\Controllers\Dosen\LoginDosenController::class, 'login'])->name('login.dosen');
    Route::get('logout-dosen', [App\Http\Controllers\Dosen\LoginDosenController::class, 'logout'])->name('dosen.logout');

Route::group(['prefix' => 'Dosen', 'middleware' => 'dosen'], function () {
        Route::get('home', [App\Http\Controllers\Dosen\HomeDosenController::class, 'index'])->name('dosen.dashboard');
        Route::resource('kelasdosen', 'App\Http\Controllers\Dosen\KelasDosenController');
        Route::get('kelas',[App\Http\Controllers\Dosen\KelasDosenController::class, 'index'])->name('dosen.kelas');
        Route::get('/kelas/{kelas_id}/mahasiswa/{mahasiswa_id}/edit', [KelasDosenController::class, 'editSiswa'])->name('kelasdosen.editsiswa');
        Route::get('/kelas/{kelas_id}/mahasiswa', [KelasDosenController::class, 'listSiswa'])->name('kelasdosen.listsiswa');
        Route::delete('/kelas/{kelas_id}/mahasiswa/{mahasiswa_id}', [KelasDosenController::class, 'removeSiswa'])->name('kelasdosen.removesiswa');
        Route::post('/kelas/{id}/inputsiswa', [KelasDosenController::class, 'inputsiswa'])->name('kelasdosen.inputsiswa');
        Route::resource('tugasdosen', 'App\Http\Controllers\Dosen\TugasDosenController');
        Route::get('/tugas/{kelas_id}/listtugas', [TugasDosenController::class, 'kelaslist'])->name('dosen.tugaslist');
        Route::get('/{id}', [TugasDosenController::class, 'show'])->name('dosen.tugasshow');
        Route::delete('/{id}', [TugasDosenController::class, 'destroy'])->name('dosen.tugasdestroy');
        Route::get('/{id}/jawaban', [TugasDosenController::class, 'jawaban'])->name('dosen.tugasjawaban');
        Route::post('/{id}/nilai', [TugasDosenController::class, 'beriNilai'])->name('dosen.nilai');
    });
