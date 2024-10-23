<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Cliente;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, rand(5, 8)) as $index) {
            Cliente::create([
                'nombre' => $faker->name,
                'ci_nit' => $faker->numerify('########'),
                'email' => $faker->unique()->safeEmail,
            ]);
        }
    }
}
