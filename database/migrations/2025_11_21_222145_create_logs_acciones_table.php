<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logs_acciones', function (Blueprint $table) {
            $table->id();

            // Usuario que realizó la acción
            $table->unsignedBigInteger('usuario_id')->nullable();

            // Cultivo relacionado (si aplica)
            $table->unsignedBigInteger('cultivo_id')->nullable();

            // Datos de la acción
            $table->string('accion');               // ejemplo: 'creación', 'riego', 'alerta generada'
            $table->text('descripcion')->nullable();
            $table->string('nivel')->default('info'); // info, warning, error

            // Momento de la acción
            $table->dateTime('fecha_hora');

            $table->timestamps();

            // Foreign Keys
            $table->foreign('usuario_id')
                ->references('id')->on('users')
                ->onDelete('set null');

            $table->foreign('cultivo_id')
                ->references('id')->on('cultivos')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs_acciones');
    }
};
