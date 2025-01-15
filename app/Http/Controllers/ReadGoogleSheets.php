<?php

namespace App\Http\Controllers;

use App\helpers\Myhelp;
use App\Models\GuardarGoogleSheetsComercial;
use App\Models\Ordentrabajo;
use App\Models\Reporte;
use App\Models\Role;
use Carbon\Carbon;
use Google\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Revolution\Google\Sheets\Sheets;

class ReadGoogleSheets extends Controller {

    public function mochar2(){return 'ejemplo basico';}

    public function mochar(){
        $hoyHora = Carbon::now();
        $reportesActivos = Reporte::whereNull('hora_final')
            // ->whereDate('fecha', $hoyHora)
            ->get();
        //dd($reportesActivos);

        if ($reportesActivos && $reportesActivos->count() > 0) {
            foreach ($reportesActivos as $index => $reportesActivo) {
                $reportesActivo->horFinalNoValidacion($hoyHora);
            }
        }
        return '
            <h1>Reportes actualizados</h1><p>Todos incluidos. y ahora con nuevas columnas</p>
            ';
    }

    public function OnlyViewNecesitaActualizaF() {
        if(GuardarGoogleSheetsComercial::exists()){
            $ultimo = GuardarGoogleSheetsComercial::OrderByDesc('updated_at')->first();
            $ultimaGuardada = Carbon::parse($ultimo->updated_at);

            if($ultimaGuardada === null){
                return true;
            }
            $difHoras = Carbon::now()->diffInHours($ultimaGuardada);
            dd('Diferencia de horas: '.$difHoras,
                'ultima hora guardada de horas: ',$ultimaGuardada);
        }
        dd('No existe google ni un solo registro');
    }

    public function NecesitaActualizaF() {
        if(GuardarGoogleSheetsComercial::exists()){
            $ultimo = GuardarGoogleSheetsComercial::OrderByDesc('updated_at')->first();
            $ultimaGuardada = Carbon::parse($ultimo->updated_at);

            if($ultimaGuardada === null){
                return true;
            }
            $difHoras = Carbon::now()->diffInHours($ultimaGuardada);
            return $difHoras >= 9;
        }
        return true;
    }

    private function consultaPrevia($service,$spreadsheetId, $sheetName){

        $allValues = $service->spreadsheet($spreadsheetId)->sheet($sheetName)->all();
        $endRow = count($allValues);
        //TODO: URGENT - insertar en la tabla parametros
        return $endRow + 212; //que tantos registros se hacen diarios?
    }

    public function vamoABusca() {
        ini_set('max_execution_time', 220);// 3:40 mins

        $spreadsheetId = '1j_eDVGjHHVjPlnsQxQBGdyQUH0CXj9HMnSNqp0tZRYU'; $sheetName = 'Comercial';
        $service = new Sheets(new Client());
//        $endRow = $this->consultaPrevia($service,$spreadsheetId, $sheetName);
        $endRow = 6000;
//        $range = 'AI1:AV'.$endRow;//asi se leian los datos antes del 23 julio 2024
        $range = 'AL1:AY'.$endRow;
//        $range = 'AL1:AY'.$endRow;
        $values = $service->spreadsheet($spreadsheetId)->sheet($sheetName)->range($range)->all();

        $cabeza =  $values[0];
        unset($values[0]);
        return [$cabeza,$values];
    }

    public function validarItemsNuevos($valuesGoogle,$Grupo) {

        $queryUltimo = GuardarGoogleSheetsComercial::latest();
        if($queryUltimo->get()->isEmpty()) return 1;

        $ultimoGrupo = $queryUltimo->first()->Grupo;
        $ValuesUltimoGrupo = GuardarGoogleSheetsComercial::Where('Grupo',$ultimoGrupo)->pluck('Item')->count();
        // VALIDACION 1 : NUMERO DE ITEMS


        if($ValuesUltimoGrupo == count($valuesGoogle)) return 1; //todo: debe actualizar en caso que sea la misma cantidad
        //todo: validar con carlos, si es posible solo recuperar las que no tengan el 100%
        return 1;
    }


    public function vamoAGuardaComercial($cabezaYvalues,$Grupo) {
        // $numberPermissions = Myhelp::getPermissionToNumber(auth()->user()->roles->pluck('name')[0]);

        $HayTiemposEstimados = 0;
        $contador_Item_vue = 0; //! carefull with changing a counting
        $hayQueGuardar = $this->validarItemsNuevos($cabezaYvalues,$Grupo);
        if($hayQueGuardar){

            $valueCabeza = $cabezaYvalues[0];
            $GoogleComercial = new GuardarGoogleSheetsComercial();
            $Eloquentvalues[0] = $GoogleComercial =(
                //            $Eloquentvalues[0] = GuardarGoogleSheetsComercial::updateOrCreate(
                //            ['Item' => $valueCabeza[1] ?? ''][
                ['Item' => $valueCabeza[1] ?? '',

                'HayTiemposEstimados' => 2, //0 no hay tiempos | 1 hay almenos 0,0 | 2 es la cabeza
                'Item_vue' => -1,
                'Grupo' => $Grupo,
                'user_id' => auth()->user()->id,
                'Nombre_tablero' => $valueCabeza[0] ?? '',
                'avance' => $valueCabeza[2] ?? '',
                'Tiempo_estimado_Ing_mec' => $valueCabeza[3] ?? '',
                'Tiempo_estimado_Ing_elec' => $valueCabeza[4] ?? '',
                'Tiempo_estimado_corte' => $valueCabeza[5] ?? '',
                'Tiempo_estimado_doblez' => $valueCabeza[6] ?? '',
                'Tiempo_estimado_soldadura' => $valueCabeza[7] ?? '',
                'Tiempo_estimado_pulida' => $valueCabeza[8] ?? '',
                'Tiempo_estimado_ensamble' => $valueCabeza[9] ?? '',
                'Tiempo_estimado_cableado' => $valueCabeza[10] ?? '',
                'Tiempo_estimado_cobre' => $valueCabeza[11] ?? '',
                'fecha_inicio_fabricacion' => $valueCabeza[12] ?? '', //newchange12
                'fecha_terminacion_fabricacion' => $valueCabeza[13] ?? '', //19jun2024

            ]);

            $superString = $valueCabeza[3] ?? ''
                .'-'.($valueCabeza[4] ?? '')
                .'-'.($valueCabeza[5] ?? '')
                .'-'.($valueCabeza[6] ?? '')
                .'-'.($valueCabeza[7] ?? '')
                .'-'.($valueCabeza[8] ?? '')
                .'-'.($valueCabeza[9] ?? '')
                .'-'.($valueCabeza[10] ?? '')
                .'-'.($valueCabeza[11] ?? '')
                .'-'.($valueCabeza[12] ?? '')
                .'-'.($valueCabeza[13] ?? '')
                .'-'.($valueCabeza[13] ?? '')
            ;

            Ordentrabajo::create([
                'codigo' => $Grupo,
                'nombre' => $superString
            ]);

            foreach ($cabezaYvalues[1] as $value) {
                if(
                    (isset($value[3])  && strcasecmp($value[3], '') !== 0) ||
                    (isset($value[4])  && strcasecmp($value[4], '') !== 0) ||
                    (isset($value[5])  && strcasecmp($value[5], '') !== 0) ||
                    (isset($value[6])  && strcasecmp($value[6], '') !== 0) ||
                    (isset($value[7])  && strcasecmp($value[7], '') !== 0) ||
                    (isset($value[8])  && strcasecmp($value[8], '') !== 0) ||
                    (isset($value[9])  && strcasecmp($value[9], '') !== 0) ||
                    (isset($value[10]) && strcasecmp($value[10], '') !== 0) ||
                    (isset($value[11]) && strcasecmp($value[11], '') !== 0) ||
                    (isset($value[12]) && strcasecmp($value[12], '') !== 0) ||
                    (isset($value[13]) && strcasecmp($value[13], '') !== 0)
                ){
                    $HayTiemposEstimados = 1;
                }
                if(isset($value[1]) && $value[1] === 'OT+Item') continue; //5dic2023

                $fechaInicioFabricacion = $value[12] ?? '';
                $fechaFinFabricacion = $value[13] ?? '';
                if($fechaInicioFabricacion !== ''){
                    $valida = Myhelp::validateDate($value[12]);
                    if(!$valida){
                        $fechaInicioFabricacion = 'fecha invalida';
                    }
                }//newchange12

                GuardarGoogleSheetsComercial::updateOrCreate(
                    [
                        'Item' => $value[1] ?? '',
                    ],
                    [
                        'Nombre_tablero' => $value[0] ?? '',
                        'Item_vue' => $contador_Item_vue,
                        'HayTiemposEstimados' => $HayTiemposEstimados,
                        'Grupo' => $Grupo,
                        'user_id' => auth()->user()->id,
                        'Item' => $value[1] ?? '',
                        'avance' => $value[2] ?? '',
                        'Tiempo_estimado_Ing_mec' => $value[3] ?? '',
                        'Tiempo_estimado_Ing_elec' => $value[4] ?? '',
                        'Tiempo_estimado_corte' => $value[5] ?? '',
                        'Tiempo_estimado_doblez' => $value[6] ?? '',
                        'Tiempo_estimado_soldadura' => $value[7] ?? '',
                        'Tiempo_estimado_pulida' => $value[8] ?? '',
                        'Tiempo_estimado_ensamble' => $value[9] ?? '',
                        'Tiempo_estimado_cableado' => $value[10] ?? '',
                        'Tiempo_estimado_cobre' => $value[11] ?? '',
                        'fecha_inicio_fabricacion' => $fechaInicioFabricacion, //newchange12
                        'fecha_terminacion_fabricacion' => $fechaFinFabricacion, //newchange12
                    ]);
                $contador_Item_vue++;
            }
            $Eloquentvalues[1] = GuardarGoogleSheetsComercial::Where('Grupo',$Grupo)->get();
        }
        return $Eloquentvalues;
    }

    public function Ultimo($Grupo) {
        if(GuardarGoogleSheetsComercial::exists()) {

            $values = GuardarGoogleSheetsComercial::Where('Grupo', $Grupo)->get();
            $BuscarXDias = 1;
            while(!isset($values[0]) || $values->count() === 1 || $BuscarXDias > 5){
                $Grupo = date('Y-m-d',strtotime("-$BuscarXDias days"));
                $values = GuardarGoogleSheetsComercial::Where('Grupo', $Grupo)->get();
                $BuscarXDias++;
            }

            $cabeza =  $values[0];
            unset($values[0]);
            return [$cabeza,$values];
        }
        return null;
    }


    // # main function
    public function GetValuesFromSheets() {
        $Grupo = date('Y-m-d');
        $NecesitaActualizar = $this->NecesitaActualizaF();
        // $NecesitaActualizar = true;
        if($NecesitaActualizar){
            $cabezaYvalues = $this->vamoABusca();
            $cabezaYvalues = $this->vamoAGuardaComercial($cabezaYvalues,$Grupo);

        }else{
            $cabezaYvalues = $this->Ultimo($Grupo);
        }
        return $cabezaYvalues;
    }



    public function ActualizaGoogleManual(Request $request) {
        $cabezaYvalues = $this->vamoABusca();
        $cabezaYvalues = $this->vamoAGuardaComercial($cabezaYvalues,date('Y-m-d'));
        dd(
            $cabezaYvalues[0] ?? '',
            $cabezaYvalues[1] ?? '',
            $cabezaYvalues[2] ?? '',
            $cabezaYvalues[3] ?? '',
            $cabezaYvalues[4] ?? '',
        );
    }
    public function __invoke(Request $request) {
         Myhelp::EscribirEnLog($this, ' Invocando a ReadGoogle ');
        // $numberPermissions = Myhelp::getPermissionToNumber($permissions);
        // $spreadsheetId = '1EZkfkdQIMoiLewYhG8Qaw2JCc_jqnb_4_pOB75jJAT4'; $sheetName = 'Hoja 1'; //zilef
        [$cabeza,$values] = $this->GetValuesFromSheets();

        $total_cantidad = 0;
        foreach ($values as $value) {
            $total_cantidad += (int)($value[2]); //%avance
        }

        $total_cantidad = ''.$total_cantidad.' / '.$total_cantidad/count($values);

        return Inertia::render('sheet1/Index', [
            'breadcrumbs'             => [['label' => __('app.label.sheet'), 'href' => '/gsheet']],
            'title'                   => __('app.label.user'),
            'cabeza'                  => $cabeza,
            'valores'                  => $values,
            'total_cantidad'                  => $total_cantidad,
        ]);
    }
}
