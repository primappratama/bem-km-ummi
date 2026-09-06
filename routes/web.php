<?php

use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\AspirasiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DokumenLpjController;
use App\Http\Controllers\Admin\KementerianController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\Admin\PengurusController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\ProgramKerjaController;
use App\Http\Controllers\AspirasiPublikController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\Kementerian;
use Illuminate\Support\Facades\Route;

// ─── Public website ────────────────────────────────────────────────────────────
Route::get('/', fn () => view('home'))->name('home');
Route::get('/profil',        fn () => view('public.profil'))->name('profil');
Route::get('/program-kerja', fn () => view('program-kerja'))->name('program-kerja');
Route::get('/berita',        fn () => view('berita'))->name('berita');
Route::get('/galeri',        fn () => view('galeri'))->name('galeri');

// Detail kementerian publik (opsional, bisa tetap ada)
Route::get('/kementerian/{id}', function ($id) {
    $kementerian  = Kementerian::findOrFail($id);
    $pengurus     = \App\Models\Pengurus::where('kementerian_id', $id)->orderBy('jabatan')->get();
    $programKerja = \App\Models\ProgramKerja::where('kementerian_id', $id)
                        ->orderBy('tanggal_pelaksanaan', 'desc')->get();
    return view('public.kementerian-detail', compact('kementerian', 'pengurus', 'programKerja'));
})->name('publik.kementerian');

// ─── Aspirasi publik ────────────────────────────────────────────────────────────
Route::get('/aspirasi',  [AspirasiPublikController::class, 'create'])->name('aspirasi.create');
Route::post('/aspirasi', [AspirasiPublikController::class, 'store'])->name('aspirasi.store');

// ─── Auth ────────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// ─── Admin Panel ─────────────────────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kementerian — super_admin only
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('/kementerian', KementerianController::class)
             ->only(['index', 'edit', 'update']);
    });

    // Pengurus
    Route::middleware('role:super_admin,sekretaris')->group(function () {
        Route::resource('/pengurus', PengurusController::class)
             ->parameters(['pengurus' => 'pengurus']);
    });

    // Keuangan
    Route::middleware('role:super_admin,bendahara')->group(function () {
        Route::resource('/keuangan', KeuanganController::class);
    });

    // Program Kerja
    Route::middleware('role:super_admin,sekretaris,kementerian')->group(function () {
        Route::resource('/program-kerja', ProgramKerjaController::class);
    });

    // Aspirasi
    Route::middleware('role:super_admin,sekretaris')->group(function () {
        Route::get('/aspirasi',                     [AspirasiController::class, 'index'])
             ->name('aspirasi.index');
        Route::patch('/aspirasi/{aspirasi}/status', [AspirasiController::class, 'updateStatus'])
             ->name('aspirasi.status');
        Route::delete('/aspirasi/{aspirasi}',       [AspirasiController::class, 'destroy'])
             ->name('aspirasi.destroy');
    });

    // Absensi
    Route::middleware('role:super_admin,sekretaris,kementerian')->group(function () {
        Route::resource('/absensi', AbsensiController::class)->except(['show']);
    });

    // Dokumen LPJ
    Route::middleware('role:super_admin,sekretaris,kementerian')->group(function () {
        Route::get('/dokumen',                    [DokumenLpjController::class, 'index'])->name('dokumen.index');
        Route::get('/dokumen/create',             [DokumenLpjController::class, 'create'])->name('dokumen.create');
        Route::post('/dokumen',                   [DokumenLpjController::class, 'store'])->name('dokumen.store');
        Route::delete('/dokumen/{dokumen}',       [DokumenLpjController::class, 'destroy'])->name('dokumen.destroy');
        Route::get('/dokumen/{dokumen}/download', [DokumenLpjController::class, 'download'])->name('dokumen.download');
    });

    // Profil Publik — super_admin only
    Route::middleware('role:super_admin')->group(function () {
        Route::get('/profil',  [ProfilController::class, 'index'])->name('profil.index');
        Route::put('/profil',  [ProfilController::class, 'update'])->name('profil.update');
    });

    // Pengaturan — semua role
    Route::get('/pengaturan',              [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::patch('/pengaturan/profil',     [PengaturanController::class, 'updateProfil'])->name('pengaturan.profil');
    Route::patch('/pengaturan/password',   [PengaturanController::class, 'updatePassword'])->name('pengaturan.password');
});
