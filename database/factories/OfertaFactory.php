<?php

namespace Database\Factories;

use App\Models\Oferta;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfertaFactory extends Factory
{
    protected $model = Oferta::class;

    public function definition()
    {
		$user = User::factory()->create();
        return [
            'cliente'         => $this->faker->firstName() . ' ejemploi',
            'codigo_oferta' => 'CD_Prueba_' . $this->faker->unique()->randomNumber(5, true),
            'descripcion'   => $this->faker->paragraph(2),
            'cargo'         => $this->faker->jobTitle(),
            'empresa'       => $this->faker->company(),
            'ciudad'        => $this->faker->city(),
            'proyecto'      => $this->faker->catchPhrase(),
            'fecha'         => Carbon::now()->subDays($this->faker->numberBetween(0, 30)),
            'user_id'       => $user->id,
        ];
    }
}