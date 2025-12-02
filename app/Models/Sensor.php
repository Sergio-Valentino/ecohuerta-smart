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
        'usuario_id',
        'cultivo_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class, 'cultivo_id');
    }
}
