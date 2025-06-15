<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table('equipos', function (Blueprint $table) {
			$table->renameColumn('Codigo', 'codigo');
			$table->renameColumn('Descripcion', 'descripcion');
			$table->renameColumn('Marca', 'marca');
		});
		DB::statement('ALTER TABLE equipos CHANGE `Tipo Fabricante` tipo_fabricante TEXT');
		DB::statement('ALTER TABLE equipos CHANGE `Referencia Fabricante` referencia_fabricante TEXT');
		DB::statement('ALTER TABLE equipos CHANGE `Unidad de Compra` unidad_de_compra TEXT');
		DB::statement('ALTER TABLE equipos CHANGE `Precio de Lista` precio_de_lista INT');
		DB::statement('ALTER TABLE equipos CHANGE `Fecha actualizacion` fecha_actualizacion DATE');
		DB::statement('ALTER TABLE equipos CHANGE `Descuento Basico` descuento_basico INT');
		DB::statement('ALTER TABLE equipos CHANGE `Descuento Proyectos` descuento_proyectos INT');
		DB::statement('ALTER TABLE equipos CHANGE `Precio con Descuento` precio_con_descuento INT');
		DB::statement('ALTER TABLE equipos CHANGE `Precio con Descuento Proyecto` precio_con_descuento_proyecto INT');
		DB::statement('ALTER TABLE equipos CHANGE `Precio Ultima Compra` precio_ultima_compra INT');
		DB::statement('ALTER TABLE equipos CHANGE `Precios de Listas` precios_de_listas TEXT');
		DB::statement('ALTER TABLE equipos CHANGE `Ruta Tiempos` ruta_tiempos TEXT');
		DB::statement('ALTER TABLE equipos CHANGE `Tiempos Chapisteria` tiempos_chapisteria INT');
		
		Schema::table('equipos', function (Blueprint $table) {
			$table->decimal('descuento_basico', 20)->nullable()->change();
			$table->decimal('descuento_proyectos', 20)->nullable()->change();
			if (Schema::hasColumn('equipos', 'clasificacion2_inventario')) {
				$table->dropColumn('clasificacion2_inventario');
			}
			if (Schema::hasColumn('equipos', 'Clasificacion 2 Inventario')) {
				DB::statement('ALTER TABLE equipos DROP COLUMN `Clasificacion 2 Inventario`');
			}
		});
	}
	
	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		//
	}
};
