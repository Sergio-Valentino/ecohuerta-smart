<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LitrosAgua;
use App\Models\LogsAcciones;
use App\Models\Actuador;
use App\Models\Cultivo;
use Carbon\Carbon;

class FinRiegoController extends Controller
{
    /**
     * El ESP32 o el sistema llaman a este endpoint cuando el riego finaliza.
     */
    public function finalizar(Request $request)
    {
        $data = $request->validate([
            'cultivo_id'   => 'required|integer',
            'actuador_id'  => 'required|integer',
            'litros'       => 'required|numeric',
            'duracion_seg' => 'required|integer',
            'motivo'       => 'nullable|string'
        ]);

        // Guardar los litros aplicados
        LitrosAgua::create([
            'cultivo_id'   => $data['cultivo_id'],
            'litros'       => $data['litros'],
            'duracion_seg' => $data['duracion_seg'],
            'fecha_hora'   => Carbon::now()
        ]);

        // Registrar acción en logs
        LogsAcciones::create([
            'cultivo_id'  => $data['cultivo_id'],
            'accion'      => 'fin_riego',
            'descripcion' => 'Riego finalizado. Motivo: ' . ($data['motivo'] ?? 'finalización normal'),
            'nivel'       => 'info',
            'fecha_hora'  => Carbon::now()
        ]);

        // Apagar actuador en base de datos
        Actuador::where('id', $data['actuador_id'])
            ->update(['activo' => 0]);

        // Registrar última fecha de riego efectivo en cultivos
        Cultivo::where('id', $data['cultivo_id'])
            ->update(['ultima_fecha_riego' => Carbon::now()]);

        return response()->json([
            'status'  => 'OK',
            'message' => 'Riego finalizado y registrado correctamente.'
        ]);
    }
}
