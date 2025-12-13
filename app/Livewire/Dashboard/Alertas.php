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
    // ====== Formulario ======
    public $alerta_id;
    public $cultivo_id;
    public $sensor_id;
    public $parametro;
    public $valor;
    public $valor_min;
    public $valor_max;
    public $estado;
    public $mensaje;
    public $fecha_hora;

    public $modal = false;

    // ====== Abrir modal crear ======
    public function abrirCrear()
    {
        $this->resetForm();
        $this->modal = true;
    }

    // ====== Abrir modal editar ======
    public function abrirEditar($id)
    {
        $a = Alerta::findOrFail($id);

        $this->alerta_id  = $a->id;
        $this->cultivo_id = $a->cultivo_id;
        $this->sensor_id  = $a->sensor_id;
        $this->parametro  = $a->parametro;
        $this->valor      = $a->valor;
        $this->valor_min  = $a->valor_min;
        $this->valor_max  = $a->valor_max;
        $this->estado     = $a->estado;
        $this->mensaje    = $a->mensaje;

        // Formato correcto para datetime-local
        $this->fecha_hora = $a->fecha_hora
            ? $a->fecha_hora->format('Y-m-d\TH:i')
            : null;

        $this->modal = true;
    }

    // ====== Guardar ======
    public function guardar()
    {
        $this->validate([
            'cultivo_id' => 'required|exists:cultivos,id',
            'sensor_id'  => 'required|exists:sensores,id',
            'parametro'  => 'required|string',
            'valor'      => 'required|numeric',
            'valor_min'  => 'required|numeric',
            'valor_max'  => 'required|numeric',
            'fecha_hora' => 'required',
        ]);

        // Estado automático (lógica simple)
        if ($this->valor < $this->valor_min || $this->valor > $this->valor_max) {
            $this->estado  = 'advertencia';
            $this->mensaje = $this->mensaje ?: 'Valor fuera de los límites configurados.';
        } else {
            $this->estado  = 'normal';
            $this->mensaje = $this->mensaje ?: 'Valor dentro del rango permitido.';
        }

        Alerta::updateOrCreate(
            ['id' => $this->alerta_id],
            [
                'cultivo_id' => $this->cultivo_id,
                'sensor_id'  => $this->sensor_id,
                'parametro'  => $this->parametro,
                'valor'      => $this->valor,
                'valor_min'  => $this->valor_min,
                'valor_max'  => $this->valor_max,
                'estado'     => $this->estado,
                'mensaje'    => $this->mensaje,
                'fecha_hora' => $this->fecha_hora,
            ]
        );

        $this->modal = false;
        $this->resetForm();
    }

    // ====== Eliminar ======
    public function eliminar($id)
    {
        Alerta::findOrFail($id)->delete();
    }

    // ====== Reset formulario ======
    public function resetForm()
    {
        $this->alerta_id  = null;
        $this->cultivo_id = null;
        $this->sensor_id  = null;
        $this->parametro  = null;
        $this->valor      = null;
        $this->valor_min  = null;
        $this->valor_max  = null;
        $this->estado     = null;
        $this->mensaje    = null;
        $this->fecha_hora = null;
    }

    // ====== Render ======
    public function render()
    {
        return view('livewire.dashboard.alertas', [
            'alertas'  => Alerta::with(['cultivo', 'sensor'])->orderBy('fecha_hora', 'desc')->get(),
            'cultivos' => Cultivo::all(),
            'sensores' => Sensor::all(),
        ]);
    }
}