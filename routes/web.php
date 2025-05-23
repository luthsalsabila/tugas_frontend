<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatkulController;

Route::get('/dashboard', function () {
    $Dosen = 1000;
    $jumlahMahasiswa = 10000;
    $jumlahMatkul = 50; // Tambahkan ini (atau ambil dari database)

    return view('Dashboard.index', compact('Dosen', 'jumlahMahasiswa', 'jumlahMatkul'));
});

Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');

Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
Route::get('/mahasiswa/{npm}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
Route::put('/mahasiswa/{npm}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
Route::delete('/mahasiswa/{npm}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

Route::resource('matkul', MatkulController::class);
Route::get('/matkul', [MatkulController::class, 'index'])->name('matkul.index');
Route::get('/matkul/create', [MatkulController::class, 'create'])->name('matkul.create');
Route::post('/matkul', [MatkulController::class, 'store'])->name('matkul.store');
Route::get('/matkul/{kode_matkul}/edit', [MatkulController::class, 'edit'])->name('matkul.edit');
Route::put('/matkul/{kode_matkul}', [MatkulController::class, 'update'])->name('matkul.update');
Route::delete('/matkul/{kode_matkul}', [MatkulController::class, 'destroy'])->name('matkul.destroy');