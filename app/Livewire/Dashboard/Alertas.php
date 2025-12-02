<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Alerta;
use App\Models\Cultivo;
use App\Models\Sensor;

#[Layout('layouts.app')]
class Alertas extends Component
{
    public $alertas;
    public $cultivos;
    public $sensores;

    public $alerta_id;
    public $cultivo_id;
    public $sensor_id;
    public $parametro;
    public $valor;
    public $valor_min;
    public $valor_max;
    public $estado = 'advertencia';
    public $mensaje;
    public $fecha_hora;

    public $modal = false;

    public function mount()
    {
        $this->recargarDatos();
    }

    public function recargarDatos()
    {
        $this->alertas = Alerta::with(['cultivo', 'sensor'])->get();
        $this->cultivos = Cultivo::all();
        $this->sensores = Sensor::all();
    }

    public function abrirCrear()
    {
        $this->resetForm();
        $this->modal = true;
    }

    public function abrirEditar($id)
    {
        $a = Alerta::findOrFail($id);

        $this->alerta_id = $a->id;
        $this->cultivo_id = $a->cultivo_id;
        $this->sensor_id = $a->sensor_id;
        $this->parametro = $a->parametro;
        $this->valor = $a->valor;
        $this->valor_min = $a->valor_min;
        $this->valor_max = $a->valor_max;
        $this->estado = $a->estado;
        $this->mensaje = $a->mensaje;
        $this->fecha_hora = $a->fecha_hora;

        $this->modal = true;
    }

    public function guardar()
    {
        $this->validate([
            'cultivo_id' => 'required',
            'sensor_id' => 'required',
            'parametro' => 'required',
            'valor' => 'required|numeric',
            'valor_min' => 'required|numeric',
            'valor_max' => 'required|numeric',
            'fecha_hora' => 'required',
        ]);

        Alerta::updateOrCreate(
            ['id' => $this->alerta_id],
            [
                'cultivo_id' => $this->cultivo_id,
                'sensor_id' => $this->sensor_id,
                'parametro' => $this->parametro,
                'valor' => $this->valor,
                'valor_min' => $this->valor_min,
                'valor_max' => $this->valor_max,
                'estado' => $this->estado,
                'mensaje' => $this->mensaje,
                'fecha_hora' => $this->fecha_hora,
            ]
        );

        $this->modal = false;
        $this->resetForm();
        $this->recargarDatos();
    }

    public function eliminar($id)
    {
        Alerta::findOrFail($id)->delete();
        $this->recargarDatos();
    }

    public function resetForm()
    {
        $this->alerta_id = null;
        $this->cultivo_id = '';
        $this->sensor_id = '';
        $this->parametro = '';
        $this->valor = '';
        $this->valor_min = '';
        $this->valor_max = '';
        $this->estado = 'advertencia';
        $this->mensaje = '';
        $this->fecha_hora = '';
    }

    public function render()
    {
        return view('livewire.dashboard.alertas');
    }
}