<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clima', function (Blueprint $table) {
            $table->id();

            // Relaciones principales
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('estacion_id')->nullable();

            // Fecha del registro climático
            $table->date('fecha');

            // Datos climáticos
            $table->float('temperatura_max')->nullable();
            $table->float('temperatura_min')->nullable();
            $table->float('humedad_relativa')->nullable();
            $table->float('velocidad_viento')->nullable(); // m/s
            $table->float('radiacion_solar')->nullable();  // W/m2
            $table->float('precipitacion')->nullable();    // mm
            $table->float('eto_diaria')->nullable();       // evapotranspiración diaria

            $table->timestamps();

            // Foreign Keys
            $table->foreign('region_id')
                  ->references('id')->on('region')
                  ->onDelete('set null');

            $table->foreign('estacion_id')
                  ->references('id')->on('estaciones')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clima');
    }
};