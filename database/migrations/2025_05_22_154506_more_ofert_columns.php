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
			Schema::table('ofertas', function (Blueprint $table) {
				$table->string('proyecto', 512)->change()->nullable();
				$table->string('ciudad', 256)->change()->nullable();
				$table->string('empresa', 256)->change()->nullable();
				$table->string('cargo', 256)->change()->nullable();
				$table->string('codigo_oferta', 256)->nullable();
				$table->string('descripcion', 2048)->nullable();
			});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
