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

class EquipoImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnError {
	
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
		'',
		' ',
	];
	public $ForbidenPrices = [
		'#N/D',
		'#N/A',
		'SIN PRECIO',
		'DESCONTINUADO',
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
			if (!$row['codigo'] || !$row['precio_de_lista'] ||
				in_array($row['codigo'], $this->ForbidenCodes) || in_array($row['precio_de_lista'], $this->ForbidenPrices)) {
				$this->nFilasOmitidas ++;
				continue;
			}
			
			
			if (isset($row['codigo']) && $row) {
				$equipoExistente = Equipo::where('Codigo', $row['codigo'])->first();
				
				if ($equipoExistente) {
					$this->EquiposExistentes[] = $row['codigo'];
					continue;
				}
				$ValidRow0 = $this->Validarvacios($row);
				$ValidRow1 = $this->ValidarNumeros($row);
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
			'precio_de_lista',
			'descuento_basico',
			'descuento_proyectos',
			'precio_con_descuento',
			'precio_con_descuento_proyecto',
			'precios_de_listas',
			//			'Precio Ultima Compra',
			//			'Tiempos Chapisteria'
		];
		$mensaje = '';
		foreach ($validarNumeros as $campo) {
			if (trim($row[$campo]) !== '') {
				if (!is_numeric($row[$campo])) {
					$mensaje = 'Campo ' . $campo . ' no es un número: ' . $row[$campo];
					Myhelp::EscribirEnLog($this, $mensaje, false);
					
					
					return $mensaje;
				}
				if (strtoupper(trim($row[$campo])) === '#N/A') {
					$mensaje = 'El campo ' . $campo . ' contiene un valor no válido: ' . $row[$campo];
					Myhelp::EscribirEnLog($this, $mensaje, false);
					
					
					return $mensaje;
				}
			}
		}
		
		
		return $mensaje;
	}
	
	private function CrearYContar(mixed $row) {
		$codigoUnico = intval($row['codigo']);
		$DatosDelEquipo = [
			'Codigo'                        => $codigoUnico,
			'Descripcion'                   => $row['descripcion'] ?? '',
			'Tipo Fabricante'               => $row['tipo_fabricante'] ?? '',
			'Referencia Fabricante'         => $row['ref_fabricante'] ?? '',
			'Marca'                         => $row['marca'] ?? '',
			'Unidad de Compra'              => $row['unidad_de_compra'] ?? '',
			'Precio de Lista'               => $row['precio_de_lista'] ?? '',
			'Fecha actualizacion'           => HelpExcel::getFechaExcel($row['fecha_actualizacion']),
			'Descuento Basico'              => $row['descuento_basico'] ?? '',
			'Descuento Proyectos'           => $row['descuento_proyectos'] ?? '',
			'Precio con Descuento'          => $row['precio_con_descuento'] ?? '',
			'Precio con Descuento Proyecto' => $row['precio_con_descuento_proyecto'] ?? '',
			'Precio Ultima Compra'          => $row['precio_ultima_compra'] ?? 0,
			'Precios de Listas'             => $row['precios_de_listas'] ?? '',
			'Clasificacion 2 Inventario'    => '',
			'Ruta Tiempos'                  => $row['ruta_tiempos'] ?? '',
			'Tiempos Chapisteria'           => $row['tiempos_chapisteria'] ?? 0,
		];
		
		$equipo = Equipo::updateOrCreate(['Codigo' => $codigoUnico], $DatosDelEquipo);
		if ($equipo->wasRecentlyCreated) {
			$this->nFilasNuevas ++;
		}else {
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
	
	public function rules(): array {
		return [
			'Precios de Listas' => 'nullable|integer', // Validar que sea un entero
		];
	}
	
	public function onError(Throwable $e) {
		// Aquí puedes registrar el error con información adicional, como el número de fila
		Myhelp::EscribirEnLog($this, 'onerror de Equipo import ' . ' | Error en la importación: ' . $e->getMessage());
		dd('Error en la importación: ' . $e->getMessage());
	}
}
