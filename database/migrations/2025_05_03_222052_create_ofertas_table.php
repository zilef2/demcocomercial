<?php

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		$superAdminRole = User::whereHas('roles', function ($query) {
			return $query->whereIn('name', ['superadmin']);
		})->first();
		
		if ($superAdminRole) {
			
			Schema::create('ofertas', function (Blueprint $table) {
				$table->id();
				$table->foreignId('user_id')->constrained();
				$table->text('cargo');
				$table->text('empresa');
				$table->text('ciudad');
				$table->text('proyecto');
				$table->date('fecha');
				$table->timestamps();
			});
			Schema::table('items', function (Blueprint $table) {
				$table->foreignId('oferta_id')->constrained()->onDelete('cascade');
			});
			
			$modelosnuevos = ['oferta'];
			$operationsCrud = ['delete', 'update', 'update2', 'read', 'create', 'update3'];
			foreach ($modelosnuevos as $index => $generic) {
				foreach ($operationsCrud as $ope) {
					Permission::firstOrCreate(['name' => $ope . ' ' . $generic], ['guard_name' => 'web']);
				}
			}
			
			$allPermissions = Permission::all();
			$superAdminRole->syncPermissions($allPermissions); // Assign all permissions
			
		}
		
	}
	
	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('ofertas');
	}
};
