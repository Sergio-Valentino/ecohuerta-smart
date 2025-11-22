<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umbrales', function (Blueprint $table) {
            $table->id();

            // Relaciones principales
            $table->unsignedBigInteger('cultivo_id')->nullable();
            $table->unsignedBigInteger('etapa_planta_id')->nullable();

            // Tipo de parámetro monitoreado: humedad_suelo, temp_aire, caudal...
            $table->string('parametro');

            // Valores límites
            $table->float('valor_min')->nullable();
            $table->float('valor_max')->nullable();
            $table->float('valor_optimo')->nullable();

            // Control de activación/desactivación
            $table->boolean('activo')->default(true);

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
        Schema::dropIfExists('umbrales');
    }
};