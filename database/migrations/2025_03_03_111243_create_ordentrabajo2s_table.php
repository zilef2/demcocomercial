<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path=/database/migrations/2025_03_03_111243_create_ordentrabajo2s_table.php
     php artisan migrate:rollback --path=/database/migrations/2025_03_03_111243_create_ordentrabajo2s_table.php
     */
    public function up(): void
    {
//        Schema::create('ordentrabajo2s', function (Blueprint $table) {
//            $table->id();
//            $table->timestamps();
//            $table->string('nombre');
//            
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordentrabajo2s');
    }
};
