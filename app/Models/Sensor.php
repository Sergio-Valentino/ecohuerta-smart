<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sensor extends Model
{
    use HasFactory;

    protected $table = 'sensores';

    protected $fillable = [
        'nombre',
        'tipo',
        'modelo',
        'descripcion',
        'pin',
        'activo'
    ];

    public function lecturas()
    {
        return $this->hasMany(Lectura::class);
    }

    public function alertas()
    {
        return $this->hasMany(Alerta::class);
    }
}
