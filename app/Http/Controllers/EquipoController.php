<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipoRequest;
use App\Models\Equipo;
use App\helpers\Myhelp;
use App\helpers\MyModels;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class EquipoController extends Controller {
	
	public array $thisAtributos;
	public string $FromController = 'Equipo';
	
	//<editor-fold desc="Construc | filtro and dependencia">
	public function __construct() {
		//        $this->middleware('permission:create Equipo', ['only' => ['create', 'store']]);
		//        $this->middleware('permission:read Equipo', ['only' => ['index', 'show']]);
		//        $this->middleware('permission:update Equipo', ['only' => ['edit', 'update']]);
		//        $this->middleware('permission:delete Equipo', ['only' => ['destroy', 'destroyBulk']]);
		$this->thisAtributos = (new Equipo())->getFillable(); //not using
	}
	
	public function index(Request $request) {
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, ' Equipos '));
		$Equipos = $this->Filtros($request)->get();
		
		$perPage = $request->has('perPage') ? $request->perPage : 10;
		
		
		return Inertia::render($this->FromController . '/Index', [
			'fromController' => $this->PerPageAndPaginate($request, $Equipos),
			'total'          => $Equipos->count(),
			
			'breadcrumbs'       => [
				[
					'label' => __('app.label.' . $this->FromController),
					'href'  => route($this->FromController . '.index')
				]
			],
			'title'             => __('app.label.' . $this->FromController),
			'filters'           => $request->all([
				                                     'search',
				                                     'field',
				                                     'order'
			                                     ]),
			'perPage'           => (int)$perPage,
			'numberPermissions' => $numberPermissions,
			'losSelect'         => $this->losSelect() ?? [],
		]);
	}
	
	public function Filtros($request): Builder {
		$Equipos = Equipo::query();
		if ($request->has('search')) {
			$Equipos = $Equipos->where(function ($query) use ($request) {
				$query->where('Codigo', 'LIKE', "%" . $request->search . "%")
					//                    ->orWhere('codigo', 'LIKE', "%" . $request->search . "%")
					//                    ->orWhere('identificacion', 'LIKE', "%" . $request->search . "%")
				;
			});
		}
		
		$allowedFields = [
			'Codigo',
			'Descripcion',
			'Tipo Fabricante',
			'Referencia Fabricante',
			'Marca',
			'Unidad de Compra',
			'Precio de Lista',
			'Fecha actualizacion',
			'Descuento Basico',
			'Descuento Proyectos',
			'Precio con Descuento',
			'Precio con Descuento Proyecto',
			'Precio Ultima Compra',
			'Precios de Listas',
			'Ruta Tiempos',
			'Tiempos Chapisteria',
		];
		
		if ($request->has(['field', 'order']) && in_array($request->field, $allowedFields)) {
			$Equipos = $Equipos->orderBy($request->field, $request->order);
		}
		else {
			$Equipos = $Equipos->orderBy('updated_at', 'DESC');
		}
		
		
		return $Equipos;
	}
	
	public function PerPageAndPaginate($request, $Equipos) {
		$perPage = $request->has('perPage') ? $request->perPage : 10;
		$page = request('page', 1); // Current page number
		$paginated = new LengthAwarePaginator($Equipos->forPage($page, $perPage), $Equipos->count(), $perPage, $page, ['path' => request()->url()]);
		
		
		return $paginated;
	}
	
	//    public function Dependencias()
	//    {
	//        $no_nadasSelect = No_nada::all('id','nombre as name')->toArray();
	//        array_unshift($no_nadasSelect,["name"=>"Seleccione un no_nada",'id'=>0]);
	
	//        $ejemploSelec = CentroCosto::all('id', 'nombre as name')->toArray();
	//        array_unshift($ejemploSelec, ["name" => "Seleccione un ejemploSelec", 'id' => 0]);
	//        return [$no_nadasSelect];
	//        return [$no_nadasSelect,$ejemploSelec];
	//    }
	
	//</editor-fold>
	
	public function losSelect(): array {
		return [
			Myhelp::NEW_turnInSelectID(\App\Models\Proveedor::all(), ' Proveedor ', 'nombre'),
		];
	}
	
	public function store(StoreEquipoRequest $request): RedirectResponse {
		Myhelp::EscribirEnLog($this, ' Begin STORE:Equipos');
		DB::beginTransaction();
		
		try {
			$datos = $request->except('proveedor_id');
			$datos['Fecha actualizacion'] = now();
			
			$Equipo = Equipo::create($datos);
			
			$this->zilefSyncManytoMany($request['proveedor_id'], $Equipo);
			DB::commit();
			Myhelp::EscribirEnLog($this, 'STORE:Equipos EXITOSO', 'Equipo id:' . $Equipo->id . ' |codigo:: ' . $Equipo->Codigo, false);
			
			
			return back()->with('success', __('app.label.created_successfully', ['name' => $Equipo->Codigo]));
		} catch (\Exception $e) {
			DB::rollBack();
			$elerror = $e->getMessage();
			Myhelp::EscribirEnLog($this, 'STORE:Equipos ERROR', $elerror);
			
			
			return back()->with('error', __('app.label.error_creating', ['name' => 'Equipo']) . " $elerror");
		}
	}
	
	//! STORE - UPDATE - DELETE
	//! STORE functions
	
	public function create() {}
	
	//fin store functions
	
	/**
	 * @param $proveedor_id
	 * @param $Equipo
	 * @return void
	 */
	public function zilefSyncManytoMany($proveedor_id, $Equipo): void {
		$proveedorIds = array_map(function ($item) {
			return $item['value'] ?? null;
		}, $proveedor_id);
		
		$Equipo->proveedores()->sync($proveedorIds);
	}
	
	public function show($id) {}
	
	public function edit($id) {}
	
	public function update(Request $request, $id): RedirectResponse {
		$permissions = Myhelp::EscribirEnLog($this, ' Begin UPDATE:Equipos');
		DB::beginTransaction();
		$Equipo = Equipo::findOrFail($id);
		$Equipo->update($request->all());
		$this->zilefSyncManytoMany($request['proveedor_id'], $Equipo);
		
		DB::commit();
		Myhelp::EscribirEnLog($this, 'UPDATE:Equipos EXITOSO', 'Equipo id:' . $Equipo->id . ' | ' . $Equipo->nombre, false);
		
		
		return back()->with('success', __('app.label.updated_successfully2', ['nombre' => $Equipo->nombre]));
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	
	public function destroy($Equipoid) {
		$permissions = Myhelp::EscribirEnLog($this, 'DELETE:Equipos');
		$Equipo = Equipo::find($Equipoid);
		$elnombre = $Equipo->nombre;
		$Equipo->delete();
		Myhelp::EscribirEnLog($this, 'DELETE:Equipos', 'Equipo id:' . $Equipo->id . ' | ' . $Equipo->nombre . ' borrado', false);
		
		
		return back()->with('success', __('app.label.deleted_successfully', ['name' => $elnombre]));
	}
	
	//FIN : STORE - UPDATE - DELETE
	
	public function destroyBulk(Request $request) {
		$Equipo = Equipo::whereIn('id', $request->id);
		$Equipo->delete();
		
		
		return back()->with('success', __('app.label.deleted_successfully', ['name' => count($request->id) . ' ' . __('app.label.user')]));
	}
	
}
