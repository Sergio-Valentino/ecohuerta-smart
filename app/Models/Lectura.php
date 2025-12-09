<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lectura extends Model
{
    use HasFactory;

    // Nombre real de la tabla
    protected $table = 'lecturas';

    // Campos que se pueden cargar masivamente
    protected $fillable = [
        'sensor_id',
        'cultivo_id',
        'valor',
        'unidad',
        'tipo_lectura',
        'fecha_hora',
    ];

    // Relaciones
    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }
}