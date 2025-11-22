<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConfiguracionSistema extends Model
{
    use HasFactory;

    protected $table = 'configuracion_sistema';

    protected $fillable = [
        'clave',
        'valor'
    ];
}
