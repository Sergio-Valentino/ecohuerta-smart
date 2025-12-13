<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actuador_cultivo', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('actuador_id');
            $table->unsignedBigInteger('cultivo_id');

            $table->timestamps();

            // Índices
            $table->index('actuador_id');
            $table->index('cultivo_id');

            // Relaciones
            $table->foreign('actuador_id')
                ->references('id')
                ->on('actuadores')
                ->onDelete('cascade');

            $table->foreign('cultivo_id')
                ->references('id')
                ->on('cultivos')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actuador_cultivo');
    }
};