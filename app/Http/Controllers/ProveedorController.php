<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\helpers\Myhelp;
use App\helpers\MyModels;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ProveedorController extends Controller {
    public array $thisAtributos;
    public string $FromController = 'Proveedor';


    //<editor-fold desc="Construc | filtro and dependencia">
    public function __construct() {
//        $this->middleware('permission:create Proveedor', ['only' => ['create', 'store']]);
//        $this->middleware('permission:read Proveedor', ['only' => ['index', 'show']]);
//        $this->middleware('permission:update Proveedor', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:delete Proveedor', ['only' => ['destroy', 'destroyBulk']]);
        $this->thisAtributos = (new Proveedor())->getFillable(); //not using
    }

    public function index(Request $request) {
        $numberPermissions = MyModels::getPermissionToNumber(Myhelp::EscribirEnLog($this, ' Proveedors '));
        $Proveedors = $this->Filtros($request)->get();
//        $losSelect = $this->Dependencias();


        $perPage = $request->has('perPage') ? $request->perPage : 10;
        return Inertia::render($this->FromController . '/Index', [
            'fromController' => $this->PerPageAndPaginate($request, $Proveedors),
            'total' => $Proveedors->count(),

            'breadcrumbs' => [
                [
                    'label' => __('app.label.' . $this->FromController),
                    'href' => route($this->FromController . '.index')
                ]
            ],
            'title' => __('app.label.' . $this->FromController),
            'filters' => $request->all([
                                           'search',
                                           'field',
                                           'order'
                                       ]),
            'perPage' => (int)$perPage,
            'numberPermissions' => $numberPermissions,
            'losSelect' => $losSelect ?? [],
        ]);
    }

    public function Filtros($request): Builder {
        $Proveedors = Proveedor::query();
        if ($request->has('search')) {
            $Proveedors = $Proveedors->where(function ($query) use ($request) {
                $query->where('nombre', 'LIKE', "%" . $request->search . "%")
                    //                    ->orWhere('codigo', 'LIKE', "%" . $request->search . "%")
                    //                    ->orWhere('identificacion', 'LIKE', "%" . $request->search . "%")
                ;
            });
        }

        if ($request->has(['field', 'order'])) {
            $Proveedors = $Proveedors->orderBy($request->field, $request->order);
        } else
            $Proveedors = $Proveedors->orderBy('updated_at', 'DESC');
        return $Proveedors;
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

    public function PerPageAndPaginate($request, $Proveedors) {
        $perPage = $request->has('perPage') ? $request->perPage : 10;
        $page = request('page', 1); // Current page number
        $paginated = new LengthAwarePaginator(
            $Proveedors->forPage($page, $perPage),
            $Proveedors->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );
        return $paginated;
    }

    public function store(Request $request): RedirectResponse {
        $permissions = Myhelp::EscribirEnLog($this, ' Begin STORE:Proveedors');
        DB::beginTransaction();
//        $no_nada = $request->no_nada['id'];
//        $request->merge(['no_nada_id' => $request->no_nada['id']]);
        $Proveedor = Proveedor::create($request->all());

        DB::commit();
        Myhelp::EscribirEnLog($this, 'STORE:Proveedors EXITOSO', 'Proveedor id:' . $Proveedor->id . ' | ' . $Proveedor->nombre, false);
        return back()->with('success', __('app.label.created_successfully', ['name' => $Proveedor->nombre]));
    }

    //! STORE - UPDATE - DELETE
    //! STORE functions

    public function create() {
    }

    //fin store functions

    public function show($id) {
    }

    public function edit($id) {
    }

    public function update(Request $request, $id): RedirectResponse {
        $permissions = Myhelp::EscribirEnLog($this, ' Begin UPDATE:Proveedors');
        DB::beginTransaction();
        $Proveedor = Proveedor::findOrFail($id);
//        $request->merge(['no_nada_id' => $request->no_nada['id']]);
        $Proveedor->update($request->all());

        DB::commit();
        Myhelp::EscribirEnLog($this, 'UPDATE:Proveedors EXITOSO', 'Proveedor id:' . $Proveedor->id . ' | ' . $Proveedor->nombre, false);
        return back()->with('success', __('app.label.updated_successfully2', ['nombre' => $Proveedor->nombre]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy($Proveedorid) {
        $permissions = Myhelp::EscribirEnLog($this, 'DELETE:Proveedors');
        $Proveedor = Proveedor::find($Proveedorid);
        $elnombre = $Proveedor->nombre;
        $Proveedor->delete();
        Myhelp::EscribirEnLog($this, 'DELETE:Proveedors', 'Proveedor id:' . $Proveedor->id . ' | ' . $Proveedor->nombre . ' borrado', false);
        return back()->with('success', __('app.label.deleted_successfully', ['name' => $elnombre]));
    }

    public function destroyBulk(Request $request) {
        $Proveedor = Proveedor::whereIn('id', $request->id);
        $Proveedor->delete();
        return back()->with('success', __('app.label.deleted_successfully', ['name' => count($request->id) . ' ' . __('app.label.user')]));
    }
    //FIN : STORE - UPDATE - DELETE

}
