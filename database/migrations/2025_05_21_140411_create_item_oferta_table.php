<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table('item_oferta', function (Blueprint $table) {
//			$table->id();
//			$table->foreignId('item_id')->constrained()->onDelete('cascade');
//			$table->foreignId('oferta_id')->constrained()->onDelete('cascade');
			$table->timestamps();
			$table->unique(['item_id', 'oferta_id']); // Evita duplicados
		});
	}
	
	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('item_oferta');
	}
};
