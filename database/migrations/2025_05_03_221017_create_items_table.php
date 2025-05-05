<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('items', function (Blueprint $table) {
			$table->id();
			$table->biginteger('numero');
			$table->text('nombre');
			$table->text('descripcion');
			$table->integer('cantidad');
			$table->integer('conteo_items');
			$table->decimal('valor_unitario_item', 16);
			$table->decimal('valor_total_item', 16);
			$table->timestamps();
		});
		
		$modelosnuevos = ['item'];
		$operationsCrud = ['delete', 'update', 'update2', 'read', 'create', 'update3'];
		foreach ($modelosnuevos as $index => $generic) {
			foreach ($operationsCrud as $ope) {
				Permission::firstOrCreate(['name' => $ope . ' ' . $generic], ['guard_name' => 'web']);
			}
		}
		
	}
	
	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('items');
	}
};
