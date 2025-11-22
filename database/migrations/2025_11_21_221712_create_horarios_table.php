<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();

            // Relaciones principales
            $table->unsignedBigInteger('cultivo_id')->nullable();
            $table->unsignedBigInteger('actuador_id')->nullable();

            // Programación del riego
            $table->time('hora_inicio');
            $table->time('hora_fin')->nullable();

            // Frecuencia del riego
            $table->string('frecuencia')->nullable(); // diaria, semanal, manual, etc.

            // Días de la semana (solo si es semanal)
            $table->string('dias_semana')->nullable(); // "L,M,X,J,V,S,D"

            // Control de activación
            $table->boolean('activo')->default(true);

            $table->timestamps();

            // Foreign Keys
            $table->foreign('cultivo_id')
                ->references('id')->on('cultivos')
                ->onDelete('set null');

            $table->foreign('actuador_id')
                ->references('id')->on('actuadores')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};