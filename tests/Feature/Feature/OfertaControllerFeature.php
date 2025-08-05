<?php

namespace Tests\Feature\Feature;

use App\Models\Equipo;
use App\Models\Oferta;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Tests\TestCase;

class OfertaControllerFeature extends TestCase {
	
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
	public function savesimlator_nice() {
		// --- 1. ARRANGE (Preparación de datos y entorno) ---
		// 1.1. Preparar usuario
		$this->seed(UserSeeder::class); // Asegúrate de que UserSeeder crea el usuario 'superadmin' con ID 1
		$user = User::find(1);
		
		$this->assertNotNull($user, 'El usuario con ID 1 no existe después del seeder.');
		$this->assertEquals('superadmin', $user->name, 'El usuario para la prueba no es "superadmin".');
		echo "0 -- El usuario para la prueba es: {$user->name}\n"; // Mensaje informativo
		
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
		$descuentoF = 26.50;
		$cantidad = 2;
		$requestData = [
			'dataOferta'     => [
				'proyecto'      => 'Proyecto de Prueba Automatizado',
				'codigo_oferta' => 'OFERTA-TEST-001',
				'observaciones' => 'Prueba de integración exitosa',
				// Asegúrate de incluir todos los campos requeridos para 'dataOferta' aquí
			],
			// 'daItems' parece ser un array placeholder, no lo incluimos si no tiene uso directo.
			'equipos'        => [ // 'equipos' aquí representa los ítems principales que contienen sub-equipos
				[ // Item 0 (el primer ítem de la oferta)
					[ // equipo
						'nombre_item'  => 'Item Principal 1',
						'equipo_selec' => [
							'value'               => $equipo1->codigo,
							'precio_de_lista'     => $equipo1->precio_de_lista,
							'descuento_basico'    => 26.50,
							'descuento_proyectos' => 30,
							'precio_de_lista2'    => $equipo1->precio_de_lista,
							'alerta_mano_obra'    => '26',
						],
						'cantidad'     => $cantidad, //en tabla equipo_item => cantidad_equipos
						
						'descuento_final' => $descuentoF,
						'costounitario'   => $descuentoF * $equipo1->precio_de_lista,
						'costototal'      => $cantidad * ($descuentoF / 100) * $equipo1->precio_de_lista,
						
						'factor_final'  => $factorFinal,
						'valorunitario' => ($descuentoF / 100) * $equipo1->precio_de_lista * $factorFinal,
						// Precio por unidad de este equipo
						'subtotalequip' => $cantidad * ($descuentoF / 100) * $equipo1->precio_de_lista * $factorFinal,
						//  $1,106,756
					],
				],
			],
			'cantidadesItem' => [
				1
			], //el tamaño de este vector, debe conicidir con el de  equipos
		];
		echo '1 -- La data enviada tiene como proyecto = ' . $requestData['dataOferta']['proyecto'] . "\n";
		
		// --- 2. ACT (Ejecución de la acción a probar) ---
		$response = $this->actingAs($user)->post(route('GuardarNuevaOferta'), $requestData);
		
		// --- 3. ASSERT (Verificación de resultados) ---
		$response->assertStatus(302); // Esperamos una redirección exitosa (Created o Found)
		//			$response->assertRedirect('/Oferta'); 
		echo '2 -- Redirigido a: ' . $response->getTargetUrl() . "\n";
		
		// 3.2. Verificación de la tabla 'ofertas'
		$this->assertDatabaseHas('ofertas', [
			'proyecto'      => $requestData['dataOferta']['proyecto'],
			'codigo_oferta' => $requestData['dataOferta']['codigo_oferta'],
			'user_id'       => $user->id,
			// Agrega aquí cualquier otro campo de 'ofertas' que sea crucial verificar
		]);
		echo '3 -- Info de Oferta exitosa: ' . $requestData['dataOferta']['codigo_oferta'] . "\n";
		
		// Recupera la oferta recién creada para verificar sus relaciones
		$oferta = Oferta::where('codigo_oferta', $requestData['dataOferta']['codigo_oferta'])->first();
		$this->assertNotNull($oferta, 'La oferta no fue encontrada en la base de datos.');
		echo '4 -- Oferta recuperada,codigo ' . $oferta->codigo_oferta . "\n";
		
		// 3.3. Verificación de la tabla 'items'
		$this->VerificacionSave_son($equipo1, $equipo2, $requestData, $oferta);
		echo "5 -- Test ended successfully.\n";
		
	}
	
	/**
	 * esta funcion quedo a medias
	 */
	private function VerificacionSave_son(Equipo $equipo1, Equipo $equipo2, array $requestData, Oferta $oferta): void {
		// --- 3.3.1. Cálculos de valores esperados para el ITEM principal ---
		$totalItemSubtotalEquip = 0;
//		$debuging = DB::table('equipo_item')->get()->toArray();
//		dd($debuging);
		
		
		foreach ($requestData['equipos'][0] as $equipoPlano) {
			if ($equipoPlano['equipo_selec'] == null) {
				echo "4.1 -- un equipo no tenia equipo_selec \n";
				continue;
				
			}
			
			$totalItemSubtotalEquip += $equipoPlano['subtotalequip'];
			
		}
		
		// --- 3.3.2. Verificación de la tabla 'items' ---
		$this->assertDatabaseHas('items', [
			'oferta_id'           => $oferta->id,
			'nombre'              => 'Item Principal 1',
			'numero'              => 0,
			'valor_unitario_item' => $totalItemSubtotalEquip,
		]);
		
		$item = $oferta->items()->where('nombre', 'Item Principal 1')->first();
		$this->assertNotNull($item, 'El ítem principal no fue encontrado para la oferta.');
		
		foreach ($requestData['equipos'][0] as $equipo) {
			
			$this->assertDatabaseHas('equipo_item', [
				'item_id'          => $item->id,
				'cantidad_equipos' => $equipo['cantidad'],
				'costo_total'      => $equipo['costototal'],
				'subtotalequip'    => $equipo['subtotalequip'],
			]);
		}
		
	}
	
	public function itemNameNull_error() {
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
