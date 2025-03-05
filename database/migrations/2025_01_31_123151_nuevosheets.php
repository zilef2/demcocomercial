<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
//        Schema::table('reportes', function (Blueprint $table) {
//            $table->renameColumn('nombreTablero', 'numero_oferta');
//        });
//        Schema::table('guardar_google_sheets_comercials', function (Blueprint $table) {
//            $table->renameColumn('Nombre_tablero', 'numero_oferta');
//            $table->renameColumn('Item', 'cliente');
//            $table->renameColumn('Item_vue', 'tiempo_estimado');
//
//            $table->string('avance', 512)->change();
//        });
//
//        Schema::table('guardar_google_sheets_comercials', function (Blueprint $table) {
//            $table->string('numero_oferta', 512)->change();
//            $table->string('cliente', 512)->change();
//            $table->string('tiempo_estimado', 512)->change();
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
         * 
        php artisan migrate --path=database/migrations/2025_01_31_123151_nuevosheets.php
         */
    }
};
