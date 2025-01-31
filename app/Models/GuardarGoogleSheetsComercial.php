<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static updateOrCreate(string[] $array, array $array1)
 */
class GuardarGoogleSheetsComercial extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'HayTiemposEstimados', //default = 0, significa que la tabla no ningun valor de tiempo
        'Grupo', //se suele poner la fecha
        'user_id',

//        'Nombre_tablero',
//        'Item',
//        'Item_vue',
//        'avance',
        'numero_oferta',
        'cliente',
        'avance',
        'tiempo_estimado',
        
     ];
}
//FALTA:: fecha terminacion AV
