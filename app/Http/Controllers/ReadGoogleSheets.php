<?php

namespace App\Http\Controllers;

use App\helpers\Myhelp;
use App\Models\GuardarGoogleSheetsComercial;
use App\Models\Ordentrabajo;
use App\Models\Reporte;
use App\Models\Role;
use Carbon\Carbon;
use Google\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Revolution\Google\Sheets\Sheets;

class ReadGoogleSheets extends Controller {
	
	public int $EstoActualizaCadaHoras = 1;
	// ordenzilef = 1
	// (2 caminos posibles a y b)
	//orden_zilef = 2
	public function mochar() {
		$hoyHora = Carbon::now();
		$reportesActivos = Reporte::whereNull('hora_final')
			// ->whereDate('fecha', $hoyHora)
			                      ->get()
		;
		
		if ($reportesActivos && $reportesActivos->count() > 0) {
			foreach ($reportesActivos as $index => $reportesActivo) {
				$reportesActivo->horFinalNoValidacion($hoyHora);
			}
		}
		
		
		return ' <h1>Reportes actualizados</h1><p>Todos incluidos. y ahora con nuevas columnas</p> ';
	}
	
	//ordenzilef = independiente
	
	public function OnlyViewNecesitaActualizaF(): bool|string {
		if (GuardarGoogleSheetsComercial::exists()) {
			$ultimo = GuardarGoogleSheetsComercial::OrderByDesc('updated_at')->first();
			$ultimaGuardada = Carbon::parse($ultimo->updated_at);
			
			if ($ultimaGuardada === null) {
				return 'Necesita actualizar';
			}
			$difHoras = Carbon::now()->diffInHours($ultimaGuardada);
			
			
			return 'Diferencia de horas: ' . $difHoras . '. Última hora guardada de horas: ' . $ultimaGuardada;
		}
		
		
		return 'No existe google ni un solo registro';
	}
	
	//ordenzilef = independiente
	public function ActualizaGoogleManual(Request $request): void {
		$cabezaYvalues = $this->vamoABusca();
		$cabezaYvalues = $this->vamoAGuardaComercial($cabezaYvalues, date('Y-m-d'));
		$this->Guardarot($cabezaYvalues, date('Y-m-d')); //este es lo nuevo que pidieron el 2 de abril
		// Encabezado HTML
		$html = "<!DOCTYPE html><html><head><title>Vista Rápida</title></head><body>";
		// Mostrar los valores
		$html .= "<h3>" . implode($cabezaYvalues[0]) . "</h1>";
		foreach ($cabezaYvalues[1] as $value) {
			$html .= "<p> " . implode(" == ", $value->getAttributes()) . " - </p>";
		}
		// Cierre HTML
		$html .= "</body></html>";
		// Enviar la respuesta HTML
		echo $html;
	}
	
	public function vamoABusca(): array {
		ini_set('max_execution_time', 200);// 3:40 mins
		$spreadsheetId = '138UtKtvq4ksEufoxHKNQUy20qHxEn5XTIBXzY5wzUJk';
		$sheetName = 'Hoja1';
		$client = new Client();
		$service = new Sheets($client);
		$client->setAuthConfig(storage_path('app/client.json'));
		//        $endRow = $this->consultaPrevia($service, $spreadsheetId, $sheetName); //todo: deberia estar en BD
		$endRow = 1000;
		$range = 'A1:E' . $endRow;
		$values = $service->spreadsheet($spreadsheetId)->sheet($sheetName)->range($range)->all();
		
		$cabeza = $values[0];
		unset($values[0]);
		
		
		return [$cabeza, $values];
	}
	
	public function vamoAGuardaComercial($cabezaYvalues, $Grupo): array {
		// $numberPermissions = Myhelp::getPermissionToNumber(auth()->user()->roles->pluck('name')[0]);
		
		$HayTiemposEstimados = 0;
		$authid = Myhelp::AuthUid();
		$hayQueGuardar = $this->validarItemsNuevos($cabezaYvalues, $Grupo);
		$Eloquentvalues = [];
		
		if ($hayQueGuardar) {
			
			$valueCabeza = $cabezaYvalues[0];
			$GoogleComercial = new GuardarGoogleSheetsComercial();
			$Eloquentvalues[0] = $GoogleComercial = ([
				'numero_oferta'       => $valueCabeza[0] ?? '',
				'ot'                  => $valueCabeza[1] ?? '',
				'cliente'             => $valueCabeza[2] ?? '',
				'avance'              => $valueCabeza[3] ?? '',
				'tiempo_estimado'     => $valueCabeza[4] ?? '',
				'HayTiemposEstimados' => $HayTiemposEstimados,
				'Grupo'               => $Grupo,
				'user_id'             => $authid,
			]);
			
			$superString = $valueCabeza[0] ?? '' . $valueCabeza[1] ?? '' . $valueCabeza[2] ?? '' . $valueCabeza[3] ?? '' . $valueCabeza[4] ?? '';
			
			Ordentrabajo::create([
				                     'codigo' => $Grupo,
				                     'nombre' => $superString
			                     ]);
			
			foreach ($cabezaYvalues[1] as $value) {
				if ((isset($value[4]) && strcasecmp($value[4], '') !== 0)) {
					$HayTiemposEstimados = 0;
				}
				else {
					$HayTiemposEstimados = 1;
				}
				
				$PrimeraFilaDebeDecir = 'CLIENTE'; //para saltar la fila de titulos en sheets
				if ((isset($value[2]) && $value[2] === $PrimeraFilaDebeDecir) || (!isset($value[4]))) {
					continue;
				}
				
				\App\Models\Ordentrabajo2::firstOrCreate([
					                                         'nombre' => $value[1] ?? '',
					                                         'cd'     => $value[0] ?? ''
				                                         ]);
				
				GuardarGoogleSheetsComercial::updateOrCreate([
					                                             'numero_oferta' => $value[0] ?? '',
					                                             'ot'            => $value[1] ?? '',
				                                             ], [
					                                             'numero_oferta'       => $value[0] ?? '',
					                                             'ot'                  => $value[1] ?? '',
					                                             'cliente'             => $value[2] ?? '',
					                                             'avance'              => $value[3] ?? '',
					                                             'tiempo_estimado'     => intval($value[4]) ?? '',
					                                             'HayTiemposEstimados' => $HayTiemposEstimados,
					                                             'Grupo'               => $Grupo,
					                                             'user_id'             => $authid,
				                                             ]);
				
			}
			
			$Eloquentvalues[1] = GuardarGoogleSheetsComercial::Where('Grupo', $Grupo)->get();
		}
		
		
		return $Eloquentvalues;
	}
	
	public function validarItemsNuevos($valuesGoogle, $Grupo): int {
		
		$queryUltimo = GuardarGoogleSheetsComercial::latest();
		if ($queryUltimo->get()->isEmpty()) {
			return 1;
		}
		
		$ultimoGrupo = $queryUltimo->first()->Grupo;
		$ValuesUltimoGrupo = GuardarGoogleSheetsComercial::Where('Grupo', $ultimoGrupo)->pluck('numero_oferta')->count();
		// VALIDACION 1 : NUMERO DE ITEMS
		
		if ($ValuesUltimoGrupo == count($valuesGoogle)) {
			return 1;
		} //todo: debe actualizar en caso que sea la misma cantidad
		
		
		return 1;
	}
	
	public function Actualizaot() {
		$cabezaYvalues = $this->vamoABusca();
		$registrosGuardados = $this->Guardarot($cabezaYvalues, date('Y-m-d'));
		$html = "<!DOCTYPE html><html><head><title>Vista Rápida</title></head><body>";
		$html .= "<h3> se actualizaron $registrosGuardados</h1>";
		$html .= "</body></html>";
		echo $html;
	}
	
	public function Guardarot($cabezaYvalues, $Grupo): int {
		try {
			$contador = 0;
			foreach ($cabezaYvalues[1] as $value) {
				$nombreParaGuardar = $value[1];
				$existe = DB::table('otgoogle')->where('nombre', $nombreParaGuardar)->exists(); // exists() es eficiente, devuelve true o false
				
				// 2. Si NO existe, entonces insertarlo
				if (!$existe) {
					DB::table('otgoogle')->insert(['nombre' => $nombreParaGuardar]);
					$contador ++;
				}
			}
			
			Log::info("Se ha insertando $contador registros en otgoogle con éxito.");
			
			return $contador;
		} catch (\Illuminate\Database\QueryException $ex) {
			Log::error("Error insertando en otgoogle: " . $ex->getMessage());
			//			 dd($ex->getMessage()); // Muestra el error para depuración
			echo 'Error insertando en otgoogle:  ' . $ex->getMessage();
			
			
			return 0;
		}
	}
	
	//ordenzilef = 4.1
	
	public function __invoke(Request $request) {
		Myhelp::EscribirEnLog($this, ' Invocando a ReadGoogle ');
		// $numberPermissions = Myhelp::getPermissionToNumber($permissions);
		// $spreadsheetId = '1EZkfkdQIMoiLewYhG8Qaw2JCc_jqnb_4_pOB75jJAT4'; $sheetName = 'Hoja 1'; //zilef
		[$cabeza, $values] = $this->GetValuesFromSheets();
		
		$total_cantidad = 0;
		foreach ($values as $value) {
			$total_cantidad += (int)($value[2]); //%avance
		}
		
		$total_cantidad = '' . $total_cantidad . ' / ' . $total_cantidad / count($values);
		
		
		return Inertia::render('sheet1/Index', [
			'breadcrumbs'    => [['label' => __('app.label.sheet'), 'href' => '/gsheet']],
			'title'          => __('app.label.user'),
			'cabeza'         => $cabeza,
			'valores'        => $values,
			'total_cantidad' => $total_cantidad,
		]);
	}
	
	//ordenzilef = 4
	
	public function GetValuesFromSheets() {
		$Grupo = date('Y-m-d');
		$NecesitaActualizar = $this->NecesitaActualizaF(); //oz = 2
		
		if ($NecesitaActualizar) {
			$cabezaYvalues = $this->vamoABusca();                                 //oz = 3
			$cabezaYvalues = $this->vamoAGuardaComercial($cabezaYvalues, $Grupo); // oz = 4
			
		}
		else {
			$cabezaYvalues = $this->Ultimo($Grupo); //oz = b1
		}
		
		
		return $cabezaYvalues;
	}
	
	//ordenzilef = b1
	
	public function NecesitaActualizaF(): bool {
		if (GuardarGoogleSheetsComercial::exists()) {
			$ultimo = GuardarGoogleSheetsComercial::OrderByDesc('updated_at')->first();
			$ultimaGuardada = Carbon::parse($ultimo->updated_at);
			
			if ($ultimaGuardada === null) {
				return true;
			}
			
			$difHoras = Carbon::now()->diffInHours($ultimaGuardada);
			
			
			return $difHoras >= $this->EstoActualizaCadaHoras;
		}
		
		
		return true;
	}
	
	public function Ultimo($Grupo): ?array {
		$ultimoGrupo = GuardarGoogleSheetsComercial::orderBy('Grupo', 'desc')->first();
		
		if (!$ultimoGrupo) {
			return null;
		}
		
		$values = GuardarGoogleSheetsComercial::where('Grupo', $ultimoGrupo->Grupo)->get();
		
		
		return [$values[0], $values];
	}
	
	public function justValidateConection(): string {
		ini_set('max_execution_time', 200);// 3:40 mins
		$spreadsheetId = '138UtKtvq4ksEufoxHKNQUy20qHxEn5XTIBXzY5wzUJk';
		$sheetName = 'Hoja1';
		$client = new Client();
		$service = new Sheets($client);
		$client->setAuthConfig(storage_path('app/client.json'));
		$endRow = $this->consultaPrevia($service, $spreadsheetId, $sheetName); //todo: deberia estar en BD
		
		
		return 'La última fila es:  ' . $endRow;
	}
	
	private function consultaPrevia($service, $spreadsheetId, $sheetName): int {
		$allValues = $service->spreadsheet($spreadsheetId)->sheet($sheetName)->all();
		$endRow = count($allValues);
		
		
		return $endRow + 1; //que tantos registros se hacen diarios?
	}
	
	public function phpinfoahk() {
		phpinfo();
	}
	
}
