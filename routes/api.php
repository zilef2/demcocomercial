<?php

use App\Http\Controllers\ActividadsController;
use App\Http\Controllers\CentrotrabajosController;
use App\Http\Controllers\DisponibilidadsController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('reporte', [ReportesController::class, 'indexApi']);
    Route::get('user', [UserController::class, 'indexApi']);
    Route::get('actividad', [ActividadsController::class, 'indexApi']);
    Route::get('centrotrabajo', [CentrotrabajosController::class, 'indexApi']);
    Route::get('disponibilidad', [DisponibilidadsController::class, 'indexApi']);
    Route::get('acti_centro', [CentrotrabajosController::class, 'RelacionActiCentroApi']);
//         ->withoutMiddleware('auth:sanctum')
	;
})->middleware('throttle:6,1');
// 6 requests per minute
