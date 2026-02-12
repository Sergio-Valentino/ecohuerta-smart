<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — EcoHuertaSmart
|--------------------------------------------------------------------------
| SOLO rutas
| NO modifica lógica
| NO rompe dashboard
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\LecturasController;
use App\Http\Controllers\Api\RiegoController;
use App\Http\Controllers\Api\ProgresoRiegoController;
use App\Http\Controllers\Api\FinRiegoController;
use App\Http\Controllers\Api\NotificacionesAPIController;
use App\Http\Controllers\Api\CalculoAgronomicoController;

/*
|--------------------------------------------------------------------------
| LECTURAS (ESP32)
|--------------------------------------------------------------------------
*/
Route::post('/lecturas', [LecturasController::class, 'store']);
Route::post('/lecturas/registrar', [LecturasController::class, 'store']); // alias seguro

/*
|--------------------------------------------------------------------------
| RIEGO
|--------------------------------------------------------------------------
*/
Route::post('/actuadores/activar', [RiegoController::class, 'activar']);
Route::get('/riego/progreso', [RiegoController::class, 'progreso']);
Route::post('/riego/progreso', [ProgresoRiegoController::class, 'update']);
Route::post('/riego/fin', [FinRiegoController::class, 'finalizar']);
Route::post('/riego/decision', [RiegoController::class, 'decisionAutomatica']);
Route::post('/riego/decision', [RiegoController::class, 'decisionAutomatica']);
/*
|--------------------------------------------------------------------------
| NOTIFICACIONES
|--------------------------------------------------------------------------
*/
Route::get('/notificaciones/{usuario_id}', [NotificacionesAPIController::class, 'index']);
Route::post('/notificaciones', [NotificacionesAPIController::class, 'store']);
Route::patch('/notificaciones/{id}/leida', [NotificacionesAPIController::class, 'marcarLeida']);

/*
|--------------------------------------------------------------------------
| CÁLCULO AGRONÓMICO
|--------------------------------------------------------------------------
*/
Route::get(
    '/calculo/agronomico/{lectura_id}',
    [CalculoAgronomicoController::class, 'calcular']
);


