<?php

namespace App\Imports;

use App\helpers\HelpExcel;
use App\Mail\ImportacionFinalizada;
use App\Models\Equipo;
use App\Models\Proveedor;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;


//WithValidation
class EquipoImport implements ToCollection, WithHeadingRow, SkipsOnError, WithChunkReading, ShouldQueue {
	
	use SkipsErrors;
	
	public int $numeroFilas = 1;
	public bool $interrupcionPorExcesoDeErrores;
	public int $numeroFilasConErrores = 0;
	public string $MensajeError = '';
	public array $MensajeErrorArray = [];
	
	//propias del proyecto
	public array $EquiposExistentes = [];
	public int $nFilasNuevas = 0;
	public int $nFilasActualizadas = 0;
	public int $nFilasOmitidas = 0;
	public int $nFilasSinPrecio = 0;
	public int $nFilasSinFecha = 0;
	

	public $ForbidenCodes = [
		'FALTA',
		'LIBRE',
		//		'#VALUE!',
		'',
		' ',
	];
	public $ForbidenPrices = [
		//		'#N/D',
		//		'#N/A',
		//		'#VALUE!',
		//		'SIN PRECIO',
		//		'DESCONTINUADO',
		'',
		' ',
	];
	
	public function chunkSize(): int { return 250; }
	
	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 * @throws \Exception
	 */
	public function collection(Collection $collection) {
		
		register_shutdown_function(function (): void {
			$error = error_get_last();
			if ($error && str_contains($error['message'], 'Allowed memory size')) {
				Log::channel('solosuper')->error('Job detenido por falta de memoria');
			}
		});
		
		$this->MensajeErrorArray = [];
		Log::channel('solosuper')->info('Desde EquipoImport Version 1.1.1 || ' . count($collection) . ' filas a procesar');
		
		if ($collection->isEmpty()) {
			Log::channel('solosuper')->error('Import vacío — nada que procesar');
			
			return null;
		}
		
		$first = $collection->first()->toArray();
		
		if (!$first) {
			return null;
		}
		
		// Normalizar las keys del primer row (case-insensitive, quitar espacios)
		$keys = array_map(function ($k) {
			return mb_strtolower(trim($k));
		}, array_keys($first));
		
		// Aceptar variaciones: 'codigo', 'código', 'code'
		$accepted = ['codigo', 'código', 'code'];
		
		$hasCodigo = collect($keys)->contains(function ($k) use ($accepted) {
			return in_array($k, $accepted, true);
		});
		
		if (!$hasCodigo) {
			Log::channel('solosuper')->error('Formato inválido: encabezado "codigo" no encontrado. Abortando import.');
			Mail::to('ajelof2@gmail.com')->send(new ImportacionFinalizada('Formato de Excel inválido: falta columna "codigo" en encabezado.'));
			
		}
		
		$this->interrupcionPorExcesoDeErrores = false;
		file_put_contents(storage_path('logs/debug_import.txt'), print_r('Antes del ciclo, linea 102 EquipMport--- ' . Carbon::now(), true), FILE_APPEND);
		$ArrayMensajeome = [];
		foreach ($collection as $row) {
			
			$this->numeroFilas ++;
			if (!isset($row['codigo'])) {
				if (!isset($row['descripcion'])) {
					$descrip = 'no descripcion';
				}
				else {
					$descrip = $row['descripcion'];
				}
				$ArrayMensajeome[] = '!!row omitida: Sin codigo. la Descricipcion es: ' . $descrip;
				
				$this->nFilasOmitidas ++;
				continue;
			}
			else {
				
				if (!$row['codigo'] || in_array($row['codigo'], $this->ForbidenCodes)) {
					$razon2 = !$row['codigo'];
					$razon3 = !$row['precio_de_lista']; //hola
					$razon4 = in_array($row['codigo'], $this->ForbidenCodes);
					//					$razon5 = in_array($row['precio_de_lista'], $this->ForbidenPrices);
					$this->nFilasOmitidas ++;
					$vectorimploded = implode(', ', $row->toArray());
					//					dd($row,$razon2 , $razon3 , $razon4);
					if ($razon2) {
						$razon2 = 'No existe el codigo. ';
					}
					if ($razon3) {
						$razon3 = 'No existe el precio de lista. ';
					}
					if ($razon4) {
						$razon4 = 'Hay un codigo prohibido. ';
					}
					$mensajeome = '!!_!row omitida: ' . $vectorimploded . ' :: ' . $razon2 . $razon3 . $razon4;
					Log::channel('solosuper')->info('Desde EquipoImport, falta o libre ' . '::' . $mensajeome);
					
					continue;
				}
			}
			
			if (isset($row['codigo']) && $row) {
				//inicio validaciones
				$ValidRow0 = $this->Validarvacios($row);
				$this->TransformarNumeros($row);
				$this->PutZeroNotRequiredNumbers($row);
				//fin validaciones
				
				if ((strcmp($ValidRow0, '') === 0)) {
					$this->CrearYContar($row);
				}
				else {
					$this->numeroFilasConErrores ++;
					$this->MensajeErrorArray[] = $ValidRow0 . ' -- En la fila ' . $this->numeroFilas . ' ';
					if ($this->numeroFilasConErrores > 10) {
						$this->interrupcionPorExcesoDeErrores = true;
						break;
					}
				}
				
			}
		}
		$countMensajeome = count($ArrayMensajeome);
		if ($countMensajeome) {
			Log::channel('solosuper')->info('Desde EquipoImport :: N = ' . $countMensajeome . ' filas omitidas sin codigo ' . '::' . implode(',', $ArrayMensajeome));
		}
		$counterrorArray = count($this->MensajeErrorArray);
		if ($counterrorArray) {
			Log::channel('solosuper')->info('Desde EquipoImport :: N = ' . $counterrorArray . ' errores ::' . implode(',', $this->MensajeErrorArray));
		}
		
	}
	
	private function Validarvacios(mixed $row): string { //excesodeerrores
		
		$valideRequired = [
			'codigo',
			'codigo',
		];
		$mensaje = '';
		foreach ($valideRequired as $campo) {
			if (!isset($row[$campo]) || strcmp($row[$campo], '') === 0) {
				$mensaje = 'Campo ' . $campo . ' es obligatorio: ' . $row[$campo] . '. En la fila ' . $this->numeroFilas;
				Log::channel('solosuper')->info('Desde EquipoImport ' . '::' . $mensaje);
				
				return $mensaje;
			}
		}
		
		return $mensaje;
	}
	
	public function TransformarNumeros(mixed &$row): void {
		
		$validarNumeros = [
			'precio_de_lista',
			'deshabilitado',
		];
		foreach ($validarNumeros as $campo) {
			$soloEsUnaFila = true;
			file_put_contents(storage_path('logs/debug_import.txt'), print_r('TransformarNumeros::' . Carbon::now(), true), FILE_APPEND);
			if (!is_numeric($row[$campo]) || trim($row[$campo]) == null) {
				$soloEsUnaFila = false;
				$imprimible = $row->toArray();
				$imprimible['abc2'] = !!(!is_numeric($row[$campo]));
				$imprimible['abc3'] = !!(trim($row[$campo]) == null);
				$imprimible['abc4'] = $campo;
				file_put_contents(storage_path('logs/debug_import.txt'), print_r($imprimible, true), FILE_APPEND);
				
				$row[$campo] = 0;
			}
		}
		
		if (!$soloEsUnaFila) {
			$this->nFilasSinPrecio ++;
		}
		file_put_contents(storage_path('logs/debug_import.txt'), print_r('Finalizamos-TransformarNumeros::' . Carbon::now(), true), FILE_APPEND);
		
	}
	
	public function PutZeroNotRequiredNumbers(mixed &$row): void {
		
		$validarNumeros = [
			//trm tasa representativa del mercado
			'descuento_basico',
			'descuento_proyectos',
			'precio_con_descuento',
			'precio_con_descuento_proyecto',
			'precio_ultima_compra',
			'precios_de_listas',
			
			'tiempos_chapisteria',
		];
		foreach ($validarNumeros as $campo) {
			if (!is_numeric($row[$campo]) || trim($row[$campo]) == null) {
				$row[$campo] = 0;
			}
		}
	}
	
	private function CrearYContar(mixed $row): null|Equipo {
		$codigoUnico = intval($row['codigo']);
		$fechaActualizacion = HelpExcel::getFechaExcel($row['fecha_actualizacion']);
		if (!$fechaActualizacion) {
			$this->nFilasSinFecha ++;
		}
		if (!isset($row['descripcion'])) {
			$descrip = 'Sin descripcion';
		}
		else {
			$descrip = $row['descripcion'];
		}
		
		$rowdesabilitado = trim($row['deshabilitado']);
		if ($rowdesabilitado == 1 || $rowdesabilitado === '1' || $rowdesabilitado === '') {
			$habilitadu = 0;
		}
		else {
			$habilitadu = 1;
		}
		
		$DatosDelEquipo = [
			'codigo'                        => $codigoUnico,
			'descripcion'                   => $descrip,
			'tipo_fabricante'               => $row['tipo_fabricante'] ?? '',
			'referencia_fabricante'         => $row['ref_fabricante'] ?? '',
			'marca'                         => $row['marca'] ?? '',
			'unidad_de_compra'              => $row['unidad_de_compra'] ?? '',
			'precio_de_lista'               => $row['precio_de_lista'] ?? 0,
			'fecha_actualizacion'           => $fechaActualizacion, //Es algo bloqueante?
			'descuento_basico'              => $row['descuento_basico'] ?? 0,
			'descuento_proyectos'           => $row['descuento_proyectos'] ?? 0,
			'precio_con_descuento'          => $row['precio_con_descuento'] ?? 0,
			'precio_con_descuento_proyecto' => $row['precio_con_descuento_proyecto'] ?? 0,
			'precio_ultima_compra'          => $row['precio_ultima_compra'] ?? 0,
			'precios_de_listas'             => $row['precios_de_listas'] ?? 0,
			'ruta_tiempos'                  => $row['ruta_tiempos'] ?? '',
			'tiempos_chapisteria'           => $row['tiempos_chapisteria'] ?? 0,
			'habilitado'                    => $habilitadu,
		];
		
		$equipo = Equipo::updateOrCreate(['codigo' => $codigoUnico], $DatosDelEquipo);
		if ($equipo->wasRecentlyCreated) {
			$this->nFilasNuevas ++;
		}
		else {
			$this->nFilasActualizadas ++;
		}
		
		$this->EncontrarProveedor($row, $equipo);
		
		return $equipo;
	}
	
	public function EncontrarProveedor($row, $equipo) {
		for ($i = 1; $i < 7; $i ++) {
			if (strcmp($row['proveedor_' . $i], '') !== 0) {
				
				$provedor1 = Proveedor::Where('nombre', $row['proveedor_' . $i])->first();
				if (!$provedor1) {
					$provedor1 = Proveedor::create(['nombre' => $row['proveedor_' . $i]]);
					$mensajeome = 'Subiendo Equipos no se encontró el provedor N' . $i . ' con nombre ' . $row['proveedor_' . $i];
					Log::channel('solosuper')->info('Desde EquipoImport ' . '::' . $mensajeome);
				}
				if (!$equipo->proveedores->contains($provedor1->id)) {
					$equipo->proveedores()->sync($provedor1->id);
				}
				
				if (!$provedor1->equipos->contains($equipo->id)) {
					$provedor1->equipos()->sync($equipo->id);
				}
			}
		}
	}
	
	
	//	public function rules(): array {
	//		return [
	//			'precios_de_listas' => 'nullable|integer', // Validar que sea un entero
	//		];
	//	}
	
	public function onError(Throwable $e) {
		$erroresThrow = $e->getMessage() . '::' . $e->getLine() . '::' . $e->getFile();
		$mensajeome = 'onerror de Equipo import ' . ' | Error en la importación: ' . $erroresThrow;
		Log::channel('solosuper')->info('Desde EquipoImport ' . '::' . $mensajeome);
		dd('Error en la importación: ' . $e->getMessage());
	}
	
	private function debugiarcodigoRow(mixed $row) {
		if ($this->numeroFilas == 22) {
			dd($row, $row->toArray(), $row->toArray()['codigo'] ?? null, $row['codigo'] ?? 'no', !$row['precio_de_lista'], in_array($row['codigo'], $this->ForbidenCodes), in_array($row['precio_de_lista'], $this->ForbidenPrices));
		}
	}
	
}
