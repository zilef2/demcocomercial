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

        'numero_oferta',
        'ot',//orden de trabajo
        'cliente',
        'avance',
        'tiempo_estimado',
     ];
}
//FALTA:: fecha terminacion AV
