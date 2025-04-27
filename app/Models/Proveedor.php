<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model {
	
	use HasFactory;
	
	protected $fillable = [
		'nombre',
	];
	
	public function equipos(): BelongsToMany {
		return $this->belongsToMany(Equipo::class);
	}
}
