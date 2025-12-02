<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Home;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Dashboard\Productores;
use App\Livewire\Dashboard\Cultivos;

Route::get('/notificaciones', \App\Livewire\Dashboard\Notificaciones::class)
    ->name('notificaciones')
    ->middleware(['auth', 'verified']);

Route::get('/alertas', \App\Livewire\Dashboard\Alertas::class)
    ->name('alertas')
    ->middleware(['auth', 'verified']);

Route::get('/horarios', \App\Livewire\Dashboard\Horarios::class)
    ->name('horarios')
    ->middleware(['auth', 'verified']);

Route::get('/actuadores', App\Livewire\Dashboard\Actuadores::class)
    ->name('actuadores')
    ->middleware(['auth', 'verified']);

Route::get('/sensores', \App\Livewire\Dashboard\Sensores::class)
    ->name('sensores')
    ->middleware(['auth', 'verified']);

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', Home::class)->name('dashboard');

    Route::get('/productores', Productores::class)->name('productores');

    Route::get('/cultivos', Cultivos::class)->name('cultivos');

});

Route::get('/productores', Productores::class)
    ->middleware(['auth', 'verified'])
    ->name('productores');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('home');

/**
 * Dashboard principal (Livewire)
 */
Route::get('/dashboard', Home::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/**
 * Perfil de usuario
 */
Route::view('/profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

/**
 * Rutas de autenticación (Breeze)
 */
require __DIR__.'/auth.php';