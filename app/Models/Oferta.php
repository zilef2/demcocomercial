<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Oferta extends Model {
	
	use HasFactory;
	
	protected $appends = [
		'LosItems',
		'QuantityItems',
		'Userino',
	];
	
	protected $fillable = [
		'codigo_oferta',
		'descripcion',
		'cargo',
		'empresa',
		'ciudad',
		'proyecto',
		'fecha',
		'user_id',
	];
	
	
	public function getUserinoAttribute(): string {
	    return $this->user ? $this->user->name : '';
	}
	
	public function user(): BelongsTo {
		return $this->belongsTo(User::class);
	}
	public function items(): BelongsToMany {
		return $this->belongsToMany(Item::class, 'item_oferta');
	}
	
	public function getLosItemsAttribute(): string {
		// Devuelve una cadena con los nombres de todos los ítems, separados por coma
		return $this->items->pluck('nombre')->implode(', ');
	}
	
	public function getQuantityItemsAttribute(): string {
		// Devuelve una cadena con los nombres de todos los ítems, separados por coma
		return $this->items->pluck('id')->count();
	}
	
}
