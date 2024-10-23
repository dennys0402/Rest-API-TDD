<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase,WithFaker;
    
    /** @test */
    public function puede_crear_un_cliente(): void
    {
        // teniendo
        $data = [
            'nombre' => $this->faker->name,
            'ci_nit' => $this->faker->numerify('########'),
            'email' => $this->faker->unique()->safeEmail,
        ];

        // haciendo
        $response = $this->postJson('/api/clientes', $data);

        // esperando
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id', 'nombre', 'ci_nit', 'email'
                 ]);

        $this->assertDatabaseHas('clientes', [
            'email' => $data['email'],
        ]);
    }

    /** @test */
    public function validacion_de_datos_para_crear_cliente(): void
    {
        // teniendo
        $data = []; 

        // haciendo
        $response = $this->postJson('/api/clientes', $data);

        // esperando
        $response->assertStatus(400)
                 ->assertJsonValidationErrors(['nombre', 'ci_nit', 'email'])
                 ->assertJson([
                    'message' => 'error en la validación de los datos',
                ]);
    }

    /** @test */
    public function validacion_de_formato_email(): void
    {
        // teniendo
        $data = [
            'nombre' => $this->faker->name,
            'ci_nit' => $this->faker->unique()->numerify('########'),
            'email' => 'email no valido', 
        ];

        // haciendo
        $response = $this->postJson('/api/clientes', $data);

        // esperando
        $response->assertStatus(400)
                 ->assertJsonValidationErrors('email')
                 ->assertJson([
                     'message' => 'error en la validación de los datos',
                 ]);
    }

    /** @test */
    public function validacion_de_formato_formato_ci_nit(): void
    {
        // teniendo
        $data = [
            'nombre' => $this->faker->name,
            'ci_nit' => 'ci nit no valido', 
            'email' => $this->faker->unique()->safeEmail,
        ];

        // haciendo
        $response = $this->postJson('/api/clientes', $data);

        // esperando
        $response->assertStatus(400)
                 ->assertJsonValidationErrors('ci_nit')
                 ->assertJson([
                     'message' => 'error en la validación de los datos',
                 ]);
    }

    /** @test */
    public function puede_listar_todos_los_clientes(): void
    {
        // teniendo
        $clientes = [
            [
                'nombre' => $this->faker->name,
                'ci_nit' => $this->faker->numerify('########'),
                'email' => $this->faker->unique()->safeEmail,
            ],
            [
                'nombre' => $this->faker->name,
                'ci_nit' => $this->faker->numerify('########'),
                'email' => $this->faker->unique()->safeEmail,
            ],
            [
                'nombre' => $this->faker->name,
                'ci_nit' => $this->faker->numerify('########'),
                'email' => $this->faker->unique()->safeEmail,
            ],
        ];
    
        // haciendo
        foreach ($clientes as $cliente) {
            $this->postJson('/api/clientes', $cliente)
                 ->assertStatus(201);
        }
        $response = $this->getJson('/api/clientes');
    
        // esperando
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'total',
                     'data' => [
                         '*' => [
                             'id', 'nombre', 'ci_nit', 'email',
                         ],
                     ],
                 ]);
    
        // Verificar que el total de clientes sea 3
        $this->assertEquals(3, $response->json('total'));
    }    
}
