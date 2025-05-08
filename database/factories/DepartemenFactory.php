<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Departemen;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Departemen>
 */
class DepartemenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->unique()->company(),
            'kode' => strtoupper(fake()->unique()->lexify('DEP-???')),
            'keterangan' => fake()->optional(0.7)->sentence(),
            'status' => fake()->boolean(80),
        ];
    }
}
