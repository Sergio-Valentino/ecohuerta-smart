<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clima extends Model
{
    use HasFactory;

    protected $table = 'clima';

    protected $fillable = [
        'region_id',
        'estacion_id',
        'temperatura',
        'humedad',
        'lluvia'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function estacion()
    {
        return $this->belongsTo(Estacion::class);
    }
}