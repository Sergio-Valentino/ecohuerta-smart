<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productor extends Model
{
    protected $table = 'productores';

    protected $fillable = [
        'usuario_id',
        'nombre_finca',
        'telefono',
        'region_id',
        'localidad_id'
    ];

    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}