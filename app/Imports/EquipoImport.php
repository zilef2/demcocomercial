<?php

namespace App\Imports;

use App\helpers\Myhelp;
use App\Models\Equipo;
use App\Models\Proveedor;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EquipoImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnError {
	
	use SkipsErrors;
	
	public $numeroFilas = 0;
	
	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function collection(Collection $rows) {
		foreach ($rows as $row) {
			if (isset($row['codigo'])) {
				$equipoExistente = Equipo::where('Codigo', $row['codigo'])->first();
				
				if ($equipoExistente) {
					Myhelp::EscribirEnLog($this, 'Equipo ya existente: ' . $row['codigo'], false);
					continue;
				}
				
				$equipo = Equipo::create([
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
					                         'Precios de Listas'             => $row['precios_de_listas'] ?? '',
					                         'Clasificacion 2 Inventario'    => $row['clasificacion_2_inventario'] ?? '',
					                         'Ruta Tiempos'                  => $row['ruta_tiempos'],
					                         'Tiempos Chapisteria'           => $row['tiempos_chapisteria'] ?? 0,
				                         ]);
				$this->numeroFilas ++;
				
				$this->EncontrarProveedor($row, $equipo);
			}
		}
	}
	
	public function EncontrarProveedor($row, $equipo) {
		for ($i = 1; $i < 7; $i ++) {
			if (strcmp($row['proveedor_' . $i], '') !== 0) {
				
				$provedor1 = Proveedor::Where('nombre', $row['proveedor_' . $i])->first();
				if (!$provedor1) {
					$provedor1 = Proveedor::create(['nombre' => $row['proveedor_' . $i]]);
					Myhelp::EscribirEnLog($this, 'Subiendo Equipos no se encontró el provedor N' . $i . ' con nombre ' . $row['proveedor_' . $i], false);
				}
				if (!$equipo->proveedores->contains($provedor1->id)) {
					$equipo->proveedores()->attach($provedor1->id);
				}
				
				if (!$provedor1->equipos->contains($equipo->id)) {
					$provedor1->equipos()->attach($equipo->id);
				}
			}
		}
	}
	
	public function rules(): array {
		return [
			'Precios de Listas' => 'nullable|integer', // Validar que sea un entero
		];
	}
	
	public function onError(Throwable $e) {
		// Aquí puedes registrar el error con información adicional, como el número de fila
		Myhelp::EscribirEnLog($this, 'onerror de Equipo import ' . ' | Error en la importación: ' . $e->getMessage());
		dd('Error en la importación: ' . $e->getMessage());
	}
}
