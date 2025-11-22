<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipo_fuente_agua', function (Blueprint $table) {
            $table->id();

            // Nombre de la fuente de agua (pozo, tanque, río, cisterna...)
            $table->string('nombre');

            // Descripción opcional
            $table->text('descripcion')->nullable();

            // Parámetros opcionales pero útiles para el sistema
            $table->string('calidad_agua')->nullable();   // buena, regular, mala...
            $table->float('caudal_disponible')->nullable(); // litros/min

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipo_fuente_agua');
    }
};