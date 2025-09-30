<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreOfertaRequest extends FormRequest {
	
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool { return true; }
	
	public function rules(): array {
		return [
			'items.*.equipos.*.equipo_selec' => 'required_if:items.*.equipos.*.tipoFila,modelo1',
			
			'dataOferta'               => 'required|array',
			'dataOferta.codigo_oferta' => 'required|string|max:150',
			'dataOferta.cliente'       => 'required|string|max:512',
			'dataOferta.descripcion'   => 'required|string|max:2048',
			'dataOferta.cargo'         => 'required|string|max:256',
			'dataOferta.empresa'       => 'required|string|max:256',
			'dataOferta.ciudad'        => 'required|string|max:256',
			'dataOferta.proyecto'      => 'required|string|max:256',
			
			'items'                      => 'required|array|min:1',
			'items.*.nombre'             => 'required|string|min:2',
			'items.*.cantidad'           => 'required|integer|min:1',
			'items.*.equipos'            => 'required|array|min:1',
			
			// --- Reglas para cada equipo ---
			// Campos en la raíz del objeto equipo
			'items.*.equipos.*.tipoFila' => 'required',
			
			'items.*.equipos.*.cantidad'        => 'required_if:items.*.equipos.*.tipoFila,modelo1|integer|min:1',
			'items.*.equipos.*.descuento_final' => 'required_if:items.*.equipos.*.tipoFila,modelo1|numeric',
			'items.*.equipos.*.factor_final'    => 'required_if:items.*.equipos.*.tipoFila,modelo1|numeric',
			'items.*.equipos.*.costounitario'   => 'required_if:items.*.equipos.*.tipoFila,modelo1|numeric',
			'items.*.equipos.*.costototal'      => 'required_if:items.*.equipos.*.tipoFila,modelo1|numeric',
			'items.*.equipos.*.valorunitario'   => 'required_if:items.*.equipos.*.tipoFila,modelo1|numeric',
			'items.*.equipos.*.subtotalequip'   => 'required_if:items.*.equipos.*.tipoFila,modelo1|numeric',
			
			// Campos dentro de 'equipo_selec'
						'items.*.equipos.*.equipo_selec.precio_de_lista'     => 'required|numeric',
			'ultra_valor_total'                 => 'required|numeric|min:0',
		];
	}
	
	public function messages(): array {
		return [
			'items.*.nombre.required'                        => 'El :attribute es obligatorio.',
			'items.*.equipos.min'                            => 'El campo :attribute debe tener al menos un equipo.',
			// Para required_if y otros errores más complejos, es mejor usar la solución withValidator
			'items.*.equipos.*.equipo_selec.required_if'     => 'En el item :index, hay equipos vacios', // MANTENER TEMPORALMENTE
			
			// El resto de mensajes que usan :attribute
			'items.*.equipos.*.equipo_selec.value.required'  => 'Falta seleccionar un equipo en el :attribute.',
			'items.*.equipos.*.required'                     => 'Falta seleccionar un equipo.',
			'items.*.equipos.*.numeric'                      => 'Un campo de equipo que debe ser numérico.',
			'items.*.equipos.*.equipo_selec.precio_de_lista' => 'El precio de un equipo no puede ser cero.',
		];
	}
	
	public function attributes(): array {
		$attributes = [];
		
		// Si existen items en la request, recorremos cada uno con índice real
		foreach ($this->input('items', []) as $i => $item) {
			$index = $i + 1; // Mostrar Item 1, Item 2...
			
			// Atributos de nivel item
			$attributes["items.$i.nombre"] = "nombre del Item {$index}";
			$attributes["items.$i.cantidad"] = "cantidad del Item {$index}";
			$attributes["items.$i.equipos"] = "equipos del Item {$index}";
			
			// Atributos de nivel equipos
			foreach ($item['equipos'] ?? [] as $j => $equipo) {
				$attributes["items.$i.equipos.$j.equipo_selec"] = "equipo del Item {$index}";
			}
		}
		
		return $attributes;
	}
	
	public function withValidator(Validator $validator): void {
		$validator->after(function (Validator $validator) {
			
			$errors = $validator->errors();
			$items = $this->input('items', []);
			
			foreach ($items as $i => $item) {
				$itemIndex = $i + 1; // 1, 2, 3...
				
				// 1. Lógica de corrección para 'items.*.nombre' (Ya explicada antes)
				$nombreKey = "items.$i.nombre";
				$defaultNombreRequired = 'The ' . $nombreKey . ' field is required.';
				
				if ($errors->has($nombreKey) && in_array($defaultNombreRequired, $errors->get($nombreKey))) {
					$errors->forget($nombreKey);
					$errors->add($nombreKey, "El nombre del item número {$itemIndex} es obligatorio.");
				}
				
				// 2. Lógica de corrección para 'items.*.equipos.*.equipo_selec' (required_if)
				if (isset($item['equipos']) && is_array($item['equipos'])) {
					
					foreach ($item['equipos'] as $j => $equipo) {
						
						$equipoSelectKey = "items.$i.equipos.$j.equipo_selec";
						$equipoSelectKeCanti = "items.$i.equipos.$j.equipo_selec";
						
						// Si el campo tipoFila en el mismo nivel es 'modelo1', buscamos el error.
						if (($equipo['tipoFila'] ?? null) === 'modelo1') {
							
							if ($errors->has($equipoSelectKey)) {
								
								// Recorremos los mensajes para eliminar el que Laravel generó.
								$messages = $errors->get($equipoSelectKey);
								$errors->forget($equipoSelectKey);
								
								// Añadimos el mensaje corregido para el usuario.
								$errors->add($equipoSelectKey, "En el item {$itemIndex}, debe seleccionar un equipo.");
								break; // Solo necesitamos corregir el error una vez por equipo.
							}
						}
					}
				}
			}
		});
	}
	
}
