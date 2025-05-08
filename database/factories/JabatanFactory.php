<?php

namespace Database\Factories;

use App\Models\Departemen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jabatan>
 */
class JabatanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'departemen_id' => Departemen::factory(),
            'kode' => strtoupper($this->faker->unique()->lexify('JBT-???')),
            'nama' => $this->faker->jobTitle(),
            'keterangan' => $this->faker->optional(0.7)->sentence(),
            'status' => $this->faker->boolean(80),
        ];
    }
}
