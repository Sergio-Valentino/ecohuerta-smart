<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LitrosAgua extends Model
{
    use HasFactory;

    protected $table = 'litros_agua';

    protected $fillable = [
        'cultivo_id',
        'actuador_id',
        'fecha_riego',
        'litros_aplicados',
        'litros_recomendados',
        'diferencia',
    ];

    // Relaciones opcionales (por si luego querés usarlas)
    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }

    public function actuador()
    {
        return $this->belongsTo(Actuador::class);
    }
}
