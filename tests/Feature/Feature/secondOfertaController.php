<?php

namespace Feature;

use App\Models\Equipo;
use App\Models\Oferta;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

// Importar Carbon
// Asegúrate de importar tu helper Myhelp si lo usas en el test

class secondOfertaController extends TestCase
{
    use RefreshDatabase; // Resetea la base de datos para cada test

    /**
     * Prueba que una nueva oferta, sus ítems y sus relaciones con equipos se guardan correctamente.
     *
     * @return void
     */
    public function CanSaveNewOffer()
{
    // --- 1. ARRANGE (Preparación de datos y entorno) ---
    // 1.1. Preparar usuario
    $this->seed(UserSeeder::class);
    $user = User::find(1);

    $this->assertNotNull($user, 'El usuario con ID 1 no existe después del seeder.');
    $this->assertEquals('superadmin', $user->name, 'El usuario para la prueba no es "superadmin".');
    echo "El usuario para la prueba es: {$user->name}\n";

    // 1.2. Preparar equipos de prueba
    // NOTA: 'costo' ya NO se incluye aquí, ya que no es un atributo del modelo Equipo.
    $equipo1 = Equipo::factory()->create([
        'id'              => 101,
        'codigo'          => 'EQ001',
        'precio_de_lista' => 1000,
    ]);
    $equipo2 = Equipo::factory()->create([
        'id'              => 102,
        'codigo'          => 'EQ002',
        'precio_de_lista' => 500,
    ]);

    // 1.3. Definir los datos de la solicitud
    // Estos datos deben reflejar la estructura exacta que tu controlador espera.
    // Los cálculos para 'costounitario', 'costototal', 'valorunitario', 'subtotalequip'
    // se realizan aquí como se haría en el frontend.
    $cantidad1 = 2; // Cantidad para equipo1
    $descuentoF1 = 0.15; // 15% de descuento final (0.15)
    $factorFinal1 = 1.05;

    $cantidad2 = 3; // Cantidad para equipo2
    $descuentoF2 = 0.0; // 0% de descuento final
    $factorFinal2 = 1.0;

    $requestData = [
        'dataOferta'     => [
            'proyecto'      => 'Proyecto de Prueba Automatizado',
            'codigo_oferta' => 'OFERTA-TEST-001',
            'observaciones' => 'Prueba de integración exitosa',
        ],
        'equipos'        => [ // 'equipos' aquí representa los ítems principales que contienen sub-equipos
            [ // Item 0 (el primer ítem de la oferta)
                [ // Primer sub-equipo dentro del Item 0 (referencia a $equipo1)
                    'nombre_item'           => 'Item Principal 1',
                    'equipo_selec'          => [
                        'value'               => $equipo1->codigo,
                        'precio_de_lista'     => $equipo1->precio_de_lista,
                        'descuento_basico'    => 0.10, // 10%
                        'descuento_proyectos' => 0.05, // 5%
                        'precio_de_lista2'    => $equipo1->precio_de_lista,
                        'alerta_mano_obra'    => false, // Booleano para el test
                    ],
                    'cantidad'              => $cantidad1,
                    'descuento_final'       => $descuentoF1,
                    // Cálculos de costo y valor basados en tu especificación
                    'costounitario'         => $descuentoF1 * $equipo1->precio_de_lista, // 0.15 * 1000 = 150
                    'costototal'            => $cantidad1 * ($descuentoF1) * $equipo1->precio_de_lista, // 2 * 0.15 * 1000 = 300
                    'factor_final'          => $factorFinal1,
                    'valorunitario'         => ($descuentoF1) * $equipo1->precio_de_lista * $factorFinal1, // 0.15 * 1000 * 1.05 = 157.5
                    'subtotalequip'         => $cantidad1 * ($descuentoF1) * $equipo1->precio_de_lista * $factorFinal1, // 2 * 0.15 * 1000 * 1.05 = 315
                ],
                [ // Segundo sub-equipo dentro del Item 0 (referencia a $equipo2)
                    'nombre_item'           => 'Item Principal 1',
                    'equipo_selec'          => [
                        'value'               => $equipo2->codigo,
                        'precio_de_lista'     => $equipo2->precio_de_lista,
                        'descuento_basico'    => 0.0, // 0%
                        'descuento_proyectos' => 0.0, // 0%
                        'precio_de_lista2'    => $equipo2->precio_de_lista,
                        'alerta_mano_obra'    => true, // Booleano para el test
                    ],
                    'cantidad'              => $cantidad2,
                    'descuento_final'       => $descuentoF2,
                    // Cálculos de costo y valor basados en tu especificación
                    'costounitario'         => $descuentoF2 * $equipo2->precio_de_lista, // 0 * 500 = 0
                    'costototal'            => $cantidad2 * ($descuentoF2) * $equipo2->precio_de_lista, // 3 * 0 * 500 = 0
                    'factor_final'          => $factorFinal2,
                    'valorunitario'         => ($descuentoF2) * $equipo2->precio_de_lista * $factorFinal2, // 0 * 500 * 1.0 = 0
                    'subtotalequip'         => $cantidad2 * ($descuentoF2) * $equipo2->precio_de_lista * $factorFinal2, // 3 * 0 * 500 * 1.0 = 0
                ],
            ],
        ],
        'cantidadesItem' => [1], // Cantidad para el "Item Principal 1"
    ];
    echo 'La data enviada tiene como proyecto = ' . $requestData['dataOferta']['proyecto'] . "\n";

    // --- 2. ACT (Ejecución de la acción a probar) ---
    // Simula la autenticación del usuario y envía la solicitud POST
    $response = $this->actingAs($user)->post(route('GuardarNuevaOferta'), $requestData);

    // --- 3. ASSERT (Verificación de resultados) ---

    // 3.1. Verificación de la respuesta HTTP
    $response->assertStatus(302); // Esperamos una redirección
    $response->assertRedirect('/Oferta'); // O la URL exacta a la que esperas ser redirigido
    echo 'Redirigido a: ' . $response->getTargetUrl() . "\n";

    // 3.2. Verificación de la tabla 'ofertas'
    $this->assertDatabaseHas('ofertas', [
        'proyecto'      => $requestData['dataOferta']['proyecto'],
        'codigo_oferta' => $requestData['dataOferta']['codigo_oferta'],
        'user_id'       => $user->id,
        'fecha'         => Carbon::now()->format('Y-m-d H:i:s'), // Verifica la fecha actual si se guarda
    ]);
    echo 'Oferta creada con éxito: ' . $requestData['dataOferta']['codigo_oferta'] . "\n";

    $oferta = Oferta::where('codigo_oferta', $requestData['dataOferta']['codigo_oferta'])->first();
    $this->assertNotNull($oferta, 'La oferta no fue encontrada en la base de datos.');
    echo 'Oferta recuperada: codigo ' . $oferta->codigo_oferta . "\n";

    // 3.3. Llama al método de verificación separado
    $this->VerificacionSave($equipo1, $equipo2, $requestData, $oferta);
}

    /**
     * Prueba que la creación de una oferta falla con un nombre de ítem inválido.
     *
     * @return void
     */
    public function test_cannot_create_offer_with_invalid_item_name()
    {
        $this->seed(UserSeeder::class);
        $user = User::find(1);

        $invalidRequestData = [
            'dataOferta' => [
                'proyecto'      => 'Proyecto Fallido',
                'codigo_oferta' => 'OFERTA-FAIL-001',
                'observaciones' => 'Prueba de fallo por nombre de ítem',
            ],
            'equipos'    => [
                [
                    [
                        'nombre_item'   => '', // Nombre inválido que causa el error
                        'equipo_selec'  => [
                            'value' => 'EQ001',
                            'precio_de_lista' => 1000,
                        ],
                        'cantidad'      => 1,
                        'subtotalequip' => 1000,
                    ],
                ],
            ],
            'cantidadesItem' => [1],
        ];

        $response = $this->actingAs($user)->post(route('GuardarNuevaOferta'), $invalidRequestData);

        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHas('error', 'Nombre del ítem inválido en ítem 1');

        $this->assertDatabaseMissing('ofertas', [
            'codigo_oferta' => 'OFERTA-FAIL-001',
        ]);
        $this->assertDatabaseMissing('items', [
            'nombre' => '',
        ]);
        $this->assertDatabaseCount('items', 0); // No debería haber ítems guardados
    }

    /**
     * Prueba que la creación de una oferta falla si un equipo no se encuentra.
     *
     * @return void
     */
    public function test_cannot_create_offer_if_equipment_not_found()
    {
        $this->seed(UserSeeder::class);
        $user = User::find(1);

        $requestDataWithNonExistentEquipo = [
            'dataOferta' => [
                'proyecto'      => 'Proyecto Fallido Equipo No Encontrado',
                'codigo_oferta' => 'OFERTA-FAIL-002',
                'observaciones' => 'Prueba de fallo por equipo no encontrado',
            ],
            'equipos'    => [
                [
                    [
                        'nombre_item'   => 'Item Válido',
                        'equipo_selec'  => [
                            'value' => 'NONEXISTENT_EQ', // Código de equipo que no existe
                            'precio_de_lista' => 100,
                        ],
                        'cantidad'      => 1,
                        'subtotalequip' => 100,
                    ],
                ],
            ],
            'cantidadesItem' => [1],
        ];

        // Mock del método SearchgetFirst
        // Necesitas mockear SearchgetFirst porque es un método interno del controlador
        // y para el test, quieres controlar su comportamiento.
        $controller = $this->app->make(\App\Http\Controllers\OfertaController::class); // Reemplaza con la ruta real de tu controlador
        $this->instance(\App\Http\Controllers\OfertaController::class, $this->mock(\App\Http\Controllers\OfertaController::class, function ($mock) use ($requestDataWithNonExistentEquipo) {
            $mock->shouldReceive('SearchgetFirst')
                ->once()
                ->with($requestDataWithNonExistentEquipo['equipos'][0][0]['equipo_selec']['value'])
                ->andReturn([-1, $requestDataWithNonExistentEquipo['equipos'][0][0]['equipo_selec']['value'], null]);
        }));

        $response = $this->actingAs($user)->post(route('GuardarNuevaOferta'), $requestDataWithNonExistentEquipo);

        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHas('error', 'El equipo NONEXISTENT_EQ no se encontro en el ítem 1');

        $this->assertDatabaseMissing('ofertas', [
            'codigo_oferta' => 'OFERTA-FAIL-002',
        ]);
        $this->assertDatabaseCount('items', 0);
    }


    /**
     * Método auxiliar para verificar los datos guardados.
     * @param Equipo $equipo1 El primer equipo de prueba.
     * @param Equipo $equipo2 El segundo equipo de prueba.
     * @param array $requestData Los datos de la solicitud enviados al controlador.
     * @param Oferta $oferta La instancia de la oferta guardada.
     */
    public function VerificacionSave(Equipo $equipo1, Equipo $equipo2, array $requestData, Oferta $oferta): void
    {
        // --- 3.3.1. Cálculos de valores esperados para el ITEM principal ---
        // Estos cálculos deben reflejar exactamente cómo se guarda el Item en tu controlador.
        // NOTA: Tu controlador SOLO ACTUALIZA 'valor_unitario_item' y 'valor_total_item' del ITEM principal.
        // Los otros campos (dcto_final, dcto_basico, etc.) en la tabla 'items' (ITEM PRINCIPAL)
        // se establecerán a 0 (o su default de migración) porque no los actualizas explícitamente.
        $totalItemSubtotalEquip = 0;
        foreach ($requestData['equipos'][0] as $equipoPlano) {
            $totalItemSubtotalEquip += $equipoPlano['subtotalequip'];
        }

        $expectedItemValorUnitario = $totalItemSubtotalEquip;
        $expectedItemValorTotal = (int)($expectedItemValorUnitario * $requestData['cantidadesItem'][0]);

        // --- 3.3.2. Verificación de la tabla 'items' ---
        $this->assertDatabaseHas('items', [
            'oferta_id'           => $oferta->id,
            'nombre'              => 'Item Principal 1',
            'numero'              => 0,
            'cantidad'            => $requestData['cantidadesItem'][0],
            'valor_unitario_item' => $expectedItemValorUnitario,
            'valor_total_item'    => $expectedItemValorTotal,
            // Nuevos campos en la tabla `items` - Se esperan en 0 porque el controlador NO los actualiza explícitamente
            'dcto_final'          => 0,
            'dcto_basico'         => 0,
            'dcto_x_proyecto'     => 0,
            'factor'              => 0, // O 1.0 si ese es el default de la migración y no se actualiza
            'costo_unitario'      => 0,
            'costo_total'         => 0,
        ]);

        $item = $oferta->items()->where('numero', 0)->first();
        $this->assertNotNull($item, 'El ítem principal no fue encontrado para la oferta.');

        // --- 3.3.3. Verificación de la tabla pivot 'equipo_item' para el Equipo 101 ---
        $equipoPlano1 = $requestData['equipos'][0][0];

        $this->assertDatabaseHas('equipo_item', [
            'item_id'                       => $item->id,
            'equipo_id'                     => $equipo1->id,
            'codigoGuardado'                => $equipoPlano1['equipo_selec']['value'],
            'cantidad_equipos'              => $equipoPlano1['cantidad'],
            'consecutivo_equipo'            => 0,
            'precio_de_lista'               => $equipoPlano1['equipo_selec']['precio_de_lista'],
            // 'fecha_actualizacion' es Carbon::now(), no se compara directamente a menos que mockees el tiempo
            'descuento_basico'              => $equipoPlano1['equipo_selec']['descuento_basico'],
            'descuento_proyectos'           => $equipoPlano1['equipo_selec']['descuento_proyectos'],
            'precio_con_descuento'          => 0, // Según tu attach en el controlador
            'precio_con_descuento_proyecto' => 0, // Según tu attach en el controlador
            'precio_ultima_compra'          => 0, // Según tu attach en el controlador
            'descuento_final'               => $equipoPlano1['descuento_final'],
            'dcto_basico'                   => $equipoPlano1['equipo_selec']['descuento_basico'],
            'dcto_x_proyecto'               => $equipoPlano1['equipo_selec']['descuento_proyectos'],
            'factor'                        => $equipoPlano1['factor_final'],
            'nombrefactor'                  => '',
            'costo_unitario'                => $equipoPlano1['costounitario'],
            'costo_total'                   => $equipoPlano1['costototal'],
            'precio_de_lista2'              => $equipoPlano1['equipo_selec']['precio_de_lista2'],
            'alerta_mano_obra'              => $equipoPlano1['equipo_selec']['alerta_mano_obra'],
            'valorunitarioequip'            => $equipoPlano1['valorunitario'],
            'subtotalequip'                 => $equipoPlano1['subtotalequip'],
        ]);

        // --- 3.3.4. Verificación de la tabla pivot 'equipo_item' para el Equipo 102 ---
        $equipoPlano2 = $requestData['equipos'][0][1];

        $this->assertDatabaseHas('equipo_item', [
            'item_id'                       => $item->id,
            'equipo_id'                     => $equipo2->id,
            'codigoGuardado'                => $equipoPlano2['equipo_selec']['value'],
            'cantidad_equipos'              => $equipoPlano2['cantidad'],
            'consecutivo_equipo'            => 1,
            'precio_de_lista'               => $equipoPlano2['equipo_selec']['precio_de_lista'],
            'descuento_basico'              => $equipoPlano2['equipo_selec']['descuento_basico'],
            'descuento_proyectos'           => $equipoPlano2['equipo_selec']['descuento_proyectos'],
            'precio_con_descuento'          => 0,
            'precio_con_descuento_proyecto' => 0,
            'precio_ultima_compra'          => 0,
            'descuento_final'               => $equipoPlano2['descuento_final'],
            'dcto_basico'                   => $equipoPlano2['equipo_selec']['descuento_basico'],
            'dcto_x_proyecto'               => $equipoPlano2['equipo_selec']['descuento_proyectos'],
            'factor'                        => $equipoPlano2['factor_final'],
            'nombrefactor'                  => '',
            'costo_unitario'                => $equipoPlano2['costounitario'],
            'costo_total'                   => $equipoPlano2['costototal'],
            'precio_de_lista2'              => $equipoPlano2['equipo_selec']['precio_de_lista2'],
            'alerta_mano_obra'              => $equipoPlano2['equipo_selec']['alerta_mano_obra'],
            'valorunitarioequip'            => $equipoPlano2['valorunitario'],
            'subtotalequip'                 => $equipoPlano2['subtotalequip'],
        ]);
    }
}