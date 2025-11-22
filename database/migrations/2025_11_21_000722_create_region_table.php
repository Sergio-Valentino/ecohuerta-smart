<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('region', function (Blueprint $table) {
        $table->id();
        $table->string('nombre'); // Norte, Centro, Oeste
        $table->string('codigo')->nullable();
        $table->string('descripcion')->nullable();
        $table->float('eto_promedio')->nullable();
        $table->string('zona_climatica')->nullable();
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('region');
    }
};
