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

// Middleware para restringir acceso solo al admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/upload-csv', [AdminController::class, 'uploadCsv'])->name('admin.uploadCsv');
    Route::post('/admin/upload-csv', [AdminController::class, 'processCsv'])->name('admin.processCsv');
});

// Middleware para proteger las rutas de Filament
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/filament-dashboard', function () {
//         return redirect('/admin'); // Redirige al panel admin de Filament
//     });
// });

//Ruta de ausencias.
Route::get('/absences', [AbsenceController::class, 'index'])->name('absences.index');

//Middleware para proteger las rutas de ausencias.
Route::middleware(['auth'])->group(function () {
    Route::get('/absences/create', [AbsenceController::class, 'create'])->name('absences.create');
    Route::post('/absences', [AbsenceController::class, 'store'])->name('absences.store');
});

//Middleware para las rutas del admin.
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/adminAbsences', [AdminAbsenceController::class, 'index'])->name('adminAbsences');
});



require __DIR__.'/auth.php';
