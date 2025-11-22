<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actuadores', function (Blueprint $table) {
            $table->id();

            // Información básica del actuador
            $table->string('nombre');
            $table->string('tipo');             // bomba, válvula, relé, etc.
            $table->string('ubicacion')->nullable();

            // Estado del actuador
            $table->boolean('activo')->default(true);

            // Relación con cultivos
            $table->unsignedBigInteger('cultivo_id')->nullable();

            $table->timestamps();

            // Foreign Key
            $table->foreign('cultivo_id')
                  ->references('id')->on('cultivos')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actuadores');
    }
};
