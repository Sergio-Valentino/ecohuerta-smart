<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lecturas', function (Blueprint $table) {
            $table->id();

            // Relaciones principales
            $table->unsignedBigInteger('sensor_id')->nullable();
            $table->unsignedBigInteger('cultivo_id')->nullable();

            // Datos de la lectura
            $table->float('valor');                     // valor numérico de la lectura
            $table->string('unidad')->nullable();       // %, °C, lx, L/min, etc.
            $table->string('tipo_lectura');             // humedad_suelo, temp_aire...

            // Momento exacto de la medición
            $table->dateTime('fecha_hora');

            $table->timestamps();

            // Foreign Keys
            $table->foreign('sensor_id')
                  ->references('id')->on('sensores')
                  ->onDelete('set null');

            $table->foreign('cultivo_id')
                  ->references('id')->on('cultivos')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lecturas');
    }
};