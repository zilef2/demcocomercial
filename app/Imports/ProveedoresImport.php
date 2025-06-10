<?php

namespace App\Imports;

use App\helpers\Myhelp;
use App\Models\Proveedor;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;

class ProveedoresImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnError {
	
	use SkipsErrors;
	
	public int $numeroFilas = 0;
	
	public function collection(\Illuminate\Support\Collection $collection) {
		
		foreach ($collection as $row) {
			
			if ($row['proveedor_1']) {
				$this->numeroFilas += $this->crearSoloSiNoExiste($row['proveedor_1']);
			}
			if ($row['proveedor_2']) {
				$this->numeroFilas += $this->crearSoloSiNoExiste($row['proveedor_2']);
			}
			if ($row['proveedor_3']) {
				$this->numeroFilas += $this->crearSoloSiNoExiste($row['proveedor_3']);
			}
			if ($row['proveedor_4']) {
				$this->numeroFilas += $this->crearSoloSiNoExiste($row['proveedor_4']);
			}
			if ($row['proveedor_5']) {
				$this->numeroFilas += $this->crearSoloSiNoExiste($row['proveedor_5']);
			}
			if ($row['proveedor_6']) {
				$this->numeroFilas += $this->crearSoloSiNoExiste($row['proveedor_6']);
			};
		}
	}
	
	public function crearSoloSiNoExiste(string $criterios, array $datosAdicionales = []): int {
		$ArrayCriterios = ['nombre' => $criterios];
		if (!(is_float($criterios) || is_int($criterios))) {
			$modelo = Proveedor::where($ArrayCriterios)->first();
			
			if (!$modelo) {
				Proveedor::create(array_merge($ArrayCriterios, $datosAdicionales));
				
				
				return 1;
			}
		}
		
		
		return 0;
	}
	
	public function rules(): array {
		return [
			//	'Nombre' => 'nullable|string',
			'proveedor_1' => 'nullable',
			'proveedor_2' => 'nullable',
			'proveedor_3' => 'nullable',
			'proveedor_4' => 'nullable',
			'proveedor_5' => 'nullable',
			'proveedor_6' => 'nullable',
		];
	}
	
	public function onError(Throwable $e) {
		// Aquí puedes registrar el error con información adicional, como el número de fila
		Myhelp::EscribirEnLog($this, 'onerror de Proveedor import ' . ' | Error en la importación: ' . $e->getMessage());
		\dd('Error en la importación de Proveedores: ' . $e->getMessage());
	}
}
