<?php

use App\Http\Controllers\Api\ConsumoInsController;
use App\Http\Controllers\Api\ConsumoSerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\api\FraccionVentaController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/fraccionventas', [FraccionVentaController::class, 'index'])->name('fraccionventas');
    Route::get('/atencion-cierre-consumosmed/{idnumregate}', [FraccionVentaController::class, 'show']);
    Route::get('/atencion-cierre-consumosins/{idnumregate}', [ConsumoInsController::class, 'show']);
    Route::get('/atencion-cierre-consumoses/{idnumregate}', [ConsumoSerController::class, 'show']);
});

require __DIR__.'/auth.php';
