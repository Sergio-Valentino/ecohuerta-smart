<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cantidad_agua_cultivo', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->unsignedBigInteger('cultivo_id')->nullable();
            $table->unsignedBigInteger('etapa_planta_id')->nullable();

            // Datos de consumo de agua
            $table->float('litros_por_riego')->nullable();   // litros aplicados por cada riego
            $table->integer('riegos_por_dia')->nullable();   // cantidad de riegos diarios
            $table->float('agua_total_diaria')->nullable();  // litros totales por día

            $table->timestamps();

            // Foreign Keys
            $table->foreign('cultivo_id')
                  ->references('id')->on('cultivos')
                  ->onDelete('set null');

            $table->foreign('etapa_planta_id')
                  ->references('id')->on('etapa_planta')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cantidad_agua_cultivo');
    }
};
