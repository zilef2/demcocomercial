<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

    class Oferta extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'cargo', 'empresa', 'ciudad', 'proyecto', 'fecha'];

}
