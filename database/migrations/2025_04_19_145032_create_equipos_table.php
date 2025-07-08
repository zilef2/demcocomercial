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
        Schema::create('equipos', function (Blueprint $table) {
            $table->text('Codigo');
            $table->text('descripcion');
            $table->text('tipo_fabricante');
            $table->text('referencia_fabricante');
            $table->text('marca');
            $table->text('unidad_de_compra');
            $table->integer('precio_de_lista');
            $table->date('fecha_actualizacion');
            $table->integer('descuento_basico');
            $table->integer('descuento_proyectos');
            $table->integer('precio_con_descuento');
            $table->integer('precio_con_descuento_proyecto');
            $table->integer('precio_ultima_compra');
            $table->text('precios_de_listas');
            $table->text('clasificacion_2_inventario');
            $table->text('ruta_tiempos');
            $table->integer('tiempos_chapisteria');
            $table->id();
            $table->timestamps();
        });
		
		
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
