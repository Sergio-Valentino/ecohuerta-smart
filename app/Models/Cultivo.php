<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cultivo extends Model
{
    use HasFactory;

    protected $table = 'cultivos';

    protected $fillable = [
        'productor_id',
        'tipo_suelo_id',
        'metodo_riego_id',
        'tipo_siembra_id',
        'tipo_fuente_agua_id',
        'etapa_planta_id',
        'estacion_id',
        'region_id',
        'nombre_cultivo',
        'fecha_siembra',
        'area_m2',
        'densidad_siembra',
        'profundidad_siembra',
        'umbral_marchitez'
    ];

    /* =========================
       Relaciones
    ========================= */

    public function productor()
    {
        return $this->belongsTo(Productor::class, 'productor_id');
    }

    public function tipoSuelo()
    {
        return $this->belongsTo(TipoSuelo::class, 'tipo_suelo_id');
    }

    public function metodoRiego()
    {
        return $this->belongsTo(MetodoRiego::class, 'metodo_riego_id');
    }

    public function tipoSiembra()
    {
        return $this->belongsTo(TipoSiembra::class, 'tipo_siembra_id');
    }

    public function tipoFuenteAgua()
    {
        return $this->belongsTo(TipoFuenteAgua::class, 'tipo_fuente_agua_id');
    }

    public function etapaPlanta()
    {
        return $this->belongsTo(EtapaPlanta::class, 'etapa_planta_id');
    }

    public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'estacion_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    /* =========================
       Relaciones funcionales
    ========================= */

    public function umbrales()
    {
        return $this->hasMany(Umbral::class, 'cultivo_id');
    }

    public function lecturas()
    {
        return $this->hasMany(Lectura::class, 'cultivo_id');
    }

    public function alertas()
    {
        return $this->hasMany(Alerta::class, 'cultivo_id');
    }

    /* =========================
       Relaciones MANY TO MANY
    ========================= */

    public function sensores()
    {
        return $this->belongsToMany(
            Sensor::class,
            'sensor_cultivo',
            'cultivo_id',
            'sensor_id'
        );
    }

    public function actuadores()
    {
        return $this->belongsToMany(
            Actuador::class,
            'actuador_cultivo',
            'cultivo_id',
            'actuador_id'
        );
    }
}