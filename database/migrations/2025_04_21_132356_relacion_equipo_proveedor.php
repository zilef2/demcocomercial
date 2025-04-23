<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('equipo_proveedor', function (Blueprint $table) {
            $table->foreignId('equipo_id')->constrained()->onDelete('cascade');
            $table->foreignId('proveedor_id')->constrained()->onDelete('cascade');
            $table->primary(['equipo_id', 'proveedor_id']);
			
			$table->integer('numero_proveedores')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipo_proveedor');
    }
	
//	public function down(): void {
//		Schema::table('equipos', function (Blueprint $table) {
//			// Elimina la foreign key si existe
//			$table->dropForeign(['proveedor_id']);
//			// Elimina la columna si existe
//			$table->dropColumn('proveedor_id');
//		});
//		
//	}
};
