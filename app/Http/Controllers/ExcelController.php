<?php

namespace App\Http\Controllers;

use App\helpers\Myhelp;
use App\Imports\EquipoImport;
use App\Imports\SubirMultipleEquipos;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ExcelController extends Controller {
	
	public function importEquipo(Request $request): \Illuminate\Http\RedirectResponse //import
	{
		$VariablesEsteProyecto = [
			'log'          => 'Este es el log de la importación de equipos',
			'Validaciones' => [
				'formatos1'           => 'xlsx',
				'formatos2'           => 'xls',
				'mensajeErrorFormato' => 'xls',
				'pesoMaximo'          => 8192, //debe pesar menos de 8MB +-
				'pesoMaximoerror'     => 'El archivo debe pesar menos de 8MB',
			],
		];
		
		Myhelp::EscribirEnLog($this, $VariablesEsteProyecto['log']);
		$exten = $request->archivo1->getClientOriginalExtension();
		// Validar que el archivo es de Excel
		if ($exten != 'xlsx' && $exten != 'xls') {
			return back()->with('warning', 'El archivo debe ser de Excel');
		}
		$pesoMaximo = $VariablesEsteProyecto['Validaciones']['pesoMaximo']; //int
		$pesoKilobyte = ((int)($request->archivo1->getSize())) / (1024);
		if ($pesoKilobyte > $pesoMaximo) {
			return back()->with('warning', $VariablesEsteProyecto['Validaciones']['pesoMaximoerror']);
		}
		
		try {
			$import = new SubirMultipleEquipos();
			Excel::import($import, $request->archivo1);
			$mensaje = $import->valoresEquipo->MensajeErrorArray;
			$filasAc = (int)$import->valoresEquipo->nFilasActualizadas;
			$filasNew = (int)$import->valoresEquipo->nFilasNuevas;
			$filasLeidas = $filasAc + $filasNew;
			
			$mensajeFinal = implode(', ', array_slice($mensaje, 0, 3)).  '  '.
				 $filasAc. ' filas actualizadas '. 
				 $filasNew. ' filas nuevas '. 
				count($mensaje) . ' filas con errores '. 
				$filasLeidas . ' filas cargadas '.
			' ';
			
			if ($mensaje === []) {
				return back()->with('success', $mensajeFinal);
			}
			else {
				return back()->with('error', $mensajeFinal);
			}
			
		} catch (ValidationException $e) {
			$failures = $e->failures();
			$errorRows = collect($failures)->map(function ($failure) {
				$rowNumber = $failure->row();
				$attribute = $failure->attribute();
				$errors = $failure->errors();
				$values = $failure->values();
				
				$errorMessage = "Fila {$rowNumber}, Columna '{$attribute}': ";
				$errorMessage .= implode(', ', $errors);
				$errorMessage .= " (Valores: " . json_encode($values) . ")";
				
				
				return $errorMessage;
			});
			
			$errorSummary = $errorRows->implode('; ');
			
			$message = 'Se encontraron errores en el archivo Excel.';
			if ($errorSummary) {
				$message .= ' Detalles: ' . $errorSummary;
			}
			else {
				$message .= ' Detalles: ' . $e->getMessage(); // Mostrar el mensaje original si no hay fallas detalladas
			}
			
			
			// if (config('app.env') === 'production') {
			return back()->with('warning', 'Error Excel. ' . $e->getMessage() . '. filas con errores: ' . $message);
			// }else{
			//     return back()
			//     ->with('error', 'Error en el proceso de Excel. ' . $lasRowMalas)
			// }
		}
	}
	
	public function FunctionUploadFromEx(Request $request) {
		Myhelp::EscribirEnLog($this, 'users FunctionUploadFromEx');
		
		
		return Inertia::render('uploadExcel/uploadFromExcel', [
			'title'       => __('app.label.Equipo'),
			'breadcrumbs' => [['label' => __('app.label.user'), 'href' => route('Equipo.index')]],
			'NumEquipos'  => \App\Models\Equipo::all()->count(),
		]);
	}
}
