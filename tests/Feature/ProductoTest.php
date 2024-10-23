<?php

namespace Tests\Feature;

use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductoTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    /** @test */
    public function puede_crear_un_producto(): void
    {
        // teniendo
        $data = [
            'nombre' => $this->faker->word,
            'precio' => $this->faker->randomFloat(2, 10, 100),
        ];

        // haciendo
        $response = $this->postJson('/api/productos', $data);

        // esperando
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id', 'nombre', 'precio',
                 ]);

        $this->assertDatabaseHas('productos', [
            'nombre' => $data['nombre'],
        ]);
    }

    /** @test */
    public function puede_listar_todos_los_productos(): void
    {
        // teniendo
        $productos = [
            [
                'nombre' => $this->faker->word,
                'precio' => $this->faker->randomFloat(2, 10, 100),
            ],
            [
                'nombre' => $this->faker->word,
                'precio' => $this->faker->randomFloat(2, 10, 100),
            ],
            [
                'nombre' => $this->faker->word,
                'precio' => $this->faker->randomFloat(2, 10, 100),
            ],
        ];
    
        // haciendo
        foreach ($productos as $producto) {
            Producto::create($producto);
        }
        $response = $this->getJson('/api/productos');
    
        // esperando
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'total',
                     'data' => [
                         '*' => [
                             'id', 'nombre', 'precio',
                         ],
                     ],
                 ]);
    
        // Verificar que el total de productos sea 3
        $this->assertEquals(3, $response->json('total'));
    }    
}
