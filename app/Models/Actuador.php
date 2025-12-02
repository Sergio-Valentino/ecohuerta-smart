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
        'cultivo_id',
    ];

    // Relación con Cultivo
    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }
}