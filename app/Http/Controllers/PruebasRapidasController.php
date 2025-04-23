<?php

namespace App\Http\Controllers;

use App\helpers\Myhelp;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PruebasRapidasController extends Controller {
	
	public string $FromController = 'Equipo';
	
	public function pruebasget(Request $request, $perPage = 10) {
		
		$titulos = [//thisnothere
			['order' => 'Codigo', 'label' => 'Codigo', 'type' => 'text'],
			['order' => 'Descripcion', 'label' => 'Descripcion', 'type' => 'text'],
			['order' => 'Tipo Fabricante', 'label' => 'Tipo Fabricante', 'type' => 'text'],
			['order' => 'Referencia Fabricante', 'label' => 'Referencia Fabricante', 'type' => 'text'],
			['order' => 'Marca', 'label' => 'Marca', 'type' => 'text'],
			['order' => 'Unidad de Compra', 'label' => 'Unidad de Compra', 'type' => 'text'],
			['order' => 'Precio de Lista', 'label' => 'Precio de Lista', 'type' => 'number'],
			['order' => 'Fecha actualizacion', 'label' => 'Fecha actualizacion', 'type' => 'date'],
			['order' => 'Descuento Basico', 'label' => 'Descuento Basico', 'type' => 'number'],
			['order' => 'Descuento Proyectos', 'label' => 'Descuento Proyectos', 'type' => 'number'],
			['order' => 'Precio con Descuento', 'label' => 'Precio con Descuento', 'type' => 'number'],
			['order' => 'Precio con Descuento Proyecto', 'label' => 'Precio con Descuento Proyecto', 'type' => 'number'],
			['order' => 'Precio Ultima Compra', 'label' => 'Precio Ultima Compra', 'type' => 'number'],
			['order' => 'Precios de Listas', 'label' => 'Precios de Listas', 'type' => 'text'],
			['order' => 'Clasificacion 2 Inventario', 'label' => 'Clasificacion 2 Inventario', 'type' => 'text'],
			['order' => 'Ruta Tiempos', 'label' => 'Ruta Tiempos', 'type' => 'text'],
			['order' => 'Tiempos Chapisteria', 'label' => 'Tiempos Chapisteria', 'type' => 'number'],
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
		Myhelp::EscribirEnLog($this, 'STORE:Equipos EXITOSO', 'Equipo id:' . $Equipo->id . ' |codigo:: ' . $Equipo->Codigo, false);
		
		
		return redirect('pruebasget')->with('success', __('app.label.created_successfully', ['name' => $Equipo->codigo]));
	}
	
	public function PerPageAndPaginate($request, $Equipos) {
		$perPage = $request->has('perPage') ? $request->perPage : 10;
		$page = request('page', 1); // Current page number
		$paginated = new LengthAwarePaginator($Equipos->forPage($page, $perPage), $Equipos->count(), $perPage, $page, ['path' => request()->url()]);
		
		
		return $paginated;
	}
}
