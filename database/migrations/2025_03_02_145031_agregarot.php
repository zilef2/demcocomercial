<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     php artisan migrate --path=/database/migrations/2025_03_02_145031_agregarot.php
     php artisan migrate:rollback --path=/database/migrations/2025_03_02_145031_agregarot.php
     */
    public function up(): void
    {
        Schema::table('guardar_google_sheets_comercials', function (Blueprint $table) {
            $table->string('ot')->nullable();
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
