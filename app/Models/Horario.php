<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    protected $fillable = [
        'cultivo_id',
        'actuador_id',
        'hora',
        'activo'
    ];

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }

    public function actuador()
    {
        return $this->belongsTo(Actuador::class);
    }
}
