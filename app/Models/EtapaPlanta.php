<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EtapaPlanta extends Model
{
    use HasFactory;

    protected $table = 'etapa_planta';

    protected $fillable = [
        'nombre',
        'descripcion',
        'dias_estimados',
        'kc'
    ];

    public function umbrales()
    {
        return $this->hasMany(Umbral::class);
    }

    public function cantidadAguaCultivo()
    {
        return $this->hasMany(CantidadAguaCultivo::class);
    }
}
