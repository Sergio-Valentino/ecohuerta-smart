<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('localidades', function (Blueprint $table) {
            $table->id();

            // Nombre de la localidad
            $table->string('nombre');

            // Relación con tabla region
            $table->unsignedBigInteger('region_id')->nullable();

            // Datos opcionales
            $table->string('codigo_postal')->nullable();
            $table->text('descripcion')->nullable();

            $table->timestamps();

            // Foreign Key
            $table->foreign('region_id')
                ->references('id')->on('region')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('localidades');
    }
};
