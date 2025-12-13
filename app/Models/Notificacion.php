<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = [
        'users_id',
        'cultivos_id',
        'tipo',
        'titulo',
        'mensaje',
        'leida',
        'fecha_envio',
    ];

    protected $casts = [
        'leida'       => 'boolean',
        'fecha_envio' => 'datetime',
    ];

    // =========================
    // Relaciones
    // =========================

    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class, 'cultivos_id');
    }
}