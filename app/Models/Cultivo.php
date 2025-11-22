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

    public function productor()
    {
        return $this->belongsTo(Productor::class);
    }

    public function tipoSuelo()
    {
        return $this->belongsTo(TipoSuelo::class);
    }

    public function tipoRiego()
    {
        return $this->belongsTo(TipoRiego::class, 'metodo_riego_id');
    }

    public function tipoSiembra()
    {
        return $this->belongsTo(TipoSiembra::class);
    }

    public function tipoFuenteAgua()
    {
        return $this->belongsTo(TipoFuenteAgua::class);
    }

    public function etapaPlanta()
    {
        return $this->belongsTo(EtapaPlanta::class);
    }

    public function estacion()
    {
        return $this->belongsTo(Estacion::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function umbrales()
    {
        return $this->hasMany(Umbral::class);
    }

    public function lecturas()
    {
        return $this->hasMany(Lectura::class);
    }

    public function cantidadAguaCultivo()
    {
        return $this->hasMany(CantidadAguaCultivo::class);
    }

    public function litrosAgua()
    {
        return $this->hasMany(LitroAgua::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
