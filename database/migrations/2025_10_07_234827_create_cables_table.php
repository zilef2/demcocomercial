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
        Schema::create('cables', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion')->nullable();
            $table->float('cantitdad', 10, 3)->nullable();
            $table->float('metros', 10, 3)->nullable();
            $table->string('calibre')->nullable();
            $table->float('total', 10, 3)->nullable();
            $table->float('campoauxiliar1', 10, 3)->nullable();
            $table->float('campoauxiliar2', 10, 3)->nullable();
            $table->string('tipo')->nullable();
            $table->integer('tiponum')->nullable();
            $table->timestamps();
	        
	        $table->unsignedBigInteger('item_id')->nullable();
	        $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade')
	        ; //cascade, set null, restrict, no action 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cables');
    }
};
