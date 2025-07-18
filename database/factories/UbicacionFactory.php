<?php

namespace Database\Factories;
use App\Models\Ubicacion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ubicacion>
 */
class UbicacionFactory extends Factory
{

    protected $model = Ubicacion::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'codsalon' => $this->faker->unique()->bothify('???###'), // Ej: "A101"
            'dotacion' => $this->faker->sentence(),
            'estado' => $this->faker->randomElement(['Disponible', 'No Disponible']),
        ];
    }
    
}
