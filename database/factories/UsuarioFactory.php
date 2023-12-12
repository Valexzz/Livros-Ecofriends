<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'=> '123',
            'matricula' => fake()->randomNumber(7, true),
            'curso_id' => fake()->numberBetween($min=1,$max=3),
            'ano' => fake()->numberBetween($min=1,$max=3),
            'telefone' => fake()->randomNumber(9, true),
        ];
    }
}
