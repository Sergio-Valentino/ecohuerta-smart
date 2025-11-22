<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lectura;
use App\Events\NuevoDatoDesdeESP32;
use Illuminate\Http\Request;

class LecturaController extends Controller
{
    public function recibir(Request $request)
    {
        $lectura = Lectura::create([
            'sensor_id' => $request->sensor_id,
            'valor'     => $request->valor,
            'fecha_hora'=> now(),
        ]);

        event(new NuevoDatoDesdeESP32($lectura));

        return response()->json(['msg' => 'OK', 'lectura' => $lectura]);
    }
}