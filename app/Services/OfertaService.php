<?php

namespace App\Services;

use App\helpers\EmailHelper;
use App\Models\Item;
use App\Models\Oferta;
use App\helpers\Myhelp;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OfertaService {
	
	public function createOferta(array $dataOferta, array $daItems, array $equipos, array $cantidadesItem) {
		DB::beginTransaction();
		
		try {
			$oferta = Oferta::create(array_merge($dataOferta, [
				'user_id' => Myhelp::AuthUid(),
				'fecha'   => Carbon::now(),
			]));
			
			$this->processItemsAndEquipos($oferta, $daItems, $equipos, $cantidadesItem);
			
			DB::commit();
			
			return $oferta;
		} catch (\Throwable $e) {
			DB::rollBack();
			$this->handleException($e, $dataOferta, $equipos);
		}
	}
	
	private function processItemsAndEquipos(Oferta $oferta, array $daItems, array $equiposData, array $cantidadesItem) {
		$helperOfertaController = new \App\Http\Controllers\HelperOfertaController();
		
		foreach ($equiposData as $indexItem => $itemPlano) {
			if ($itemPlano == null) {
				continue;
			}
			
			$soloItems = $daItems[$indexItem];
			if (!isset($soloItems) || count($soloItems) === 0) {
				throw new \Exception("Nombre del ítem inválido en el ítem " . ($indexItem + 1));
			}
			if(count($itemPlano) === 0 || $cantidadesItem[$indexItem] === 0) {;
				throw new \Exception("Algunas cantidades son cero. En el item " . ($indexItem + 1));
				
			}
			
			$totalItem = 0;

			if (empty($soloItems['nombre'])) {
				throw new \Exception("El nombre del ítem " . ($indexItem + 1) . " no debe estar vacío.");
			}

			$item = Item::create([
				                     'numero'              => $indexItem,
				                     'nombre'              => $soloItems['nombre'],
				                     'descripcion'         => $soloItems['descripcion'] ?? '', // Ensure description is handled
				                     'conteo_items'        => count($itemPlano),
				                     'cantidad'            => $cantidadesItem[$indexItem],
				                     'oferta_id'           => $oferta->id,
				                     'valor_unitario_item' => 0,
				                     'valor_total_item'    => 0,
			                     ]);
			
			foreach ($itemPlano as $indexEquipo => $equipoPlano) {
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
				
				if ($respuesta === - 1) {
					throw new \Exception("El equipo $valorBuscado no se encontro en el ítem " . ($indexItem + 1));
				}
				
				$pivotData = [
					'codigoGuardado'                => $equipoPlano['equipo_selec']['value'] ?? 0,
					'descripcion'                   => $equipoPlano['equipo_selec']['title'] ?? 'No hay descripcion',
					'cantidad_equipos'              => $equipoPlano['cantidad'] ?? 1,
					'consecutivo_equipo'            => $indexEquipo,
					'precio_de_lista'               => $equipoPlano['equipo_selec']['precio_de_lista'] ?? 0,
					'fecha_actualizacion'           => Carbon::now(),
					'descuento_basico'              => $equipoPlano['equipo_selec']['descuento_basico'] ?? 0,
					'descuento_proyectos'           => $equipoPlano['equipo_selec']['descuento_proyectos'] ?? 0,
					'precio_con_descuento'          => 0,
					'precio_con_descuento_proyecto' => 0,
					'precio_ultima_compra'          => 0,
					'descuento_final'               => $equipoPlano['descuento_final'] ?? 1.0,
					'factor'                        => $equipoPlano['factor_final'],
					'nombrefactor'                  => '',
					'costo_unitario'                => $equipoPlano['costounitario'],
					'costo_total'                   => $equipoPlano['costototal'],
					//                    'alerta_mano_obra' => $equipoPlano['equipo_selec']['alerta_mano_obra'],
					'valorunitarioequip'            => $equipoPlano['valorunitario'],
					'subtotalequip'                 => $equipoPlano['subtotalequip'],
				];
				
				$pivotExists = $item->equipos()->wherePivot('equipo_id', $equipo->id)->first();
				if ($pivotExists) {
					$item->equipos()->updateExistingPivot($equipo->id, $pivotData);
				}
				else {
					$item->equipos()->attach($equipo->id, $pivotData);
				}
			}
			
			$item->update([
				              'valor_unitario_item' => $totalItem,
				              'valor_total_item'    => (int)($totalItem * ($cantidadesItem[$indexItem])),
			              ]);
			
			$item->ofertas()->attach($oferta->id);
		}
	}
	
	private function handleException(\Throwable $e, array $dataOferta, array $equipos) {
		$userloged = Myhelp::AuthU();
		if ($e instanceof \Illuminate\Database\QueryException && $e->getCode() == 23000 && str_contains($e->getMessage(), "equipo_item.PRIMARY")) {
			// Specific handling for duplicate entry on equipo_item pivot
			$problematicEquipo = null;
			foreach ($equipos as $itemPlano) {
				if ($itemPlano) {
					foreach ($itemPlano as $equipoPlano) {
						if (isset($equipoPlano['equipo_selec']['value'])) {
							// This is a simplified way to find the problematic equipo. 
							// A more robust solution might involve tracking the exact item/equipo causing the error.
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
		}
		else {
			$errorMessage = $e->getMessage();
			$secondpart = 'Fatal error en la linea ' . $e->getLine() . ' del archivo ' . $e->getFile() . ' -- ' . $errorMessage;
			$errorMail = 'Usuario conectado: ' . $userloged->name . ' - ' . $secondpart;
			if ((app()->environment('local') || app()->environment('test'))) {
				dd($errorMail);
			}else{
				EmailHelper::sendEmailViaJob($errorMail);
			}
			throw new \Exception($errorMessage, 0, $e);
		}
	}//no se que paso con vite 3
	
	public function updateOferta(Oferta $oferta, array $dataOferta, array $daItems, array $equipos, array $cantidadesItem) {
		
		DB::beginTransaction();
		
		try {
			$oferta->update(array_merge($dataOferta, ['fecha'   => Carbon::now() ]));
			
			// Delete existing items and their associated pivot records for this offer
			$oferta->items()->detach();
			$oferta->items()->delete();
			
			$this->processItemsAndEquipos($oferta, $daItems, $equipos, $cantidadesItem);
			
			DB::commit();
			
			return $oferta;
		} catch (\Throwable $e) {
			DB::rollBack();
			$this->handleException($e, $dataOferta, $equipos); // un cambio de ignore
		}
	}
}