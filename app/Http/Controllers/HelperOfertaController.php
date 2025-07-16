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


class HelperOfertaController extends Controller
{
    
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
	
		/**
	 * @param $value
	 * @return mixed
	 */
	public function SearchgetFirst($codigoEquipo) {
		$codigoEntrada = (string)$codigoEquipo;
		$codigoLimpio = trim($codigoEntrada);
		$codigoParaBusqueda = intval($codigoLimpio);
		
		$equipo = Equipo::Where('codigo', $codigoParaBusqueda)->first();
		
		if ($equipo == null || is_string($equipo->codigo)) { // Si la primera búsqueda no encontró nada y el campo de la DB es string
			
			$codigoSinCerosLimpio = ltrim($codigoLimpio, '0');
			$equipo = Equipo::where('codigo', $codigoSinCerosLimpio)->first();
			
			if (!$equipo && ($codigoLimpio[0] === '0' && strlen($codigoLimpio) > 1)) {
				$equipo = Equipo::where('codigo', $codigoLimpio)->first();
			}
		}
		
		if ($equipo) {
			return [200, $codigoEquipo, $equipo];
		}
		else {
			return [- 1, $codigoEquipo, null];
		}
		
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
}
