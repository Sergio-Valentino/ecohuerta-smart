<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoRiego extends Model
{
    use HasFactory;

    protected $table = 'tipos_riego';

    protected $fillable = [
        'nombre',
        'descripcion',
        'eficiencia'
    ];

    public function cultivos()
    {
        return $this->hasMany(Cultivo::class, 'metodo_riego_id');
    }
}
