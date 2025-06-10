<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SubirMultipleEquipos implements WithMultipleSheets ,SkipsUnknownSheets {
  
	public int $numeroFilas1;
	public int $numeroFilas2;
	public int $numeroFilasErrores1;
	public int $numeroFilasErrores2;
	public mixed $valoresProvedores;
	public mixed $valoresEquipo;

	/**
	 * @return array
	 */
	public function __construct() {
//		$this->numeroFilas1 = 0;
//		$this->numeroFilas2 = 0;
//		$this->numeroFilasErrores1 = 0;
//		$this->numeroFilasErrores2 = 0;
	}

	/**
	 * @return array
	 */
	public function sheets(): array {
		$this->valoresProvedores = new ProveedoresImport();
		$this->valoresEquipo = new EquipoImport();
        return [
            'PROVEDORES' => $this->valoresProvedores,
            'LISTADO' => $this->valoresEquipo,
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