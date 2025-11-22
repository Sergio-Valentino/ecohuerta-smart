<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;   // ← CAMBIADO

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('home');

/**
 * Dashboard principal (Livewire)
 * Protegido por login y verificación.
 */
Route::get('/dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/**
 * Perfil de usuario
 */
Route::view('/profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

/**
 * Rutas de autenticación (Breeze)
 */
require __DIR__.'/auth.php';
