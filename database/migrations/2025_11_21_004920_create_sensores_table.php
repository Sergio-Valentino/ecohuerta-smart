<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sensores', function (Blueprint $table) {
            $table->id();

            // Información del sensor
            $table->string('nombre');
            $table->string('tipo');              // humedad, temperatura, luz, caudal...
            $table->string('ubicacion')->nullable();
            $table->string('modelo')->nullable();

            // Estado del sensor
            $table->boolean('activo')->default(true);

            // Relación con usuarios y cultivos
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->unsignedBigInteger('cultivo_id')->nullable();

            $table->timestamps();

            // Foreign Keys
            $table->foreign('usuario_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            $table->foreign('cultivo_id')
                  ->references('id')->on('cultivos')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensores');
    }
};
