<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clima extends Model
{
    use HasFactory;

    protected $table = 'clima';

    protected $fillable = [
        'region_id',
        'estaciones_id',
        'fecha',
        'temperatura_max',
        'temperatura_min',
        'humedad_relativa',
        'velocidad_viento',
        'radiacion_solar',
        'precipitacion',
        'eto_diaria',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'estaciones_id');
    }
}