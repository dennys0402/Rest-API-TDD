<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class VentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Obtener todos los clientes y productos existentes
        $clientes = Cliente::all();
        $productos = Producto::all();

        // Crear ventas con detalles
        foreach ($clientes as $cliente) {
            foreach (range(1, 3) as $index) {
                $total = 0;
                $venta = Venta::create([
                    'cliente_id' => $cliente->id,
                    'metodo_pago' => $faker->randomElement([Venta::METODO_PAGO_EFECTIVO, Venta::METODO_PAGO_TARJETA, Venta::METODO_PAGO_QR]),
                    'total' => 0,  // Será actualizado posteriormente
                ]);

                // Crear detalles para la venta
                foreach (range(1, mt_rand(1, 3)) as $detailIndex) {
                    $producto = $productos->random();
                    $cantidad = $faker->numberBetween(1, 5);
                    $precio_unitario = $producto->precio;
                    $detalle_total = $cantidad * $precio_unitario;

                    DetalleVenta::create([
                        'venta_id' => $venta->id,
                        'producto_id' => $producto->id,
                        'cantidad' => $cantidad,
                        'precio_unitario' => $precio_unitario,
                        'total' => $detalle_total,
                    ]);

                    $total += $detalle_total;
                }

                // Actualizar el total de la venta
                $venta->update(['total' => $total]);
            }
        }
    }
}
