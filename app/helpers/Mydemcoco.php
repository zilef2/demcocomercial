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
			'valorbarraje'   => $equipos[$codigos[0]]->precio_de_lista, //kilo  de cobre
			'valorlaminilla' => $equipos[$codigos[1]]->precio_de_lista,
			'Aisladores'     => [$equipos[$codigos[2]]->precio_de_lista, $equipos[$codigos[3]]->precio_de_lista],
			'Soporteangulo'  => [$equipos[$codigos[4]]->precio_de_lista, $equipos[$codigos[5]]->precio_de_lista],
			'docslive'  => 4.38, //todo: essto que
			'hora_del_oficial_con_prestaciones'  => 16778.24138,//todo: essto que
		];
	}
	public static function datacables(): array {
			//'41227', //no, el d29 no esta 
		$codigos = [
			'41211', //0
			'41217', //1
			'41219', //2
			'41221', //3
			'41223', //4
			'41224', //5
			'41225', //6
			'41226', //7
			'41228', //8
			'41244',//d19 alambre //9
		];
		
		$equipos = Equipo::whereIn('codigo', $codigos)->get()->keyBy('codigo')->pluck('precio_de_lista');
		
		return $equipos->toArray();
	}
}
	
?>