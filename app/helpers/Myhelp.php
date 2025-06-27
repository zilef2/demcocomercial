<?php

namespace App\helpers;

use App\Models\Equipo;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Translator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

//JUST THIS PROJECT
//STRING S
//LARAVELFunctions
//dates

class Myhelp {
	
	public static function AuthU(): ?User {
		$TheUser = Auth::user();
		if ($TheUser instanceof User) {
			return $TheUser;
		}
		
		//        return redirect()->to('/');
		abort(403, 'Unauthorized');
	}
	
	public static function AuthUid(): ?int {
		$TheUser = Auth::user();
		if ($TheUser instanceof User) {
			return $TheUser->id;
		}
		abort(403, 'Unauthorized');
	}
	
	//JUST THIS PROJECT
	public static function CargosYModelos() {
		//otros cargos NO_ADMIN
		$nombresDeCargos = [
			'trabajador',
			'supervisor',
		];
		$isSome = [];
		foreach ($nombresDeCargos as $key => $value) {
			$isSome[] = 'is' . $value;
		}
		//arrrays for easyway
		$Models = [
			'role',
			'permission',
			'user',
			
			'reporte',//core
			
			'ordentrabajo',
			'actividad',
			'centrotrabajo',
			'disponibilidad',
			// 'material',
			'pieza',
			'reproceso',
			// 'operario',
		];
		
		return [
			'nombresDeCargos' => $nombresDeCargos,
			'Models'          => $Models,
			'isSome'          => $isSome,
		];
	}
	
	public static function getPermissionToNumber($permissions) {
		
		if ($permissions === 'trabajador') {
			return 1;
		}
		if ($permissions === 'supervisor') {
			return 2;
		}
		if ($permissions === 'admin') {
			return 9;
		}
		if ($permissions === 'superadmin') {
			return 10;
		}
		
		return 0;
	}
	//JUST THIS PROJECT
	
	//STRING S
	
	public static function ArrayInString($Elarray, $limite = 3) {
		$Elarray = $Elarray->toArray();
		// dd($Elarray instanceof Collection);
		if (count($Elarray) > $limite) {
			$result = [];
			$result[] = $Elarray[0];
			$result[] = $Elarray[1];
			$result[] = $Elarray[2];
			
			return implode(", ", $result) . '...';
		}
		else {
			if (count($Elarray) > 0) {
				return implode(",", $Elarray);
			}
			else {
				return 'Sin resultados';
			}
		}
	}
	
	public static function validateDate($dateString, $format = 'd/m/Y') {
		$dateString = date_create_from_format('d/m/Y', $dateString);
		
		return $dateString;
	}
	
	public static function FechaCarbon($date) {
		try {
			// $translator = Translator::get('es_CO');
			Carbon::setLocale('es');
			$carbonDate = Carbon::createFromFormat('d/m/Y', $date);
			$anioActual = Carbon::now()->year;
			if ($anioActual == $carbonDate->year) {
				$result = $carbonDate->format('d \d\e M');
			}
			else {
				$result = $carbonDate->format('d \d\e M \d\e Y');
			}
			
			return $result;
		} catch (\Throwable $th) {
			return $th->getMessage();
		}
	}
	
	//fin strings
	
	//LARAVELFunctions
	
	public static function filtrar_solo_id($ARRAY_with_attributes) {
		$Result = [];
		foreach ($ARRAY_with_attributes as $key => $value) {
			$buscarid = strpos(trim($value), '_id');
			if ($buscarid !== false) {
				$Result[] = substr($value, 0, $buscarid);
			}
		}
		
		return $Result;
	}
	
	public static function NEW_turnInSelectID($theArrayofStrings, $ModelName, $displayField = null, $displayField2 = null) {
		if ($displayField === null) {
			$displayField = 'nombre';
		}
		if (count($theArrayofStrings) == 0) {
			return [
				['title' => 'No hay registros ', 'value' => 0,]
				// 'filtro' => 'General'
			];
		}
		
		$result = [
			[
				'title' => 'Selecciona un ' . $ModelName,
				'value' => 0,
				// 'filtro' => 'General'
			]
		];
		if ($displayField2) { //si tiene una descripcion aparte del nombre por defecto
			
			foreach ($theArrayofStrings as $value) {
				$result[] = [
					'title' => $value->{$displayField} . ' - ' . $value->{$displayField2},
					'value' => $value->id,
				];
			}
		}
		else {
			
			foreach ($theArrayofStrings as $value) {
				$result[] = [
					'title' => $value->{$displayField},
					'value' => $value->id,
					// 'filtro' => $value->teoricaOpractica
				];
			}
		}
		
		return $result;
	}
	
	public static function MakeSelect(Collection $modelAll, string $nameofclass, bool $allAttributes, string $displayField, string $displayField2 = '', array $arrayOtherValues = []) {
		if (count($modelAll) == 0) {
			return [['title' => 'No hay registros de ' . $nameofclass, 'value' => 0,]];
		}
		//Fin validaciones
		
		$result = [
			[
				'title' => 'Selecciona un Equipo',
				'value' => 0,
			]
		];
		
		$ModelClass = 'App\\Models\\' . $nameofclass;
		$modelInstance = new $ModelClass();
		$elfillable = call_user_func([$modelInstance, 'getFillable']);
		foreach ($modelAll as $index => $value) {
			$title = $value->{$displayField} . ($value->{$displayField2} ? ' - ' . $value->{$displayField2} : '');
			$arrayNormal = [
				'value' => $value->id,
				'title' => $title,
			];
			if ($arrayOtherValues) {
				foreach ($arrayOtherValues as $index => $other_value) {
					$arrayNormal = array_merge($arrayNormal, [
						$other_value => $value->{$other_value}
					]);
				}
			}
			if ($allAttributes) {
				foreach ($elfillable as $index => $itemFill) {
					$newArray = [str_replace(" ", "_", $itemFill) => $value->{$itemFill} ?? ''];
					//ex: 'Precio_de_Lista' => $value->precio_de_lista
					
					$arrayNormal = array_merge($arrayNormal, $newArray);
					
				}
			}
			$result[] = $arrayNormal;
		}
		
		return $result;
	}
	
	public static function MakeSelect_hardmode(Collection $modelAll, string $nameofclass, bool $allAttributes, string $displayField, string $displayField2 = '', array $arrayOtherValues = []) {
		if (count($modelAll) == 0) {
			return [['title' => 'No hay registros de ' . $nameofclass, 'value' => 0,]];
		}
		//Fin validaciones
		
		$result = [
			[
				'title' => 'Selecciona un Equipo',
				'value' => 0,
			]
		];
		
		$ModelClass = 'App\\Models\\' . $nameofclass;
		$modelInstance = new $ModelClass();
		$elfillable = call_user_func([$modelInstance, 'getFillable']);
		foreach ($modelAll as $index => $value) {
			$title = $value->{$displayField} . ($value->{$displayField2} ? ' - ' . $value->{$displayField2} : '');
			$arrayNormal = [
				'value' => $value->codigo,
				'title' => $title,
			];
			if ($arrayOtherValues) {
				foreach ($arrayOtherValues as $other_value) {
					$arrayNormal = array_merge($arrayNormal, [
						$other_value => $value->{$other_value},
						$other_value.'2' => $value->{$other_value}
					]);
				}
			}
			if ($allAttributes) {
				foreach ($elfillable as $itemFill) {
					$newArray = [str_replace(" ", "_", $itemFill) => $value->{$itemFill} ?? ''];
					
					$arrayNormal = array_merge($arrayNormal, $newArray);
					
				}
			}
			$result[] = $arrayNormal;
		}
		
		return $result;
	}
	
	public function EncontrarEnString($frase, $busqueda): array {
		$Resultado = [];
		$NuevaPos = strlen($frase);
		$ResultOnce = strpos($frase, $busqueda);
		
		// if($busqueda == '[tema]')
		// dd($ResultOnce);
		//ResultOnce,  = 2
		//frase,  = a [tema]
		//busqueda,  = [tema]
		//strlen($frase)  =  8
		
		while ($ResultOnce !== false && $ResultOnce < $NuevaPos) {
			$Resultado[] = $ResultOnce;
			$NuevaPos = $ResultOnce + strlen($busqueda);
			$ResultOnce = strpos($frase, $busqueda, $NuevaPos);
		}
		
		return $Resultado;
	}
	
	function cortarFrase($frase, $maxPalabras = 3) {
		$noTerminales = [
			"de",
			"a",
			"para",
			"of",
			"by",
			"for"
		];
		
		$palabras = explode(" ", $frase);
		$numPalabras = count($palabras);
		if ($numPalabras > $maxPalabras) {
			$offset = $maxPalabras - 1;
			while (in_array($palabras[$offset], $noTerminales) && $offset < $numPalabras) {
				$offset ++;
			}
			$ultimaPalabra = $palabras[$offset];
			if ((intval($ultimaPalabra)) != 0) {
				session(['ultimaPalabra' => $ultimaPalabra]);
			}
			
			return implode(" ", array_slice($palabras, 0, $offset + 1));
		}
		
		return $frase;
	}
	
	//fin LARAVEL
	
	//dates
	
	public function mensajesErrorBD($e, $clasePrincipal, $elid, $elnombre) {
		$errorCode = $e->getCode();
		$arrayCodes = [
			23000 => ' No se puede eliminar porque está relacionado con otros registros.',
			1451  => ' Hay otros campos que necesitan este registro',
			1062  => ' Ya existe un registro con esa información.',
			1048  => ' Campo obligatorio, por favor completa la información.',
			1216  => ' Este registro no se puede eliminar, hay dependencias pendientes.'
		];
		
		if (isset($arrayCodes[$errorCode])) {
			$errorMessage = $arrayCodes[$errorCode];
		}
		else {
			$errorMessage = "Ocurrió un error de base de datos.";
		}
		
		Myhelp::EscribirEnLog($this, 'DELETE:' . $clasePrincipal . ', QueryException', $clasePrincipal . ' id:' . $elid . ' | ' . $elnombre . ' fallo en el borrado:: ' . $errorMessage, false, true);
		
		return $errorMessage;
		
	}
	
	public static function EscribirEnLog($thiis, $clase = '', $mensaje = '', $returnPermission = true, $critico = false) {
		
		$permissions = $returnPermission ? auth()->user()->roles->pluck('name')[0] : null;
		$ListaControladoresYnombreClase = (explode('\\', get_class($thiis)));
		$nombreC = end($ListaControladoresYnombreClase);
		if (!$critico) {
			
			$Elpapa = (explode('\\', get_parent_class($thiis)));
			$nombreP = end($Elpapa);
			if ($permissions == 'admin' || $permissions == 'superadmin') {
				
				$permissionsString = $permissions == 'admin' ? 'soloadmin' : 'solosuper';//valor del logging
				$ElMensaje = $mensaje != '' ? ' Mensaje: ' . $mensaje : '';
				Log::channel($permissionsString)->info('Vista:' . $nombreC . ' Padre: ' . $nombreP . '|  U:' . Auth::user()->name . $ElMensaje);
			}
			else {
				Log::info('Vista: ' . $nombreC . ' Padre: ' . $nombreP . 'U:' . Auth::user()->name . ' ||' . $clase . '|| ' . ' Mensaje: ' . $mensaje);
			}
			
			return $permissions;
		}
		else {
			Log::critical('Vista: ' . $nombreC . 'U:' . Auth::user()->name . ' ||' . $clase . '|| ' . ' Mensaje: ' . $mensaje);
		}
	}
	
	public function redirect($ruta, $seconds = 14) {
		sleep($seconds);
		
		return redirect()->to($ruta);
	}
	//fin dates
	
	//IN: { intelu::HelpGPT.php}
	
	public function erroresExcel($errorFeo) {
		// $fila = session('ultimaPalabra');
		$error1 = "PDOException: SQLSTATE[22007]: Invalid datetime format: 1292 Incorrect date";
		if ($errorFeo == $error1) {
			return 'Existe una fecha invalida';
		}
		
		return 'Error desconocido';
	}
	
	public function ValidarFecha($laFecha) {
		if (strtotime($laFecha)) {
			return $laFecha;
		}
		
		return '';
	}
	
}
