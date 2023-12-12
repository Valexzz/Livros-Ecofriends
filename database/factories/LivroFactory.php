<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livro>
 */
class LivroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => fake()->company(),
            'area_conhecimento_id' => fake()->numberBetween($minx=1,$max=3),
            'numero_cadastro' => fake()->postcode(),
            'estoque' => 1,
        ];
    }
}
