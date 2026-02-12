<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LitrosAgua;
use App\Models\LogsAcciones;
use Carbon\Carbon;

class ProgresoRiegoController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'cultivo_id'        => 'required|exists:cultivos,id',
            'actuador_id'       => 'required|exists:actuadores,id',
            'litros_aplicados'  => 'required|numeric|min:0',
            'litros_recomendados' => 'required|numeric|min:0'
        ]);

        // Buscar registro de progreso existente o crearlo
        $progreso = LitrosAgua::updateOrCreate(
            [
                'cultivos_id'  => $data['cultivo_id'],
                'actuadores_id' => $data['actuador_id'],
            ],
            [
                'fecha_riego'        => Carbon::now(),
                'litros_aplicados'   => $data['litros_aplicados'],
                'litros_recomendados'=> $data['litros_recomendados'],
                'diferencia'         => $data['litros_recomendados'] - $data['litros_aplicados'],
            ]
        );

        // Registrar en logs
        LogsAcciones::create([
            'user_id'   => null, // ESP32 no tiene usuario
            'cultivos_id'   => $data['cultivo_id'],
            'accion'       => 'progreso_riego',
            'descripcion'  => 'Progreso actualizado: ' . $data['litros_aplicados'] . ' L aplicados',
            'nivel'        => 'info',
            'fecha_hora'   => Carbon::now(),
        ]);

        return response()->json([
            'status'   => 'ok',
            'message'  => 'Progreso actualizado correctamente',
            'progreso' => $progreso
        ], 200);
    }
}
