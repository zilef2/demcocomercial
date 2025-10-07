<?php

namespace App\helpers;

use App\Models\Equipo;

class Mydemcoco {
	
	public static function datacoubres(): array {
		$codigos = [
			'61600',
			'61665',
			'61003', //t40 -> $7800
			'61004', //t50 -> $16.300
			'61511',//t40 soportes
			'61566',//t50 soportes
		];
		
		//		$equipos = Cache::remember('equipos_base', 3, function () use ($codigos) {
		//			return Equipo::whereIn('codigo', $codigos)->get()->keyBy('codigo');
		//		});
		$equipos = Equipo::whereIn('codigo', $codigos)->get()->keyBy('codigo');
		
		return [
			'valorbarraje'   => $equipos['61600']->precio_de_lista, //kilo  de cobre
			'valorlaminilla' => $equipos['61665']->precio_de_lista,
			'Aisladores'     => [$equipos['61003']->precio_de_lista, $equipos['61004']->precio_de_lista],
			'Soporteangulo'  => [$equipos['61511']->precio_de_lista, $equipos['61566']->precio_de_lista],
			'docslive'  => 4.38,
			'hora_del_oficial_con_prestaciones'  => 16778.24138,
		];
	}
}
	
?>