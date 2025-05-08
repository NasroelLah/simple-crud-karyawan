<?php

namespace Database\Seeders;

use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Database\Seeder;

class KaryawanWithRelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Departemen::factory()->count(5)->create();

        $departments->each(function ($department) {
            $positions = Jabatan::factory()
                ->count(rand(2, 3))
                ->for($department)
                ->create();

            $positions->each(function ($position) use ($department) {
                Karyawan::factory()
                    ->count(rand(3, 5))
                    ->for($department)
                    ->for($position)
                    ->create();
            });
        });

        $this->command->info('Created ' . Departemen::count() . ' departments');
        $this->command->info('Created ' . Jabatan::count() . ' positions');
        $this->command->info('Created ' . Karyawan::count() . ' employees');
    }
}
