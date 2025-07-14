<?php

namespace Tests\Feature\Feature;

use App\Models\Equipo;
use App\Models\Oferta;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Tests\TestCase;

class OfertaControllerTest extends TestCase {
	
	use RefreshDatabase;
	
	/**
	 * A basic feature test example.
	 */
	public function test_example(): void {
		//		dd(['connection' => config('database.default'), 'database'   => config('database.connections.sqlite.database')]);
		$response = $this->get('/');
		
		$response->assertStatus(302);
	}
	
	public function test_required_tables_exist() {
		// Debido a 'use RefreshDatabase;', en este punto, las migraciones ya se han ejecutado.
		// Por lo tanto, podemos verificar la existencia de las tablas.
		
		$this->assertTrue(Schema::hasTable('users'), 'La tabla "users" no existe.');
		$this->assertTrue(Schema::hasTable('equipos'), 'La tabla "equipos" no existe.');
		$this->assertTrue(Schema::hasTable('items'), 'La tabla "items" no existe.');
		$this->assertTrue(Schema::hasTable('ofertas'), 'La tabla "ofertas" no existe.');
		
		// Puedes incluso verificar la existencia de columnas específicas si lo deseas
		$this->assertTrue(Schema::hasColumns('users', [
			'id',
			'name',
			'email'
		]),               'La tabla "users" no tiene las columnas esperadas.');
		$this->assertTrue(Schema::hasColumns('items', [
			'oferta_id',
			'nombre'
		]),               'La tabla "items" no tiene las columnas esperadas.');
		
		$userSuper = !!User::factory()->create(['id' => 1]); // Crea el usuario con ID 1, que es el que simularemos.
		$this->assertTrue($userSuper);
	}
	
	public function test_db_connection_is_sqlite_in_memory() {
		$connection = config('database.default');
		$database = config('database.connections.' . $connection . '.database');
		$this->assertEquals(':memory:', $database);
		
		$this->assertEquals('sqlite', $connection);
	}
	
	/** @test */
	public function savesimlator() {
			// --- 1. ARRANGE (Preparación de datos y entorno) ---
			// 1.1. Preparar usuario
			$this->seed(UserSeeder::class); // Asegúrate de que UserSeeder crea el usuario 'superadmin' con ID 1
			$user = User::find(1);
			
			$this->assertNotNull($user, 'El usuario con ID 1 no existe después del seeder.');
			$this->assertEquals('superadmin', $user->name, 'El usuario para la prueba no es "superadmin".');
			echo "El usuario para la prueba es: {$user->name}\n"; // Mensaje informativo
			
			// 1.2. Preparar equipos de prueba
			$equipo1 = Equipo::factory()->create([
				                                     'id'              => 101,
				                                     'codigo'          => '51105',
				                                     'precio_de_lista' => 334620,
			                                     ]);
			$equipo2 = Equipo::factory()->create([
				                                     'id'              => 102,
				                                     'codigo'          => 'EQ002',
				                                     'precio_de_lista' => 500,
			                                     ]);
			
			// 1.3. Definir los datos de la solicitud
			// Estos datos deben reflejar la estructura exacta que tu controlador espera.
		  	

		$factorFinal = 1.05;
		$descuentoF  = 26.50;
		$cantidad  = 2;
			$requestData = [
				'dataOferta'     => [
					'proyecto'      => 'Proyecto de Prueba Automatizado',
					'codigo_oferta' => 'OFERTA-TEST-001',
					'observaciones' => 'Prueba de integración exitosa',
					// Asegúrate de incluir todos los campos requeridos para 'dataOferta' aquí
				],
				// 'daItems' parece ser un array placeholder, no lo incluimos si no tiene uso directo.
				'equipos' => [ // 'equipos' aquí representa los ítems principales que contienen sub-equipos
					[ // Item 0 (el primer ítem de la oferta)
						[ // Primer sub-equipo dentro del Item 0
							'nombre_item'        => 'Item Principal 1',
							'equipo_selec'       => [
								'value'               => $equipo1->codigo,
								'precio_de_lista'     => $equipo1->precio_de_lista,
								'descuento_basico'    => 26.50,
								'descuento_proyectos' => 30,
								'precio_de_lista2'    => $equipo1->precio_de_lista,
								'alerta_mano_obra'    => '26',
							],
							'cantidad'           => $cantidad,
							
							'descuento_final'    => $descuentoF,
							'costounitario'      => $descuentoF * $equipo1->precio_de_lista,
							'costototal'         => $cantidad * ($descuentoF/100) * $equipo1->precio_de_lista,
							
							'factor_final'       => $factorFinal,
							'valorunitario' => ($descuentoF/100) * $equipo1->precio_de_lista * $factorFinal, // Precio por unidad de este equipo
							'subtotalequip'      => $cantidad * ($descuentoF/100) * $equipo1->precio_de_lista * $factorFinal, //  $1,106,756
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
			$response->assertStatus(302); // Esperamos una redirección exitosa (Created o Found)
//			$response->assertRedirect('/Oferta'); // O la URL exacta a la que esperas ser redirigido
			echo 'Redirigido a: ' . $response->getTargetUrl() . "\n";
			
			// 3.2. Verificación de la tabla 'ofertas'
			$this->assertDatabaseHas('ofertas', [
				'proyecto'      => $requestData['dataOferta']['proyecto'],
				'codigo_oferta' => $requestData['dataOferta']['codigo_oferta'],
				'user_id'       => $user->id,
				// Agrega aquí cualquier otro campo de 'ofertas' que sea crucial verificar
			]);
			echo 'Oferta creada con éxito: ' . $requestData['dataOferta']['codigo_oferta'] . "\n";
			
			// Recupera la oferta recién creada para verificar sus relaciones
			$oferta = Oferta::where('codigo_oferta', $requestData['dataOferta']['codigo_oferta'])->first();
			$this->assertNotNull($oferta, 'La oferta no fue encontrada en la base de datos.');
			echo 'Oferta recuperada,codigo ' . $oferta->codigo_oferta . "\n";
			
			// 3.3. Verificación de la tabla 'items'
		$this->VerificacionSave($equipo1, $equipo2, $requestData, $oferta);
	}
	
	public function it_returns_error_if_item_name_is_null() {
		// --- 1. ARRANGE ---
		$user = User::factory()->create([
			                                'email'    => 'ajelof2+7@gmail.com', // Provide specific data if needed
			                                'password' => bcrypt('password'),
		                                ]);
		
		$requestData = [
			'dataOferta'     => [
				'proyecto'      => 'Proyecto con Ítem Inválido',
				'codigo_oferta' => 'OFERTA-FAIL-001',
			],
			'daItems'        => [],
			'equipos'        => [//items
				[//equipos
					[//equiposelec
						'nombre_item'   => null, // ESTO CAUSARÁ EL ERROR
						'equipo_selec'  => [
							'value'           => 1, // Dummy ID
							'precio_de_lista' => 100,
						],
						'cantidad'      => 1,
						'subtotalequip' => 100,
					],
				],
			],
			'cantidadesItem' => [1],
		];
		
		// --- 2. ACT ---
		$response = $this->actingAs($user)->post(route('GuardarNuevaOferta'), $requestData);
		
		// --- 3. ASSERT ---
		$response->assertStatus(419); // Esperamos redirección por el error
		//		$response->assertSessionHas('error', "Nombre del ítem inválido en ítem 1"); // Verifica el mensaje de error
		
		// Asegúrate de que no se haya creado ninguna oferta en la base de datos
		$this->assertDatabaseMissing('ofertas', [
			'proyecto' => $requestData['dataOferta']['proyecto'],
		]);
	}
	
	/**
	 * esta funcion quedo a medias
     */
    public function VerificacionSave(Equipo $equipo1, Equipo $equipo2, array $requestData, Oferta $oferta): void
    {
        // --- 3.3.1. Cálculos de valores esperados para el ITEM principal ---
        $totalItemSubtotalEquip = 0;
        $totalItemDctoBasico = 0;
        $totalItemDctoProyectos = 0;
        $totalItemCostoUnitario = 0;
        $totalItemCostoTotal = 0;
        $totalItemFactor = 0;
        $equipoCount = 0;

        foreach ($requestData['equipos'][0] as $equipoPlano) {
            if ($equipoPlano['equipo_selec'] == null) {
                continue;
            }
            
            $totalItemSubtotalEquip += $equipoPlano['subtotalequip'];
            
            $dctoBasicoEquipo = $equipoPlano['equipo_selec']['descuento_basico'] ?? 0;
            $dctoProyectosEquipo = $equipoPlano['equipo_selec']['descuento_proyectos'] ?? 0;

            $totalItemDctoBasico += $dctoBasicoEquipo * $equipoPlano['cantidad'] * ($equipoPlano['equipo_selec']['precio_de_lista'] ?? 0);
            $totalItemDctoProyectos += $dctoProyectosEquipo * $equipoPlano['cantidad'] * ($equipoPlano['equipo_selec']['precio_de_lista'] ?? 0);
            
            $totalItemCostoUnitario += $equipoPlano['costounitario'] * $equipoPlano['cantidad']; // Suma del costo unitario * cantidad de cada equipo
            $totalItemCostoTotal += $equipoPlano['costototal']; // Suma del costo total de cada equipo
            $totalItemFactor += $equipoPlano['factor_final'] * $equipoPlano['cantidad']; // Ponderar el factor
            $equipoCount += $equipoPlano['cantidad'];
        }

        $expectedItemValorUnitario = $totalItemSubtotalEquip;
        $expectedItemValorTotal = (int)($expectedItemValorUnitario * $requestData['cantidadesItem'][0]);

        $expectedItemDctoFinal = 0; // O la suma/promedio ponderado que uses
        
        // El factor del item principal podría ser un promedio ponderado
        $expectedItemFactor = ($equipoCount > 0) ? ($totalItemFactor / $equipoCount) : 0;
        

        // --- 3.3.2. Verificación de la tabla 'items' ---
        $this->assertDatabaseHas('items', [
            'oferta_id'           => $oferta->id,
            'nombre'              => 'Item Principal 1',
            'numero'              => 0,
            'cantidad'            => $requestData['cantidadesItem'][0],
            'valor_unitario_item' => $expectedItemValorUnitario,
            'valor_total_item'    => $expectedItemValorTotal,
            // Nuevos campos en la tabla `items` - AJUSTA ESTOS VALORES
            'dcto_final'          => round($expectedItemDctoFinal, 2), // Redondea si tu DB o lógica lo hace
            'dcto_basico'         => round($totalItemDctoBasico, 2),
            'dcto_x_proyecto'     => round($totalItemDctoProyectos, 2),
            'factor'              => round($expectedItemFactor, 4), // Factor con más decimales
            'costo_unitario'      => round($totalItemCostoUnitario, 2),
            'costo_total'         => round($totalItemCostoTotal, 2),
        ]);

        $item = $oferta->items()->where('numero', 0)->first();
        $this->assertNotNull($item, 'El ítem principal no fue encontrado para la oferta.');

        // --- 3.3.3. Verificación de la tabla pivot 'equipo_item' para el Equipo 101 ---
        // Extrae los datos del primer equipo de la solicitud para facilitar la verificación
        $equipoPlano1 = $requestData['equipos'][0][0];

        $this->assertDatabaseHas('equipo_item', [
            'item_id'                       => $item->id,
            'equipo_id'                     => $equipo1->id,
            'cantidad_equipos'              => $equipoPlano1['cantidad'],
            'consecutivo_equipo'            => 0,
            'precio_de_lista'               => $equipo1->precio_de_lista,
            // No verifiques 'fecha_actualizacion' a menos que la hardcodees en el test y controlador
            'descuento_basico'              => $equipoPlano1['equipo_selec']['descuento_basico'],
            'descuento_proyectos'           => $equipoPlano1['equipo_selec']['descuento_proyectos'],
            'precio_con_descuento'          => round($equipo1->precio_de_lista * (1 - $equipoPlano1['equipo_selec']['descuento_basico']), 2),
            'precio_con_descuento_proyecto' => round($equipo1->precio_de_lista * (1 - $equipoPlano1['equipo_selec']['descuento_proyectos']), 2),
            'precio_ultima_compra'          => 0,
            'dcto_final'                    => $equipoPlano1['descuento_final'],
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
        // Extrae los datos del segundo equipo de la solicitud
        $equipoPlano2 = $requestData['equipos'][0][1];

        $this->assertDatabaseHas('equipo_item', [
            'item_id'                       => $item->id,
            'equipo_id'                     => $equipo2->id,
            'cantidad_equipos'              => $equipoPlano2['cantidad'],
            'consecutivo_equipo'            => 1,
            'precio_de_lista'               => $equipo2->precio_de_lista,
            'descuento_basico'              => $equipoPlano2['equipo_selec']['descuento_basico'],
            'descuento_proyectos'           => $equipoPlano2['equipo_selec']['descuento_proyectos'],
            'precio_con_descuento'          => round($equipo2->precio_de_lista * (1 - $equipoPlano2['equipo_selec']['descuento_basico']), 2),
            'precio_con_descuento_proyecto' => round($equipo2->precio_de_lista * (1 - $equipoPlano2['equipo_selec']['descuento_proyectos']), 2),
            'precio_ultima_compra'          => 0,
            'dcto_final'                    => $equipoPlano2['descuento_final'],
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
	
	protected function setUp(): void {
		parent::setUp();
		
		$this->artisan('migrate'); // corre migraciones
		$this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
		
		// --------------------------------------------------------------------
		// MOQUEO DE DEPENDENCIAS EXTERNAS O ESTÁTICAS
		// --------------------------------------------------------------------
		// Tu función usa 'Myhelp::EscribirEnLog' y 'Myhelp::AuthUid()'.
		// Queremos simular su comportamiento para que no realicen acciones reales
		// durante los tests (como escribir en un archivo de log o depender de una sesión real).
		
		// Mock para Myhelp::EscribirEnLog()
		// `alias:` es necesario para mockear métodos estáticos
		//		Mockery::mock('alias:App\Helpers\Myhelp') // Asegúrate de que la ruta a Myhelp sea correcta
		//		       ->shouldReceive('EscribirEnLog')
		// No se espera un valor de retorno, o puedes poner ->andReturn(null);
		//			   ->andReturn(null)
		//		; // Simula que no hace nada o devuelve nulo
		
		// Mock para Myhelp::AuthUid()
		// Este método devuelve el ID del usuario autenticado.
		// Aquí simulamos que siempre devuelve '1' (el ID de un usuario que crearemos).
		//		Mockery::mock('alias:App\Helpers\Myhelp')->shouldReceive('AuthUid')->andReturn(1); // Simula que el usuario autenticado tiene ID 1
	}
	
	protected function tearDown(): void {
		Mockery::close(); // Importante para liberar los mocks
		parent::tearDown();
	}
	
	// --- ESCENARIOS ADICIONALES PARA PROBAR ---
	// 1. Validación de 'dataOferta' y 'daItems' (campos requeridos)
	//    public function it_fails_with_missing_required_data(): void { ... }
	
	// 2. Cuando 'equipo_selec' es nulo o inválido
	//    public function it_fails_if_equipo_selec_is_null_or_invalid(): void { ... }
	
	// 3. Cuando SearchgetFirst() no encuentra el equipo
	//    public function it_fails_if_equipo_not_found(): void { ... }
	//    (Para esto necesitarías mockear SearchgetFirst() específicamente para devolver el fallo)
	
	// 4. Prueba de la excepción QueryException (equipo repetido)
	//    public function it_handles_duplicate_equipo_exception(): void { ... }
	
	// 5. Prueba de la excepción \Throwable (error genérico)
	//    public function it_handles_general_exceptions(): void { ... }
	
	// 6. Pruebas de actualización de cantidad_equipos en el pivote si ya existe
	//    public function it_updates_existing_pivot_quantity(): void { ... }
	
}
