<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = [
        'user_id',
        'cultivo_id',
        'alerta_id',
        'mensaje',
        'leido'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }

    public function alerta()
    {
        return $this->belongsTo(Alerta::class);
    }
}
