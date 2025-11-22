<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipo_suelo', function (Blueprint $table) {
            $table->id();

            // Nombre del tipo de suelo (arcilloso, arenoso, franco...)
            $table->string('nombre');

            // Capacidad de campo (CC) - % de agua retenida tras drenaje
            $table->float('capacidad_campo')->nullable();

            // Punto de marchitez permanente (PMP)
            $table->float('punto_marchitez')->nullable();

            // Densidad aparente del suelo (g/cm³)
            $table->float('densidad_aparente')->nullable();

            // Velocidad de infiltración (mm/h)
            $table->float('infiltracion')->nullable();

            // Descripción general del suelo
            $table->text('descripcion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipo_suelo');
    }
};
