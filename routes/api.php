<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LecturasController;
use App\Http\Controllers\Api\RiegoController;
use App\Http\Controllers\Api\ProgresoRiegoController;
use App\Http\Controllers\FinRiegoController;
use App\Http\Controllers\Api\NotificacionesAPIController;
use App\Http\Controllers\Api\CalculoAgronomicoController;



/*
|--------------------------------------------------------------------------
| API Routes — EcoHuertaSmart
|--------------------------------------------------------------------------
*/

//  ACTIVAR RIEGO (manual o automático)
Route::post('/actuadores/activar', [RiegoController::class, 'activar']);

// REGISTRAR LECTURAS DEL ESP32
Route::post('/lecturas/registrar', [LecturasController::class, 'store']);

Route::post('/riego/progreso', [ProgresoRiegoController::class, 'update']);

Route::post('/riego/fin', [FinRiegoController::class, 'finalizar']);

Route::get('/notificaciones/{usuario_id}', [NotificacionesAPIController::class, 'index']);
Route::post('/notificaciones', [NotificacionesAPIController::class, 'store']);
Route::patch('/notificaciones/{id}/leida', [NotificacionesAPIController::class, 'marcarLeida']);

Route::get('/calculo/agronomico/{lectura_id}', [CalculoAgronomicoController::class, 'calcular']);


