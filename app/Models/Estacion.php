<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estacion extends Model
{
    use HasFactory;

    protected $table = 'estaciones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'temp_promedio',
        'humedad_promedio',
        'lluvia_promedio'
    ];

    public function climas()
    {
        return $this->hasMany(Clima::class);
    }

    public function cultivos()
    {
        return $this->hasMany(Cultivo::class);
    }
}
