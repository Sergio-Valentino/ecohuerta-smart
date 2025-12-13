<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Notificacion;
use App\Models\User;
use App\Models\Cultivo;

#[Layout('layouts.app')]
class Notificaciones extends Component
{
    // ===== FORMULARIO =====
    public $notificacion_id;
    public $users_id;
    public $cultivos_id;
    public $tipo;
    public $titulo;
    public $mensaje;
    public $fecha_envio;
    public $leida = false;

    public $modal = false;

    // ===== CREAR =====
    public function abrirCrear()
    {
        $this->resetForm();
        $this->modal = true;
    }

    // ===== EDITAR =====
    public function abrirEditar($id)
    {
        $n = Notificacion::findOrFail($id);

        $this->notificacion_id = $n->id;
        $this->users_id        = $n->users_id;
        $this->cultivos_id     = $n->cultivos_id;
        $this->tipo            = $n->tipo;
        $this->titulo          = $n->titulo;
        $this->mensaje         = $n->mensaje;
        $this->leida           = $n->leida;

        // formato correcto para datetime-local
        $this->fecha_envio = $n->fecha_envio
            ? $n->fecha_envio->format('Y-m-d\TH:i')
            : null;

        $this->modal = true;
    }

    // ===== GUARDAR / ACTUALIZAR =====
    public function guardar()
    {
        $this->validate([
            'users_id'    => 'required|exists:users,id',
            'cultivos_id' => 'nullable|exists:cultivos,id',
            'tipo'        => 'required|string',
            'titulo'      => 'required|string',
            'mensaje'     => 'required|string',
            'fecha_envio' => 'required',
        ]);

        Notificacion::updateOrCreate(
            ['id' => $this->notificacion_id],
            [
                'users_id'    => $this->users_id,
                'cultivos_id' => $this->cultivos_id,
                'tipo'        => $this->tipo,
                'titulo'      => $this->titulo,
                'mensaje'     => $this->mensaje,
                'leida'       => $this->leida ?? false,
                'fecha_envio' => $this->fecha_envio,
            ]
        );

        $this->modal = false;
        $this->resetForm();
    }

    // ===== ELIMINAR =====
    public function eliminar($id)
    {
        Notificacion::findOrFail($id)->delete();
    }

    // ===== RESET =====
    public function resetForm()
    {
        $this->notificacion_id = null;
        $this->users_id        = null;
        $this->cultivos_id     = null;
        $this->tipo            = null;
        $this->titulo          = null;
        $this->mensaje         = null;
        $this->leida           = false;
        $this->fecha_envio     = now()->format('Y-m-d\TH:i');
    }

    // ===== RENDER (CLAVE) =====
    public function render()
    {
        return view('livewire.dashboard.notificaciones', [
            'notificaciones' => Notificacion::with(['usuario', 'cultivo'])
                                    ->orderBy('fecha_envio', 'desc')
                                    ->get(),
            'usuarios' => User::all(),
            'cultivos' => Cultivo::all(),
        ]);
    }
}