<?php

namespace App\Imports;

use App\helpers\Myhelp;
use App\Models\Proveedor;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;

class ProveedoresImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;
	
	public int $numeroFilas = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
		if(isset($row['Nombre'])) {
			$this->numeroFilas++;
			return new Proveedor(
				['nombre' => $row['Nombre']]
			);
		}
    }
	
	 public function rules(): array
    {
        return [
            'Nombre' => 'nullable|string',
        ];
    }
	
	public function onError(Throwable $e)
    {
        // Aquí puedes registrar el error con información adicional, como el número de fila
		Myhelp::EscribirEnLog($this, 'onerror de Proveedor import '. ' | Error en la importación: ' . $e->getMessage());
        \dd('Error en la importación de Proveedores: ' . $e->getMessage());
    }
}
