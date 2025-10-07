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
        Schema::create('cobres', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion')->nullable();
            $table->integer('amperios')->nullable();
            $table->float('cantitdad', 10, 3)->nullable();
            $table->float('metros', 10, 3)->nullable();
            $table->float('peso_u', 10, 3)->nullable();
            $table->float('peso_total', 10, 3)->nullable();
            $table->decimal('valor', 60, 3)->nullable();
            $table->string('tiempo_hora')->nullable();
            $table->float('campoauxiliar1', 10, 3)->nullable();
            $table->float('campoauxiliar2', 10, 3)->nullable();
            $table->float('campoauxiliar3', 10, 3)->nullable();
            $table->string('tipo')->nullable();
            $table->integer('tiponum')->nullable();
	        
	        $table->unsignedBigInteger('item_id')->nullable();
			$table->foreign('item_id')->references('id')->on('items')->onDelete('set null'); //cascade, set null, restrict, no action
	        
	        $table->unsignedBigInteger('oferta_id')->nullable();
	        $table->foreign('oferta_id')->references('id')->on('ofertas')->onDelete('cascade'); //cascade, set null, restrict, no action
	         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cobres');
		
    }
};
