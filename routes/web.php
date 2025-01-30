<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserImportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ruta para el formulario de subida de CSV.
Route::get('/admin/upload-users', [UserImportController::class, 'showUploadForm'])->name('admin.upload-users');

// Ruta para procesar el CSV.
Route::post('/admin/import-users', [UserImportController::class, 'importUsers'])->name('admin.import-users');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/upload-users', [UserImportController::class, 'showUploadForm'])->name('admin.upload-users');
    Route::post('/admin/import-users', [UserImportController::class, 'importUsers'])->name('admin.import-users');
});


require __DIR__.'/auth.php';
