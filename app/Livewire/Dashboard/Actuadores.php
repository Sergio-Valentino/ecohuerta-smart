<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Actuador;
use App\Models\Cultivo;

#[Layout('layouts.app')]
class Actuadores extends Component
{
    public $actuadores, $cultivos;
    public $actuador_id, $nombre, $tipo, $ubicacion, $activo = 1, $cultivo_id;
    public $modal = false;

    public function mount()
    {
        $this->cargarDatos();
    }

    public function cargarDatos()
    {
        $this->actuadores = Actuador::with('cultivo')->get();
        $this->cultivos = Cultivo::all();
    }

    public function abrirCrear()
    {
        $this->resetForm();
        $this->modal = true;
    }

    public function abrirEditar($id)
    {
        $a = Actuador::findOrFail($id);

        $this->actuador_id = $a->id;
        $this->nombre = $a->nombre;
        $this->tipo = $a->tipo;
        $this->ubicacion = $a->ubicacion;
        $this->activo = $a->activo;
        $this->cultivo_id = $a->cultivo_id;

        $this->modal = true;
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|min:3',
            'tipo' => 'required',
            'cultivo_id' => 'required',
        ]);

        Actuador::updateOrCreate(
            ['id' => $this->actuador_id],
            [
                'nombre' => $this->nombre,
                'tipo' => $this->tipo,
                'ubicacion' => $this->ubicacion,
                'activo' => $this->activo ?? 0,
                'cultivo_id' => $this->cultivo_id,
            ]
        );

        $this->cargarDatos();
        $this->modal = false;
        $this->resetForm();
    }

    public function eliminar($id)
    {
        Actuador::findOrFail($id)->delete();
        $this->cargarDatos();
    }

    public function resetForm()
    {
        $this->actuador_id = null;
        $this->nombre = '';
        $this->tipo = '';
        $this->ubicacion = '';
        $this->activo = 1;
        $this->cultivo_id = '';
    }

    public function render()
    {
        return view('livewire.dashboard.actuadores');
    }
}
