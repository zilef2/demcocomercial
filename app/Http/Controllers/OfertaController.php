<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\Equipo;
use App\Models\Oferta;
use App\helpers\Myhelp;
use App\helpers\MyModels;
use App\Models\User;
use App\Services\OfertaService;

// Import the new service class
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OfertaController extends Controller {
	
	public array $thisAtributos;
	public string $FromController = 'Oferta';
	public $ultimoIdMasUno;
	public $ultimaCD;
	protected $ofertaService;
	private User $theuser;
	
	//<editor-fold desc="Construc | filtro and dependencia">
	
	public function __construct() {
		
		$this->ofertaService = new OfertaService;
		$this->thisAtributos = (new Oferta())->getFillable(); //not using
		$Ely_En_Reunion = 250852;
		$ultimoIdMasUno = Oferta::latest()->first();
		if ($ultimoIdMasUno) {
			
			$prefijo = 'CD';
			$base = $Ely_En_Reunion;
			
			$codigos = Oferta::where('codigo_oferta', 'like', $prefijo . '%')->orderByRaw("CAST(SUBSTRING(codigo_oferta, 3) AS UNSIGNED)")->pluck('codigo_oferta')->map(fn($codigo) => (int)str_replace($prefijo, '', $codigo))->filter(fn($numero) => $numero >= $base)->values()->all();
			
			$resultado = $base;
			
			foreach ($codigos as $numero) {
				if ($numero > $resultado) {
					$resultado = $numero;
				}
			}
			$this->ultimaCD = $resultado + 1;
			
		}
		else {
			$this->ultimaCD = 1;
		}
		
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
	
	public function NuevaOferta($numplantilla = 1) {
		
		$nombreMetodoCompleto = __METHOD__;
		$permissions = auth()->user()->roles->pluck('name')->first();
		$numberPermissions = MyModels::getPermissionToNumber($permissions);
//		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, "Begin $nombreMetodoCompleto", ' primera linea del metodo ' . $nombreMetodoCompleto));
		
		$this->theuser = Myhelp::AuthU();
		
		return Inertia::render($this->FromController . '/NuevaOferta', [
			'numberPermissions' => $numberPermissions,
			'ultimoIdMasUno'    => $this->ultimoIdMasUno,
			'plantilla'         => $numplantilla,
			'ultimaCD'          => $this->ultimaCD,
			'theuser'           => $this->theuser,
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
		$validated = $request->validate([
				'dataOferta' => 'required|array',
				'dataOferta.codigo_oferta' => 'required|string|max:150',
				'dataOferta.cliente' => 'required|string|max:512',
				'dataOferta.descripcion' => 'required|string|max:2048',
				'dataOferta.cargo' => 'required|string|max:256',
				'dataOferta.empresa' => 'required|string|max:256',
				'dataOferta.ciudad' => 'required|string|max:256',
				'dataOferta.proyecto' => 'required|string|max:256',
				
				'items' => 'required|array|min:1',
				'items.*.nombre' => 'required|string|min:2',
				'items.*.cantidad' => 'required|integer|min:1',
				'items.*.equipos' => 'required|array|min:1',
				
				// --- Reglas para cada equipo ---
				// Campos en la raíz del objeto equipo
				'items.*.equipos.*.cantidad' => 'required|integer|min:1',
				'items.*.equipos.*.descuento_final' => 'required|numeric',
				'items.*.equipos.*.factor_final' => 'required|numeric',
				'items.*.equipos.*.costounitario' => 'required|numeric',
				'items.*.equipos.*.costototal' => 'required|numeric',
				'items.*.equipos.*.valorunitario' => 'required|numeric',
				'items.*.equipos.*.subtotalequip' => 'required|numeric',
				
				// Campos dentro de 'equipo_selec'
				'items.*.equipos.*.equipo_selec' => 'required|array',
				'items.*.equipos.*.equipo_selec.value' => 'required',
				'items.*.equipos.*.equipo_selec.title' => 'required',
				'items.*.equipos.*.equipo_selec.precio_de_lista' => 'required|numeric|gt:0',
				'items.*.equipos.*.equipo_selec.descuento_basico' => 'required|numeric',
				'items.*.equipos.*.equipo_selec.descuento_proyectos' => 'required|numeric',
				'ultra_valor_total' => 'required|numeric|min:0',
                    ], [
                        'items.*.nombre.required'                           => 'El nombre de cada item es obligatorio.',
                        'items.*.equipos.min'                               => 'Cada item debe tener al menos un equipo.',
                        
                        // Mensajes personalizados
                        'items.*.equipos.*.equipo_selec.value.required'     => 'Falta el ID (value) de un equipo. Los datos del frontend son incompletos.',
                        'items.*.equipos.*.required'                        => 'Un campo requerido para un equipo no está presente. Los datos del frontend son incompletos.',
                        'items.*.equipos.*.numeric'                         => 'Un campo de equipo que debería ser numérico no lo es.',
                        'items.*.equipos.*.equipo_selec.precio_de_lista.gt' => 'El precio de un equipo no puede ser cero.',
                    ]);
		
		try {
			$oferta = $this->ofertaService->createOferta($validated['dataOferta'], $validated['items']);
			
			$mensajeSucces = 'Parte1 EXITOSO - Oferta id:' . $oferta->id;
			Myhelp::EscribirEnLog($this, 'ofertacontroller', $mensajeSucces);
			
			return redirect('/Oferta')->with('success', __('app.label.created_successfully', ['name' => $oferta->proyecto]));
		} catch (\Throwable $e) {
			return redirect()->back()->with('error', $e->getMessage());
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
		$this->theuser = Myhelp::AuthU();
		
		$oferta = Oferta::with('items.equipos')->findOrFail($id);
		
		return Inertia::render($this->FromController . '/EditOferta', [
			'numberPermissions' => $numberPermissions,
			'oferta'            => $oferta,
			'theuser'           => $this->theuser,
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
	
	public function buscarEquipos(Request $request): JsonResponse {
		$query = $request->get('q', '');
		
		//codigo descripcion precio_de_lista
		$equipos = Equipo::where('codigo', 'like', "%$query%")->orWhere('descripcion', 'like', "%$query%")->orWhere('codigo', 'like', "%$query%")->limit(80)->get();
		
		return response()->json(Myhelp::MakeSelect_hardmode($equipos, 'Equipo', false, 'codigo', 'descripcion', [
			'precio_de_lista',
			'descuento_basico',
			'descuento_proyectos',
			'alerta_mano_obra',
		]));
	}
	
	public function equiposApiError(Request $request): void {
		
		Myhelp::EscribirEnLog($this, "apierror", 'a: ' . $request->get('error', ''));
			
        SendEmailJob::dispatch(' Error en la API de equipos: ' . $request->get('error', '')
                               . ' Usuario: ' . Myhelp::AuthU()->name 
                               . ' IP: ' . $request->ip()
        );
	}
	
	public function buscarEquiposCodigo(Request $request): JsonResponse {
		$query = $request->get('q', '');
		$query = intval(trim($query));
		
		$equipos = Equipo::where('codigo', "$query")->limit(1)->get();
		
		return response()->json(Myhelp::MakeSelect_hardmode($equipos, 'Equipo', false, 'codigo', 'descripcion', [
			'precio_de_lista',
			'descuento_basico',
			'descuento_proyectos',
			'alerta_mano_obra',
		]));
	}
	
	public function pdf($id) {
		$nombreMetodoCompleto = __METHOD__;
		Myhelp::EscribirEnLog($this, "Begin $nombreMetodoCompleto", ' primera linea del metodo ' . $nombreMetodoCompleto);
		
		$oferta = Oferta::with(['items.equipos'])->findOrFail($id);
//		$user = User::find($oferta->user_id);
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
		
		$pdf = PDF::loadView('pdf.oferta', compact('oferta', 'totalOferta'))->setPaper('A4');
		
		return $pdf->stream("Oferta_{$oferta->codigo_oferta}.pdf");
	}
	
	public function GuardarEditOferta(Request $request, $oferta): RedirectResponse {
		$nombreMetodoCompleto = __METHOD__;
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, "Begin $nombreMetodoCompleto", ' primera linea del metodo ' . $nombreMetodoCompleto));
	    $oferta = Oferta::Find($oferta);
//		if($numberPermissions > 9)
//			dd($request->items,$numberPermissions);
		
		$validated = $request->validate([
			'dataOferta' => 'required|array',
			'dataOferta.cliente' => 'required|string|min:1|max:512',
			'dataOferta.codigo_oferta' => 'required|string|max:150',
			'dataOferta.descripcion' => 'required|string|max:2048',
			'dataOferta.cargo' => 'required|string|max:256',
			'dataOferta.empresa' => 'required|string|max:256',
			'dataOferta.ciudad' => 'required|string|max:256',
			'dataOferta.proyecto' => 'required|string|max:256',
			
			'items' => 'required|array|min:1',
			'items.*.nombre' => 'required|string|min:2',
			'items.*.cantidad' => 'required|integer|min:1',
			'items.*.equipos' => 'required|array|min:1',
			
			'items.*.equipos.*.cantidad' => 'required|integer|min:1',
			'items.*.equipos.*.descuento_final' => 'required|numeric',
			'items.*.equipos.*.factor_final' => 'required|numeric',
			'items.*.equipos.*.costounitario' => 'required|numeric',
			'items.*.equipos.*.costototal' => 'required|numeric',
			'items.*.equipos.*.valorunitario' => 'required|numeric',
			'items.*.equipos.*.subtotalequip' => 'required|numeric',
			
			'items.*.equipos.*.equipo_selec' => 'required|array',
			'items.*.equipos.*.equipo_selec.value' => 'required',
			'items.*.equipos.*.equipo_selec.title' => 'required',
			'items.*.equipos.*.equipo_selec.precio_de_lista' => 'required|numeric|gt:0',
			'items.*.equipos.*.equipo_selec.descuento_basico' => 'required|numeric',
			'items.*.equipos.*.equipo_selec.descuento_proyectos' => 'required|numeric',
			'ultra_valor_total' => 'required|numeric|min:0',
        ], [
            'items.*.nombre.required'                           => 'El nombre de cada item es obligatorio.',
            'items.*.equipos.min'                               => 'Cada item debe tener al menos un equipo.',
            
            // Mensajes personalizados
            'items.*.equipos.*.equipo_selec.value.required'     => 'Falta el ID (value) de un equipo. Los datos del formulario son incompletos.',
            'items.*.equipos.*.required'                        => 'Un campo requerido para un equipo no está presente. Los datos del formulario son incompletos.',
            'items.*.equipos.*.numeric'                         => 'Un campo de equipo que debería ser numérico no lo es.',
            'items.*.equipos.*.equipo_selec.precio_de_lista.gt' => 'El precio de un equipo no puede ser cero.',
        ]);
		
		try {
			$ofertaActualizada = $this->ofertaService->updateOferta($oferta, $validated['dataOferta'], $validated['items']);
			
			$mensajeSucces = 'Parte1 EXITOSO - Oferta id:' . $ofertaActualizada->id;
			Myhelp::EscribirEnLog($this, 'ofertacontroller', $mensajeSucces);
			
			return redirect('/Oferta')->with('success', __('app.label.updated_successfully', ['name' => $ofertaActualizada->proyecto]));
		} catch (\Throwable $e) {
			return redirect()->back()->with('error', $e->getMessage());
		}
	}
	
	public function ContinueOferta($id) {
		$nombreMetodoCompleto = __METHOD__;
		$numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, "Begin $nombreMetodoCompleto", ' primera linea del metodo ' . $nombreMetodoCompleto));
		$this->theuser = Myhelp::AuthU();
		
		$oferta = Oferta::with('items.equipos')->findOrFail($id);
		
		return Inertia::render($this->FromController . '/ContinueOferta', [
			'numberPermissions' => $numberPermissions,
			'oferta'            => $oferta,
			'theuser'           => $this->theuser,
			'existingItemCount' => $oferta->items->count(),
		]);
	}
	
	public function GuardarContinueOferta(Request $request): RedirectResponse {
		Myhelp::EscribirEnLog($this, ' Begin ' . __METHOD__, ' primera linea del metodo ' . __METHOD__);
		$request->validate([
			                   'dataOferta'               => 'required|array',
			                   'dataOferta.codigo_oferta' => 'required|string|max:150',
			                   'dataOferta.descripcion'   => 'required|string|max:2048',
			                   'dataOferta.cargo'         => 'required|string|max:256',
			                   'dataOferta.empresa'       => 'required|string|max:256',
			                   'dataOferta.ciudad'        => 'required|string|max:256',
			                   'dataOferta.proyecto'      => 'required|string|max:256',
			                   
			                   'daItems' => 'required|array',
			                   'equipos' => 'required|array|min:1',
		                   ]);
		
		$theofer = Oferta::findOrFail($request->input('oferta_id'));
		try {
			$oferta = $this->ofertaService->addItemsToOferta($theofer, $request->dataOferta, $request->daItems, $request->equipos, $request->cantidadesItem);
			
			$mensajeSucces = 'Parte1 EXITOSO - Oferta id:' . $oferta->id;
			Myhelp::EscribirEnLog($this, 'ofertacontroller', $mensajeSucces);
			
			return redirect('/Oferta')->with('success', __('app.label.updated_successfully', ['name' => $oferta->proyecto]));
		} catch (\Throwable $e) {
			return redirect()->back()->with('error', $e->getMessage());
		}
	}
}