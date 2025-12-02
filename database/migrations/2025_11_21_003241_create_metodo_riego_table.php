<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipos_riego', function (Blueprint $table) {
            $table->id();

            // Nombre del método (goteo, aspersión, manual)
            $table->string('nombre');

            // Eficiencia del sistema (%)
            $table->float('eficiencia')->nullable();

            // Uniformidad del riego (%)
            $table->float('uniformidad')->nullable();

            // Descripción opcional
            $table->text('descripcion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos_riego');
    }
};