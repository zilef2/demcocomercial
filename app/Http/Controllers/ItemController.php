<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Item;
use App\helpers\Myhelp;
use App\helpers\MyModels;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ItemController extends Controller {
	
	public array $thisAtributos;
	public string $FromController = 'Item';
	
	//<editor-fold desc="Construc | filtro and dependencia">
	public function __construct() {
		//        $this->middleware('permission:create Item', ['only' => ['create', 'store']]);
		//        $this->middleware('permission:read Item', ['only' => ['index', 'show']]);
		//        $this->middleware('permission:update Item', ['only' => ['edit', 'update']]);
		//        $this->middleware('permission:delete Item', ['only' => ['destroy', 'destroyBulk']]);
		$this->thisAtributos = (new Item())->getFillable(); //not using
	}
	
	public function index(Request $request) {
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, ' Items '));
		$Items = $this->Filtros($request)->get();
		
		$perPage = $request->has('perPage') ? $request->perPage : 10;
		
		
		return Inertia::render($this->FromController . '/Index', [
			'fromController'    => $this->PerPageAndPaginate($request, $Items),
			'total'             => $Items->count(),
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
			'titulos'           => Item::getFillableWithTypes(),
			'losSelect'         => $this->losSelect(['Equipo'], ['Codigo'],['Descripcion']),
		]);
	}
	
	public function Filtros($request): Builder {
		$Items = Item::query();
		if ($request->has('search')) {
			$Items = $Items->where(function ($query) use ($request) {
				$query->where('nombre', 'LIKE', "%" . $request->search . "%")
					//                    ->orWhere('codigo', 'LIKE', "%" . $request->search . "%")
					//                    ->orWhere('identificacion', 'LIKE', "%" . $request->search . "%")
				;
			});
		}
		
		if ($request->has(['field', 'order'])) {
			$Items = $Items->orderBy($request->field, $request->order);
		}
		else {
			$Items = $Items->orderBy('updated_at', 'DESC');
		}
		
		
		return $Items;
	}
	
	public function PerPageAndPaginate($request, $Items) {
		$perPage = $request->has('perPage') ? $request->perPage : 10;
		$page = request('page', 1); // Current page number
		$paginated = new LengthAwarePaginator($Items->forPage($page, $perPage), $Items->count(), $perPage, $page, ['path' => request()->url()]);
		
		
		return $paginated;
	}
	
	//</editor-fold>
	
	//This is awesome
	
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
//			$simpleClass[$displayField[$index]] = Myhelp::MakeSelect(
//				$modelCollection, $nameofclass,false,$displayField);
			$simpleClass[$displayField[$index]] = Myhelp::MakeSelect($modelCollection, $nameofclass, false, $displayField[$index], $displayField2[$index]);
		}
		
		
		return $simpleClass;
	}
	
	public function losSelect2(string $modelClass, string $label, string $displayField = 'nombre', $displayField2 = 'Descripcion'): array {
		// Verifica si la clase del modelo existe
		if (!class_exists($modelClass)) {
			return []; // O podrías lanzar una excepción más informativa
		}
		
		// Intenta obtener todos los registros del modelo
		$modelCollection = call_user_func([$modelClass, 'all']);
		// Verifica si el resultado es una colección
		if (!$modelCollection instanceof Collection) {
			return []; // O podrías lanzar una excepción
		}
		
		
		return [
			$label => Myhelp::NEW_turnInSelectID($modelCollection, $label . ' ', $displayField, $displayField2),
		];
	}
	
	public function store(Request $request): RedirectResponse {
		dd($request);
		
		$permissions = Myhelp::EscribirEnLog($this, ' Begin STORE:Items');
		DB::beginTransaction();
		
		$Item = Item::create($request->all());//todo: equipo_item
		$this->zilefSyncManytoMany($request['equipos_id'], $Item);
		
		DB::commit();
		Myhelp::EscribirEnLog($this, 'STORE:Items EXITOSO', 'Item id:' . $Item->id . ' | ' . $Item->nombre, false);
		
		
		return back()->with('success', __('app.label.created_successfully', ['name' => $Item->nombre]));
	}
	
	public function create() {}
	
	//! STORE - UPDATE - DELETE
	//! STORE functions
	
	public function zilefSyncManytoMany($ManyRequestIds, $currentModel): void {
		$ids = array_map(function ($item) {
			return $item['value'] ?? null;
		}, $ManyRequestIds);
		
		$currentModel->Equipos()->sync($ids);
	}
	
	//fin store functions
	
	public function show($id) {}
	
	public function edit($id) {}
	
	public function update(Request $request, $id): RedirectResponse {
		$permissions = Myhelp::EscribirEnLog($this, ' Begin UPDATE:Items');
		DB::beginTransaction();
		$Item = Item::findOrFail($id);
		//        $request->merge(['no_nada_id' => $request->no_nada['id']]);
		$Item->update($request->all());
		
		DB::commit();
		Myhelp::EscribirEnLog($this, 'UPDATE:Items EXITOSO', 'Item id:' . $Item->id . ' | ' . $Item->nombre, false);
		
		
		return back()->with('success', __('app.label.updated_successfully2', ['nombre' => $Item->nombre]));
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	
	public function destroy($Itemid) {
		$permissions = Myhelp::EscribirEnLog($this, 'DELETE:Items');
		$Item = Item::find($Itemid);
		$elnombre = $Item->nombre;
		$Item->delete();
		Myhelp::EscribirEnLog($this, 'DELETE:Items', 'Item id:' . $Item->id . ' | ' . $Item->nombre . ' borrado', false);
		
		
		return back()->with('success', __('app.label.deleted_successfully', ['name' => $elnombre]));
	}
	
	public function destroyBulk(Request $request) {
		$Item = Item::whereIn('id', $request->id);
		$Item->delete();
		
		
		return back()->with('success', __('app.label.deleted_successfully', ['name' => count($request->id) . ' ' . __('app.label.user')]));
	}
	//FIN : STORE - UPDATE - DELETE
	
}
