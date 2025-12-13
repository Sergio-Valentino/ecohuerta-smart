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

    // Ahora es un array porque es MUCHOS A MUCHOS
    public $actuador_id, $nombre, $tipo, $ubicacion, $activo = 1, $cultivos_ids = [];

    public $modal = false;

    public function mount()
    {
        $this->cargarDatos();
    }

    public function cargarDatos()
    {
        // Cargar actuadores con múltiples cultivos
        $this->actuadores = Actuador::with('cultivos')->get();
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

        // Cargar los cultivos asociados
        $this->cultivos_ids = $a->cultivos->pluck('id')->toArray();

        $this->modal = true;
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|min:3',
            'tipo' => 'required',
            'cultivos_ids' => 'required|array|min:1',
        ]);

        // Guardar sin cultivo_id
        $actuador = Actuador::updateOrCreate(
            ['id' => $this->actuador_id],
            [
                'nombre' => $this->nombre,
                'tipo' => $this->tipo,
                'ubicacion' => $this->ubicacion,
                'activo' => $this->activo ?? 0,
            ]
        );

        // Relación pivote actuadores ↔ cultivos
        $actuador->cultivos()->sync($this->cultivos_ids);

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
        $this->cultivos_ids = []; // reiniciar array
    }

    public function render()
    {
        return view('livewire.dashboard.actuadores');
    }
}