<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoFuenteAgua extends Model
{
    use HasFactory;

    protected $table = 'tipo_fuente_agua';

    protected $fillable = [
        'nombre',
        'descripcion',
        'calidad',
        'caudal'
    ];

    public function cultivos()
    {
        return $this->hasMany(Cultivo::class);
    }
}