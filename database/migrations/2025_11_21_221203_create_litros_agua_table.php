<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('litros_agua', function (Blueprint $table) {
            $table->id();

            // Relaciones principales
            $table->unsignedBigInteger('cultivo_id')->nullable();
            $table->unsignedBigInteger('actuador_id')->nullable();

            // Datos del riego
            $table->dateTime('fecha_riego');
            $table->float('litros_aplicados')->nullable();
            $table->float('litros_recomendados')->nullable();
            $table->float('diferencia')->nullable(); // aplicado - recomendado

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
        Schema::dropIfExists('litros_agua');
    }
};
