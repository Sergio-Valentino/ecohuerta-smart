<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory;

    protected $table = 'region';

    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo',
        'eto_promedio',
        'zona_climatica'
    ];

    public function localidades()
    {
        return $this->hasMany(Localidad::class);
    }

    public function productores()
    {
        return $this->hasMany(Productor::class);
    }

    public function climas()
    {
        return $this->hasMany(Clima::class);
    }

    public function cultivos()
    {
        return $this->hasMany(Cultivo::class);
    }
}
