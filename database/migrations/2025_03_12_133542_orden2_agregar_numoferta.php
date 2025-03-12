<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path=/database/migrations/2025_03_12_133542_orden2_agregar_numoferta.php
     php artisan migrate:rollback --path=/database/migrations/2025_03_12_133542_orden2_agregar_numoferta.php
     */
    public function up(): void
    {
        Schema::table('ordentrabajo2s', function (Blueprint $table) {
            $table->string('cd');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
