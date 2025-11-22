<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productor extends Model
{
    use HasFactory;

    protected $table = 'productores';

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'telefono',
        'localidad_id',
        'region_id'
    ];

    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function cultivos()
    {
        return $this->hasMany(Cultivo::class);
    }
}
