<?php

namespace Database\Factories;

use App\Models\Oferta;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Oferta>
 */
class OfertaFactory extends Factory {
	
	protected $model = Oferta::class;
	
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition() {
		return [
			'codigo_oferta' => 'OFR-' . $this->faker->unique()->randomNumber(5, true),
			'descripcion'   => $this->faker->paragraph(3),
			'cargo'         => $this->faker->jobTitle(),
			'empresa'       => $this->faker->company(),
			'ciudad'        => $this->faker->city(),
			'proyecto'      => $this->faker->catchPhrase(),
			'fecha'         => Carbon::now()->subDays($this->faker->numberBetween(0, 30)), // Fechas recientes
			// Si 'user_id' es requerido y una Oferta siempre pertenece a un User,
			// puedes vincularlo así:
			'user_id'       => User::factory(), // Esto creará un User si no se especifica uno
		];
	}
}
