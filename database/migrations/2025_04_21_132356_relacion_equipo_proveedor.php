<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	
	/**
	 * Run the migrations.
	 */
	public function up(): void {
//		Schema::table('equipos', function (Blueprint $table) {
//			$table->dropColumn('proveedor_id');
//			
//		});
		Schema::table('equipos', function (Blueprint $table) {
			$table->foreignId('proveedor_id')->constrained()->onDelete('cascade');
		});
	}
	
	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('equipos', function (Blueprint $table) {
			// Elimina la foreign key si existe
			$table->dropForeign(['proveedor_id']);
			
			// Elimina la columna si existe
			$table->dropColumn('proveedor_id');
		});
		
	}
};
