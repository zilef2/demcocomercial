<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class cable extends Model {
	
	use HasFactory;
	
	    protected $fillable = [
		'descripcion',
		'cantidad',
		'metros',
		'calibre',
		'valor_unitario',
		'total',
		'campoauxiliar1',
		'campoauxiliar2',
		'tipo',
		'tiponum',
		'item_id',
	];
	
	public static function getFillableWithTypes() {
		$table = (new static)->getTable();
		$columns = \DB::select("SHOW COLUMNS FROM {$table}");
		
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
	
}