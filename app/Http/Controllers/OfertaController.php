<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Item;
use App\Models\Oferta;
use App\helpers\Myhelp;
use App\helpers\MyModels;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class OfertaController extends Controller {
	
	public array $thisAtributos;
	public string $FromController = 'Oferta';
	
	//<editor-fold desc="Construc | filtro and dependencia">
	public function __construct() {
		//        $this->middleware('permission:create Oferta', ['only' => ['create', 'store']]);
		//        $this->middleware('permission:read Oferta', ['only' => ['index', 'show']]);
		//        $this->middleware('permission:update Oferta', ['only' => ['edit', 'update']]);
		//        $this->middleware('permission:delete Oferta', ['only' => ['destroy', 'destroyBulk']]);
		$this->thisAtributos = (new Oferta())->getFillable(); //not using
	}
	
	public function index(Request $request) {
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, ' Ofertas '));
		$Ofertas = $this->Filtros($request)->get();
		//        $losSelect = $this->Dependencias();
		
		$perPage = $request->has('perPage') ? $request->perPage : 10;
		
		
		return Inertia::render($this->FromController . '/Index', [
			'fromController'    => $this->PerPageAndPaginate($request, $Ofertas),
			'total'             => $Ofertas->count(),
			'breadcrumbs'       => [
				[
					'label' => __('app.label.' . $this->FromController),
					'href'  => route($this->FromController . '.index')
				]
			],
			'title'             => __('app.label.' . $this->FromController),
			'filters'           => $request->all(['search', 'field', 'order']),
			'perPage'           => (int)$perPage,
			'numberPermissions' => $numberPermissions,
			'losSelect'         => $losSelect ?? [],
		]);
	}
	
	public function Filtros($request): Builder {
		$Ofertas = Oferta::query();
		if ($request->has('search')) {
			$Ofertas = $Ofertas->where(function ($query) use ($request) {
				$query->where('nombre', 'LIKE', "%" . $request->search . "%")
					//                    ->orWhere('codigo', 'LIKE', "%" . $request->search . "%")
					//                    ->orWhere('identificacion', 'LIKE', "%" . $request->search . "%")
				;
			});
		}
		
		if ($request->has(['field', 'order'])) {
			$Ofertas = $Ofertas->orderBy($request->field, $request->order);
		}
		else {
			$Ofertas = $Ofertas->orderBy('updated_at', 'DESC');
		}
		
		
		return $Ofertas;
	}
	
	public function PerPageAndPaginate($request, $Ofertas) {
		$perPage = $request->has('perPage') ? $request->perPage : 10;
		$page = request('page', 1); // Current page number
		$paginated = new LengthAwarePaginator($Ofertas->forPage($page, $perPage), $Ofertas->count(), $perPage, $page, ['path' => request()->url()]);
		
		
		return $paginated;
	}
	
	public function NuevaOferta(Request $request) {
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, ' Nueva|Oferta '));
		$Ofertas = $this->Filtros($request)->get();
		
		$perPage = $request->has('perPage') ? $request->perPage : 10;
		
		$losSelect = [
			'ultimosEquipos' => Equipo::Where('updated_at', '>', Carbon::now()->subDays(30))->take(5)->get()
		];
		$losSelect = array_merge($losSelect, $this->losSelect(['Equipo'], ['Codigo'], ['Descripcion']));
		
		
		return Inertia::render($this->FromController . '/NuevaOferta', [
			'fromController'    => $this->PerPageAndPaginate($request, $Ofertas),
			'total'             => $Ofertas->count(),
			'breadcrumbs'       => [
				[
					'label' => __('app.label.' . $this->FromController),
					'href'  => route($this->FromController . '.index')
				]
			],
			'title'             => __('app.label.' . $this->FromController),
			'filters'           => $request->all(['search', 'field', 'order']),
			'perPage'           => (int)$perPage,
			'numberPermissions' => $numberPermissions,
			'losSelect'         => $losSelect,
		]);
	}
	
	public function losSelect(array $modelClass, array $displayField, array $displayField2): array {
		if (!(count($modelClass) === count($displayField) && count($modelClass) === count($displayField2))) {
			throw new \Exception("Los vectores no tienen el mismo tamaño.");
		}
		
		foreach ($modelClass as $index => $model_cla) {
			$nameofclass = $model_cla;
			if (!class_exists($model_cla)) {
				if (class_exists('App\\Models\\' . $model_cla)) {
					$model_cla = 'App\\Models\\' . $model_cla;
				}
				else {
					throw new \Exception("La clase {$model_cla} no existe.");
				}
			}
			// Intenta obtener todos los registros del modelo
			$modelCollection = call_user_func([$model_cla, 'all']);
			// Verifica si el resultado es una colección
			if (!$modelCollection instanceof Collection) {
				$simpleClass[$displayField[$index]] = [];
			}
			
			//Explain: $simpleClass['User'] = User::all()
			//mode::all(), string Modelname, string $displayField
			$simpleClass[$nameofclass] = Myhelp::MakeSelect($modelCollection, $nameofclass, true, $displayField[$index], $displayField2[$index]);
		}
		
		
		return $simpleClass;
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
	
	public function losSelect2(): array {
		return [
			'ultimosEquipos' => Equipo::Where('updated_at', '>', Carbon::now()->subDays(30))->take(150)->get(),
			'0'              => Myhelp::NEW_turnInSelectID(\App\Models\Proveedor::all(), ' Proveedor ', 'nombre'),
			'Equipos'        => $this->SelectEquipos('Equipo', 'Codigo'),
		];
	}
	
	public function store(Request $request): RedirectResponse {
		$permissions = Myhelp::EscribirEnLog($this, ' Begin STORE:Ofertas');
		DB::beginTransaction();
		//        $no_nada = $request->no_nada['id'];
		//        $request->merge(['no_nada_id' => $request->no_nada['id']]);
		$Oferta = Oferta::create($request->all());
		
		DB::commit();
		Myhelp::EscribirEnLog($this, 'STORE:Ofertas EXITOSO', 'Oferta id:' . $Oferta->id . ' | ' . $Oferta->nombre, false);
		
		
		return back()->with('success', __('app.label.created_successfully', ['name' => $Oferta->nombre]));
	}
	
	public function create() {}
	
	//! STORE - UPDATE - DELETE
	//! STORE functions
	
	public function GuardarNuevaOferta(Request $request): RedirectResponse {
		$permissions = Myhelp::EscribirEnLog($this, ' Begin GuardarNuevaOferta');
		DB::beginTransaction();
		$request->validate([
			                   'items' => 'required|array',
			                   //    'items.*' => 'exists:items,id',
		                   ]);
		dd($request->all());
		//		$proveedorId = $request['proveedor_id']['value'] ?? null;
//		$request->merge([
		$Oferta = Oferta::create([
            "user_id"  => myhelp::AuthUid(),
            "cargo"    => 'cargo ejemplo',
            "empresa"  => 'empresa ejemplo',
            "ciudad"   => 'ciudad ejemplo',
            "proyecto" => 'proyecto ejemplo',
            "fecha"    => Carbon::now(),
        ]);
		
		foreach ($request->equipos as $indexItem => $itemPlano) {
			$totalItem = 0;
			foreach ($itemPlano as $indexEquipo => $equipoPlano) {
				$totalItem += $equipoPlano['subtotalequip'];
			}
			$item = Item::create([
					'numero' => $indexItem,
					'nombre' => 'nombre ejemplo'.$indexItem,
					'descripcion' => '',
					'conteo_items' => count($itemPlano),
					'valor_unitario_item' => $totalItem,
					'cantidad' => count($itemPlano),
					'valor_total_item' => (int)($totalItem * count($itemPlano)),
					'oferta_id' => $Oferta->id,
             ]);
			$equipo = Equipo::find($equipoPlano['value']);
			if($equipo) $equipo->items()->attach($item->id);
			
		}
		
		DB::commit();
		Myhelp::EscribirEnLog($this, 'GuardarNuevaOferta:Ofertas EXITOSO', 'Oferta id:' . $Oferta->id . ' | ' . $Oferta->proyecto, false);
		
        return redirect('/Oferta.index')->with('success', __('app.label.created_successfully', ['name' => $Oferta->proyecto]));
	}
	
	//fin store functions
	
	public function show($id) {}
	
	public function edit($id) {}
	
	public function update(Request $request, $id): RedirectResponse {
		$permissions = Myhelp::EscribirEnLog($this, ' Begin UPDATE:Ofertas');
		DB::beginTransaction();
		$Oferta = Oferta::findOrFail($id);
		//        $request->merge(['no_nada_id' => $request->no_nada['id']]);
		$Oferta->update($request->all());
		
		DB::commit();
		Myhelp::EscribirEnLog($this, 'UPDATE:Ofertas EXITOSO', 'Oferta id:' . $Oferta->id . ' | ' . $Oferta->nombre, false);
		
		
		return back()->with('success', __('app.label.updated_successfully2', ['nombre' => $Oferta->nombre]));
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	
	public function destroy($Ofertaid) {
		$permissions = Myhelp::EscribirEnLog($this, 'DELETE:Ofertas');
		$Oferta = Oferta::find($Ofertaid);
		$elnombre = $Oferta->nombre;
		$Oferta->delete();
		Myhelp::EscribirEnLog($this, 'DELETE:Ofertas', 'Oferta id:' . $Oferta->id . ' | ' . $Oferta->nombre . ' borrado', false);
		
		
		return back()->with('success', __('app.label.deleted_successfully', ['name' => $elnombre]));
	}
	
	public function destroyBulk(Request $request) {
		$Oferta = Oferta::whereIn('id', $request->id);
		$Oferta->delete();
		
		
		return back()->with('success', __('app.label.deleted_successfully', ['name' => count($request->id) . ' ' . __('app.label.user')]));
	}
	//FIN : STORE - UPDATE - DELETE
	
}
