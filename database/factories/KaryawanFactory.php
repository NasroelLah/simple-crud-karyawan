<?php

namespace Database\Factories;

use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Karyawan>
 */
class KaryawanFactory extends Factory
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
            'jabatan_id' => Jabatan::factory(),
            'kode' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{4}'),
            'nik' => $this->faker->unique()->numerify('##############'),
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'no_hp' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->address(),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '-20 years'),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'jabatan' => $this->faker->jobTitle(),
            'foto' => null,
            'status' => 'aktif',
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'nonaktif',
        ]);
    }

    public function forDepartemen(Departemen $departemen): static
    {
        return $this->state(fn(array $attributes) => [
            'departemen_id' => $departemen->id,
        ]);
    }

    public function forJabatan(Jabatan $jabatan): static
    {
        return $this->state(fn(array $attributes) => [
            'jabatan_id' => $jabatan->id,
        ]);
    }
}
