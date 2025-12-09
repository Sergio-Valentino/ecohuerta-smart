<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

// Modelos que TENÉS en tu proyecto
use App\Models\Lectura;
use App\Models\Sensor;
use App\Models\Cultivo;
use App\Models\Umbral;
use App\Models\LogsAcciones;

class LecturasController extends Controller
{
    /**
     * Endpoint para recibir lecturas desde el ESP32
     * POST /api/lecturas
     */
    public function store(Request $request)
    {
        // 1️⃣ VALIDAR DATOS QUE LLEGAN DEL ESP32
        $data = $request->validate([
            'sensor_id' => 'required|exists:sensores,id',
            'valor'     => 'required|numeric',
            'unidad'    => 'required|string',   // %, °C, etc.
            'tipo'      => 'required|string',   // humedad, temperatura, etc.
            // cultivo_id opcional: si no viene, lo inferimos del sensor
            'cultivo_id'=> 'nullable|exists:cultivos,id',
        ]);

        // 2️⃣ OBTENER SENSOR Y CULTIVO REAL
        $sensor = Sensor::findOrFail($data['sensor_id']);

        // Si no mandan cultivo_id, usamos el que está asociado al sensor
        $cultivoId = $data['cultivo_id'] ?? $sensor->cultivo_id;

        if (!$cultivoId) {
            return response()->json([
                'status'  => 'error',
                'mensaje' => 'El sensor no tiene cultivo asociado y no se envió cultivo_id.'
            ], 422);
        }

        $cultivo = Cultivo::findOrFail($cultivoId);

        // 3️⃣ GUARDAR LECTURA EN TABLA lecturas
        $lectura = Lectura::create([
            'sensor_id'    => $sensor->id,
            'cultivo_id'   => $cultivo->id,
            'valor'        => $data['valor'],
            'unidad'       => $data['unidad'],
            'tipo_lectura' => $data['tipo'],
            'fecha_hora'   => Carbon::now(),
        ]);

        // 4️⃣ BUSCAR UMBRAL CONFIGURADO
        // 4.a) Primero intentamos en tabla umbrales
        $umbral = Umbral::where('cultivo_id', $cultivo->id)
                        ->where('parametro', $data['tipo'])
                        ->where('activo', 1)
                        ->first();

        // 4.b) Si no hay umbral en tabla umbrales, usamos cultivos.umbral_marchitez
        $umbralMinimo = null;

        if ($umbral) {
            $umbralMinimo = $umbral->valor_min;
        } elseif (!is_null($cultivo->umbral_marchitez) && $data['tipo'] === 'humedad') {
            // usamos el umbral de marchitez del cultivo solo para humedad del suelo
            $umbralMinimo = $cultivo->umbral_marchitez;
        }

        // 5️⃣ EVALUAR SI REQUIERE RIEGO
        $riegoNecesario = false;

        if (!is_null($umbralMinimo)) {
            // Si el valor medido es menor al umbral → falta agua → hay que regar
            $riegoNecesario = $data['valor'] < $umbralMinimo;
        }

        // 6️⃣ REGISTRAR EN LOGS_ACCIONES
        LogsAcciones::create([
            'usuario_id' => null, // ESP32 (sin usuario logueado)
            'cultivo_id' => $cultivo->id,
            'accion'     => 'lectura_recibida',
            'descripcion'=> "Lectura {$data['tipo']}: {$data['valor']} {$data['unidad']} (sensor #{$sensor->id})",
            'fecha_hora' => Carbon::now(),
            'nivel'      => $riegoNecesario ? 'warning' : 'info',
        ]);

        // 7️⃣ RESPUESTA PARA EL ESP32
        return response()->json([
            'status'          => 'ok',
            'mensaje'         => 'Lectura almacenada correctamente.',
            'riego_necesario' => $riegoNecesario,
            'umbral_minimo'   => $umbralMinimo,
            'lectura'         => $lectura,
        ]);
    }
}