<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserImportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminAbsenceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas para el perfil del usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Gestión de usuarios por CSV (solo admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/upload-users', [UserImportController::class, 'showUploadForm'])->name('upload-users');
    Route::post('/import-users', [UserImportController::class, 'importUsers'])->name('import-users');
});

// Panel de Administración
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/absences', [AdminAbsenceController::class, 'index'])->name('absences.index');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
});

// Route::post('/admin/users/store', [UserController::class, 'store'])->name('admin.users.store');
Route::post('/admin/users/upload-csv', [UserController::class, 'processCsv'])->name('admin.processCsv');

// Rutas de ausencias (Usuarios normales)
Route::middleware(['auth'])->prefix('absences')->name('absences.')->group(function () {
    Route::get('/', [AbsenceController::class, 'index'])->name('index');
    Route::get('/create', [AbsenceController::class, 'create'])->name('create');
    Route::post('/', [AbsenceController::class, 'store'])->name('store');
    Route::get('/{absence}/edit', [AbsenceController::class, 'edit'])->name('edit'); 
    Route::put('/{absence}', [AbsenceController::class, 'update'])->name('update'); 
    Route::delete('/{absence}', [AbsenceController::class, 'destroy'])->name('destroy');
});

// Rutas de ausencias (Admin)
Route::middleware(['auth'])->prefix('admin/absences')->name('admin.absences.')->group(function () {
    Route::get('/', [AdminAbsenceController::class, 'index'])->name('index');
    Route::post('/', [AdminAbsenceController::class, 'store'])->name('store');
    Route::delete('/{absence}', [AdminAbsenceController::class, 'destroy'])->name('destroy');
    Route::get('/{absence}/edit', [AdminAbsenceController::class, 'edit'])->name('edit');
});


require __DIR__ . '/auth.php';
