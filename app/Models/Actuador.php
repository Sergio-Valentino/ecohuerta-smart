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
        'pin',
        'activo'
    ];

    public function litrosAgua()
    {
        return $this->hasMany(LitroAgua::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function logsAcciones()
    {
        return $this->hasMany(LogAccion::class);
    }
}