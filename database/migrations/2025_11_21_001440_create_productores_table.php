<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productores', function (Blueprint $table) {
            $table->id();

            // Relación con usuarios del sistema (opcional)
            $table->unsignedBigInteger('usuario_id')->nullable();

            // Relación con regiones
            $table->unsignedBigInteger('region_id')->nullable();

            // Relación con localidades
            $table->unsignedBigInteger('localidad_id')->nullable();

            // Información del productor
            $table->string('nombre_finca')->nullable();
            $table->string('telefono')->nullable();

            $table->timestamps();

            // Foreign Keys
            $table->foreign('usuario_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            $table->foreign('region_id')
                  ->references('id')->on('region')
                  ->onDelete('set null');

            $table->foreign('localidad_id')
                  ->references('id')->on('localidades')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productores');
    }
};