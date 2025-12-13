<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'cultivos_id',
        'sensores_id',
        'actuadores_id',
        'hora_inicio',
        'hora_fin',
        'frecuencia',
        'dias_semana',
        'activo',
    ];

    // Relaciones correctas según los nombres de columnas
    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class, 'cultivos_id');
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class, 'sensores_id');
    }

    public function actuador()
    {
        return $this->belongsTo(Actuador::class, 'actuadores_id');
    }
}