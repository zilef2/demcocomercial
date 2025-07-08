<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
	 /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;
	
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'         => Hash::make('password'), // Una contraseña por defecto
            'remember_token'   => Str::random(10),
            'identificacion'   => $this->faker->unique()->randomNumber(8, true),
            'sexo'             => $this->faker->randomElement(['Masculino', 'Femenino']), // Masculino, Femenino, Otro
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '2005-01-01'), // Fecha de nacimiento coherente
            'celular'          => $this->faker->phoneNumber(),
            'area'             => $this->faker->jobTitle(),
            'cargo'            => $this->faker->word(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
