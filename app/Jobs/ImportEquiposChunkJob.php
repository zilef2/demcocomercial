<?php

namespace App\Jobs;

use App\Imports\SubirMultipleEquipos;
use App\Mail\ImportacionFinalizada;
use App\Models\Equipo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ImportEquiposChunkJob implements ShouldQueue {
	
	//php artisan queue:work --queue=default --daemon --sleep=1 --tries=1 --max-jobs=100
	
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	public string $rutaArchivo;
	public string $email;
	
	public function __construct(string $rutaArchivo, $email = 'ajelof2@gmail.com') {
		$this->rutaArchivo = $rutaArchivo;
		$this->email = $email;
	}
	
	public function handle() {
		try {
			Log::channel('solosuper')->info('estamos en job 1');
			
			$import = new SubirMultipleEquipos();
			//			Excel::import($import, $this->rutaArchivo);
			if (!file_exists($this->rutaArchivo)) {
				Log::error("Archivo no encontrado: " . $this->rutaArchivo);
			}
			app(\Maatwebsite\Excel\Excel::class)->import($import, $this->rutaArchivo);
			
			// Preparar el mensaje
			$interrupcionPorExcesoDeErrores = $import->valoresEquipo->interrupcionPorExcesoDeErrores;
			
				
				$mensaje = $import->valoresEquipo->MensajeErrorArray;
				$filasAc = (int)$import->valoresEquipo->nFilasActualizadas;
				$filasNew = (int)$import->valoresEquipo->nFilasNuevas;
				$nFilasSinPrecio = (int)$import->valoresEquipo->nFilasSinPrecio;
//				$nFilasSinFecha = (int)$import->valoresEquipo->nFilasSinFecha;
				$filasLeidas = $filasAc + $filasNew;
				$nFilasOmitidas = (int)$import->valoresEquipo->nFilasOmitidas;
				
				$mensajefin = $filasNew . ' filas nuevas.  ' 
					. $filasAc . ' filas actualizadas.  ' 
					. $nFilasOmitidas . ' sin código.  '
					. $nFilasSinPrecio . ' sin precio.  ' 
//					. $nFilasSinFecha . ' sin fecha de actualizacion. ' 
					. $filasLeidas . ' en total.'
				;
				$mensajeFinal = implode(', ', array_slice($mensaje, 0, 3)) . '  ' . $mensajefin;
				
				if(count($import->valoresEquipo->MensajeErrorArray)){
					$mensajeFinal = 'Errores encontrados: ' . implode(', ', $import->valoresEquipo->MensajeErrorArray) . '. ' . $mensajeFinal;
				} else {
					$mensajeFinal = 'Importación finalizada sin errores. ' . $mensajeFinal;
				}
				
				if ($interrupcionPorExcesoDeErrores) {
					$mensajeFinal =  'Se ha interrumpido la importación debido a que algunos equipos no cuentan con codigo. Por favor, revise el archivo.' . $mensajeFinal;
					Log::error($mensajeFinal);
				}
				// Enviar el correo
			Log::channel('solosuper')->info('Empezamos a mandar correo');
			
			if (app()->environment('local') || app()->environment('test')) {
				$mensajeFinal = 'Este es un mensaje de prueba. ' . $mensajeFinal;
				Log::channel('solosuper')->info('Estamos en local o test, no se envian correos');
				Log::channel('solosuper')->info($mensajeFinal);
			} else {
			
				if($this->email !== 'ajelof2@gmail.com')
					Mail::to('ajelof2@gmail.com')->send(new ImportacionFinalizada($mensajeFinal));
				
				Mail::to($this->email)->send(new ImportacionFinalizada($mensajeFinal));
			}
			Log::channel('solosuper')->info('Correos enviados');
			
		} catch (\Throwable $e) {
			Log::channel('solosuper')->error($e->getMessage() .' - - '. $e->getLine() .' - - '. $e->getFile());
//			dd($e->getMessage(), $e->getLine(), $e->getFile());
		}
	}
}
