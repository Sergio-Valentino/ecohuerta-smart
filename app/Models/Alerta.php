<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected $casts = [
        'valor'      => 'float',
        'valor_min'  => 'float',
        'valor_max'  => 'float',
        'fecha_hora' => 'datetime',
    ];

    /* =========================
       Relaciones
    ========================= */

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class, 'cultivo_id');
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class, 'sensor_id');
    }
}