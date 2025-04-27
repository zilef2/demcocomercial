<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SubirMultipleEquipos implements WithMultipleSheets ,SkipsUnknownSheets
{
  
	public $numeroFilas;

	/**
	 * @return array
	 */
	public function __construct()
	{
		$this->numeroFilas = 0;
	}

	/**
	 * @return array
	 */
	public function sheets(): array
    {
        return [
            'PRO' => new ProveedoresImport(),
            'LISTADO' => new EquipoImport(),
        ];
    }
	
	public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        info("La hoja {$sheetName} fue omitida");
    }
}