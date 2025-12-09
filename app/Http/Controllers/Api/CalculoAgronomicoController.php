<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lectura;
use App\Services\CalculoRiegoService;

class CalculoAgronomicoController extends Controller
{
    public function calcular($lectura_id, CalculoRiegoService $service)
    {
        // Buscar la lectura
        $lectura = Lectura::find($lectura_id);

        if (!$lectura) {
            return response()->json([
                'success' => false,
                'message' => 'Lectura no encontrada.'
            ], 404);
        }

        // Llamar al servicio de cálculo
        $resultado = $service->calcularParaLectura($lectura);

        return response()->json([
            'success' => true,
            'data' => $resultado
        ]);
    }
}