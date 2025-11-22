<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();

            // Usuario que recibe la notificación
            $table->unsignedBigInteger('usuario_id')->nullable();

            // Cultivo relacionado (si aplica)
            $table->unsignedBigInteger('cultivo_id')->nullable();

            // Información de la notificación
            $table->string('tipo')->default('info');   // info, alerta, riego, sistema
            $table->string('titulo');                 // título de la notificación
            $table->text('mensaje')->nullable();      // detalle del mensaje
            $table->boolean('leida')->default(false); // si el usuario la abrió

            // Fecha de envío
            $table->dateTime('fecha_envio');

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
        Schema::dropIfExists('notificaciones');
    }
};
