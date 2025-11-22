<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cultivos', function (Blueprint $table) {
            $table->id();

            // Relaciones principales
            $table->unsignedBigInteger('productor_id')->nullable();
            $table->unsignedBigInteger('tipo_suelo_id')->nullable();
            $table->unsignedBigInteger('metodo_riego_id')->nullable();
            $table->unsignedBigInteger('tipo_siembra_id')->nullable();
            $table->unsignedBigInteger('tipo_fuente_agua_id')->nullable();
            $table->unsignedBigInteger('etapa_planta_id')->nullable();
            $table->unsignedBigInteger('estacion_id')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();

            // Campos propios del cultivo
            $table->string('nombre_cultivo');
            $table->date('fecha_siembra')->nullable();
            $table->float('area_m2')->nullable();
            $table->integer('densidad_siembra')->nullable(); // plantas por metro cuadrado
            $table->float('profundidad_siembra')->nullable(); // cm
            $table->float('umbral_marchitez')->nullable(); // punto crítico de humedad

            $table->timestamps();

            // Foreign keys
            $table->foreign('productor_id')
                ->references('id')->on('productores')
                ->onDelete('set null');

            $table->foreign('tipo_suelo_id')
                ->references('id')->on('tipo_suelo')
                ->onDelete('set null');

            $table->foreign('metodo_riego_id')
                ->references('id')->on('metodo_riego')
                ->onDelete('set null');

            $table->foreign('tipo_siembra_id')
                ->references('id')->on('tipo_siembra')
                ->onDelete('set null');

            $table->foreign('tipo_fuente_agua_id')
                ->references('id')->on('tipo_fuente_agua')
                ->onDelete('set null');

            $table->foreign('etapa_planta_id')
                ->references('id')->on('etapa_planta')
                ->onDelete('set null');

            $table->foreign('estacion_id')
                ->references('id')->on('estacion')
                ->onDelete('set null');

            $table->foreign('region_id')
                ->references('id')->on('region')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cultivos');
    }
};