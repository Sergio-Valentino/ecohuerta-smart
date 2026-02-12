<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

// Modelos del sistema
use App\Models\Lectura;
use App\Models\Sensor;
use App\Models\Umbral;
use App\Models\LogsAcciones;
use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
class LecturasController extends Controller
{
    /**
     * =====================================================
     * POST /api/lecturas
     *
     * Soporta:
     *  - ESP32 (múltiples sensores en un JSON)
     *  - Postman / pruebas (sensor único)
     * =====================================================
     */
    public function store(Request $request)
    {
        /*
        =====================================================
        🔁 MODO IOT – ESP32
        =====================================================
        */
        if ($request->input('sensores') !== null) {

            $data = $request->validate([
                'dispositivo_id' => 'required|integer',
                'sensores'       => 'required|array'
            ]);

            /**
             * MAPA DE SENSORES
             * Ajustar SOLO si cambian los IDs en la BD
             */
            $mapaSensores = [
                'suelo_1'      => ['sensor_id' => 1, 'tipo' => 'humedad',        'unidad' => '%'],
                'suelo_2'      => ['sensor_id' => 2, 'tipo' => 'humedad',        'unidad' => '%'],
                'temperatura'  => ['sensor_id' => 3, 'tipo' => 'temperatura',    'unidad' => 'C'],
                'humedad_aire' => ['sensor_id' => 4, 'tipo' => 'humedad_aire',   'unidad' => '%'],
                'luz'          => ['sensor_id' => 5, 'tipo' => 'luz',            'unidad' => '%'],
                'lluvia'       => ['sensor_id' => 6, 'tipo' => 'lluvia',         'unidad' => 'bool'],
                'nivel_agua'   => ['sensor_id' => 7, 'tipo' => 'nivel_agua',     'unidad' => 'bool'],
                'caudal_1'     => ['sensor_id' => 8, 'tipo' => 'caudal',         'unidad' => 'L/min'],
                'caudal_2'     => ['sensor_id' => 9, 'tipo' => 'caudal',         'unidad' => 'L/min'],
            ];

            $procesadas = 0;

            foreach ($data['sensores'] as $nombre => $valor) {

                if (!isset($mapaSensores[$nombre])) {
                    continue;
                }

                // Reinyectamos al flujo normal
                $fakeRequest = new Request([
                    'sensor_id' => $mapaSensores[$nombre]['sensor_id'],
                    'valor'     => $valor,
                    'unidad'    => $mapaSensores[$nombre]['unidad'],
                    'tipo'      => $mapaSensores[$nombre]['tipo'],
                ]);

                $this->procesarLectura($fakeRequest);
                $procesadas++;
            }

            return response()->json([
                'status'  => 'ok',
                'mensaje' => 'Lecturas IoT registradas correctamente',
                'total'   => $procesadas
            ], 200);
        }

        /*
        =====================================================
        🧱 MODO SENSOR ÚNICO (Postman / Dashboard)
        =====================================================
        */
        return response()->json(
            $this->procesarLectura($request),
            200
        );
    }

    /**
     * =====================================================
     * 🔒 LÓGICA CENTRAL (NO SE DUPLICA)
     * =====================================================
     */
    private function procesarLectura(Request $request)
    {
        // 1️⃣ VALIDACIÓN
        $data = $request->validate([
            'sensor_id' => 'required|exists:sensores,id',
            'valor'     => 'required|numeric',
            'unidad'    => 'required|string',
            'tipo'      => 'required|string',
        ]);

        // 2️⃣ SENSOR
        $sensor = Sensor::findOrFail($data['sensor_id']);

        // 3️⃣ CULTIVOS ASOCIADOS
        $cultivos = $sensor->cultivos;

        /*
        ============================
        🟢 SENSOR SIN CULTIVO
        ============================
        */
        if ($cultivos->isEmpty()) {

            $lectura = Lectura::create([
                'sensores_id'  => $sensor->id,
                'cultivos_id'  => null,
                'valor'        => $data['valor'],
                'unidad'       => $data['unidad'],
                'tipo_lectura' => $data['tipo'],
                'fecha_hora'   => Carbon::now(),
            ]);

            LogsAcciones::create([
                'users_id'    => null,
                'cultivos_id' => null,
                'accion'      => 'lectura_recibida',
                'descripcion' => "Lectura {$data['tipo']}: {$data['valor']} {$data['unidad']} (sensor #{$sensor->id})",
                'fecha_hora'  => Carbon::now(),
                'nivel'       => 'info',
            ]);

            return [
                'sensor_id'  => $sensor->id,
                'lectura_id' => $lectura->id,
                'riego'      => false
            ];
        }

        /*
        ============================
        🟢 SENSOR CON CULTIVOS
        ============================
        */
        foreach ($cultivos as $cultivo) {

            $lectura = Lectura::create([
                'sensores_id'  => $sensor->id,
                'cultivos_id'  => $cultivo->id,
                'valor'        => $data['valor'],
                'unidad'       => $data['unidad'],
                'tipo_lectura' => $data['tipo'],
                'fecha_hora'   => Carbon::now(),
            ]);

            // 4️⃣ UMBRAL
            $umbral = Umbral::where('cultivos_id', $cultivo->id)
                            ->where('parametro', $data['tipo'])
                            ->where('activo', 1)
                            ->first();

            $umbralMinimo = $umbral->valor_min
                ?? ($data['tipo'] === 'humedad' ? $cultivo->umbral_marchitez : null);

            // 5️⃣ EVALUACIÓN
            $riegoNecesario = !is_null($umbralMinimo)
                && $data['valor'] < $umbralMinimo;

 if ($riegoNecesario) {

    // 🔎 Usuario a notificar (para prueba / defensa)
    $usuario = User::first();

    if ($usuario) {

        // 🧾 Guardar notificación en BD
        Notificacion::create([
            'users_id'    => $usuario->id,
            'cultivos_id' => $cultivo->id,
            'tipo'        => 'Alerta',
            'titulo'      => '⚠ Alerta de Riego',
            'mensaje'     => "El cultivo {$cultivo->nombre} tiene {$data['tipo']} por debajo del umbral mínimo ({$data['valor']} {$data['unidad']}).",
            'leida'       => 0,
            'fecha_envio' => Carbon::now(),
        ]);

        // 📧 Enviar mail automático
        Mail::raw(
            "ALERTA ECOHUERTA SMART\n\n".
            "Cultivo: {$cultivo->nombre}\n".
            "Sensor: {$data['tipo']}\n".
            "Valor actual: {$data['valor']} {$data['unidad']}\n".
            "Umbral mínimo: {$umbralMinimo}\n\n".
            "Se recomienda activar riego.",
            function ($message) use ($usuario) {
                $message->to($usuario->email)
                        ->subject('🚨 EcoHuerta Smart - Alerta de Riego');
            }
        );
    }
}
            // 6️⃣ LOG
            LogsAcciones::create([
                'users_id'    => null,
                'cultivos_id' => $cultivo->id,
                'accion'      => 'lectura_recibida',
                'descripcion' => "Lectura {$data['tipo']}: {$data['valor']} {$data['unidad']} (sensor #{$sensor->id})",
                'fecha_hora'  => Carbon::now(),
                'nivel'       => $riegoNecesario ? 'warning' : 'info',
            ]);
        }

        return [
            'sensor_id'      => $sensor->id,
            'riego_evaluado' => true
        ];
    }
}