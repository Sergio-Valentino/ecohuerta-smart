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
    public $notificaciones, $usuarios, $cultivos;

    public $notificacion_id;
    public $usuario_id;
    public $cultivo_id;
    public $tipo;
    public $titulo;
    public $mensaje;
    public $leida;
    public $fecha_envio;

    public $modal = false;

    public function mount()
    {
        $this->recargarDatos();
    }

    public function recargarDatos()
    {
        $this->notificaciones = Notificacion::with(['usuario', 'cultivo'])->get();
        $this->usuarios = User::all();
        $this->cultivos = Cultivo::all();
    }

    public function abrirCrear()
    {
        $this->resetForm();
        $this->modal = true;
    }

    public function abrirEditar($id)
    {
        $n = Notificacion::findOrFail($id);

        $this->notificacion_id = $n->id;
        $this->usuario_id = $n->usuario_id;
        $this->cultivo_id = $n->cultivo_id;
        $this->tipo = $n->tipo;
        $this->titulo = $n->titulo;
        $this->mensaje = $n->mensaje;
        $this->leida = $n->leida;
        $this->fecha_envio = $n->fecha_envio;

        $this->modal = true;
    }

    public function guardar()
    {
        $this->validate([
            'usuario_id' => 'required',
            'cultivo_id' => 'required',
            'tipo'       => 'required',
            'titulo'     => 'required|min:3',
            'mensaje'    => 'required|min:5',
            'fecha_envio' => 'required|date',
        ]);

        Notificacion::updateOrCreate(
            ['id' => $this->notificacion_id],
            [
                'usuario_id' => $this->usuario_id,
                'cultivo_id' => $this->cultivo_id,
                'tipo' => $this->tipo,
                'titulo' => $this->titulo,
                'mensaje' => $this->mensaje,
                'leida' => $this->leida ?? 0,
                'fecha_envio' => $this->fecha_envio,
            ]
        );

        $this->recargarDatos();
        $this->modal = false;
        $this->resetForm();
    }

    public function eliminar($id)
    {
        Notificacion::findOrFail($id)->delete();
        $this->recargarDatos();
    }

    public function resetForm()
    {
        $this->notificacion_id = null;
        $this->usuario_id = '';
        $this->cultivo_id = '';
        $this->tipo = '';
        $this->titulo = '';
        $this->mensaje = '';
        $this->leida = 0;
        $this->fecha_envio = date('Y-m-d\TH:i');
    }

    public function render()
    {
        return view('livewire.dashboard.notificaciones');
    }
}