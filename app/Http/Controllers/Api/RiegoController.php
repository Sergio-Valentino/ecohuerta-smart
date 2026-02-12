<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Actuador;
use App\Models\LogsAcciones;
use App\Models\Lectura;
use App\Models\Umbral;

use Illuminate\Support\Facades\Auth;

class RiegoController extends Controller
{
    /**
     * ACTIVACIÓN MANUAL (dashboard / pruebas)
     */
    public function activar(Request $request)
    {
        $data = $request->validate([
            'cultivo_id'  => 'required|exists:cultivos,id',
            'actuador_id' => 'required|exists:actuadores,id',
            'motivo'      => 'required|string'
        ]);

        $actuador = Actuador::findOrFail($data['actuador_id']);
        $actuador->update(['activo' => 1]);

        LogsAcciones::create([
            'users_id'    => Auth::id() ?? 1,
            'cultivos_id' => $data['cultivo_id'],
            'accion'      => 'activar_riego',
            'descripcion' => 'Riego manual: ' . $data['motivo'],
            'nivel'       => 'info',
            'fecha_hora'  => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'ok',
            'continuar' => true
        ], 200);
    }

    /**
     * DECISIÓN AUTOMÁTICA DE RIEGO
     * FC-28 / Capacitivo
     * - Valor ALTO  => suelo SECO
     * - Valor BAJO  => suelo HÚMEDO
     */
    public function decisionAutomatica(Request $request)
    {
        // 1️⃣ Tomar las últimas 2 lecturas de humedad del suelo
        $lecturas = Lectura::where('tipo_lectura', 'humedad')
            ->orderBy('fecha_hora', 'desc')
            ->take(2)
            ->pluck('valor');

        // Si no hay lecturas, NO regar
        if ($lecturas->count() === 0) {
            return response()->json([
                'riego' => [
                    'activar' => false,
                    'error'   => 'Sin lecturas de humedad'
                ]
            ], 200);
        }

        // Si hay una sola lectura, se replica
        $suelo1 = (float) ($lecturas[0] ?? 100);
        $suelo2 = (float) ($lecturas[1] ?? $lecturas[0]);

        // 2️⃣ Umbrales (desde BD o valores seguros)
        // umbral_min = suelo húmedo
        // umbral_max = suelo seco
        $umbralMin = Umbral::where('parametro', 'humedad')
            ->where('activo', 1)
            ->min('valor_min') ?? 45;

        $umbralMax = Umbral::where('parametro', 'humedad')
            ->where('activo', 1)
            ->max('valor_max') ?? 90;

        // 3️⃣ LÓGICA DEFINITIVA (SIN FILTROS RAROS)
        $activar = false;

        // REGAR si alguno está SECO
        if ($suelo1 >= $umbralMax || $suelo2 >= $umbralMax) {
            $activar = true;
        }

        // CORTAR SOLO si ambos están HÚMEDOS
        if ($suelo1 <= $umbralMin && $suelo2 <= $umbralMin) {
            $activar = false;
        }

        // 4️⃣ RESPUESTA FINAL AL ESP32
        return response()->json([
            'riego' => [
                'activar'      => $activar,
                'valvula_1'    => $activar,
                'valvula_2'    => $activar,
                'duracion_seg' => 60,
                'suelo_1'      => $suelo1,
                'suelo_2'      => $suelo2,
                'umbral_min'   => $umbralMin,
                'umbral_max'   => $umbralMax
            ]
        ], 200);
    }
}