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
            $table->text('Descripcion');
            $table->text('Tipo Fabricante');
            $table->text('Referencia Fabricante');
            $table->text('Marca');
            $table->text('Unidad de Compra');
            $table->integer('Precio de Lista');
            $table->date('Fecha actualizacion');
            $table->integer('Descuento Basico');
            $table->integer('Descuento Proyectos');
            $table->integer('Precio con Descuento');
            $table->integer('Precio con Descuento Proyecto');
            $table->integer('Precio Ultima Compra');
            $table->text('Precios de Listas');
            $table->text('Clasificacion 2 Inventario');
            $table->text('Ruta Tiempos');
            $table->integer('Tiempos Chapisteria');
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
