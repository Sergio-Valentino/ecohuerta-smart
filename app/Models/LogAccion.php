<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogAccion extends Model
{
    use HasFactory;

    protected $table = 'logs_acciones';

    protected $fillable = [
        'user_id',
        'cultivo_id',
        'actuador_id',
        'accion'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }

    public function actuador()
    {
        return $this->belongsTo(Actuador::class);
    }
}
