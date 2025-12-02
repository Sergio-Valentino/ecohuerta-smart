<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    // 👈 Nombre REAL de la tabla en la BD
    protected $table = 'notificaciones';

    protected $fillable = [
        'usuario_id',
        'cultivo_id',
        'tipo',
        'titulo',
        'mensaje',
        'leida',
        'fecha_envio',
    ];

    // Relaciones (opcionales pero recomendadas)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class, 'cultivo_id');
    }
}