<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Productor;
use App\Models\Localidad;
use App\Models\Region;

#[Layout('layouts.app')]
class Productores extends Component
{
    public $productores, $localidades, $regiones;

    public $productor_id, $nombre_finca, $telefono, $region_id, $localidades_id;

    public $modal = false;

    public function mount()
    {
        $this->recargarDatos();
    }

    public function recargarDatos()
    {
        $this->productores = Productor::with(['localidad', 'region'])->get();
        $this->localidades = Localidad::all();
        $this->regiones = Region::all();
    }

    public function abrirCrear()
    {
        $this->resetForm();
        $this->modal = true;
    }

    public function abrirEditar($id)
    {
        $p = Productor::findOrFail($id);

        $this->productor_id = $p->id;
        $this->nombre_finca = $p->nombre_finca;
        $this->telefono = $p->telefono;
        $this->region_id = $p->region_id;
        $this->localidades_id = $p->localidades_id;

        $this->modal = true;
    }

    public function guardar()
    {
        $this->validate([
            'nombre_finca' => 'required|min:3',
            'region_id' => 'required',
            'localidades_id' => 'required',
        ]);

        Productor::updateOrCreate(
            ['id' => $this->productor_id],
            [
                'nombre_finca' => $this->nombre_finca,
                'telefono' => $this->telefono,
                'region_id' => $this->region_id,
                'localidades_id' => $this->localidades_id,
            ]
        );

        $this->recargarDatos();
        $this->modal = false;
        $this->resetForm();
    }

    public function eliminar($id)
    {
        Productor::findOrFail($id)->delete();
        $this->recargarDatos();
    }

    public function resetForm()
    {
        $this->productor_id = null;
        $this->nombre_finca = '';
        $this->telefono = '';
        $this->region_id = '';
        $this->localidades_id = '';
    }

    public function render()
    {
        return view('livewire.dashboard.productores');
    }
}