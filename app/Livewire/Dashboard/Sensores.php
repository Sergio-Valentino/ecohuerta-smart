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
    public $sensores, $cultivos, $users;

    // AHORA cultivos_ids ES UN ARRAY (muchos a muchos)
    public $sensor_id, $nombre, $tipo, $ubicacion, $modelo, $activo, $users_id, $cultivos_ids = [];

    public $modal = false;

    public function mount()
    {
        $this->recargarDatos();
    }

    public function recargarDatos()
    {
        // Cargar sensores con relaciones
        $this->sensores = Sensor::with(['usuario', 'cultivos'])->get();
        $this->cultivos = Cultivo::all();
        $this->users = User::all();
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
        $this->users_id = $s->users_id;

        // Cargar cultivos relacionados desde la tabla pivote
        $this->cultivos_ids = $s->cultivos->pluck('id')->toArray();

        $this->modal = true;
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|min:3',
            'tipo' => 'required|min:3',
        ]);

        // Guardar el sensor (sin cultivo_id porque ahora es pivote)
        $sensor = Sensor::updateOrCreate(
            ['id' => $this->sensor_id],
            [
                'nombre' => $this->nombre,
                'tipo' => $this->tipo,
                'ubicacion' => $this->ubicacion,
                'modelo' => $this->modelo,
                'activo' => $this->activo ?? 1,
                'users_id' => $this->users_id,
            ]
        );

        // Sincronizar cultivos seleccionados → TABLA PIVOTE
        $sensor->cultivos()->sync($this->cultivos_ids);

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
        $this->users_id = '';
        $this->cultivos_ids = []; // Reiniciar array
    }

    public function render()
    {
        return view('livewire.dashboard.sensores');
    }
}