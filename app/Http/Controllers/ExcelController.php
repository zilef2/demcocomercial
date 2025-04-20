<?php

namespace App\Http\Controllers;

use App\helpers\Myhelp;
use App\Imports\EquipoImport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ExcelController extends Controller {
	
	public function importEquipo(Request $request) //import
	{
		Myhelp::EscribirEnLog($this, 'users FunctionUploadFromExPost');
		$exten = $request->archivo1->getClientOriginalExtension();
		// Validar que el archivo es de Excel
		if ($exten != 'xlsx' && $exten != 'xls') {
			return back()->with('warning', 'El archivo debe ser de Excel');
		}
		$pesoKilobyte = ((int)($request->archivo1->getSize())) / (1024);
		if ($pesoKilobyte > 1256) { //debe pesar menos de 1MB +-
			return back()->with('warning', 'El archivo debe pesar menos de 1MB');
		}
		
		try {
			$import = new EquipoImport;
			Excel::import($import, $request->archivo1);
			
			
			return back()->with('success', $import->numeroFilas.' filas han sido cargadas correctamente.');
			
		} catch (ValidationException $e) {
			$failures = $e->failures();
			$errorRows = collect($failures)->map(function ($failure) {
				$rowNumber = $failure->row();
				$attribute = $failure->attribute();
				$errors = $failure->errors();
//				$values = $failure->values();
				
				$errorMessage = "Fila {$rowNumber}, Columna '{$attribute}': ";
				$errorMessage .= implode(', ', $errors);
//				$errorMessage .= " (Valores: " . json_encode($values) . ")";
				
				
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
