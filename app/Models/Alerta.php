<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alerta extends Model
{
    use HasFactory;

    protected $table = 'alertas';

    protected $fillable = [
        'sensor_id',
        'cultivo_id',
        'tipo',
        'mensaje',
        'leido'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }
}
