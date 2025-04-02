<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReporteRequest extends FormRequest {
	
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules() {
		$reporteId = $this->route('reporte') ?? null;
		
		
		//		$tipoReport
		return [
			// 'nombre' => 'required',
			// 'codigo' => 'required|unique:reportes,codigo,'.$reporteId,
			'fecha'             => 'required',
			'hora_inicial'      => 'required',
			'hora_final'        => 'nullable',
			'centrotrabajo_id'  => 'required',
			'ordentrabajo_id'   => 'nullable',
			'ordentrabajo_ids'  => [
				function ($attribute, $value, $fail) {
					if ($this->tipoReporte['value'] < 2) { //si no es disponibilidad
						if ($this->input('centrotrabajo_id.value') === 2 //ofertas
							&& empty($value)
						) {
							
							$fail('El campo número de oferta es obligatorio');
						}
					}
				}
			],
			'ot_id'             => [
				function ($attribute, $value, $fail) {
					if ($this->tipoReporte['value'] < 2) { //si no es disponibilidad
						if ($this->input('centrotrabajo_id.value') === 1 //proyectos
							&& empty($value)
						) {
							
							$fail('El campo Orden de trabajo es obligatorio');
						}
					}
				}
			],
			//			'actividad_id'      => 'nullable',
			'actividad_id'      => [
				function ($attribute, $value, $fail) {
					if ($this->tipoReporte['value'] < 2 && empty($value)) {
						$fail('El campo actividad es obligatorio');
						
					}
				}
			],
			'disponibilidad_id' => 'nullable',
			'reproceso_id'      => [
				function ($attribute, $value, $fail) {
					if ($this->tipoReporte['value'] === 1 && empty($value)) {
						$fail('El campo reproceso es obligatorio');
						
					}
				}
			],
			'user_id'           => 'nullable',
			'tipoReporte'       => 'required',
		];
	}
}
