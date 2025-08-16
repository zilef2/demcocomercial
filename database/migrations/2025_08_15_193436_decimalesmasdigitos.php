<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	
	/**
	 * Run the migrations.
	 */
	    public function up(): void
    {
        // Modifica las columnas existentes en la tabla 'equipo_item'
        Schema::table('equipo_item', function (Blueprint $table) {
            $table->decimal('descuento_basico', 8, 6)->nullable()->change();
            $table->decimal('descuento_proyectos', 8, 6)->nullable()->change();
        });

        Schema::table('equipos', function (Blueprint $table) {
            $table->decimal('descuento_basico', 8, 6)->nullable()->change();
            $table->decimal('descuento_proyectos', 8, 6)->nullable()->change();
        });
    }
	
	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		//
	}
};
