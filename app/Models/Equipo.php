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
