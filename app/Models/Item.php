<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Item extends Model {
	
	use HasFactory;
	
	/*
	 * detablee == equipo_item 15jul2025
	 * 
	codigoGuardado
	cantidad_equipos
	
	precio_de_lista
	fecha_actualizacion
	descuento_basico
	descuento_proyectos
	precio_con_descuento
	precio_con_descuento_proyecto
	precio_ultima_compra
	
	descuento_final
	
	factor
	nombrefactor
	costo_unitario
	costo_total
	subtotalequip
	valorunitarioequip
	precio_de_lista2
	alerta_mano_obra
	 */
	
	protected $fillable = [ //relaciones muchoamuchos = equipo_item,
		'numero',
		'nombre',
		'descripcion',
		'cantidad',
		'conteo_items',
		'valor_unitario_item',
		'valor_total_item',
		'oferta_id',
		

	];
	protected $appends = [
		'codigoDes',
	];
	
	public static function getFillableWith() {
		return [
			['order' => 'numero', 'label' => 'numero', 'type' => 'integer'],
			['order' => 'nombre', 'label' => 'nombre', 'type' => 'text'],
			['order' => 'descripcion', 'label' => 'descripcion', 'type' => 'text'],
			['order' => 'cantidad', 'label' => 'cantidad', 'type' => 'integer'],
			['order' => 'conteo_items', 'label' => 'conteo_items', 'type' => 'integer'],
			['order' => 'valor_unitario_item', 'label' => 'valor_unitario_item', 'type' => 'dinero'],
			['order' => 'valor_total_item', 'label' => 'valor_total_item', 'type' => 'dinero'],
			['order' => 'oferta_id', 'label' => 'oferta_id', 'type' => 'foreign', 'nameid' => 'ofertau'],
		];
	}
	
	public static function getFillableWithTypes() {
		$table = (new static)->getTable();
		$columns = DB::select("SHOW COLUMNS FROM {$table}");
		
		$fillable = (new static)->getFillable();
		$result = [];
		
		foreach ($columns as $column) {
			if (!in_array($column->Field, $fillable)) {
				continue;
			}
			
			// Detectar tipo
			$type = 'text'; // default
			if (str_contains($column->Type, 'int')) {
				$type = 'integer';
			}
			elseif (str_contains($column->Type, 'decimal') || str_contains($column->Type, 'float')) {
				$type = 'dinero';
			}
			elseif (str_contains($column->Type, 'foreign') || $column->Field === 'oferta_id') {
				$type = 'foreign';
			}
			
			$result[] = [
				'order' => $column->Field,
				'label' => $column->Field,
				'type'  => $type,
			];
		}
		
		return $result;
	}
	
	public function getcodigoDesAttribute2(): array {
		// Retorna un array de arrays, cada uno con clave y valor explícitos
		return $this->Equipos->map(function ($equipo) {
			return [
				'codigo'      => $equipo->codigo,
				'descripcion' => $equipo->descripcion,
			];
		})->values()->toArray();
	}
	
	public function getCodigoDesAttribute(): array {
		// 1. Acceder a la relación 'equipos' que ya incluye los datos del pivote
		// 2. La ordenación se hace en la definición de la relación 'equipos'
		return $this->equipos->map(function ($equipo) {
				return [
					'codigo'             => $equipo->codigo,
					'descripcion'        => $equipo->descripcion,
					'cantidad_equipos'   => $equipo->pivot->cantidad_equipos,
					'precio_de_lista'    => $equipo->pivot->precio_de_lista,
					'consecutivo_equipo' => $equipo->pivot->consecutivo_equipo,
				];
			})->values() // Re-indexar el array después de mapear
			->toArray()
		; // Convertir la colección a un array PHP
	}
	
	public function equipos() {
		return $this->belongsToMany(Equipo::class, 'equipo_item', 'item_id', 'equipo_id')
		            ->withPivot(
                        'codigoGuardado',
                        'cantidad_equipos',
                        'consecutivo_equipo',
                        'precio_de_lista',
                        'fecha_actualizacion',
                        'descuento_basico',
                        'descuento_proyectos',
                        'precio_con_descuento',
                        'precio_con_descuento_proyecto',
                        'precio_ultima_compra',
                        'descuento_final',
                        'factor',
                        'nombrefactor',
                        'costo_unitario',
                        'costo_total',
                        'precio_de_lista2',
                        'alerta_mano_obra',
                        'valorunitarioequip',
                        'subtotalequip'
		            )->orderBy('equipo_item.consecutivo_equipo', 'asc');
	}
	
	public function ofertas(): BelongsToMany {
		return $this->belongsToMany(Oferta::class, 'item_oferta');
	}
	
}