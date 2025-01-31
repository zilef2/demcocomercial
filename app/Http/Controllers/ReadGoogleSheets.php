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

class ReadGoogleSheets extends Controller
{


    // ordenzilef = 1
    // (2 caminos posibles a y b)
    public function GetValuesFromSheets()
    {
        $Grupo = date('Y-m-d');
        $NecesitaActualizar = $this->NecesitaActualizaF(); //oz = 2
        // $NecesitaActualizar = true;
        if ($NecesitaActualizar) {
            $cabezaYvalues = $this->vamoABusca(); //oz = 3
            $cabezaYvalues = $this->vamoAGuardaComercial($cabezaYvalues, $Grupo); // oz = 4

        } else {
            $cabezaYvalues = $this->Ultimo($Grupo); //oz = b1
        }
        return $cabezaYvalues;
    }

    //orden_zilef = 2
    public function NecesitaActualizaF()
    {
        if (GuardarGoogleSheetsComercial::exists()) {
            $ultimo = GuardarGoogleSheetsComercial::OrderByDesc('updated_at')->first();
            $ultimaGuardada = Carbon::parse($ultimo->updated_at);

            if ($ultimaGuardada === null) {
                return true;
            }
            $difHoras = Carbon::now()->diffInHours($ultimaGuardada);
            return $difHoras >= 9;
        }
        return true;
    }


    //ordenzilef = independiente
    public function mochar2()
    {
        return 'ejemplo basico';
    }

    //ordenzilef = independiente
    public function mochar()
    {
        $hoyHora = Carbon::now();
        $reportesActivos = Reporte::whereNull('hora_final')
            // ->whereDate('fecha', $hoyHora)
            ->get();

        if ($reportesActivos && $reportesActivos->count() > 0) {
            foreach ($reportesActivos as $index => $reportesActivo) {
                $reportesActivo->horFinalNoValidacion($hoyHora);
            }
        }
        return '
            <h1>Reportes actualizados</h1><p>Todos incluidos. y ahora con nuevas columnas</p>
            ';
    }


    //ordenzilef = ?
    public function OnlyViewNecesitaActualizaF()
    {
        if (GuardarGoogleSheetsComercial::exists()) {
            $ultimo = GuardarGoogleSheetsComercial::OrderByDesc('updated_at')->first();
            $ultimaGuardada = Carbon::parse($ultimo->updated_at);

            if ($ultimaGuardada === null) {
                return true;
            }
            $difHoras = Carbon::now()->diffInHours($ultimaGuardada);
            dd('Diferencia de horas: ' . $difHoras,
                'ultima hora guardada de horas: ', $ultimaGuardada);
        }
        dd('No existe google ni un solo registro');
    }


    private function consultaPrevia($service, $spreadsheetId, $sheetName): int
    {

        $allValues = $service->spreadsheet($spreadsheetId)->sheet($sheetName)->all();
        $endRow = count($allValues);
        //TODO: URGENT - insertar en la tabla parametros
        return $endRow + 212; //que tantos registros se hacen diarios?
    }

    //ordenzilef = 3
    public function vamoABusca(): array
    {
        ini_set('max_execution_time', 220);// 3:40 mins
        $spreadsheetId = '138UtKtvq4ksEufoxHKNQUy20qHxEn5XTIBXzY5wzUJk';
        $sheetName = 'Hoja1';
        $client = new Client();
//        https://docs.google.com/spreadsheets/d/138UtKtvq4ksEufoxHKNQUy20qHxEn5XTIBXzY5wzUJk/edit?gid=0#gid=0
        $service = new Sheets($client);
        $client->setAuthConfig(storage_path('app/client.json'));
//        $endRow = $this->consultaPrevia($service,$spreadsheetId, $sheetName);
        $endRow = 6;
        $range = 'A1:D' . $endRow;
        $values = $service->spreadsheet($spreadsheetId)->sheet($sheetName)->range($range)->all();

        $cabeza = $values[0];
        unset($values[0]);
        return [$cabeza, $values];
    }

    //ordenzilef = 4.1
    public function validarItemsNuevos($valuesGoogle, $Grupo): int
    {

        $queryUltimo = GuardarGoogleSheetsComercial::latest();
        if ($queryUltimo->get()->isEmpty()) return 1;

        $ultimoGrupo = $queryUltimo->first()->Grupo;
        $ValuesUltimoGrupo = GuardarGoogleSheetsComercial::Where('Grupo', $ultimoGrupo)->pluck('numero_oferta')->count();
        // VALIDACION 1 : NUMERO DE ITEMS


        if ($ValuesUltimoGrupo == count($valuesGoogle)) return 1; //todo: debe actualizar en caso que sea la misma cantidad
        //todo: validar con carlos, si es posible solo recuperar las que no tengan el 100%
        return 1;
    }

    //ordenzilef = 4
    public function vamoAGuardaComercial($cabezaYvalues, $Grupo): array
    {
        // $numberPermissions = Myhelp::getPermissionToNumber(auth()->user()->roles->pluck('name')[0]);

        $HayTiemposEstimados = 0;
        $authid = Myhelp::AuthUid();
        $hayQueGuardar = $this->validarItemsNuevos($cabezaYvalues, $Grupo);
        $Eloquentvalues = [];

        if ($hayQueGuardar) {

            $valueCabeza = $cabezaYvalues[0];
            $GoogleComercial = new GuardarGoogleSheetsComercial();
            $Eloquentvalues[0] = $GoogleComercial = (
            [
                'numero_oferta' => $valueCabeza[0] ?? '',
                'cliente' => $valueCabeza[1] ?? '',
                'avance' => $valueCabeza[2] ?? '',
                'tiempo_estimado' => $valueCabeza[3] ?? '',
                'HayTiemposEstimados' => $HayTiemposEstimados,
                'Grupo' => $Grupo,
                'user_id' => $authid,
            ]);

            $superString = $valueCabeza[0] ?? '' .    
                $valueCabeza[1] ?? '' .    
                $valueCabeza[2] ?? '' .    
                $valueCabeza[3] ?? ''     
                ; //deberia ser lo unico de cada fila
            
            Ordentrabajo::create([
                'codigo' => $Grupo,
                'nombre' => $superString
            ]);

            foreach ($cabezaYvalues[1] as $value) {
                $HayTiemposEstimados = 0;
                if ((isset($value[3]) && strcasecmp($value[3], '') !== 0)) {
                    $HayTiemposEstimados = 1;
                }
                $PrimeraFilaDebeDecir = 'TIEMPO ESTIMADO';
                if (isset($value[1]) && $value[3] === $PrimeraFilaDebeDecir) continue; //5dic2023

                GuardarGoogleSheetsComercial::updateOrCreate(
                    ['numero_oferta' => $value[0] ?? '',],
                    [
                        'numero_oferta' => $value[0] ?? '',
                        'cliente' => $value[1] ?? '',
                        'avance' => $value[2] ?? '',
                        'tiempo_estimado' => $value[3] ?? '',
                        'HayTiemposEstimados' => $HayTiemposEstimados,
                        'Grupo' => $Grupo,
                        'user_id' => $authid,
//                        'fecha_inicio_fabricacion' => $fechaInicioFabricacion,
//                        'fecha_terminacion_fabricacion' => $fechaFinFabricacion,
                    ]);
            }
            $Eloquentvalues[1] = GuardarGoogleSheetsComercial::Where('Grupo', $Grupo)->get();
        }
        return $Eloquentvalues;
    }

    //ordenzilef = b1
    public function Ultimo($Grupo): ?array
    {
        if (GuardarGoogleSheetsComercial::exists()) {

            $values = GuardarGoogleSheetsComercial::Where('Grupo', $Grupo)->get();
            $BuscarXDias = 1;
            while (!isset($values[0]) || $values->count() === 1 || $BuscarXDias > 5) {
                $Grupo = date('Y-m-d', strtotime("-$BuscarXDias days"));
                $values = GuardarGoogleSheetsComercial::Where('Grupo', $Grupo)->get();
                $BuscarXDias++;
            }

//            $cabeza = $values[0];
//            unset($values[0]);
            return [$values[0], $values];
        }
        return null;
    }


    public function ActualizaGoogleManual(Request $request): void
    {
        $cabezaYvalues = $this->vamoABusca();
        $cabezaYvalues = $this->vamoAGuardaComercial($cabezaYvalues, date('Y-m-d'));
        // Encabezado HTML
        $html = "<!DOCTYPE html><html><head><title>Vista Rápida</title></head><body>";
        // Mostrar los valores
            $html .= "<h3>" . implode($cabezaYvalues[0]) . "</h1>";
        foreach ($cabezaYvalues[1] as $value) {
            $html .= "<p> " . implode(" == ", $value->getAttributes()) . " - </p>";
        }
        // Cierre HTML
        $html .= "</body></html>";
        // Enviar la respuesta HTML
        echo $html;
    }


    public function __invoke(Request $request)
    {
        Myhelp::EscribirEnLog($this, ' Invocando a ReadGoogle ');
        // $numberPermissions = Myhelp::getPermissionToNumber($permissions);
        // $spreadsheetId = '1EZkfkdQIMoiLewYhG8Qaw2JCc_jqnb_4_pOB75jJAT4'; $sheetName = 'Hoja 1'; //zilef
        [$cabeza, $values] = $this->GetValuesFromSheets();

        $total_cantidad = 0;
        foreach ($values as $value) {
            $total_cantidad += (int)($value[2]); //%avance
        }

        $total_cantidad = '' . $total_cantidad . ' / ' . $total_cantidad / count($values);

        return Inertia::render('sheet1/Index', [
            'breadcrumbs' => [['label' => __('app.label.sheet'), 'href' => '/gsheet']],
            'title' => __('app.label.user'),
            'cabeza' => $cabeza,
            'valores' => $values,
            'total_cantidad' => $total_cantidad,
        ]);
    }
}
