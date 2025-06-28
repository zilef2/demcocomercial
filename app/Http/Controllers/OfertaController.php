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
	
	public function NuevaOferta(Request $request) {
		$numberPermissions = MyModels::getPermissionToNumber(
			Myhelp::EscribirEnLog($this, ' Nueva|Oferta ','ingreso a la vista NuevaOferta'));
		$ultimoIdMasUno = Oferta::latest()->first();
		$ultimoIdMasUno = $ultimoIdMasUno ? ((int)$ultimoIdMasUno->id) + 1 : 1;
		
		$perPage = $request->has('perPage') ? $request->perPage : 10;
		
		$losSelect = [ //ultimosEquipos -> table inferior
			'ultimosEquipos' => Equipo::Where('updated_at', '>', Carbon::now()->subDays(30))->Where('precio_de_lista', 0)->take(100)->get()
		];
		$losSelect = array_merge($losSelect, $this->losSelect(['Equipo'], ['codigo'], ['descripcion']));
		
		//		$losSelect = $this->losSelect(['Equipo'], ['codigo'], ['descripcion']);
		
		return Inertia::render($this->FromController . '/NuevaOferta', [
			'numberPermissions' => $numberPermissions,
			'ultimoIdMasUno'    => $ultimoIdMasUno,
		]);
	}
	public function NuevaOferta2(Request $request) {
		$numberPermissions = MyModels::getPermissionToNumber(
			Myhelp::EscribirEnLog($this, ' Nueva|Oferta2 ','ingreso al paso 2 de la oferta'));
		$ultimoIdMasUno = Oferta::latest()->first();
		$ultimoIdMasUno = $ultimoIdMasUno ? ((int)$ultimoIdMasUno->id) + 1 : 1;
		
		return Inertia::render($this->FromController . '/NuevaOferta2', [
			'numberPermissions' => $numberPermissions,
			'ultimoIdMasUno'    => $ultimoIdMasUno,
		]);
	}
	
	//</editor-fold>
	
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
	
	public function create() {}
	
	//! STORE - UPDATE - DELETE
	//! STORE functions
	
	public function GuardarNuevaOferta(Request $request): RedirectResponse {
		$permissions = Myhelp::EscribirEnLog($this, ' Begin GuardarNuevaOferta');
		
		DB::beginTransaction();
		$request->validate([
			                   'daItems'      => 'required|array',
			                   'dataOferta' => 'required|array',
			                   //    'items.*' => 'exists:items,id',
		                   ]);
		
		$ArrayOferta = array_merge($request->dataOferta, [
			'user_id'       => myhelp::AuthUid(),
			'codigo_oferta' => myhelp::AuthUid(),
			"fecha"         => Carbon::now(),
		
		]);
		try {
			
			$Oferta = Oferta::create($ArrayOferta);
			
			foreach ($request->equipos as $indexItem => $itemPlano) { //items
				$totalItem = 0;
				$item = Item::create([
					                     'numero'       => $indexItem,
					                     'nombre'       => $request->daItems[$indexItem]['nombre'] ?? 'nombre no liedo' . $indexItem,
					                     'descripcion'  => '',
					                     'conteo_items' => count($itemPlano),
					                     'cantidad'     => count($itemPlano),
					                     'oferta_id'    => $Oferta->id,
					                     
					                     'valor_unitario_item' => $totalItem,
					                     'valor_total_item'    => 0,
				                     ]);
				
				foreach ($itemPlano as $indexEquipo => $equipoPlano) { //equipos
					$totalItem += $equipoPlano['subtotalequip'];
					$equipo = Equipo::where('codigo',$equipoPlano['equipo_selec']['value'])->first();
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
			$mensajeSucces = 'Parte1 EXITOSO - Oferta id:' . $Oferta->id;
		Myhelp::EscribirEnLog($this, 'ofertacontroller', $mensajeSucces);
		
		return redirect('/OfertaPaso2')->with('success', __('app.label.created_successfully', ['name' => $Oferta->proyecto]));
//		return redirect('/Oferta')->with('success', __('app.label.created_successfully', ['name' => $Oferta->proyecto]));
		} catch (\Throwable $e) {
			DB::rollBack();
			dd(
				'esto  es un error fatal',
			    'error'       , $e->getMessage(),
				'line'        , $e->getLine(),
				'file'        , $e->getFile(),
				'indexEquipo' , $indexEquipo ?? null,
				'item_id'     , $item->id ?? null,
				'oferta_id'   , $Oferta->id ?? null,
			);
			$arrayerr = [
				'error'       => $e->getMessage(),
				'line'        => $e->getLine(),
				'file'        => $e->getFile(),
				'indexEquipo' => $indexEquipo ?? null,
				'item_id'     => $item->id ?? null,
				'oferta_id'   => $Oferta->id ?? null,
			];
			$StringError = implode(' -- ', $arrayerr);
			Myhelp::EscribirEnLog($this, 'ofertacontroller Error catastrofico ',$StringError );
			
			// Mensaje humano para el usuario
			return redirect()->back()->with('error', 'Ocurrió un problema al guardar la oferta. Intenta nuevamente.');
		}
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
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, ' Ofertas '));
		if ($numberPermissions > 8) {
			
			$Oferta = Oferta::whereIn('id', $request->id);
			$Oferta->delete();
			
			return back()->with('success', __('app.label.deleted_successfully', ['name' => count($request->id) . ' ' . __('app.label.ofertas')]));
		}
		abort(502, 'No tienes permisos suficientes para realizar esta acción.');
	}
	
	//</editor-fold>
	
	public function buscarEquipos(Request $request) {
		$query = $request->get('q', '');
		
		//codigo descripcion precio_de_lista
		$equipos = Equipo::where('codigo', 'like', "%$query%")->orWhere('descripcion', 'like', "%$query%")->limit(100)->get();
		
		return response()->json(Myhelp::MakeSelect_hardmode($equipos, 'Equipo', false, 'codigo', 'descripcion', ['precio_de_lista']));
	}
	
}
