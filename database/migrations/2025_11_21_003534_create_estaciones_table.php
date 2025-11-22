<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estaciones', function (Blueprint $table) {
            $table->id();

            // Nombre de la estación (Verano, Otoño, Invierno, Primavera)
            $table->string('nombre');

            // Rango de meses
            $table->integer('mes_inicio')->nullable(); // Ejemplo: 12 = diciembre
            $table->integer('mes_fin')->nullable();    // Ejemplo: 2 = febrero

            // Factores estacionales para el cálculo de ETc
            $table->float('factor_estacional')->nullable();
            $table->float('temperatura_promedio')->nullable();
            $table->float('humedad_relativa')->nullable();

            // Descripción general
            $table->text('descripcion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estaciones');
    }
};
