<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	
	/**
	 * Run the migrations.
	 */
	public function up() {
		Schema::table('equipos', function (Blueprint $table) {
			if (Schema::hasColumn('equipos', 'Clasificacion 2 Inventario')) {
				$table->dropColumn('Clasificacion 2 Inventario');
			}
		});
	}
	
	public function down() {
		Schema::table('equipos', function (Blueprint $table) {
			// Si necesitas revertir, puedes agregar la columna de nuevo aquí.
			// Por ejemplo:
			// $table->string('Clasificacion 2 Inventario')->nullable();
		});
	}
};
