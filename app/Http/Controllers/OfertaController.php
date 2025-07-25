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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OfertaController extends Controller {
	
	public array $thisAtributos;
	public string $FromController = 'Oferta';
	public $ultimoIdMasUno;
	public $ultimaCD;
	
	//<editor-fold desc="Construc | filtro and dependencia">
	public function __construct() {
		$this->thisAtributos = (new Oferta())->getFillable(); //not using
		$VALOR_Ely_En_Reunion = 250852;
		$ultimoIdMasUno = Oferta::latest()->first();
		if($ultimoIdMasUno){
			$this->ultimoIdMasUno =  ((int)$ultimoIdMasUno->id) + 1;
//			$this->ultimaCD = $ultimoIdMasUno->codigo_oferta ++;
			
		}else{
			$this->ultimoIdMasUno = 1;
		}
		$this->ultimaCD = $VALOR_Ely_En_Reunion + Oferta::count() + 1;
		
	}
	
	public function index(Request $request) {
		$nombreMetodoCompleto = __METHOD__;
		Myhelp::EscribirEnLog($this, "Begin $nombreMetodoCompleto", ' primera linea del metodo ' . $nombreMetodoCompleto);
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, ' Ofertas '));
		$helperOfertaController = new HelperOfertaController();
		$Ofertas = $helperOfertaController->Filtros($request)->get();
		
		$perPage = $request->has('perPage') ? $request->perPage : 10;
		
		return Inertia::render($this->FromController . '/Index', [
			'fromController'    => $helperOfertaController->PerPageAndPaginate($request, $Ofertas),
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
		]);
	}
	
	public function NuevaOferta(Request $request, $numplantilla = 1) {
		
		$nombreMetodoCompleto = __METHOD__;
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, "Begin $nombreMetodoCompleto", ' primera linea del metodo ' . $nombreMetodoCompleto));
		
		//		$helperOfertaController = new HelperOfertaController();
		//		$losSelect = [ //ultimosEquipos -> table inferior
		//			'ultimosEquipos' => Equipo::Where('updated_at', '>', Carbon::now()->subDays(30))->Where('precio_de_lista', 0)->take(100)->get()
		//		];
		//		$losSelect = array_merge($losSelect, $helperOfertaController->losSelect(['Equipo'], ['codigo'], ['descripcion']));
		
		return Inertia::render($this->FromController . '/NuevaOferta', [
			'numberPermissions' => $numberPermissions,
			'ultimoIdMasUno'    => $this->ultimoIdMasUno,
			'plantilla'         => $numplantilla,
			'ultimaCD'          => $this->ultimaCD,
		]);
	}
	
	public function NuevaOferta2(Request $request, $numplantilla = 1) {
		$nombreMetodoCompleto = __METHOD__;
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, "Begin $nombreMetodoCompleto", ' primera linea del metodo ' . $nombreMetodoCompleto));
		
		return Inertia::render($this->FromController . '/NuevaOferta2', [
			'numberPermissions' => $numberPermissions,
			'ultimoIdMasUno'    => 0,
			'ultimaCD'          => $this->ultimaCD,
			'plantilla'         => $numplantilla,
		]);
	}
	
	//</editor-fold>
	
	public function GuardarNuevaOferta(Request $request): RedirectResponse {
		
		Myhelp::EscribirEnLog($this, ' Begin ' . __METHOD__, ' primera linea del metodo ' . __METHOD__);
		$request->validate([
			                   'dataOferta'               => 'required|array',
			                   'dataOferta.codigo_oferta' => 'required|string|max:150',
			                   'dataOferta.descripcion'   => 'required|string|max:2048',
			                   'dataOferta.cargo'         => 'required|string|max:256',
			                   'dataOferta.empresa'       => 'required|string|max:256',
			                   'dataOferta.ciudad'        => 'required|string|max:256',
			                   'dataOferta.proyecto'      => 'required|string|max:256',
			                   //			                   'dataOferta.fecha'         => 'required|date',
			                   //			                   'dataOferta.user_id'       => 'required|numeric',
			                   
			                   'daItems' => 'required|array',
			                   'equipos' => 'required|array|min:1',
		                   ]);
		
		$ArrayOferta = array_merge($request->dataOferta, [
			'user_id' => myhelp::AuthUid(),
			//			'codigo_oferta' => $request->dataOferta->codigo_oferta,
			"fecha"   => Carbon::now(),
		]);
		$helperOfertaController = new HelperOfertaController();
		
		try {
			DB::beginTransaction();
			
			$Oferta = Oferta::create($ArrayOferta);
			
			//validacion de los items y equipos
			foreach ($request->equipos as $indexItem => $itemPlano) {
				
				if ($itemPlano == null) {
					continue;
				}
				
				foreach ($itemPlano as $indexEquipo => $equipoPlano) { //equipos
					$soloItems = $request->daItems[$indexItem];
					if (!isset($soloItems) || count($soloItems) === 0) {
						//					dd($itemPlano,
						//						$request->daItems,
						//					    !isset($equipoPlano['nombre_item']) || $equipoPlano['nombre_item'] == null,
						//					    !isset($equipoPlano['nombre_item']) , $equipoPlano['nombre_item'] == null
						//					);
						
						return redirect()->back()->with('error', "Nombre del ítem inválido en ítem " . ($indexItem + 1));
					}
					if ($equipoPlano['equipo_selec'] == null) {
						continue; //permite borrar un equipo
						//						return redirect()->back()->with('error', "No hay equipo señeccionado en el ítem " . ($indexItem + 1));
					}
					if (!isset($equipoPlano['equipo_selec']) && (empty($equipoPlano['equipo_selec']['value']) || $equipoPlano['equipo_selec']['value'] == 0)) {
						return redirect()->back()->with('error', "Nombre del ítem inválido en ítem " . ($indexItem + 1));
					}
				}
			}//fin validacion
			
			foreach ($request->equipos as $indexItem => $itemPlano) { //items
				if (!$itemPlano) {
					continue;
				}
				
				$soloItems = $request->daItems[$indexItem];
				if ($itemPlano == null) {
					continue;
				}
				
				$totalItem = 0;
				$item = Item::create([
					                     'numero'              => $indexItem,
					                     'nombre'              => $soloItems['nombre'],
					                     'descripcion'         => '', //todo: falta descripcion en $soloItems
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
					[
						$respuesta,
						$valorBuscado,
						$equipo
					] = $helperOfertaController->SearchgetFirst($equipoPlano['equipo_selec']['value']);
					if ($respuesta === - 1) {
						return redirect()->back()->with('error', "El equipo $valorBuscado no se encontro en el ítem " . ($indexItem + 1));
					}
					
					$pivotExists = $item->equipos()->wherePivot('equipo_id', $equipo->id)->first();
					if ($pivotExists) {
						//todo: falta validar que el precio de lista sea el mismo
						// Ya existe la relación
						$cantidadActualEnPivote = $pivotExists->pivot->cantidad_equipos;
						$sumQuatity = $equipoPlano['cantidad'] + $cantidadActualEnPivote;
						$item->equipos()->updateExistingPivot($equipo->id, [
							'cantidad_equipos' => $sumQuatity
						]);
					}
					else {
						
						$dctobasico = $equipoPlano['equipo_selec']['descuento_basico'] ?? 0;
						$dctoproyectos = $equipoPlano['equipo_selec']['descuento_proyectos'] ?? 0;
						//todo: validar que seal el mayor de ambos, aunque esto puede variar si el usuario lo cambia en el frontend
						$descFinal = $equipoPlano['descuento_final'] ?? 1.0;
						$item->equipos()->attach($equipo->id, [
							'codigoGuardado'                => $equipoPlano['equipo_selec']['value'] ?? 0,
							'cantidad_equipos'              => $equipoPlano['cantidad'] ?? 1,
							'consecutivo_equipo'            => $indexEquipo,
							'precio_de_lista'               => $equipoPlano['equipo_selec']['precio_de_lista'] ?? 0,
							'fecha_actualizacion'           => Carbon::now(),
							'descuento_basico'              => $dctobasico,    
							'descuento_proyectos'           => $dctoproyectos, 
							'precio_con_descuento'          => 0, //todo: multiplicar por el coste?
							'precio_con_descuento_proyecto' => 0, //todo: multiplicar por el coste?
							'precio_ultima_compra'          => 0,
							
							'descuento_final'    => $descFinal,
							'factor'             => $equipoPlano['factor_final'],
							'nombrefactor'       => '',           //todo: recuperar el nombre apartir del vector en el frontend
							'costo_unitario'     => $equipoPlano['costounitario'],
							'costo_total'        => $equipoPlano['costototal'],
							'precio_de_lista2'   => $equipoPlano['equipo_selec']['precio_de_lista2'],
							'alerta_mano_obra'   => $equipoPlano['equipo_selec']['alerta_mano_obra'],
							'valorunitarioequip' => $equipoPlano['valorunitario'],
							'subtotalequip'      => $equipoPlano['subtotalequip'],
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
			if (app()->environment('local') || app()->environment('test') || app()->environment('testing')) {
				dd($StringError);
			}
			//			Myhelp::EscribirEnLog($this, 'ofertacontroller Error catastrofico ', $StringError);
			
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
	
	//fin store functions
	
	//<editor-fold desc="Edit a recover">
	
	public function update(Request $request, $id): RedirectResponse {
		$nombreMetodoCompleto = __METHOD__;
		Myhelp::EscribirEnLog($this, "Begin $nombreMetodoCompleto", ' primera linea del metodo ' . $nombreMetodoCompleto);
		
		DB::beginTransaction();
		$Oferta = Oferta::findOrFail($id);
		//        $request->merge(['no_nada_id' => $request->no_nada['id']]);
		$Oferta->update($request->all());
		
		DB::commit();
		Myhelp::EscribirEnLog($this, 'UPDATE:Ofertas EXITOSO', 'Oferta id:' . $Oferta->id . ' | ' . $Oferta->nombre, false);
		
		return back()->with('success', __('app.label.updated_successfully2', ['nombre' => $Oferta->nombre]));
	}
	//</editor-fold>
	
	//<editor-fold desc="destroy and others">
	
	public function EditOferta($id) {
		
		$nombreMetodoCompleto = __METHOD__;
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, "Begin $nombreMetodoCompleto", ' primera linea del metodo ' . $nombreMetodoCompleto));
		
		$oferta = Oferta::with('items.equipos')->findOrFail($id);
		
		return Inertia::render($this->FromController . '/EditOferta', [
			'numberPermissions' => $numberPermissions,
			'oferta'            => $oferta,
		]);
	}
	
	public function destroy($Ofertaid) {
		$nombreMetodoCompleto = __METHOD__;
		
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, "Begin $nombreMetodoCompleto", ' primera linea del metodo ' . $nombreMetodoCompleto));
		
		$Oferta = Oferta::find($Ofertaid);
		$elnombre = $Oferta->nombre;
		if ($numberPermissions > 8) {
			
			$Oferta->delete();
			$mensaje = 'Oferta id:' . $Oferta->id . ' | ' . $Oferta->nombre . ' borrado | permisos del usuario = ' . $numberPermissions;
			Myhelp::EscribirEnLog($this, 'DELETE:Ofertas', $mensaje, false);
			
			return back()->with('success', __('app.label.deleted_successfully', ['name' => $elnombre]));
		}
		else {
			abort(502, 'No tienes permisos suficientes para realizar esta acción.');
		}
	}
	
	//</editor-fold>
	
	public function destroyBulk(Request $request) {
		$nombreMetodoCompleto = __METHOD__;
		$permissions = Myhelp::EscribirEnLog($this, "Begin $nombreMetodoCompleto", ' primera linea del metodo ' . $nombreMetodoCompleto);
		$numberPermissions = MyModels::getPermissionToNumber($permissions);
		
		if ($numberPermissions > 8) {
			
			$Oferta = Oferta::whereIn('id', $request->id);
			$Oferta->delete();
			
			return back()->with('success', __('app.label.deleted_successfully', ['name' => count($request->id) . ' ' . __('app.label.ofertas')]));
		}
		abort(502, 'No tienes permisos suficientes para realizar esta acción.');
	}
	
	//		$pdf = Pdf::loadView('pdf.oferta', compact('oferta', 'user'));
	//		$pdf = PDF::loadView('pdf.oferta', compact('oferta', 'user'))->setPaper('A4', 'landscape');
	
	public function buscarEquipos(Request $request): \Illuminate\Http\JsonResponse {
		$query = $request->get('q', '');
		
		//codigo descripcion precio_de_lista
		$equipos = Equipo::where('codigo', 'like', "%$query%")->orWhere('descripcion', 'like', "%$query%")->limit(80)->get();
		
		return response()->json(Myhelp::MakeSelect_hardmode($equipos, 'Equipo', false, 'codigo', 'descripcion', [
			'precio_de_lista',
			'descuento_basico',
			'descuento_proyectos',
			'alerta_mano_obra',
		]));
	}
	
	//esta intacta, igual a guardar nueva oferta
	public function GuardarEditOferta(Request $request): RedirectResponse {
		
		Myhelp::EscribirEnLog($this, ' Begin ' . __METHOD__, ' primera linea del metodo ' . __METHOD__);
		$request->validate([
			                   'dataOferta'               => 'required|array',
			                   'dataOferta.codigo_oferta' => 'required|string|max:150',
			                   'dataOferta.descripcion'   => 'required|string|max:2048',
			                   'dataOferta.cargo'         => 'required|string|max:256',
			                   'dataOferta.empresa'       => 'required|string|max:256',
			                   'dataOferta.ciudad'        => 'required|string|max:256',
			                   'dataOferta.proyecto'      => 'required|string|max:256',
			                   //			                   'dataOferta.fecha'         => 'required|date',
			                   //			                   'dataOferta.user_id'       => 'required|numeric',
			                   
			                   'daItems' => 'required|array',
			                   'equipos' => 'required|array|min:1',
		                   ]);
		
		$ArrayOferta = array_merge($request->dataOferta, [
			'user_id' => myhelp::AuthUid(),
			//			'codigo_oferta' => $request->dataOferta->codigo_oferta,
			"fecha"   => Carbon::now(),
		]);
		$helperOfertaController = new HelperOfertaController();
		
		try {
			DB::beginTransaction();
			
			$Oferta = Oferta::create($ArrayOferta);
			
			//validacion de los items y equipos
			foreach ($request->equipos as $indexItem => $itemPlano) {
				
				if ($itemPlano == null) {
					continue;
				}
				
				foreach ($itemPlano as $indexEquipo => $equipoPlano) { //equipos
					$soloItems = $request->daItems[$indexItem];
					if (!isset($soloItems) || count($soloItems) === 0) {
						//					dd($itemPlano,
						//						$request->daItems,
						//					    !isset($equipoPlano['nombre_item']) || $equipoPlano['nombre_item'] == null,
						//					    !isset($equipoPlano['nombre_item']) , $equipoPlano['nombre_item'] == null
						//					);
						
						return redirect()->back()->with('error', "Nombre del ítem inválido en ítem " . ($indexItem + 1));
					}
					if ($equipoPlano['equipo_selec'] == null) {
						continue; //permite borrar un equipo
						//						return redirect()->back()->with('error', "No hay equipo señeccionado en el ítem " . ($indexItem + 1));
					}
					if (!isset($equipoPlano['equipo_selec']) && (empty($equipoPlano['equipo_selec']['value']) || $equipoPlano['equipo_selec']['value'] == 0)) {
						return redirect()->back()->with('error', "Nombre del ítem inválido en ítem " . ($indexItem + 1));
					}
				}
			}//fin validacion
			
			foreach ($request->equipos as $indexItem => $itemPlano) { //items
				if (!$itemPlano) {
					continue;
				}
				
				$soloItems = $request->daItems[$indexItem];
				if ($itemPlano == null) {
					continue;
				}
				
				$totalItem = 0;
				$item = Item::create([
					                     'numero'              => $indexItem,
					                     'nombre'              => $soloItems['nombre'],
					                     'descripcion'         => '', //todo: falta descripcion en $soloItems
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
					[
						$respuesta,
						$valorBuscado,
						$equipo
					] = $helperOfertaController->SearchgetFirst($equipoPlano['equipo_selec']['value']);
					if ($respuesta === - 1) {
						return redirect()->back()->with('error', "El equipo $valorBuscado no se encontro en el ítem " . ($indexItem + 1));
					}
					
					$pivotExists = $item->equipos()->wherePivot('equipo_id', $equipo->id)->first();
					if ($pivotExists) {
						//todo: falta validar que el precio de lista sea el mismo
						// Ya existe la relación
						$cantidadActualEnPivote = $pivotExists->pivot->cantidad_equipos;
						$sumQuatity = $equipoPlano['cantidad'] + $cantidadActualEnPivote;
						$item->equipos()->updateExistingPivot($equipo->id, [
							'cantidad_equipos' => $sumQuatity
						]);
					}
					else {
						$dctobasico = $equipoPlano['equipo_selec']['descuento_basico'] ?? 0;
						$dctoproyectos = $equipoPlano['equipo_selec']['descuento_proyectos'] ?? 0;
						//todo: validar que seal el mayor de ambos, aunque esto puede variar si el usuario lo cambia en el frontend
						$descFinal = $equipoPlano['descuento_final'] ?? 1.0;
						$item->equipos()->attach($equipo->id, [
							'codigoGuardado'                => $equipoPlano['equipo_selec']['value'] ?? 0,
							'cantidad_equipos'              => $equipoPlano['cantidad'] ?? 1,
							'consecutivo_equipo'            => $indexEquipo,
							'precio_de_lista'               => $equipoPlano['equipo_selec']['precio_de_lista'] ?? 0,
							'fecha_actualizacion'           => Carbon::now(),
							'descuento_basico'              => $dctobasico,
							'descuento_proyectos'           => $dctoproyectos,
							'precio_con_descuento'          => 0, //todo: multiplicar por el coste?
							'precio_con_descuento_proyecto' => 0, //todo: multiplicar por el coste?
							'precio_ultima_compra'          => 0,
							
							'descuento_final'    => $descFinal,
							'factor'             => $equipoPlano['factor_final'],
							'nombrefactor'       => '', //todo: recuperar el nombre apartir del vector en el frontend
							'costo_unitario'     => $equipoPlano['costounitario'],
							'costo_total'        => $equipoPlano['costototal'],
							'precio_de_lista2'   => $equipoPlano['equipo_selec']['precio_de_lista2'],
							'alerta_mano_obra'   => $equipoPlano['equipo_selec']['alerta_mano_obra'],
							'valorunitarioequip' => $equipoPlano['valorunitario'],
							'subtotalequip'      => $equipoPlano['subtotalequip'],
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
			if (app()->environment('local') || app()->environment('test') || app()->environment('testing')) {
				dd($StringError);
			}
			//			Myhelp::EscribirEnLog($this, 'ofertacontroller Error catastrofico ', $StringError);
			
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
	
	public function pdf($id) {
		$nombreMetodoCompleto = __METHOD__;
		Myhelp::EscribirEnLog($this, "Begin $nombreMetodoCompleto", ' primera linea del metodo ' . $nombreMetodoCompleto);
		
		$oferta = Oferta::with(['items.equipos'])->findOrFail($id);
		$user = User::find($oferta->user_id);
		
		$totalOferta = 0;
		
		foreach ($oferta->items as $item) {
			// Ordenar los equipos por el consecutivo guardado en la tabla pivote
			$item->equipos = $item->equipos->sortBy(function ($equipo) {
				return $equipo->pivot->consecutivo_equipo ?? 0;
			});
			
			// Asignar la cantidad a una propiedad temporal para el PDF
			foreach ($item->equipos as $equipo) {
				$equipo->cantidadpdf = $equipo->pivot->cantidad_equipos ?? 1;
			}
			
			// Acumula para el total general
			$totalOferta += $item->valor_total_item;
		}
		//	if($equipo === $lastEquipo)
		//		dd($debug[0]->pivot->toarray(), $precioDeListadebug, $precioDeListadebug2);
		
		$pdf = PDF::loadView('pdf.oferta', compact('oferta', 'user', 'totalOferta'))->setPaper('A4');
		
		return $pdf->stream("Oferta_{$oferta->codigo_oferta}.pdf");
	}
	
}

//		$equipos = Equipo::where('codigo', 'like', "%12%")->orWhere('descripcion', 'like', "%12%")->limit(10)->get();
//		dd(
//		    Myhelp::MakeSelect_hardmode($equipos, 'Equipo', false, 'codigo', 'descripcion', [
//																'precio_de_lista',
//																'descuento_basico',
//																'descuento_proyectos',
//		                                                    ])
//		);