<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alertas', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->unsignedBigInteger('cultivo_id')->nullable();
            $table->unsignedBigInteger('sensor_id')->nullable();

            // Datos de la alerta
            $table->string('parametro');       // humedad_suelo, temp_aire, etc.
            $table->float('valor')->nullable();
            $table->float('valor_min')->nullable();
            $table->float('valor_max')->nullable();
            $table->string('estado')->default('activa'); // activa, resuelta
            $table->text('mensaje')->nullable();

            // Momento exacto del evento
            $table->dateTime('fecha_hora');

            $table->timestamps();

            // Foreign Keys
            $table->foreign('cultivo_id')
                ->references('id')->on('cultivos')
                ->onDelete('set null');

            $table->foreign('sensor_id')
                ->references('id')->on('sensores')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alertas');
    }
};