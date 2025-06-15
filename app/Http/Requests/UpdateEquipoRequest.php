<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'codigo' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('tu_tabla', 'codigo')->ignore($this->route()->tu_modelo)], // Asegúrate de reemplazar 'tu_tabla' y 'tu_modelo'
            'descripcion' => ['sometimes', 'required', 'string'],
            'tipo_fabricante' => ['nullable', 'string', 'max:255'],
            'referencia_fabricante' => ['nullable', 'string', 'max:255'],
            'marca' => ['nullable', 'string', 'max:255'],
            'unidad_de_compra' => ['nullable', 'string', 'max:255'],
            'precio_de_lista' => ['nullable', 'numeric', 'min:0'],
            'fecha_actualizacion' => ['nullable', 'date'],
            'descuento_basico' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'descuento_proyectos' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'precio_con_descuento' => ['nullable', 'numeric', 'min:0'],
            'precio_con_descuento_proyecto' => ['nullable', 'numeric', 'min:0'],
            'precio_ultima_compra' => ['nullable', 'numeric', 'min:0'],
            'precios_de_listas' => ['nullable', 'string'],
            'Clasificacion 2 Inventario' => ['nullable', 'string', 'max:255'],
            'ruta_tiempos' => ['nullable', 'string', 'max:255'],
            'tiempos_chapisteria' => ['nullable', 'string', 'max:255'],
            'proveedor_id' => ['nullable', 'exists:proveedores,id'], // Asegúrate de reemplazar 'proveedores'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'codigo.required' => 'El Código es obligatorio.',
            'codigo.unique' => 'Este Código ya existe.',
            'descripcion.required' => 'La Descripción es obligatoria.',
            'precio_de_lista.numeric' => 'El precio_de_lista debe ser un número.',
            'precio_de_lista.min' => 'El precio_de_lista no puede ser negativo.',
            'fecha_actualizacion.date' => 'La Fecha de actualización debe ser una fecha válida.',
            'descuento_basico.numeric' => 'El Descuento Básico debe ser un número.',
            'descuento_basico.min' => 'El Descuento Básico no puede ser negativo.',
            'descuento_basico.max' => 'El Descuento Básico no puede ser mayor a 100.',
            'descuento_proyectos.numeric' => 'El descuento_proyectos debe ser un número.',
            'descuento_proyectos.min' => 'El descuento_proyectos no puede ser negativo.',
            'descuento_proyectos.max' => 'El descuento_proyectos no puede ser mayor a 100.',
            'precio_con_descuento.numeric' => 'El precio_con_descuento debe ser un número.',
            'precio_con_descuento.min' => 'El precio_con_descuento no puede ser negativo.',
            'precio_con_descuento_proyecto.numeric' => 'El precio_con_descuento_proyecto debe ser un número.',
            'precio_con_descuento_proyecto.min' => 'El precio_con_descuento_proyecto no puede ser negativo.',
            'precio_ultima_compra.numeric' => 'El Precio Última Compra debe ser un número.',
            'precio_ultima_compra.min' => 'El Precio Última Compra no puede ser negativo.',
            'proveedor_id.exists' => 'El proveedor seleccionado no existe.',
        ];
    }
}
