<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('sensor_cultivo', function (Blueprint $table) {
        $table->id();

        // Foreign keys reales de tus tablas
        $table->unsignedBigInteger('sensor_id');
        $table->unsignedBigInteger('cultivos_id');

        // Relaciones
        $table->foreign('sensor_id')->references('id')->on('sensores')->onDelete('cascade');
        $table->foreign('cultivos_id')->references('id')->on('cultivos')->onDelete('cascade');

        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('sensor_cultivo');
}
};
