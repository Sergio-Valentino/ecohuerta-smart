<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoSiembra extends Model
{
    use HasFactory;

    protected $table = 'tipo_siembra';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function cultivos()
    {
        return $this->hasMany(Cultivo::class);
    }
}
