<?php

namespace App\Services;

use App\Models\Lectura;
use App\Models\Umbral;
use App\Models\Clima;

class CalculoRiegoService
{
    public function calcularParaLectura(Lectura $lectura): array
    {
        $cultivo = $lectura->cultivo;

        if (!$cultivo) {
            return respuesta('La lectura no está asociada a un cultivo.');
        }

        // 1️⃣ KC — Coeficiente de Cultivo según etapa
        $etapa = $cultivo->etapaPlanta;
        $kc = $etapa?->kc_media ?? 1.0;

        // 2️⃣ ETo — Evapotranspiración
        // Busco el clima más reciente de la región del cultivo
        $clima = Clima::where('region_id', $cultivo->region_id)
            ->orderBy('fecha', 'desc')
            ->first();

        // Si existe clima, usamos dato real; si no, usamos valor regional preestablecido
        if ($clima && $clima->eto_diaria) {
            $eto = $clima->eto_diaria;
        } else {
            $eto = $cultivo->region->eto_promedio ?? 3.5; 
        }

        // 3️⃣ Tipo de suelo → capacidad de campo y punto de marchitez
        $suelo = $cultivo->tipoSuelo;

        $capacidadCampo = $suelo->capacidad_campo ?? 35;
        $puntoMarchitez = $suelo->punto_marchitez ?? 15;

        // 4️⃣ Necesidad hídrica (NR)
        $nr = $kc * $eto;

        // 5️⃣ Umbral dinámico basado en el suelo
        $umbralMin = $puntoMarchitez + 5; 
        $umbralMax = $capacidadCampo - 5; 

        // 6️⃣ Si existe un umbral manual en BD → priorizarlo
        $umbral = Umbral::where('cultivo_id', $cultivo->id)
            ->where('etapa_planta_id', $cultivo->etapa_planta_id)
            ->where('parametro', 'humedad_suelo')
            ->where('activo', 1)
            ->first();

        if ($umbral) {
            $umbralMin = $umbral->valor_min;
            $umbralMax = $umbral->valor_max;
        }

        // 7️⃣ Decisión final de riego
        $humedad = $lectura->valor;

        if ($humedad <= $umbralMin) {
            return respuestaCompleta(
                $kc, $eto, $nr, $umbral, true,
                "Humedad baja. El suelo '{$suelo->nombre}' necesita riego."
            );
        }

        if ($humedad >= $umbralMax) {
            return respuestaCompleta(
                $kc, $eto, $nr, $umbral, false,
                "El suelo está saturado. No regar."
            );
        }

        return respuestaCompleta(
            $kc, $eto, $nr, $umbral, false,
            "Humedad dentro del rango óptimo."
        );
    }
}

function respuesta($motivo)
{
    return [
        'kc' => null,
        'eto' => null,
        'nr' => null,
        'riego_necesario' => false,
        'motivo' => $motivo
    ];
}

function respuestaCompleta($kc, $eto, $nr, $umbral, $riego, $motivo)
{
    return [
        'kc' => $kc,
        'eto' => $eto,
        'nr' => $nr,
        'umbral' => $umbral,
        'riego_necesario' => $riego,
        'motivo' => $motivo
    ];
}