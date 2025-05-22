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
        Schema::create('equipo_item', function (Blueprint $table) {
            $table->foreignId('equipo_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->primary(['equipo_id', 'item_id']);
			
        });
        Schema::create('item_oferta', function (Blueprint $table) {
            $table->foreignId('oferta_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->primary(['oferta_id', 'item_id']);
			
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
