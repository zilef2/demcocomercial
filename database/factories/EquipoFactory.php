<?php

namespace Database\Factories;

use App\Models\Equipo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipo>
 */
class EquipoFactory extends Factory
{
     protected $model = Equipo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigo'                     => $this->faker->unique()->word() . '-' . $this->faker->randomNumber(3),
            'descripcion'                => $this->faker->sentence(6),
            'tipo_fabricante'            => $this->faker->company(),
            'referencia_fabricante'      => $this->faker->uuid(),
            'marca'                      => $this->faker->companySuffix(),
            'unidad_de_compra'           => $this->faker->randomElement(['Unidad', 'Caja', 'Litro', 'Kg']),
            'precio_de_lista'            => ($this->faker->randomFloat(2, 100, 5000000) * 1000), // Precio entre 100 y 5,000,000 * 1000
            'fecha_actualizacion'        => Carbon::now(),
            'descuento_basico'           => $this->faker->randomFloat(2, 0, 0.15), // Descuento entre 0 y 15%
            'descuento_proyectos'        => $this->faker->randomFloat(2, 0, 0.25), // Descuento entre 0 y 25%
            'precio_con_descuento'       => $this->faker->randomFloat(2, 50, 4000), // Este y los siguientes suelen calcularse
            'precio_con_descuento_proyecto' => $this->faker->randomFloat(2, 40, 3500),
            'precio_ultima_compra'       => $this->faker->randomFloat(2, 80, 4500),
            'precios_de_listas'          => json_encode(['lista1' => $this->faker->randomFloat(2, 100, 5000), 'lista2' => $this->faker->randomFloat(2, 90, 4800)]), // JSON
            'ruta_tiempos'               => 'T-' . $this->faker->randomFloat(2, 1, 500),
            'tiempos_chapisteria'        => $this->faker->randomFloat(2, 0.5, 10), // Horas
        ];
    }
}
