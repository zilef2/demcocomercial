<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Oferta;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

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
            'oferta_id'           => Oferta::factory(),
        ];
    }
}