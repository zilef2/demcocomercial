<?php

namespace App\Imports;

use App\helpers\Myhelp;
use App\Models\Equipo;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;

class EquipoImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;
	
	public $numeroFilas = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
		if(isset($row['codigo'])) {
			$this->numeroFilas++;
			
			return new Equipo([
				                  'Codigo'                        => $row['codigo'],
				                  'Descripcion'                   => $row['descripcion'],
				                  'Tipo Fabricante'               => $row['tipo_fabricante'],
				                  'Referencia Fabricante'         => $row['ref_fabricante'],
				                  'Marca'                         => $row['marca'],
				                  'Unidad de Compra'              => $row['unidad_de_compra'],
				                  'Precio de Lista'               => $row['precio_de_lista'],
				                  'Fecha actualizacion'           => \App\helpers\HelpExcel::getFechaExcel($row['fecha_actualizacion']),
				                  'Descuento Basico'              => $row['descuento_basico'],
				                  'Descuento Proyectos'           => $row['descuento_proyectos'],
				                  'Precio con Descuento'          => $row['precio_con_descuento'],
				                  'Precio con Descuento Proyecto' => $row['precio_con_descuento_proyecto'],
				                  'Precio Ultima Compra'          => $row['precio_ultima_compra'] ?? 0,
				                  'Precios de Listas'             => $row['precios_de_listas'],
				                  'Clasificacion 2 Inventario'    => $row['clasificacion_2_inventario'],
				                  'Ruta Tiempos'                  => $row['ruta_tiempos'],
				                  'Tiempos Chapisteria'           => $row['tiempos_chapisteria'] ?? 0,
			                  ]);
		}
    }
	
	 public function rules(): array
    {
        return [
            'Precios de Listas' => 'nullable|integer', // Validar que sea un entero
        ];
    }
	
	public function onError(Throwable $e)
    {
        // Aquí puedes registrar el error con información adicional, como el número de fila
		Myhelp::EscribirEnLog($this, 'onerror de Equipo import '. ' | Error en la importación: ' . $e->getMessage());
        dd('Error en la importación: ' . $e->getMessage());
    }
}
