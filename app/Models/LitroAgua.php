<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LitroAgua extends Model
{
    use HasFactory;

    protected $table = 'litros_agua';

    protected $fillable = [
        'cultivo_id',
        'actuador_id',
        'litros'
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
