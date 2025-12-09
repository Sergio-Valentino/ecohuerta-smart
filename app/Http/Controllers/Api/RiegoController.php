<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cultivo;
use App\Models\Actuador;
use App\Models\LogsAcciones;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RiegoController extends Controller
{
    public function activar(Request $request)
    {
        $data = $request->validate([
            'cultivo_id'  => 'required|exists:cultivos,id',
            'actuador_id' => 'required|exists:actuadores,id',
            'motivo'      => 'required|string'
        ]);

        $actuador = Actuador::find($data['actuador_id']);

        // ACTIVAR ACTUADOR EN BD
        $actuador->update(['activo' => 1]);

        // REGISTRAR EN LOGS_ACCIONES (estructura real de tu BD)
        LogsAcciones::create([
            'usuario_id'  => Auth::id() ?? 1, // si no hay usuario logueado
            'cultivo_id'  => $data['cultivo_id'],
            'accion'      => 'activar_riego',
            'descripcion' => 'Riego iniciado por motivo: ' . $data['motivo'],
            'nivel'       => 'info',
            'fecha_hora'  => Carbon::now(),
        ]);

        return response()->json([
            'status'      => 'ok',
            'mensaje'     => 'Actuador activado correctamente',
            'actuador_id' => $actuador->id,
            'continuar'   => true
        ]);
    }
}