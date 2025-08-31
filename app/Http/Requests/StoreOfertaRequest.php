<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfertaRequest extends FormRequest {
	
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool {
		return true;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array {
		return [
			'dataOferta'               => 'required|array',
			'dataOferta.codigo_oferta' => 'required|string|max:150',
			'dataOferta.cliente'       => 'required|string|max:512',
			'dataOferta.descripcion'   => 'required|string|max:2048',
			'dataOferta.cargo'         => 'required|string|max:256',
			'dataOferta.empresa'       => 'required|string|max:256',
			'dataOferta.ciudad'        => 'required|string|max:256',
			'dataOferta.proyecto'      => 'required|string|max:256',
			
			'items'                             => 'required|array|min:1',
			'items.*.nombre'                    => 'required|string|min:2',
			'items.*.cantidad'                  => 'required|integer|min:1',
			'items.*.equipos'                   => 'required|array|min:1',
			
			// --- Reglas para cada equipo ---
			// Campos en la raíz del objeto equipo
			'items.*.equipos.*.cantidad'        => 'required|integer|min:1',
			'items.*.equipos.*.descuento_final' => 'required|numeric',
			'items.*.equipos.*.factor_final'    => 'required|numeric',
			'items.*.equipos.*.costounitario'   => 'required|numeric',
			'items.*.equipos.*.costototal'      => 'required|numeric',
			'items.*.equipos.*.valorunitario'   => 'required|numeric',
			'items.*.equipos.*.subtotalequip'   => 'required|numeric',
			
			// Campos dentro de 'equipo_selec'
			'items.*.equipos.*.equipo_selec'    => 'required|array',
			//			'items.*.equipos.*.equipo_selec.precio_de_lista'     => 'required|numeric|gt:0',
			//			'items.*.equipos.*.equipo_selec.descuento_basico'    => 'required|numeric',
			//			'items.*.equipos.*.equipo_selec.descuento_proyectos' => 'required|numeric',
			'ultra_valor_total'                 => 'required|numeric|min:0',
		];
	}
	
	public function messages(): array {
		return [
			//			'items.*.nombre.required'                                     => 'El campo :attribute es obligatorio.',
			//			'items.*.equipos.*.equipo_selec.required'                     => 'Hay :attribute vacío.',
			'items.*.nombre.required'                           => 'El nombre de cada item es obligatorio.',
			'items.*.equipos.*.equipo_selec.required'           => 'Hay equipos vacíos.',
			
			//			'items.*.equipos.*.equipo_selec.precio_de_lista.required'     => 'El campo :attribute es obligatorio.',
			//			'items.*.equipos.*.equipo_selec.descuento_basico.required'    => 'El campo :attribute es obligatorio.',
			//			'items.*.equipos.*.equipo_selec.descuento_proyectos.required' => 'El campo :attribute es obligatorio.',
			'items.*.equipos.min'                               => 'Cada item debe tener al menos un equipo.',
			
			// Mensajes personalizados
			'items.*.equipos.*.equipo_selec.value.required'     => 'Falta seleccionar un equipo.',
			'items.*.equipos.*.required'                        => 'Falta seleccionar un equipo.',
			'items.*.equipos.*.numeric'                         => 'Un campo de equipo que debe ser numérico.',
			'items.*.equipos.*.equipo_selec.precio_de_lista.gt' => 'El precio de un equipo no puede ser cero.',
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
	
}
