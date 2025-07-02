<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('equipo_item', function (Blueprint $table) {
            $table->string('codigoGuardado')->nullable();
        });
    }

    public function down()
    {
        Schema::table('equipo_item', function (Blueprint $table) {
            $table->dropColumn('codigoGuardado');
        });
    }
};