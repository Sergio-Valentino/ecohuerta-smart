<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Home;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Dashboard\Productores;
use App\Livewire\Dashboard\Cultivos;

/*
|--------------------------------------------------------------------------
| Rutas sueltas (como las tenías)
|--------------------------------------------------------------------------
*/

Route::get('/notificaciones', \App\Livewire\Dashboard\Notificaciones::class)
    ->name('notificaciones')
    ->middleware(['auth', 'verified', 'permission:notificaciones.ver|role:admin']);

Route::get('/alertas', \App\Livewire\Dashboard\Alertas::class)
    ->name('alertas')
    ->middleware(['auth', 'verified', 'permission:alertas.ver|role:admin']);

Route::get('/horarios', \App\Livewire\Dashboard\Horarios::class)
    ->name('horarios')
    ->middleware(['auth', 'verified', 'permission:horarios.ver|role:admin']);

Route::get('/actuadores', \App\Livewire\Dashboard\Actuadores::class)
    ->name('actuadores')
    ->middleware(['auth', 'verified', 'permission:actuadores.ver|role:admin']);

Route::get('/sensores', \App\Livewire\Dashboard\Sensores::class)
    ->name('sensores')
    ->middleware(['auth', 'verified', 'permission:sensores.ver|role:admin']);

/*
|--------------------------------------------------------------------------
| Grupo principal (NO TOCAR DASHBOARD)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // ❗ NO SE TOCA
    Route::get('/dashboard', Home::class)->name('dashboard');

    // 👇 permiso agregado (solo esto)
    Route::get('/productores', Productores::class)
        ->name('productores')
        ->middleware('permission:productores.ver|role:admin');

    // 👇 permiso agregado (solo esto)
    Route::get('/cultivos', Cultivos::class)
        ->name('cultivos')
        ->middleware('permission:cultivos.ver|role:admin');
});

/*
|--------------------------------------------------------------------------
| Rutas base
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('home');

Route::view('/profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

require __DIR__.'/auth.php';
