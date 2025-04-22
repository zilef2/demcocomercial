<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

    class Equipo extends Model
{
    use HasFactory;
    protected $fillable = [
		'Codigo',
	    'Descripcion',
	    'Tipo Fabricante',
	    'Referencia Fabricante',
	    'Marca',
	    'Unidad de Compra',
	    'Precio de Lista',
	    'Fecha actualizacion',
	    'Descuento Basico',
	    'Descuento Proyectos',
	    'Precio con Descuento',
	    'Precio con Descuento Proyecto',
	    'Precio Ultima Compra',
	    'Precios de Listas',
	    'Clasificacion 2 Inventario',
	    'Ruta Tiempos',
	    'Tiempos Chapisteria',
	    'proveedor_id',
    ];

}
