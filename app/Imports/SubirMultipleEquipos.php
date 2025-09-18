<?php

namespace App\Imports;

use App\Mail\ImportacionFinalizada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterImport;

class SubirMultipleEquipos implements WithMultipleSheets, SkipsUnknownSheets {
	
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
			'Hoja1'      => $this->valoresEquipo,
		];
	}
	
	public function onUnknownSheet($sheetName) { info("La hoja {$sheetName} fue omitida"); }
	
	public function onError(\Throwable $e): void {
		$this->numeroFilasConErrores ++;
		//        $this->errores[] = [
		//            'fila' => $this->numeroFilas + 1, // La fila con error (considerando la fila de encabezado)
		//            'mensaje' => $e->getMessage(),
		//        ];
	}
	
	public function registerEvents(): array {
		return [
			AfterImport::class => function () {
				Mail::to($this->email)->send(new ImportacionFinalizada('Archivo procesado correctamente'));
			},
		];
	}
	
}