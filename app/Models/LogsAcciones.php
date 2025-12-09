<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogsAcciones extends Model
{
    use HasFactory;

    protected $table = 'logs_acciones';

    protected $fillable = [
        'usuario_id',
        'cultivo_id',
        'accion',
        'descripcion',
        'nivel',
        'fecha_hora'
    ];

    public $timestamps = true;

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    // RELACIÓN: un log pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // RELACIÓN: un log pertenece a un cultivo
    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class, 'cultivo_id');
    }
}