<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Item;
use App\Models\Oferta;
use App\helpers\Myhelp;
use App\helpers\MyModels;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
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
	
	public function NuevaOferta(Request $request, $numplantilla = 1) {
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, ' Nueva|Oferta ', 'ingreso a la vista NuevaOferta'));
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
			'plantilla'         => $numplantilla,
		]);
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
	
	public function NuevaOferta2(Request $request) {
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, ' Nueva|Oferta2 ', 'ingreso al paso 2 de la oferta'));
		$ultimoIdMasUno = Oferta::latest()->first();
		$ultimoIdMasUno = $ultimoIdMasUno ? ((int)$ultimoIdMasUno->id) + 1 : 1;
		
		return Inertia::render($this->FromController . '/NuevaOferta2', [
			'numberPermissions' => $numberPermissions,
			'ultimoIdMasUno'    => $ultimoIdMasUno,
		]);
	}
	
	public function GuardarNuevaOferta(Request $request): RedirectResponse {
		$permissions = Myhelp::EscribirEnLog($this, ' Begin GuardarNuevaOferta');
		
		DB::beginTransaction();
		$request->validate([
			                   'daItems'    => 'required|array',
			                   'dataOferta' => 'required|array',
			                   //    'items.*' => 'exists:items,id',
		                   ]);
		
		$ArrayOferta = array_merge($request->dataOferta, [
			'user_id' => myhelp::AuthUid(),
			//			'codigo_oferta' => $request->dataOferta->codigo_oferta,
			"fecha"   => Carbon::now(),
		
		]);
		try {
			
			$Oferta = Oferta::create($ArrayOferta);
			
			foreach ($request->equipos as $indexItem => $itemPlano) {
				if ($itemPlano == null) {
					continue;
				}
				
				foreach ($itemPlano as $indexEquipo => $equipoPlano) { //equipos
					if (!isset($equipoPlano['nombre_item']) || $equipoPlano['nombre_item'] == null) {
						
						return redirect()->back()->with('error', "Nombre del ítem inválido en ítem " . ($indexItem + 1));
					}
					if ($equipoPlano['equipo_selec'] == null) {
						continue;
						//						return redirect()->back()->with('error', "No hay equipo señeccionado en el ítem " . ($indexItem + 1));
					}
					if (!isset($equipoPlano['equipo_selec']) && (empty($equipoPlano['equipo_selec']['value']) || $equipoPlano['equipo_selec']['value'] == 0)) {
						return redirect()->back()->with('error', "Nombre del ítem inválido en ítem " . ($indexItem + 1));
					}
				}
			}//fin validacion
			
			foreach ($request->equipos as $indexItem => $itemPlano) { //items
				if ($itemPlano == null) {
					continue;
				}
				
				$totalItem = 0;
				$item = Item::create([
					                     'numero'              => $indexItem,
					                     'nombre'              => $itemPlano[0]['nombre_item'] ?? 'item numero ' . $indexItem,
					                     'descripcion'         => '',
					                     'conteo_items'        => count($itemPlano),
					                     'cantidad'            => $request->cantidadesItem[$indexItem],
					                     'oferta_id'           => $Oferta->id,
					                     'valor_unitario_item' => 0,
					                     'valor_total_item'    => 0,
				                     ]);
				
				foreach ($itemPlano as $indexEquipo => $equipoPlano) { //equipos
					if ($equipoPlano['equipo_selec'] == null) {
						continue;
					}
					
					$totalItem += $equipoPlano['subtotalequip'];
					[$respuesta,$valorBuscado, $equipo] = $this->SearchgetFirst($equipoPlano['equipo_selec']['value']);
					if ($respuesta === - 1) {
						return redirect()->back()->with('error', "El equipo $valorBuscado no se encontro en el ítem " . ($indexItem + 1));
					}
					
					$pivotExists = $item->equipos()->wherePivot('equipo_id', $equipo->id)->first();
					
					if ($pivotExists) {
						//todo: falta validar que el precio de lista sea el mismo
						// Ya existe la relación
						$cantidadActualEnPivote = $pivotExists->pivot->cantidad_equipos;
						$sumQuatity = $equipoPlano['cantidad'] +$cantidadActualEnPivote;
						$item->equipos()->updateExistingPivot($equipo->id, [
							'cantidad_equipos' => $sumQuatity
						]);
						
					}
					else {
						$item->equipos()->attach($equipo->id, [
							'codigoGuardado'                => $equipoPlano['equipo_selec']['value'] ?? 0,
							'cantidad_equipos'              => $equipoPlano['cantidad'] ?? 1,
							'consecutivo_equipo'            => $indexEquipo,
							'precio_de_lista'               => $equipoPlano['equipo_selec']['precio_de_lista'] ?? 0,
							'fecha_actualizacion'           => Carbon::now(),
							'descuento_basico'              => 0,
							'descuento_proyectos'           => 0,
							'precio_con_descuento'          => 0,
							'precio_con_descuento_proyecto' => 0,
							'precio_ultima_compra'          => 0,
						]);
					}
				}
				
				$item->update([
					              'valor_unitario_item' => $totalItem,
					              'valor_total_item'    => (int)($totalItem * ($request->cantidadesItem[$indexItem])),
				              ]);
				
				$item->ofertas()->attach($Oferta->id);
			}
			
			DB::commit();
			$mensajeSucces = 'Parte1 EXITOSO - Oferta id:' . $Oferta->id;
			Myhelp::EscribirEnLog($this, 'ofertacontroller', $mensajeSucces);
			
			//		return redirect('/OfertaPaso2')->with('success', __('app.label.created_successfully', ['name' => $Oferta->proyecto]));
			return redirect('/Oferta')->with('success', __('app.label.created_successfully', ['name' => $Oferta->proyecto]));
			
		} catch (QueryException $e) {
			if ($e->getCode() == 23000 && str_contains($e->getMessage(), "equipo_item.PRIMARY")) {
				return redirect()->back()->with('error', 'Hay un equipo repetido en el item ' . $item->nombre . '. Código del equipo: ' . $equipo->codigo);
			}
			if (app()->environment('local') || app()->environment('test')) {
				$ProblemEquipo = $equipoPlano ?? false;
				if ($ProblemEquipo) {
					$ProblemEquipo = $ProblemEquipo['equipo_selec'];
					if ($ProblemEquipo) {
						$ProblemEquipo = $ProblemEquipo['value'];
					}
				}
				dd('Fatal error en la linea ' . $e->getLine() . ' del archivo ' . $e->getFile(), $e->getMessage(), 'item_nombre', $item->nombre ?? null, 'Data del equipo: ' . $ProblemEquipo);
			}
			
			return redirect()->back()->with('error', 'Ocurrió un problema con la base de datos. Intenta mas tarde.');
		} catch (\Throwable $e) {
			DB::rollBack();
			$arrayerr = [
				'error'       => $e->getMessage(),
				'line'        => $e->getLine(),
				'file'        => $e->getFile(),
				'indexEquipo' => $indexEquipo ?? null,
				'item_id'     => $item->id ?? null,
				'oferta_id'   => $Oferta->id ?? null,
			];
			$StringError = implode(' -- ', $arrayerr);
			Myhelp::EscribirEnLog($this, 'ofertacontroller Error catastrofico ', $StringError);
			
			if (app()->environment('local') || app()->environment('test')) {
				$ProblemEquipo = $equipoPlano ?? false;
				if ($ProblemEquipo) {
					$ProblemEquipo = $ProblemEquipo['equipo_selec'];
					if ($ProblemEquipo) {
						$ProblemEquipo = $ProblemEquipo['value'];
					}
				}
				
				dd('Fatal error en la linea ' . $e->getLine() . ' del archivo ' . $e->getFile(), $e->getMessage(), 'item_nombre', $item->nombre ?? null, 'Data del equipo: ' . $ProblemEquipo);
			}
			else {
				return redirect()->back()->with('error', 'Ocurrió un problema al guardar la oferta.');
				
			}
			
		}
	}
	
	//! STORE - UPDATE - DELETE
	//! STORE functions
	
	public function create() {}
	
	//fin store functions
	
	/**
	 * @param $value
	 * @return mixed
	 */
	public function SearchgetFirst($value) {
		$codigoEntrada = (string)$value;
		$codigoLimpio = trim($codigoEntrada);
		$codigoParaBusqueda = intval($codigoLimpio);
		
		$equipo = Equipo::Where('codigo', $codigoParaBusqueda)->first();
		
		if (!$equipo && is_string($equipo->codigo)) { // Si la primera búsqueda no encontró nada y el campo de la DB es string
			
			// Para el caso de "01359" vs "1359" cuando el campo de la DB es VARCHAR
			// podrías probar eliminando solo los ceros a la izquierda, no convirtiendo a int
			$codigoSinCerosLimpio = ltrim($codigoLimpio, '0');
			$equipo = Equipo::where('codigo', $codigoSinCerosLimpio)->first();
			
			// Si aún no lo encuentras, quizás el código sin los ceros a la izquierda originales.
			// Esto es si tu campo 'codigo' en la DB almacena valores como '1359' y la entrada podría ser '01359'.
			// Esta parte ya depende mucho de cómo están los datos en tu DB.
			if (!$equipo && ($codigoLimpio[0] === '0' && strlen($codigoLimpio) > 1)) {
				// Intentar buscar el código original si contenía ceros a la izquierda
				// y no se encontró después de trim y intval.
				// Esto solo es útil si tu campo 'codigo' es VARCHAR y puede contener '01359' como tal.
				$equipo = Equipo::where('codigo', $codigoLimpio)->first();
			}
		}
		
		if ($equipo) {
			return [200,$value,$equipo];
		}
		else {
			return [-1,$value,null];
		}
		
	}
	
	//<editor-fold desc="destroy and others">
	
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
		Myhelp::EscribirEnLog($this, 'DELETE:Ofertas', 'Oferta id:' . $Oferta->id . ' | ' . $Oferta->nombre . ' borrado | permisos = '.$permissions, false);
		
		return back()->with('success', __('app.label.deleted_successfully', ['name' => $elnombre]));
	}
	
	//</editor-fold>
	
	public function destroyBulk(Request $request) {
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, ' Ofertas '));
		if ($numberPermissions > 8) {
			
			$Oferta = Oferta::whereIn('id', $request->id);
			$Oferta->delete();
			
			return back()->with('success', __('app.label.deleted_successfully', ['name' => count($request->id) . ' ' . __('app.label.ofertas')]));
		}
		abort(502, 'No tienes permisos suficientes para realizar esta acción.');
	}
	
	//		$pdf = Pdf::loadView('pdf.oferta', compact('oferta', 'user'));
	//		$pdf = PDF::loadView('pdf.oferta', compact('oferta', 'user'))->setPaper('A4', 'landscape');
	
	public function buscarEquipos(Request $request) {
		$query = $request->get('q', '');
		
		//codigo descripcion precio_de_lista
		$equipos = Equipo::where('codigo', 'like', "%$query%")->orWhere('descripcion', 'like', "%$query%")->limit(100)->get();
		
		return response()->json(Myhelp::MakeSelect_hardmode($equipos, 'Equipo', false, 'codigo', 'descripcion', ['precio_de_lista']));
	}
	
	public function pdf($id) {
		$oferta = Oferta::with(['items.equipos'])->findOrFail($id);
		$user = User::find($oferta->user_id);
		
		$totalOferta = 0;
		
		foreach ($oferta->items as $item) {
			$subtotalEquipos = 0;
			
			$lastEquipo = $item->equipos->last();
			$precioDeListadebug = [];
			$precioDeListadebug2 = [];
			$item->equipos = $item->equipos->sortBy(function ($equipo) {
				// Asegúrate de que 'pivot' y 'consecutivo_equipo' existan
				return $equipo->pivot->consecutivo_equipo ?? 0;
			});
			foreach ($item->equipos as $equipo) {
				$cantidadEquipos = $equipo->pivot->cantidad_equipos ?? 1;
				$precioDeLista = $equipo->pivot->precio_de_lista ?? 0;
				$subtotalEquipos += $precioDeLista * $cantidadEquipos;
				
				if (417 == $equipo->codigo) {
					$precioDeListadebug2[] = $equipo->pivot->toArray();
				}
				$precioDeListadebug[$equipo->codigo] = [$equipo->pivot->precio_de_lista,$equipo->pivot->cantidad_equipos];
				$debug = $item->equipos;
			}
			
			// Multiplica por la cantidad del ítem
			$item->sumatotal = $subtotalEquipos;
			$item->subtotal = $subtotalEquipos * $item->cantidad;
			
			// Acumula para el total general
			$totalOferta += $item->subtotal;
		}
		//	if($equipo === $lastEquipo)
//		dd($debug[0]->pivot->toarray(), $precioDeListadebug, $precioDeListadebug2);
		
		$pdf = PDF::loadView('pdf.oferta', compact('oferta', 'user', 'totalOferta'))->setPaper('A4');
		
		return $pdf->stream("Oferta_{$oferta->codigo_oferta}.pdf");
	}
	
}
