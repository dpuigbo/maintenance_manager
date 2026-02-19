<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Placeholder routes for navigation (will be implemented later)
    Route::get('/clientes', fn () => inertia('Placeholder', ['section' => 'Clientes']))->name('clientes.index');
    Route::get('/intervenciones', fn () => inertia('Placeholder', ['section' => 'Intervenciones']))->name('intervenciones.index');
    Route::get('/fabricantes', fn () => inertia('Placeholder', ['section' => 'Fabricantes']))->name('fabricantes.index');
    Route::get('/modelos', fn () => inertia('Placeholder', ['section' => 'Modelos de Componente']))->name('modelos.index');
    Route::get('/aceites', fn () => inertia('Placeholder', ['section' => 'Aceites']))->name('aceites.index');
    Route::get('/consumibles', fn () => inertia('Placeholder', ['section' => 'Consumibles']))->name('consumibles.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
