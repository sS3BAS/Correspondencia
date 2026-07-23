<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Public Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (Require Authentication)
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', function () {
        return view('dashboard');
    })->name('home');

    // Users Routes (HU-1)
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::delete('/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
    });

    // Entradas Routes (HU-04, HU-05, HU-06)
    Route::prefix('entradas')->name('entradas.')->group(function () {
        Route::get('/', [\App\Http\Controllers\EntradaController::class, 'index'])->name('index');
        Route::get('/crear', [\App\Http\Controllers\EntradaController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\EntradaController::class, 'store'])->name('store');
        Route::get('/{entrada}/entrega', [\App\Http\Controllers\EntradaController::class, 'entrega'])->name('entrega');
        Route::post('/entrega', [\App\Http\Controllers\EntradaController::class, 'storeEntrega'])->name('entrega.store');
    });

    // Salidas Routes (HU-07, HU-08)
    Route::prefix('salidas')->name('salidas.')->group(function () {
        Route::get('/', [\App\Http\Controllers\SalidaController::class, 'index'])->name('index');
        Route::get('/crear', [\App\Http\Controllers\SalidaController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\SalidaController::class, 'store'])->name('store');
    });

    // Repartos / Bitácora Logística (HU-09)
    Route::prefix('repartos')->name('repartos.')->group(function () {
        Route::get('/', [\App\Http\Controllers\RepartoController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\RepartoController::class, 'store'])->name('store');
    });

    // Acuses (HU-10)
    Route::prefix('acuses')->name('acuses.')->group(function () {
        Route::get('/{correspondencia}/crear', [\App\Http\Controllers\AcuseController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\AcuseController::class, 'store'])->name('store');
    });

    // Seguimiento (HU-11)
    Route::get('/seguimiento', [\App\Http\Controllers\SeguimientoController::class, 'index'])->name('seguimiento.index');

});
