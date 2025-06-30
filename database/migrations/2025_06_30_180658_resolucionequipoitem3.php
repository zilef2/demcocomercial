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
		Schema::table('equipo_item', function (Blueprint $table) {
			
			$table->decimal('precio_de_lista', 20, 1)->nullable();
			$table->Datetime('fecha_actualizacion')->nullable()->nullable();
			$table->decimal('descuento_basico', 20, 1)->nullable();
			$table->decimal('descuento_proyectos', 20, 1)->nullable();
			$table->decimal('precio_con_descuento', 20, 1)->nullable();
			$table->decimal('precio_con_descuento_proyecto', 20, 1)->nullable();
			$table->decimal('precio_ultima_compra', 20, 1)->nullable();
		});
    }

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('equipo_item', function (Blueprint $table) {
        $table->dropColumn([
            'precio_de_lista',
            'fecha_actualizacion',
            'descuento_basico',
            'descuento_proyectos',
            'precio_con_descuento',
            'precio_con_descuento_proyecto',
            'precio_ultima_compra',
        ]);
    });
}

};
