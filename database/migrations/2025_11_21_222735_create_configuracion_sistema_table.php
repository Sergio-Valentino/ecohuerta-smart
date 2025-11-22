<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion_sistema', function (Blueprint $table) {
            $table->id();

            // Clave del parámetro
            $table->string('clave');    // Ej: modo_riego, email_sistema, tiempo_espera, etc.

            // Valor del parámetro
            $table->string('valor')->nullable();

            // Descripción del parámetro
            $table->string('descripcion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_sistema');
    }
};
