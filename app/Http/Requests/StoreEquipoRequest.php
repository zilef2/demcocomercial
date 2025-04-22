<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Codigo' => ['required', 'string', 'max:255', 'unique:equipos,Codigo'], // Asegúrate de reemplazar 'equipos' con el nombre real de tu tabla
            'Descripcion' => ['required', 'string'],
            'Tipo Fabricante' => ['nullable', 'string', 'max:255'],
            'Referencia Fabricante' => ['nullable', 'string', 'max:255'],
            'Marca' => ['nullable', 'string', 'max:255'],
            'Unidad de Compra' => ['nullable', 'string', 'max:255'],
            'Precio de Lista' => ['nullable', 'numeric', 'min:0'],
            'Fecha actualizacion' => ['nullable', 'date'],
            'Descuento Basico' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'Descuento Proyectos' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'Precio con Descuento' => ['nullable', 'numeric', 'min:0'],
            'Precio con Descuento Proyecto' => ['nullable', 'numeric', 'min:0'],
            'Precio Ultima Compra' => ['nullable', 'numeric', 'min:0'],
            'Precios de Listas' => ['nullable', 'string'],
            'Clasificacion 2 Inventario' => ['nullable', 'string', 'max:255'],
            'Ruta Tiempos' => ['nullable', 'string', 'max:255'],
            'Tiempos Chapisteria' => ['nullable'],
            'proveedor_id' => ['nullable', 'array'],
            'proveedor_id.value' => ['nullable', 'exists:proveedores,id'],
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
            'Codigo.required' => 'El Código es obligatorio.',
            'Codigo.unique' => 'Este Código ya existe.',
            'Descripcion.required' => 'La Descripción es obligatoria.',
            'Precio de Lista.numeric' => 'El Precio de Lista debe ser un número.',
            'Precio de Lista.min' => 'El Precio de Lista no puede ser negativo.',
            'Fecha actualizacion.date' => 'La Fecha de actualización debe ser una fecha válida.',
            'Descuento Basico.numeric' => 'El Descuento Básico debe ser un número.',
            'Descuento Basico.min' => 'El Descuento Básico no puede ser negativo.',
            'Descuento Basico.max' => 'El Descuento Básico no puede ser mayor a 100.',
            'Descuento Proyectos.numeric' => 'El Descuento Proyectos debe ser un número.',
            'Descuento Proyectos.min' => 'El Descuento Proyectos no puede ser negativo.',
            'Descuento Proyectos.max' => 'El Descuento Proyectos no puede ser mayor a 100.',
            'Precio con Descuento.numeric' => 'El Precio con Descuento debe ser un número.',
            'Precio con Descuento.min' => 'El Precio con Descuento no puede ser negativo.',
            'Precio con Descuento Proyecto.numeric' => 'El Precio con Descuento Proyecto debe ser un número.',
            'Precio con Descuento Proyecto.min' => 'El Precio con Descuento Proyecto no puede ser negativo.',
            'Precio Ultima Compra.numeric' => 'El Precio Última Compra debe ser un número.',
            'Precio Ultima Compra.min' => 'El Precio Última Compra no puede ser negativo.',
            'proveedor_id.exists' => 'El proveedor seleccionado no existe.',
	        'proveedor_id.array' => 'El Proveedor debe ser un array.',
            'proveedor_id.value.exists' => 'El proveedor seleccionado no existe.',
        ];
    }
}
