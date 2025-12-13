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
        'ubicacion',
        'modelo',
        'activo',
        'users_id',
    ];

    /* =========================
       Relaciones
    ========================= */

    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function cultivos()
    {
        return $this->belongsToMany(
            Cultivo::class,
            'sensor_cultivo',
            'sensor_id',
            'cultivo_id'
        );
    }

    public function lecturas()
    {
        return $this->hasMany(Lectura::class, 'sensor_id');
    }

    public function alertas()
    {
        return $this->hasMany(Alerta::class, 'sensor_id');
    }
}

