<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Umbral extends Model
{
    use HasFactory;

    protected $table = 'umbrales';

    protected $fillable = [
        'cultivo_id',
        'etapa_planta_id',
        'humedad_min',
        'humedad_max',
        'temperatura_min',
        'temperatura_max'
    ];

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }

    public function etapaPlanta()
    {
        return $this->belongsTo(EtapaPlanta::class);
    }
}
