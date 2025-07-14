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
            // Descuentos
            $table->decimal('descuento_final', 9, 3)->nullable();
            $table->decimal('dcto_basico', 9, 3)->default(0)->after('descuento_final');
            $table->decimal('dcto_x_proyecto', 9, 3)->default(0)->after('dcto_basico');

            // Factor y Costos
            $table->decimal('factor', 8, 4)->default(1.0000)->after('dcto_x_proyecto'); // Un factor suele tener más decimales
            $table->string('nombrefactor')->nullable();
            $table->decimal('costo_unitario', 25)->default(0)->after('factor'); // Asume que el costo puede ser mayor que el valor
            $table->decimal('costo_total', 25)->default(0)->after('costo_unitario');
            $table->decimal('valorunitarioequip', 25)->default(0); // Asume que el costo puede ser mayor que el valor
            $table->decimal('subtotalequip', 25)->default(0);
            $table->decimal('precio_de_lista2', 25)->default(0);
            $table->decimal('alerta_mano_obra', 25)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipo_item', function (Blueprint $table) {
            $table->dropColumn([
                'descuento_final',
                'dcto_basico',
                'dcto_x_proyecto',
                'factor',
                'nombrefactor',
                'costo_unitario',
                'costo_total',
                'valorunitarioequip',
                'subtotalequip',
                'precio_de_lista2',
                'alerta_mano_obra',
            ]);
        });
    }
};
