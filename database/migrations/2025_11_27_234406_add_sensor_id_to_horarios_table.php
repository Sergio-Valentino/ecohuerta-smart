<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('horarios', function (Blueprint $table) {
            $table->unsignedBigInteger('sensor_id')->nullable()->after('actuador_id');

            $table->foreign('sensor_id')
                ->references('id')->on('sensores')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('horarios', function (Blueprint $table) {
            $table->dropForeign(['sensor_id']);
            $table->dropColumn('sensor_id');
        });
    }
};
