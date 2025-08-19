<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipo extends Model {
	
	use HasFactory;
	/* updated_at == equipo_item 15jul2025 
	PIVOT TABLE equipo_item
	equipo_id
	item_id
	
	
	alerta_mano_obra
	cantidad_equipos
	codigoGuardado
	consecutivo_equipo
	costo_total
	costo_unitario
	created_at
	dcto_basico
	dcto_x_proyecto
	descripcion
	descuento_basico
	descuento_final
	descuento_proyectos
	factor
	fecha_actualizacion
	nombrefactor
	precio_con_descuento
	precio_con_descuento_proyecto
	precio_de_lista
	precio_de_lista2
	precio_ultima_compra
	subtotalequip
	updated_at
	valorunitarioequip

	 */ 
	// - descripcion added at 2025-ago08-05 - 
	
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
		'precio_de_lista', // todo: estos cambian cuando se guarda
		'fecha_actualizacion', // estos cambian cuando se guarda
		'descuento_basico', // estos cambian cuando se guarda
		'descuento_proyectos', // estos cambian cuando se guarda
		'precio_con_descuento', // estos cambian cuando se guarda
		'precio_con_descuento_proyecto', // estos cambian cuando se guarda
		'precio_ultima_compra', // estos cambian cuando se guarda
		'precios_de_listas',
		'ruta_tiempos',
		'tiempos_chapisteria',
	];
	
	public function items() {
//		return $this->belongsToMany(Item::class, 'equipo_item', 'equipo_id', 'item_id');
		return $this->belongsToMany(Item::class, 'equipo_item', 'item_id', 'equipo_id')
                ->withPivot('cantidad_equipos');
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
