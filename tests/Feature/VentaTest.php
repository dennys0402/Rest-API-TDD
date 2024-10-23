<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VentaTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function puede_registrar_venta_con_detalles()
    {
        // Crear un cliente
        $cliente = Cliente::create([
            'nombre' => 'Juan Perez',
            'ci_nit' => '1234567',
            'email' => 'juanperez@example.com'
        ]);

        // Crear unos productos
        $producto1 = Producto::create([
            'nombre' => 'Producto A',
            'precio' => 100
        ]);

        $producto2 = Producto::create([
            'nombre' => 'Producto B',
            'precio' => 150
        ]);

        // Datos de la venta
        $ventaData = [
            'cliente_id' => $cliente->id,
            'metodo_pago' => Venta::METODO_PAGO_EFECTIVO,
            'items' => [
                [
                    'producto_id' => $producto1->id,
                    'cantidad' => 2,
                    'precio_unitario' => $producto1->precio,
                ],
                [
                    'producto_id' => $producto2->id,
                    'cantidad' => 2,
                    'precio_unitario' => $producto2->precio,
                ]
            ]
        ];

        $response = $this->post('api/ventas', $ventaData);

        $response->assertStatus(201);

        // Verificar que la venta fue registrada en la base de datos
        $this->assertDatabaseHas('ventas', [
            'cliente_id' => $cliente->id,
            'total' => 500,  
            'metodo_pago' => Venta::METODO_PAGO_EFECTIVO
        ]);

        // Verificar que los detalles de la venta fueron registrados en la base de datos
        $this->assertDatabaseHas('detalle_ventas', [
            'producto_id' => $producto1->id,
            'cantidad' => 2,
            'precio_unitario' => $producto1->precio,
            'total' => 200
        ]);
        $this->assertDatabaseHas('detalle_ventas', [
            'producto_id' => $producto2->id,
            'cantidad' => 2,
            'precio_unitario' => $producto2->precio,
            'total' => 300
        ]);
    }

/** @test */
public function puede_listar_todas_las_ventas(): void
{
    // Crear un cliente
    $cliente = Cliente::create([
        'nombre' => 'John Doe',
        'ci_nit' => '1234567',
        'email' => $this->faker->unique()->safeEmail
    ]);

    // Crear unos productos
    $producto1 = Producto::create([
        'nombre' => 'Producto A',
        'precio' => 1.5
    ]);

    // Crear una venta
    $venta = Venta::create([
        'cliente_id' => $cliente->id,
        'total' => 3,
        'metodo_pago' => Venta::METODO_PAGO_EFECTIVO,
    ]);

    // Crear los detalles de la venta
    DetalleVenta::create([
        'venta_id' => $venta->id,
        'producto_id' => $producto1->id,
        'cantidad' => 2,
        'precio_unitario' => 1.5,
        'total' => 3,
    ]);

    // Hacer la petición a la ruta index
    $response = $this->get('api/ventas');

    // Verificar que el status sea 200
    $response->assertStatus(200);

    // Verificar los datos específicos de la respuesta
    $responseData = $response->json('data')[0];
    $this->assertEquals($venta->id, $responseData['id']);
    $this->assertEquals($cliente->id, $responseData['cliente']['id']);
    $this->assertEquals($cliente->nombre, $responseData['cliente']['nombre']);
    $this->assertEquals($venta->metodo_pago, $responseData['metodo_pago']);
    $this->assertEquals($venta->total, $responseData['total']);

    $itemData = $responseData['items'][0];
    $this->assertEquals($producto1->id, $itemData['producto']['id']);
    $this->assertEquals($producto1->nombre, $itemData['producto']['nombre']);
    $this->assertEquals(2, $itemData['cantidad']);
    $this->assertEquals(1.5, $itemData['precio_unitario']);
    $this->assertEquals(3, $itemData['total']);
} 
}
