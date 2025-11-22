<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Localidad extends Model
{
    use HasFactory;

    protected $table = 'localidades';

    protected $fillable = [
        'nombre',
        'region_id'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function productores()
    {
        return $this->hasMany(Productor::class);
    }
}
