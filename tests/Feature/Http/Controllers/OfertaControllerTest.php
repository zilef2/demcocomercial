<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Equipo;
use App\Models\Item;
use App\Models\Oferta;
use App\Models\User;
use App\Services\OfertaService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class OfertaControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function actualiza_la_cantidad_de_un_equipo_en_un_item()
    {
        // 1. Arrange
		$nombredb = DB::connection()->getDatabaseName();
		echo $nombredb;
	    
        $user = User::factory()->create();
        $oferta = Oferta::factory()->create();
        $item = Item::factory()->create(['oferta_id' => $oferta->id]);
        $equipo = Equipo::factory()->create();

        $cantidadInicial = 2;
        $item->equipos()->attach($equipo->id, [
            'cantidad_equipos' => $cantidadInicial,
            'consecutivo_equipo' => 1,
        ]);

        // 2. Act
        $nuevaCantidad = 10;

        // Perform the update directly within the test
        $item->equipos()->updateExistingPivot($equipo->id, ['cantidad_equipos' => $nuevaCantidad]);

        // 3. Assert
	    echo '\nASSERTING...';
        $this->assertDatabaseHas('equipo_item', [
            'item_id' => $item->id,
            'equipo_id' => $equipo->id,
            'cantidad_equipos' => $nuevaCantidad,
        ]);
		echo '\nBACKEND OK -- updateExistingPivot works fine.';
    }
}