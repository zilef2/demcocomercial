<?php

namespace App\Imports;

use App\helpers\HelpExcel;
use App\helpers\Myhelp;
use App\Models\Equipo;
use App\Models\Proveedor;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

//WithValidation
class EquipoImport implements ToCollection, WithHeadingRow, SkipsOnError {
	
	use SkipsErrors;
	
	public int $numeroFilas = 1;
	public int $numeroFilasConErrores = 0;
	public string $MensajeError = '';
	public array $MensajeErrorArray = [];
	
	//propias del proyecto
	public array $EquiposExistentes = [];
	public int $nFilasNuevas = 0;
	public int $nFilasActualizadas = 0;
	public int $nFilasOmitidas = 0;
	
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
	
	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 * @throws \Exception
	 */
	public function collection(Collection $collection) {
		foreach ($collection as $row) {
			$this->numeroFilas ++;
			
			//			if(true)$this->debugiarCodigoRow($row);
			if (!isset($row['codigo'])) {
				$mensajeome = '!!row omitida: Sin codigo';
				Myhelp::EscribirEnLog($this, 'EquipoImport collection', $mensajeome, false);
				$this->nFilasOmitidas ++;
				
				continue;
			}
			else {
				if (!$row['codigo'] || !$row['precio_de_lista'] || in_array($row['codigo'], $this->ForbidenCodes)) {
					$razon2 = !$row['codigo'];
					$razon3 = !$row['precio_de_lista']; //hola
					$razon4 = in_array($row['codigo'], $this->ForbidenCodes);
					//					$razon5 = in_array($row['precio_de_lista'], $this->ForbidenPrices);
					$this->nFilasOmitidas ++;
					$vectorimploded = implode(', ', $row->toArray());
					//					dd($row,$razon2 , $razon3 , $razon4);
					$mensajeome = '!!_!row omitida: ' . $vectorimploded . ' ...las razones fueron: ' . $razon2 . $razon3 . $razon4;
					Myhelp::EscribirEnLog($this, 'EquipoImport collection', $mensajeome, false);
					
					continue;
				}
			}
			
			if (isset($row['codigo']) && $row) {
				$equipoExistente = Equipo::where('Codigo', $row['codigo'])->first();
				
				if ($equipoExistente) {
					$this->EquiposExistentes[] = $row['codigo'];
					continue;
				}
				
				//validaciones
				$ValidRow0 = $this->Validarvacios($row);
				$ValidRow1 = $this->ValidarNumeros($row);
				$this->TransformarNumeros($row);
				
				if ((strcmp($ValidRow0, '') === 0 && strcmp($ValidRow1, '') === 0)) {
					$this->CrearYContar($row);
				}
				else {
					$this->numeroFilasConErrores ++;
					$this->MensajeErrorArray[] = $ValidRow0 . ' ' . $ValidRow1 . ' En la fila ' . $this->numeroFilas . ' ';
					if ($this->numeroFilasConErrores > 5) {
						break;
					}
				}
				
			}
		}
		Myhelp::EscribirEnLog($this, 'Equipos ya existentes (codigo): ' . implode(', ', $this->EquiposExistentes), false);
		
	}
	
	private function Validarvacios(mixed $row): string {
		
		$valideRequired = [
			'codigo',
		];
		$mensaje = '';
		foreach ($valideRequired as $campo) {
			if (!isset($row[$campo]) || strcmp($row[$campo], '') === 0) {
				$mensaje = 'Campo ' . $campo . ' es obligatorio: ' . $row[$campo] . '. En la fila ' . $this->numeroFilas;
				Myhelp::EscribirEnLog($this, $mensaje, false);
				
				
				return $mensaje;
			}
		}
		
		
		return $mensaje;
	}
	
	private function ValidarNumeros(mixed $row): string {
		$validarNumeros = [
			//			'precio_de_lista',
			//			'descuento_basico', //trm tasa representativa del mercado
			//			'descuento_proyectos',
			//			'precio_con_descuento',
			
			//			'precio_con_descuento_proyecto',
			//			'precios_de_listas',
			//			'Precio Ultima Compra',
			//			'Tiempos Chapisteria'
		];
		$mensaje = '';
		foreach ($validarNumeros as $campo) {
			if (trim($row[$campo]) !== '') {
				if (!is_numeric($row[$campo])) {
					$mensaje = 'La Columna ' . $campo . ' no es un número: ' . $row[$campo];
					Myhelp::EscribirEnLog($this, $mensaje, false);
					
					
					return $mensaje;
				}
				if (strtoupper(trim($row[$campo])) === '#N/A') {
					$mensaje = 'La Columna ' . $campo . ' contiene un valor no válido: ' . $row[$campo];
					Myhelp::EscribirEnLog($this, $mensaje, false);
					
					
					return $mensaje;
				}
			}
		}
		
		
		return $mensaje;
	}
	
	public function TransformarNumeros(mixed $row): void {
		
		$validarNumeros = [
			'descuento_basico', //trm tasa representativa del mercado
			'descuento_proyectos',
			'precio_con_descuento',
			'precio_ultima_compra',
			'tiempos_chapisteria',
			'precio_de_lista',
			
			'precio_con_descuento_proyecto',
			'precios_de_listas',
		];
		foreach ($validarNumeros as $campo) {
			//			if($row[$campo] == '#VALUE!') dd($row,$this->numeroFilas);
			if (trim($row[$campo]) !== '') {
				if (!is_numeric($row[$campo])) {
					$row[$campo] = 0;
				}
			}
		}
	}
	
	private function CrearYContar(mixed $row): null|Equipo {
		$codigoUnico = intval($row['codigo']);
		$fechaActualizacion = HelpExcel::getFechaExcel($row['fecha_actualizacion']);
		if ($fechaActualizacion) {
			
			$DatosDelEquipo = [
				'Codigo'                        => $codigoUnico,
				'Descripcion'                   => $row['descripcion'] ?? '',
				'Tipo Fabricante'               => $row['tipo_fabricante'] ?? '',
				'Referencia Fabricante'         => $row['ref_fabricante'] ?? '',
				'Marca'                         => $row['marca'] ?? '',
				'Unidad de Compra'              => $row['unidad_de_compra'] ?? '',
				'Precio de Lista'               => $row['precio_de_lista'] ?? '',
				'Fecha actualizacion'           => $fechaActualizacion, //a
				'Descuento Basico'              => $row['descuento_basico'] ?? 0,
				'Descuento Proyectos'           => $row['descuento_proyectos'] ?? 0,
				'Precio con Descuento'          => $row['precio_con_descuento'] ?? 0,
				'Precio con Descuento Proyecto' => $row['precio_con_descuento_proyecto'] ?? 0,
				'Precio Ultima Compra'          => $row['precio_ultima_compra'] ?? 0,
				'Precios de Listas'             => $row['precios_de_listas'] ?? 0,
				'Clasificacion 2 Inventario'    => '',
				'Ruta Tiempos'                  => $row['ruta_tiempos'] ?? '',
				'Tiempos Chapisteria'           => $row['tiempos_chapisteria'] ?? 0,
			];
			
			$equipo = Equipo::updateOrCreate(['Codigo' => $codigoUnico], $DatosDelEquipo);
			if ($equipo->wasRecentlyCreated) {
				$this->nFilasNuevas ++;
			}
			else {
				$this->nFilasActualizadas ++;
			}
			
			$this->EncontrarProveedor($row, $equipo);
			
			
			return $equipo;
		}else{
			$this->nFilasOmitidas ++;
			return null;
		}
	}
	
	public function EncontrarProveedor($row, $equipo) {
		for ($i = 1; $i < 7; $i ++) {
			if (strcmp($row['proveedor_' . $i], '') !== 0) {
				
				$provedor1 = Proveedor::Where('nombre', $row['proveedor_' . $i])->first();
				if (!$provedor1) {
					$provedor1 = Proveedor::create(['nombre' => $row['proveedor_' . $i]]);
					Myhelp::EscribirEnLog($this, 'Subiendo Equipos no se encontró el provedor N' . $i . ' con nombre ' . $row['proveedor_' . $i], false);
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
	//			'Precios de Listas' => 'nullable|integer', // Validar que sea un entero
	//		];
	//	}
	
	public function onError(Throwable $e) {
		// Aquí puedes registrar el error con información adicional, como el número de fila
		Myhelp::EscribirEnLog($this, 'onerror de Equipo import ' . ' | Error en la importación: ' . $e->getMessage());
		dd('Error en la importación: ' . $e->getMessage());
	}
	
	private function debugiarCodigoRow(mixed $row) {
		if ($this->numeroFilas == 22) {
			dd($row, $row->toArray(), $row->toArray()['codigo'] ?? null, $row['codigo'] ?? 'no', !$row['precio_de_lista'], in_array($row['codigo'], $this->ForbidenCodes), in_array($row['precio_de_lista'], $this->ForbidenPrices));
		}
	}
}
