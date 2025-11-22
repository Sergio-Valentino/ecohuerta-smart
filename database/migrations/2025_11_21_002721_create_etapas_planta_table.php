<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etapa_planta', function (Blueprint $table) {
            $table->id();

            // Nombre de la etapa: siembra, crecimiento, floración, etc.
            $table->string('nombre');

            // Duración estimada en días
            $table->integer('dias_duracion')->nullable();

            // Coeficientes Kc según FAO56
            $table->float('kc_inicial')->nullable();
            $table->float('kc_desarrollo')->nullable();
            $table->float('kc_media')->nullable();
            $table->float('kc_maduracion')->nullable();

            // Factor de estrés hídrico
            $table->float('factor_estres')->nullable();

            // Descripción general
            $table->text('descripcion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etapa_planta');
    }
};