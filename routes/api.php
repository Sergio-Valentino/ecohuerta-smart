<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LecturaController;

Route::post('/lecturas', [LecturaController::class, 'store']);