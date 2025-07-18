<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Docentes;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Docentes>
 */
class DocentesFactory extends Factory
{
  protected $model = Docentes::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numdocumento' => $this->faker->unique()->numerify('##########'), // Ej: "1234567890"
            'nomcompleto' => $this->faker->name(),
            'vinculcion' => $this->faker->randomElement(['Activo', 'Inactivo']),
        ];
    }
}
