<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Cultivo;
use App\Models\Productor;
use App\Models\TipoSuelo;
use App\Models\MetodoRiego;
use App\Models\TipoSiembra;
use App\Models\TipoFuenteAgua;
use App\Models\EtapaPlanta;
use App\Models\Estacion;
use App\Models\Region;

#[Layout('layouts.app')]
class Cultivos extends Component
{
    public $cultivos, $productores, $tipos_suelo, $metodos_riego, 
           $tipos_siembra, $tipos_fuente_agua, $etapas_planta, 
           $estaciones, $regiones;

    public $cultivo_id, $productor_id, $tipo_suelo_id, $metodo_riego_id,
           $tipo_siembra_id, $tipo_fuente_agua_id, $etapa_planta_id,
           $estacion_id, $region_id, $nombre_cultivo, $fecha_siembra,
           $area_m2, $densidad_siembra, $profundidad_siembra,
           $umbral_marchitez;

    public $modal = false;

    public function mount()
    {
        $this->recargarDatos();
    }

    public function recargarDatos()
    {
        $this->cultivos = Cultivo::all();
        $this->productores = Productor::all();
        $this->tipos_suelo = TipoSuelo::all();
        $this->metodos_riego = MetodoRiego::all();
        $this->tipos_siembra = TipoSiembra::all();
        $this->tipos_fuente_agua = TipoFuenteAgua::all();
        $this->etapas_planta = EtapaPlanta::all();
        $this->estaciones = Estacion::all();
        $this->regiones = Region::all();
    }

    public function abrirCrear()
    {
        $this->resetForm();
        $this->modal = true;
    }

    public function abrirEditar($id)
    {
        $c = Cultivo::findOrFail($id);

        $this->cultivo_id = $c->id;
        $this->productor_id = $c->productor_id;
        $this->tipo_suelo_id = $c->tipo_suelo_id;
        $this->metodo_riego_id = $c->metodo_riego_id;
        $this->tipo_siembra_id = $c->tipo_siembra_id;
        $this->tipo_fuente_agua_id = $c->tipo_fuente_agua_id;
        $this->etapa_planta_id = $c->etapa_planta_id;
        $this->estacion_id = $c->estacion_id;
        $this->region_id = $c->region_id;
        $this->nombre_cultivo = $c->nombre_cultivo;
        $this->fecha_siembra = $c->fecha_siembra;
        $this->area_m2 = $c->area_m2;
        $this->densidad_siembra = $c->densidad_siembra;
        $this->profundidad_siembra = $c->profundidad_siembra;
        $this->umbral_marchitez = $c->umbral_marchitez;

        $this->modal = true;
    }

    public function guardar()
    {
        Cultivo::updateOrCreate(
            ['id' => $this->cultivo_id],
            [
                'productor_id' => $this->productor_id,
                'tipo_suelo_id' => $this->tipo_suelo_id,
                'metodo_riego_id' => $this->metodo_riego_id,
                'tipo_siembra_id' => $this->tipo_siembra_id,
                'tipo_fuente_agua_id' => $this->tipo_fuente_agua_id,
                'etapa_planta_id' => $this->etapa_planta_id,
                'estacion_id' => $this->estacion_id,
                'region_id' => $this->region_id,
                'nombre_cultivo' => $this->nombre_cultivo,
                'fecha_siembra' => $this->fecha_siembra,
                'area_m2' => $this->area_m2,
                'densidad_siembra' => $this->densidad_siembra,
                'profundidad_siembra' => $this->profundidad_siembra,
                'umbral_marchitez' => $this->umbral_marchitez,
            ]
        );

        $this->recargarDatos();
        $this->modal = false;
        $this->resetForm();
    }

    public function eliminar($id)
    {
        Cultivo::findOrFail($id)->delete();
        $this->recargarDatos();
    }

    public function resetForm()
    {
        $this->cultivo_id = null;
        $this->productor_id = '';
        $this->tipo_suelo_id = '';
        $this->metodo_riego_id = '';
        $this->tipo_siembra_id = '';
        $this->tipo_fuente_agua_id = '';
        $this->etapa_planta_id = '';
        $this->estacion_id = '';
        $this->region_id = '';
        $this->nombre_cultivo = '';
        $this->fecha_siembra = '';
        $this->area_m2 = '';
        $this->densidad_siembra = '';
        $this->profundidad_siembra = '';
        $this->umbral_marchitez = '';
    }

    public function render()
    {
        return view('livewire.dashboard.cultivos');
    }
}