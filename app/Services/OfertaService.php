<?php

namespace App\Services;

use App\helpers\EmailHelper;
use App\Models\Item;
use App\Models\Oferta;
use App\helpers\Myhelp;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OfertaService {

    public function createOferta(array $dataOferta, array $items) {
        DB::beginTransaction();

        try {
            $oferta = Oferta::create(array_merge($dataOferta, [
                'user_id' => Myhelp::AuthUid(),
                'fecha'   => Carbon::now(),
            ]));

            $this->processItemsAndEquipos($oferta, $items);

            DB::commit();

            return $oferta;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->handleException($e, $dataOferta, $items);
        }
    }

    private function processItemsAndEquipos(Oferta $oferta, array $items) {
        $helperOfertaController = new \App\Http\Controllers\HelperOfertaController();

        foreach ($items as $indexItem => $itemData) {//todo: guardar el ultra_valor_total
            if ($itemData == null) {
                continue;
            }
			

            if (!isset($itemData['nombre']) || $itemData['nombre'] === '') {
                throw new \Exception("El nombre del ítem no puede estar vacío en el ítem " . ($indexItem + 1));
            }
            if(empty($itemData['equipos']) || $itemData['cantidad'] === 0) {
                throw new \Exception("El item " . ($indexItem + 1) . " no tiene equipos o su cantidad es cero.");
            }

            $totalItem = 0;
			
            $item = Item::create([
                'numero'              => $indexItem,
                'nombre'              => $itemData['nombre'],
                'descripcion'         => $itemData['descripcion'] ?? '',
                'conteo_items'        => count($itemData['equipos']),
                'cantidad'            => $itemData['cantidad'],
                'oferta_id'           => $oferta->id,
                'valor_unitario_item' => 0, // Se actualiza después
                'valor_total_item'    => 0, // Se actualiza después
            ]);

            foreach ($itemData['equipos'] as $indexEquipo => $equipoPlano) {
				
				if (!isset($equipoPlano['factor_final'])) {
                    DB::rollBack();
                    $errorMessage = 'Hay un equipo sin factor, Codigo: ' . ($equipoPlano['equipo_selec']['value'] ?? 'N/A');
                    throw new \Exception($errorMessage, 0, null);
                }

                if ($equipoPlano['equipo_selec'] == null) {
                    continue;
                }

                $totalItem += $equipoPlano['subtotalequip'];
                list($respuesta, $valorBuscado, $equipo) = $helperOfertaController->SearchgetFirst($equipoPlano['equipo_selec']['value']);

                if ($respuesta === -1) {
                    throw new \Exception("El equipo $valorBuscado no se encontro en el ítem " . ($indexItem + 1));
                }

				if(!isset($equipoPlano['equipo_selec']['title']))dd(
				    $equipoPlano['equipo_selec']
				);
				$equipoPlano['equipo_selec']['title'] = preg_replace('/^\d+\s*-\s*/', '', $equipoPlano['equipo_selec']['title']);
				
                $pivotData = [
                    'codigoGuardado'                => $equipoPlano['equipo_selec']['value'],
                    'descripcion'                   => $equipoPlano['equipo_selec']['title'] ?? 'No hay descripcion',
                    'cantidad_equipos'              => $equipoPlano['cantidad'],
                    'consecutivo_equipo'            => $indexEquipo,
                    'precio_de_lista'               => $equipoPlano['equipo_selec']['precio_de_lista'],
                    'fecha_actualizacion'           => Carbon::now(),
                    'descuento_basico'              => $equipoPlano['equipo_selec']['descuento_basico'],
                    'descuento_proyectos'           => $equipoPlano['equipo_selec']['descuento_proyectos'],
//                    'precio_con_descuento'          => 0,
//                    'precio_con_descuento_proyecto' => 0,
//                    'precio_ultima_compra'          => 0,
                    'descuento_final'               => $equipoPlano['descuento_final'],
                    'factor'                        => $equipoPlano['factor_final'],
                    'nombrefactor'                  => '',
                    'costo_unitario'                => $equipoPlano['costounitario'],
                    'costo_total'                   => $equipoPlano['costototal'],
                    'valorunitarioequip'            => $equipoPlano['valorunitario'],
                    'subtotalequip'                 => $equipoPlano['subtotalequip'],
                ];

                $pivotExists = $item->equipos()->wherePivot('equipo_id', $equipo->id)->first();
                if ($pivotExists) {
                    $item->equipos()->updateExistingPivot($equipo->id, $pivotData);
                } else {
                    $item->equipos()->attach($equipo->id, $pivotData);
                }
            }

            $item->update([
                'valor_unitario_item' => $totalItem,
                'valor_total_item'    => (int)($totalItem * $itemData['cantidad']),
            ]);

            $item->ofertas()->attach($oferta->id);
        }
    }

    private function handleException(\Throwable $e, array $dataOferta, array $items) {
        $userloged = Myhelp::AuthU();
        if ($e instanceof \Illuminate\Database\QueryException && $e->getCode() == 23000 && str_contains($e->getMessage(), "equipo_item.PRIMARY")) {
            $problematicEquipo = null;
            foreach ($items as $itemData) {
                if ($itemData && !empty($itemData['equipos'])) {
                    foreach ($itemData['equipos'] as $equipoPlano) {
                        if (isset($equipoPlano['equipo_selec']['value'])) {
                            $problematicEquipo = $equipoPlano['equipo_selec']['value'];
                            break 2;
                        }
                    }
                }
            }
            $errorMessage = 'Hay un equipo repetido. Código del equipo: ' . ($problematicEquipo ?? 'desconocido');
            $errorMail = 'Usuario conectado: ' . $userloged->name . ' - ' . $errorMessage;
            EmailHelper::sendEmailViaJob('Error de duplicado en equipo_item: ' . $e->getMessage() . ' - ' . $errorMail);
            throw new \Exception($errorMessage, 0, $e);
        } else {
            $errorMessage = $e->getMessage();
            $secondpart = 'Fatal error en la linea ' . $e->getLine() . ' del archivo ' . $e->getFile() . ' -- ' . $errorMessage;
            $errorMail = 'Usuario conectado: ' . $userloged->name . ' - ' . $secondpart;
            if ((app()->environment('local') || app()->environment('test'))) {
                dd($errorMail);
            } else {
                EmailHelper::sendEmailViaJob($errorMail);
            }
            throw new \Exception($errorMessage, 0, $e);
        }
    }

    public function updateOferta(Oferta $oferta, array $dataOferta, array $items) {
        DB::beginTransaction();
		
        try {
            $oferta->update(array_merge($dataOferta, ['fecha' => Carbon::now()]));

            // Eliminar items viejos para reemplazarlos con los nuevos
            foreach ($oferta->items as $item) {
                $item->equipos()->detach();
                $item->delete();
            }

            $this->processItemsAndEquipos($oferta, $items);

            DB::commit();

            return $oferta;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->handleException($e, $dataOferta, $items);
        }
    }
}
