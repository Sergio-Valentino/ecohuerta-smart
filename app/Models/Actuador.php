<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Actuador extends Model
{
    use HasFactory;

    protected $table = 'actuadores';

    protected $fillable = [
        'nombre',
        'tipo',
        'ubicacion',
        'activo',
    ];

    /**
     * Relación Muchos a Muchos con Cultivo
     * Tabla pivote: actuador_cultivo
     */
    public function cultivos()
    {
        return $this->belongsToMany(Cultivo::class, 'actuador_cultivo');
    }
}