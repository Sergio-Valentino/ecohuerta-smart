<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoSuelo extends Model
{
    use HasFactory;

    protected $table = 'tipo_suelo';

    protected $fillable = [
        'nombre',
        'capacidad_campo',
        'punto_marchitez',
        'densidad_aparente',
        'infiltracion',
        'descripcion'
    ];

    public function cultivos()
    {
        return $this->hasMany(Cultivo::class);
    }
}
