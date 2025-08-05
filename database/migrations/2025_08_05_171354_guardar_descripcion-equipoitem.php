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
         Schema::table('equipo_item', function (Blueprint $table) {
	         $table->string('descripcion', 2048)->nullable();
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::table('equipo_item', function (Blueprint $table) {
            $table->dropColumn([
                'descripcion',
            ]);
        });
    }
};
