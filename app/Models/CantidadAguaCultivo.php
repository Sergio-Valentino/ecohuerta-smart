<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CantidadAguaCultivo extends Model
{
    use HasFactory;

    protected $table = 'cantidad_agua_cultivo';

    protected $fillable = [
        'cultivo_id',
        'etapa_planta_id',
        'mm_dia'
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
