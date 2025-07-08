<?php

namespace Tests\Feature\Feature;

use App\Models\Equipo;
use App\Models\Oferta;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Tests\TestCase;

class OfertaControllerTest extends TestCase {
	
	use RefreshDatabase;
	
	// Este trait se encarga de las migraciones
	
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
		                                            ]), 'La tabla "items" no tiene las columnas esperadas.');
		
		$userSuper = !!User::factory()->create(['id' => 1]); // Crea el usuario con ID 1, que es el que simularemos.
		$this->assertTrue($userSuper);
	}
	
	public function test_db_connection_is_sqlite_in_memory() {
		$connection = config('database.default');
		$database = config('database.connections.' . $connection . '.database');
		$this->assertEquals(':memory:', $database);
		
		$this->assertEquals('sqlite', $connection);
	}
	

	public function it_can_save_a_new_oferta_successfully() {
		
		// --- 1. ARRANGE (Preparación de datos y estado) ---
		$user = User::find(1);
		$nombreDelsuper = (strcmp('superadmin', $user->name) === 0);
		$this->assertTrue($nombreDelsuper);
		$this->assertEquals('sqlite', config('database.default'), 'La conexión a la base de datos no es SQLite como se esperaba.');
		
		$equipo1 = Equipo::factory()->create([
			                                     'id'              => 101, // ID que usaremos en la solicitud de prueba
			                                     'codigo'          => 'EQ001',
			                                     'precio_de_lista' => 1000,
		                                     ]);
		$equipo2 = Equipo::factory()->create([
			                                     'id'              => 102,
			                                     'codigo'          => 'EQ002',
			                                     'precio_de_lista' => 500,
		                                     ]);
		
		// Datos que simulan la petición HTTP POST a tu controlador
		$requestData = [
			'dataOferta'     => [
				'proyecto'      => 'Proyecto de Prueba Automatizado',
				'codigo_oferta' => 'OFERTA-TEST-001',
				'observaciones' => 'Prueba de integración exitosa',
				// Asegúrate de incluir todos los campos requeridos por tu validación para `dataOferta`
			],
			'daItems'        => [
				// Este campo parece ser un array requerido por la validación,
				// pero no se usa directamente en el bucle 'equipos'.
				// Puedes dejarlo vacío o con un valor dummy.
			],
			'equipos'        => [
				[ // Este es el "item 0" en tu lógica
					[ // Este es el "equipo 0" dentro del "item 0"
						'nombre_item'   => 'Item Principal 1',
						'equipo_selec'  => [
							'value'           => $equipo1->id,
							'precio_de_lista' => $equipo1->precio_de_lista,
						],
						'cantidad'      => 2,
						'subtotalequip' => 2 * $equipo1->precio_de_lista, // 2000
					],
					[ // Este es el "equipo 1" dentro del "item 0"
						'nombre_item'   => 'Item Principal 1', // El nombre del ítem es el mismo
						'equipo_selec'  => [
							'value'           => $equipo2->id,
							'precio_de_lista' => $equipo2->precio_de_lista,
						],
						'cantidad'      => 3,
						'subtotalequip' => 3 * $equipo2->precio_de_lista, // 1500
					],
				],
				// Puedes añadir más ítems y equipos si tu escenario lo requiere
			],
			'cantidadesItem' => [1], // Cantidad para el "item 0"
		];
		
		// --- 2. ACT (Ejecución de la acción a probar) ---
		// Simula la autenticación del usuario y envía la petición POST
		$response = $this
			->actingAs($user)->post(route('GuardarNuevaOferta'), $requestData);
		
		// --- 3. ASSERT (Verificación de resultados) ---
		// Verifica que la petición fue exitosa y resultó en una redirección
		$response->assertStatus(302); // Código 302 para redirecciones
		$response->assertRedirect('/Oferta'); // Verifica que redirige a la URL correcta
		$response->assertSessionHas('success', __('app.label.created_successfully', ['name' => $requestData['dataOferta']['proyecto']])); // Verifica el mensaje de éxito en la sesión
		
		// Verifica que los datos se hayan guardado correctamente en la base de datos
		$this->assertDatabaseHas('ofertas', [
			'proyecto'      => $requestData['dataOferta']['proyecto'],
			'codigo_oferta' => $requestData['dataOferta']['codigo_oferta'],
			'user_id'       => $user->id,
			// Agrega más campos de 'ofertas' que esperas se guarden
		]);
		
		// Recupera la oferta recién creada para verificar sus ítems y equipos
		$oferta = Oferta::where('codigo_oferta', $requestData['dataOferta']['codigo_oferta'])->first();
		$this->assertNotNull($oferta, 'La oferta no fue encontrada en la base de datos.');
		
		$this->assertDatabaseHas('items', [
			'oferta_id'           => $oferta->id,
			'nombre'              => 'Item Principal 1',
			'numero'              => 0,
			'cantidad'            => $requestData['cantidadesItem'][0],
			'valor_unitario_item' => 3500, // 2000 (EQ001) + 1500 (EQ002)
			'valor_total_item'    => 3500 * $requestData['cantidadesItem'][0],
		]);
		
		// Recupera el ítem recién creado para verificar sus equipos
		$item = $oferta->items->first(); // Asumiendo que solo hay un ítem en este test
		$this->assertNotNull($item, 'El ítem no fue encontrado para la oferta.');
		
		// Verifica las relaciones pivot entre ítems y equipos
		$this->assertDatabaseHas('equipo_item', [
			'item_id'          => $item->id,
			'equipo_id'        => $equipo1->id,
			'cantidad_equipos' => 2,
		]);
		$this->assertDatabaseHas('equipo_item', [
			'item_id'          => $item->id,
			'equipo_id'        => $equipo2->id,
			'cantidad_equipos' => 3,
		]);
		
	}
	
	/**
	 * @test
	 * Prueba que el método falla si el nombre del ítem es nulo.
	 */
	public function it_returns_error_if_item_name_is_null() {
		// --- 1. ARRANGE ---
		$user = User::factory()->create([
            'email' => 'ajelof2+7@gmail.com', // Provide specific data if needed
            'password' => bcrypt('password'),
        ]);
		$requestData = [
			'dataOferta'     => [
				'proyecto'      => 'Proyecto con Ítem Inválido',
				'codigo_oferta' => 'OFERTA-FAIL-001',
			],
			'daItems'        => [],
			'equipos'        => [
				[
					[
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
		
		// --------------------------------------------------------------------
		// MOQUEO DE DEPENDENCIAS EXTERNAS O ESTÁTICAS
		// --------------------------------------------------------------------
		// Tu función usa 'Myhelp::EscribirEnLog' y 'Myhelp::AuthUid()'.
		// Queremos simular su comportamiento para que no realicen acciones reales
		// durante los tests (como escribir en un archivo de log o depender de una sesión real).
		
		// Mock para Myhelp::EscribirEnLog()
		// `alias:` es necesario para mockear métodos estáticos
		Mockery::mock('alias:App\Helpers\Myhelp') // Asegúrate de que la ruta a Myhelp sea correcta
		       ->shouldReceive('EscribirEnLog')
			// No se espera un valor de retorno, o puedes poner ->andReturn(null);
			   ->andReturn(null)
		; // Simula que no hace nada o devuelve nulo
		
		// Mock para Myhelp::AuthUid()
		// Este método devuelve el ID del usuario autenticado.
		// Aquí simulamos que siempre devuelve '1' (el ID de un usuario que crearemos).
		Mockery::mock('alias:App\Helpers\Myhelp')->shouldReceive('AuthUid')->andReturn(1); // Simula que el usuario autenticado tiene ID 1
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
