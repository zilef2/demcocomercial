<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SubirMultipleEquipos implements WithMultipleSheets ,SkipsUnknownSheets {
  
	public mixed $valoresProvedores;
	public mixed $valoresEquipo;

	/**
	 * @return array
	 */
	public function sheets(): array {
		$this->valoresProvedores = new ProveedoresImport();
		$this->valoresEquipo = new EquipoImport();
        return [
            'PROVEDORES' => $this->valoresProvedores,
            'Hoja1' => $this->valoresEquipo,
        ];
    }
	
	public function onUnknownSheet($sheetName) {info("La hoja {$sheetName} fue omitida"); }
	
	public function onError(\Throwable $e): void {
        $this->numeroFilasConErrores++;
//        $this->errores[] = [
//            'fila' => $this->numeroFilas + 1, // La fila con error (considerando la fila de encabezado)
//            'mensaje' => $e->getMessage(),
//        ];
    }
}