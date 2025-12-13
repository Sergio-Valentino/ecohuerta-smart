<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Productor extends Model
{
    protected $table = 'productores';

    protected $fillable = [
        'users_id',
        'nombre_finca',
        'telefono',
        'region_id',
        'localidades_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'localidades_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}