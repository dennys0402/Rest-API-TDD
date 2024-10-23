<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Producto;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, rand(5, 8)) as $index) {
            Producto::create([
                'nombre' => $faker->word,
                'precio' => $faker->randomFloat(2, 10, 100),
            ]);
        }
    }
}
