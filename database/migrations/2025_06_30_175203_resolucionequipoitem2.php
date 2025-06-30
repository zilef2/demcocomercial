<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('equipo_item', function (Blueprint $table) {
			$table->id();
		    $table->foreignId('equipo_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
			
			$table->integer('consecutivo_equipo');
			$table->integer('cantidad_equipos')->default(1);
			
			$table->unique(['item_id', 'equipo_id', 'consecutivo_equipo']);
			
			$table->timestamps();
		});
	}
	
	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		//
	}
};
