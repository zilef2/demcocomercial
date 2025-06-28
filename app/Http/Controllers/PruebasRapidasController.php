<?php

namespace App\Http\Controllers;

use App\helpers\Myhelp;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class PruebasRapidasController extends Controller {
	
	public string $FromController = 'Equipo';
	
	public function pruebasget(Request $request, $perPage = 10) {
		
		$titulos = [//thisnothere
			['order' => 'codigo', 'label' => 'codigo', 'type' => 'text'],
			['order' => 'descripcion', 'label' => 'descripcion', 'type' => 'text'],
			['order' => 'tipo_fabricante', 'label' => 'tipo_fabricante', 'type' => 'text'],
			['order' => 'referencia_fabricante', 'label' => 'referencia_fabricante', 'type' => 'text'],
			['order' => 'marca', 'label' => 'marca', 'type' => 'text'],
			['order' => 'unidad_de_compra', 'label' => 'unidad_de_compra', 'type' => 'text'],
			['order' => 'precio_de_lista', 'label' => 'precio_de_lista', 'type' => 'number'],
			['order' => 'fecha_actualizacion', 'label' => 'fecha_actualizacion', 'type' => 'date'],
			['order' => 'descuento_basico', 'label' => 'descuento_basico', 'type' => 'number'],
			['order' => 'descuento_proyectos', 'label' => 'descuento_proyectos', 'type' => 'number'],
			['order' => 'precio_con_descuento', 'label' => 'precio_con_descuento', 'type' => 'number'],
			['order' => 'precio_con_descuento_proyecto', 'label' => 'precio_con_descuento_proyecto', 'type' => 'number'],
			['order' => 'precio_ultima_compra', 'label' => 'precio_ultima_compra', 'type' => 'number'],
			['order' => 'precios_de_listas', 'label' => 'precios_de_listas', 'type' => 'text'],
			['order' => 'Clasificacion 2 Inventario', 'label' => 'Clasificacion 2 Inventario', 'type' => 'text'],
			['order' => 'ruta_tiempos', 'label' => 'ruta_tiempos', 'type' => 'text'],
			['order' => 'tiempos_chapisteria', 'label' => 'tiempos_chapisteria', 'type' => 'number'],
		];
		
		return Inertia::render('CreateP', [
			
			'title'             => __('app.label.' . $this->FromController),
			'filters'           => $request->all(['search', 'field', 'order']),
			'perPage'           => (int)$perPage,
			'numberPermissions' => 10,
			'titulos'           => $titulos,
			'losSelect'         => $this->losSelect() ?? [],
			'show'              => true,
		]);
	}
	
	public function losSelect(): array {
		return [
			Myhelp::NEW_turnInSelectID(\App\Models\Proveedor::all(), ' Proveedor ', 'nombre')
		];
	}
	
	public function pruebaspost(\App\Http\Requests\StoreEquipoRequest $request) {
		$permissions = Myhelp::EscribirEnLog($this, ' Begin STORE:Equipos');
		DB::beginTransaction();
		
		$proveedorId = $request['proveedor_id']['value'] ?? null;
		$request->merge(['proveedor_id' => $proveedorId]);
		$Equipo = Equipo::create($request->all());
		
		DB::commit();
		Myhelp::EscribirEnLog($this, 'STORE:Equipos EXITOSO', 'Equipo id:' . $Equipo->id . ' |codigo:: ' . $Equipo->codigo, false);
		
		return redirect('pruebasget')->with('success', __('app.label.created_successfully', ['name' => $Equipo->codigo]));
	}
	
	public function PerPageAndPaginate($request, $Equipos) {
		$perPage = $request->has('perPage') ? $request->perPage : 10;
		$page = request('page', 1); // Current page number
		$paginated = new LengthAwarePaginator($Equipos->forPage($page, $perPage), $Equipos->count(), $perPage, $page, ['path' => request()->url()]);
		
		return $paginated;
	}
	
	public function EnviarCorreoDebuging() {
		try {
			Mail::raw('Este es un correo de prueba.', function ($message) {
				$message->to('ajelof2@gmail.com')->subject('Correo de prueba');
			});
			
			return 'Correo enviado con éxito.';
		} catch (\Exception $e) {
			return 'Error al enviar el correo: ' . $e->getMessage();
		}
		
	}
}
