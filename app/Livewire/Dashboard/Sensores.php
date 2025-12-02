<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Sensor;
use App\Models\Cultivo;
use App\Models\User;

#[Layout('layouts.app')]
class Sensores extends Component
{
    public $sensores, $cultivos, $usuarios;
    public $sensor_id, $nombre, $tipo, $ubicacion, $modelo, $activo, $usuario_id, $cultivo_id;
    public $modal = false;

    public function mount()
    {
        $this->recargarDatos();
    }

    public function recargarDatos()
    {
        $this->sensores = Sensor::with(['usuario', 'cultivo'])->get();
        $this->cultivos = Cultivo::all();
        $this->usuarios = User::all();
    }

    public function abrirCrear()
    {
        $this->resetForm();
        $this->modal = true;
    }

    public function abrirEditar($id)
    {
        $s = Sensor::findOrFail($id);

        $this->sensor_id = $s->id;
        $this->nombre = $s->nombre;
        $this->tipo = $s->tipo;
        $this->ubicacion = $s->ubicacion;
        $this->modelo = $s->modelo;
        $this->activo = $s->activo;
        $this->usuario_id = $s->usuario_id;
        $this->cultivo_id = $s->cultivo_id;

        $this->modal = true;
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|min:3',
            'tipo' => 'required|min:3',
        ]);

        Sensor::updateOrCreate(
            ['id' => $this->sensor_id],
            [
                'nombre' => $this->nombre,
                'tipo' => $this->tipo,
                'ubicacion' => $this->ubicacion,
                'modelo' => $this->modelo,
                'activo' => $this->activo ?? 1,
                'usuario_id' => $this->usuario_id,
                'cultivo_id' => $this->cultivo_id,
            ]
        );

        $this->recargarDatos();
        $this->modal = false;
        $this->resetForm();
    }

    public function eliminar($id)
    {
        Sensor::findOrFail($id)->delete();
        $this->recargarDatos();
    }

    public function resetForm()
    {
        $this->sensor_id = null;
        $this->nombre = '';
        $this->tipo = '';
        $this->ubicacion = '';
        $this->modelo = '';
        $this->activo = 1;
        $this->usuario_id = '';
        $this->cultivo_id = '';
    }

    public function render()
    {
        return view('livewire.dashboard.sensores');
    }
}