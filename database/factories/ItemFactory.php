<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Oferta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
   protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'numero'              => $this->faker->numberBetween(1, 10),
            'nombre'              => $this->faker->sentence(3, true),
            'descripcion'         => $this->faker->paragraph(2),
            'cantidad'            => $this->faker->numberBetween(1, 5),
            'conteo_items'        => $this->faker->numberBetween(1, 10),
            'valor_unitario_item' => $this->faker->randomFloat(2, 50, 5000),
            'valor_total_item'    => $this->faker->randomFloat(2, 100, 10000),
            // Si 'oferta_id' es requerido y un Item siempre pertenece a una Oferta,
            // puedes vincularlo así:
            'oferta_id'           => Oferta::factory(), // Esto creará una Oferta si no se especifica una
        ];
    }
}
