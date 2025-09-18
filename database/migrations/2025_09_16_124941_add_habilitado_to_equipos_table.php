<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	
	public function up(): void {
		Schema::table('equipos', function (Blueprint $table) {
			$table->tinyInteger('habilitado')->default(1) // ponlo después de un campo que tenga sentido
				->comment('1 = habilitado, 0 = deshabilitado');
			
	        $table->string('estado', 50)
              ->default('activo')
              ->after('habilitado')
              ->comment('Estado lógico del equipo: activo, inactivo, descontinuado, etc.');
			
	        $table->string('estado_precio', 50)
              ->default('normalmente_con_descuento')
              ->after('estado')
              ->comment('esta columna la anadi yo para manejar los precios: normalmente_sin_descuento, normalmente_con_descuento, precio_fijo, sin_precio');
		});
	}
	
	public function down(): void {
		Schema::table('equipos', function (Blueprint $table) {
			$table->dropColumn('habilitado');
			$table->dropColumn('estado');
			$table->dropColumn('estado_precio');
		});
	}
	
};
