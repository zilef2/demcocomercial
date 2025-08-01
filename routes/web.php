<?php
//esto es comercial
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\ParametrosController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PruebasRapidasController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActividadsController;
use App\Http\Controllers\CentrotrabajosController;
use App\Http\Controllers\DisponibilidadsController;

//use App\Http\Controllers\OrdentrabajosController;
//use App\Http\Controllers\PiezasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReadGoogleSheets;
use App\Http\Controllers\ReprocesosController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
require __DIR__ . '/auth.php';

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', [UserController::class, 'Dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/RRepor', [UserController::class, 'RRepor'])->middleware(['auth', 'verified'])->name('RRepor');
Route::get('/ActualizaGoogleManual', [ReadGoogleSheets::class, 'ActualizaGoogleManual'])->middleware(['auth', 'verified'])->name('ActualizaGoogleManual');
Route::get('/Actualizaot', [ReadGoogleSheets::class, 'Actualizaot'])->middleware(['auth', 'verified'])->name('Actualizaot');
Route::get('/phpinfoahk', [ReadGoogleSheets::class, 'phpinfoahk'])->middleware(['auth', 'verified'])->name('phpinfoahk');
Route::get('/OnlyViewNecesitaActualizaF', [ReadGoogleSheets::class, 'OnlyViewNecesitaActualizaF'])->middleware(['auth', 'verified'])->name('OnlyViewNecesitaActualizaF');
Route::get('/mochar', [ReadGoogleSheets::class, 'mochar'])->name('mochar'); //sin ejemplos papa
Route::get('/justValidateConection', [ReadGoogleSheets::class, 'justValidateConection'])->name('justValidateConection'); //sin ejemplos papa
Route::get('/logout2', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout2');

Route::get('/setLang/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return back();
})->name('setlang');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //# user
    Route::resource('/user', UserController::class)->except('create', 'show', 'edit');
    Route::post('/user/destroy-bulk', [UserController::class, 'destroyBulk'])->name('user.destroy-bulk');
    // Route::get('/subirexceles', [UserController::class, 'subirexceles'])->name('subirexceles');


    Route::resource('/role', RoleController::class)->except('create', 'show', 'edit');
    Route::post('/role/destroy-bulk', [RoleController::class, 'destroyBulk'])->name('role.destroy-bulk');

    Route::resource('/permission', PermissionController::class)->except('create', 'show', 'edit');
    Route::post('/permission/destroy-bulk', [PermissionController::class, 'destroyBulk'])->name('permission.destroy-bulk');


    Route::resource('/parametro', ParametrosController::class);

    //# SIDEBARMENU
    Route::resource('/reporte', ReportesController::class);
    Route::post('/reporte/destroy-bulk', [ReportesController::class, 'destroyBulk'])->name('reporte.destroy-bulk');


    Route::resource('/actividad', ActividadsController::class);

    Route::resource('/centrotrabajo', CentrotrabajosController::class);
    Route::resource('/disponibilidad', DisponibilidadsController::class);
    Route::resource('/reproceso', ReprocesosController::class);
    Route::get('/gsheet', ReadGoogleSheets::class);


    //# EXCEL
    Route::get('/EquipoUploadExcel', [ExcelController::class, 'FunctionUploadFromEx'])->name('EquipoUploadExcel');
    Route::post('/EquipoUploadExcelPost', [ExcelController::class, 'importEquipo'])->name('EquipoUploadExcelPost');


    Route::get('/demco', [UserController::class, 'todaBD'])->name('demcodb');
	
	
	Route::resource("/Proveedor", \App\Http\Controllers\ProveedorController::class);
	Route::resource("/Equipo", \App\Http\Controllers\EquipoController::class);
	Route::resource("/Proveedor", \App\Http\Controllers\ProveedorController::class);
	
    Route::get('/pruebas', [PruebasRapidasController::class, 'pruebasget'])->name('pruebasget');
    Route::post('/pruebas', [PruebasRapidasController::class, 'pruebaspost'])->name('pruebaspost');
	
	Route::resource("/Item", \App\Http\Controllers\ItemController::class);
	Route::resource("/Oferta", OfertaController::class);
	Route::get("/NuevaOferta/{plantilla}", [OfertaController::class, 'NuevaOferta'])->name('NuevaOferta');
	Route::get("/NuevaOferta2/{id}", [OfertaController::class, 'NuevaOferta2'])->name('NuevaOferta2');
	Route::post("/GuardarNuevaOferta", [OfertaController::class, 'GuardarNuevaOferta'])->name('GuardarNuevaOferta');
	Route::get("/EditOferta/{id}", [OfertaController::class, 'EditOferta'])->name('EditOferta');
	Route::post("/GuardarEditOferta", [OfertaController::class, 'GuardarEditOferta'])->name('GuardarEditOferta');
	
    Route::get('/probando', [ParametrosController::class, 'probando'])->name('probando');
	Route::get('/select/equipos', [OfertaController::class, 'buscarEquipos'])->name('api.select.equipos');
    Route::post('/oferta/destroy-bulk', [OfertaController::class, 'destroyBulk'])->name('oferta.destroy-bulk');
	Route::get('/oferta/pdf/{oferta}', [OfertaController::class, 'pdf'])->name('Oferta.pdf');

	//aquipues

});

// <editor-fold desc="Artisan">
Route::get('/exception', function () {
    throw new Exception('Probando excepciones y enrutamiento. La prueba ha concluido exitosamente.');
});

Route::get('/foo', function () {
    if (file_exists(public_path('storage'))) {
        return 'Ya existe';
    }
    App('files')->link(
        storage_path('App/public'),
        public_path('storage')
    );
    return 'Listo';
});
Route::get('/tmantenimiento', function () {
    echo Artisan::call('down --secret="token-it"');
    return "Aplicación abajo: token-it";
});

Route::get('/test-email', function () {
    try {
        \Illuminate\Support\Facades\Mail::raw('Este es un correo de prueba.', function ($message) {
            $message->to('ajelof2@gmail.com')
                ->subject('Correo de prueba');
        });
        return 'Correo enviado con éxito.';
    } catch (\Exception $e) {
        return 'Error al enviar el correo: ' . $e->getMessage();
    }
});
//</editor-fold>
