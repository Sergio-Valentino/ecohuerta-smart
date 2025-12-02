<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    use HasFactory;

    protected $table = 'alertas';

    protected $fillable = [
        'cultivo_id',
        'sensor_id',
        'parametro',
        'valor',
        'valor_min',
        'valor_max',
        'estado',
        'mensaje',
        'fecha_hora'
    ];

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}