<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Horario;
use App\Models\Cultivo;
use App\Models\Sensor;
use App\Models\Actuador;

#[Layout('layouts.app')]
class Horarios extends Component
{
    public $horarios;

    public $horario_id = null;
    public $cultivo_id = '';
    public $sensor_id = '';
    public $actuador_id = '';
    public $hora_inicio = '';
    public $hora_fin = '';
    public $frecuencia = '';
    public $dias_semana = '';
    public $activo = true;

    public $modal = false;

    public function mount()
    {
        $this->cargarDatos();
    }

    public function cargarDatos()
    {
        $this->horarios = Horario::with(['cultivo','sensor','actuador'])->get();
    }

    // Abrir modal para crear
    public function abrirCrear()
    {
        $this->resetForm();
        $this->modal = true;
    }

    // Abrir modal para editar
    public function abrirEditar($id)
    {
        $h = Horario::findOrFail($id);

        $this->horario_id = $h->id;
        $this->cultivo_id = $h->cultivo_id;
        $this->sensor_id = $h->sensor_id;
        $this->actuador_id = $h->actuador_id;
        $this->hora_inicio = $h->hora_inicio;
        $this->hora_fin = $h->hora_fin;
        $this->frecuencia = $h->frecuencia;
        $this->dias_semana = $h->dias_semana;
        $this->activo = $h->activo;

        $this->modal = true;
    }

    // Guardar o actualizar
    public function guardar()
    {
        $this->validate([
            'cultivo_id' => 'required',
            'actuador_id' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ]);

        Horario::updateOrCreate(
            ['id' => $this->horario_id],
            [
                'cultivo_id' => $this->cultivo_id,
                'sensor_id' => $this->sensor_id,
                'actuador_id' => $this->actuador_id,
                'hora_inicio' => $this->hora_inicio,
                'hora_fin' => $this->hora_fin,
                'frecuencia' => $this->frecuencia,
                'dias_semana' => $this->dias_semana,
                'activo' => $this->activo,
            ]
        );

        $this->modal = false;
        $this->resetForm();
        $this->cargarDatos();
    }

    // Eliminar
    public function eliminar($id)
    {
        Horario::findOrFail($id)->delete();
        $this->cargarDatos();
    }

    // Resetear formulario
    public function resetForm()
    {
        $this->horario_id = null;
        $this->cultivo_id = '';
        $this->sensor_id = '';
        $this->actuador_id = '';
        $this->hora_inicio = '';
        $this->hora_fin = '';
        $this->frecuencia = '';
        $this->dias_semana = '';
        $this->activo = true;
    }

    public function render()
    {
        return view('livewire.dashboard.horarios', [
            'cultivos' => Cultivo::all(),
            'sensores' => Sensor::all(),
            'actuadores' => Actuador::all(),
            'horarios' => $this->horarios,
        ]);
    }
}
