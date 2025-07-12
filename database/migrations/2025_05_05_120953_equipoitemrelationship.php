<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *  table('equipo_item', ...
     *  equipo_selec, item_id
     * cantidad_equipos
     * consecutivo_equipo
	$table->unique(['item_id', 'equipo_id', 'consecutivo_equipo']);
     * 
     * los que hay que agregar
precio_de_lista
fecha_actualizacion
descuento_basico
descuento_proyectos
precio_con_descuento
precio_con_descuento_proyecto
precio_ultima_compra
     * 
     * codigoGuardado

     */
    public function up(): void
    {
        Schema::create('equipo_item', function (Blueprint $table) {
            $table->foreignId('equipo_selec')->constrained()->onDelete('cascade');
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->primary(['equipo_selec', 'item_id']);
			
        });
        Schema::create('item_oferta', function (Blueprint $table) {
            $table->foreignId('oferta_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->primary(['oferta_id', 'item_id']);
			
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
