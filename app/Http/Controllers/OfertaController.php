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
	
	public function losSelect(array $modelClass, array $displayField, array $displayField2): array {
		if (!(count($modelClass) === count($displayField) && count($modelClass) === count($displayField2))) {
			throw new \Exception("Los vectores no tienen el mismo tamaño."); //for dev
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
	
	//</editor-fold>
	
	public function NuevaOferta(Request $request) {
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, ' Nueva|Oferta '));
		$ultimoIdMasUno = Oferta::latest()->first();
		$ultimoIdMasUno = $ultimoIdMasUno ? ((int)$ultimoIdMasUno->id) + 1 : 1;
		$Ofertas = $this->Filtros($request)->get();
		
		$perPage = $request->has('perPage') ? $request->perPage : 10;
		
		$losSelect = [ //ultimosEquipos -> table inferior
			'ultimosEquipos' => Equipo::Where('updated_at', '>', Carbon::now()->subDays(90))->Where('precio_de_lista', 0)->take(100)->get()
		];
		$losSelect = array_merge($losSelect, $this->losSelect(['Equipo'], ['codigo'], ['descripcion']));
		
		//		$losSelect = $this->losSelect(['Equipo'], ['codigo'], ['descripcion']);
		
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
			'ultimoIdMasUno'    => $ultimoIdMasUno,
		]);
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
			                   'dataOferta' => 'required|array',
			                   //    'items.*' => 'exists:items,id',
		                   ]);
		
		$ArrayOferta = array_merge($request->dataOferta, [
			'user_id'       => myhelp::AuthUid(),
			'codigo_oferta' => myhelp::AuthUid(),
			"fecha"         => Carbon::now(),
		
		]);
		$Oferta = Oferta::create($ArrayOferta);
		//			                         "user_id"       => myhelp::AuthUid(),
		//			                         "codigo_oferta" => myhelp::AuthUid(),
		//			                         "descripcion"   => 'descripcion ejemplo',
		//			                         "cargo"         => 'cargo ejemplo',
		//			                         "empresa"       => 'empresa ejemplo',
		//			                         "ciudad"        => 'ciudad ejemplo',
		//			                         "proyecto"      => 'proyecto ejemplo',
		//		                         ]);
		
		foreach ($request->equipos as $indexItem => $itemPlano) { //items
			$totalItem = 0;
			$item = Item::create([
				                     'numero'              => $indexItem,
				                     'nombre'              => 'nombre ejemplo' . $indexItem,
				                     //todo: falta pedir el autoincremental
				                     'descripcion'         => '',
				                     //todo: falta poner la descripcion de demco que va en el excel
				                     'conteo_items'        => count($itemPlano),
				                     'valor_unitario_item' => $totalItem,
				                     'cantidad'            => count($itemPlano),
				                     'valor_total_item'    => 0,
				                     'oferta_id'           => $Oferta->id,
			                     ]);
			
			foreach ($itemPlano as $indexEquipo => $equipoPlano) { //equipos
				$totalItem += $equipoPlano['subtotalequip'];
				$equipo = Equipo::find($equipoPlano['equipo_selec']['value']);
				if ($equipo) {
					$equipo->items()->attach($item->id);
				}
			}
			
			$item->update([
				              'valor_unitario_item' => $totalItem,
				              'valor_total_item'    => (int)($totalItem * count($itemPlano)),
			              ]);
			
			$item->ofertas()->attach($Oferta->id);
		}
		
		DB::commit();
		Myhelp::EscribirEnLog($this, 'GuardarNuevaOferta:Ofertas EXITOSO', 'Oferta id:' . $Oferta->id . ' | proyecto' . $Oferta->proyecto, false);
		
		return redirect('/Oferta')->with('success', __('app.label.created_successfully', ['name' => $Oferta->proyecto]));
	}
	
	//fin store functions
	
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
	
	//<editor-fold desc="destroy and others">
	public function show($id) {}
	
	public function edit($id) {}
	
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
	
	//</editor-fold>
	
	public function buscarEquipos(Request $request) {
		$query = $request->get('q', '');
		
		//codigo descripcion precio_de_lista
		$equipos = Equipo::where('codigo', 'like', "%$query%")->orWhere('descripcion', 'like', "%$query%")->limit(100)->get()
		;
		
		return response()->json(Myhelp::MakeSelect_hardmode($equipos, 'Equipo', false, 'codigo', 'descripcion', ['precio_de_lista']));
	}
	
}
