<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'cultivo_id',
        'sensor_id',
        'actuador_id',
        'hora_inicio',
        'hora_fin',
        'frecuencia',
        'dias_semana',
        'activo',
    ];

    // Relaciones
    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

    public function actuador()
    {
        return $this->belongsTo(Actuador::class);
    }
}