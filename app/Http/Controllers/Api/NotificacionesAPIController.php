<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notificacion;
use Carbon\Carbon;

class NotificacionesAPIController extends Controller
{
    /**
     * Listar notificaciones del usuario
     */
    public function index($users_id)
    {
        return Notificacion::where('users_id', $users_id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * Crear una nueva notificación
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'users_id' => 'required|exists:users,id',
            'cultivos_id' => 'nullable|exists:cultivos,id',
            'tipo'       => 'required|string',
            'titulo'     => 'required|string',
            'mensaje'    => 'required|string',
        ]);

        $notificacion = notificacion::create([
            'users_id' => $data['users_id'],
            'cultivos_id' => $data['cultivos_id'] ?? null,
            'tipo'       => $data['tipo'],
            'titulo'     => $data['titulo'],
            'mensaje'    => $data['mensaje'],
            'leida'      => 0,
            'fecha_envio'=> Carbon::now(),
        ]);

        return response()->json([
           'status' => 'ok',
            'data'   => $notificacion
        ], 201);
    }

    /**
     * Marcar notificación como leída
     */
    public function marcarLeida($id)
    {
        $notificacion = notificacion::findOrFail($id);
        $notificacion->leida = 1;
        $notificacion->save();
      
        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Notificación marcada como leída'
        ]);
    }
}
