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
	
	protected $fillable = [ //relaciones muchoamuchos = equipo_item,
		'numero',
		'nombre',
		'descripcion',
		'cantidad',
		'conteo_items',
		'valor_unitario_item',
		'valor_total_item',
		'oferta_id'
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
	
	public function Equipos() {
		return $this->belongsToMany(Equipo::class, 'equipo_item', 'item_id', 'equipo_id');
	}
	
	public function oferta(): BelongsTo { return $this->belongsTo(Oferta::class); }
	
}