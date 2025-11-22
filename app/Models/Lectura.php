<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lectura extends Model
{
    use HasFactory;

    protected $table = 'lecturas';

    protected $fillable = [
        'sensor_id',
        'valor',
        'fecha'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}