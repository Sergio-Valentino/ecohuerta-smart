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
    public function index($usuario_id)
    {
        return notificacion::where('usuario_id', $usuario_id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * Crear una nueva notificación
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'cultivo_id' => 'nullable|exists:cultivos,id',
            'tipo'       => 'required|string',
            'titulo'     => 'required|string',
            'mensaje'    => 'required|string',
        ]);

        $notificacion = notificacion::create([
            'usuario_id' => $data['usuario_id'],
            'cultivo_id' => $data['cultivo_id'] ?? null,
            'tipo'       => $data['tipo'],
            'titulo'     => $data['titulo'],
            'mensaje'    => $data['mensaje'],
            'leida'      => false,
            'fecha_envio'=> Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'data' => $notificacion
        ]);
    }

    /**
     * Marcar notificación como leída
     */
    public function marcarLeida($id)
    {
        $notificacion = notificacion::findOrFail($id);
        $notificacion->leida = true;
        $notificacion->save();

        return response()->json(['success' => true]);
    }
}
