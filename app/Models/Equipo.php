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
		'Ruta Tiempos',
		'Tiempos Chapisteria',
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
