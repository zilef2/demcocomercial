<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipo extends Model {
	
	use HasFactory;
	
	protected $appends = [
		'proveedor_ids',
		'proveeNombre',
	];
	
	protected $fillable = [
		'codigo',
		'descripcion',
		'tipo_fabricante',
		'referencia_fabricante',
		'marca',
		'unidad_de_compra',
		'precio_de_lista',
		'fecha_actualizacion',
		'descuento_basico',
		'descuento_proyectos',
		'precio_con_descuento',
		'precio_con_descuento_proyecto',
		'precio_ultima_compra',
		'precios_de_listas',
		'ruta_tiempos',
		'tiempos_chapisteria',
	];
	
	public function items() {
		return $this->belongsToMany(Item::class, 'equipo_item', 'equipo_id', 'item_id');
	}
	public function proveedores(): BelongsToMany {
		return $this->belongsToMany(Proveedor::class, 'equipo_proveedor', 'equipo_id', 'proveedor_id');
	}
	
	
	
	//get somethings
	
	public function getProveedorIdsAttribute(): array {
		return $this->proveedores()->pluck('id')->toArray();
	}
	
	
	public function getproveeNombreAttribute(): string {
		
		return implode(', ', $this->proveedores()->pluck('nombre')->toArray());
	}
	
}
