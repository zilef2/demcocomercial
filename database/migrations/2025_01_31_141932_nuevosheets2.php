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
//        Schema::table('guardar_google_sheets_comercials', function (Blueprint $table) {
//            $table->dropColumn([
//                'Tiempo_estimado_corte',
//                'Tiempo_estimado_doblez',
//                'Tiempo_estimado_soldadura',
//                'Tiempo_estimado_pulida',
//                'Tiempo_estimado_ensamble',
//                'Tiempo_estimado_cobre',
//                'Tiempo_estimado_cableado',
//                'Tiempo_estimado_Ing_mec',
//                'Tiempo_estimado_Ing_elec',
//                'fecha_inicio_fabricacion',
//                'fecha_terminacion_fabricacion',
//            ]);
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
         * 
        php artisan migrate --path=database/migrations/2025_01_31_141932_nuevosheets2.php
         */
    }
};
