<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetalleVenta;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with(['cliente', 'detalles.producto'])->get();

        $response = [
            'total' => $ventas->count(),
            'data' => $ventas->map(function ($venta) {
                return [
                    'id' => $venta->id,
                    'cliente' => [
                        'id' => $venta->cliente->id,
                        'nombre' => $venta->cliente->nombre,
                    ],
                    'metodo_pago' => $venta->metodo_pago,
                    'total' => $venta->total,
                    'items' => $venta->detalles->map(function ($detalle) {
                        return [
                            'producto' => [
                                'id' => $detalle->producto->id,
                                'nombre' => $detalle->producto->nombre,
                            ],
                            'cantidad' => $detalle->cantidad,
                            'precio_unitario' => $detalle->precio_unitario,
                            'total' => $detalle->total,
                        ];
                    }),
                ];
            }),
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required|exists:clientes,id',
            'metodo_pago' => 'required|in:' . Venta::METODO_PAGO_EFECTIVO . ',' . Venta::METODO_PAGO_TARJETA . ',' . Venta::METODO_PAGO_QR,
            'items' => 'required|array',
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.cantidad' => 'required|numeric|min:1',
            'items.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'error en la validación de los datos',
                'errors' => $validator->errors(),
            ];
            return response()->json($data, 400);
        }

        $total = 0;
        foreach ($request->items as $item) {
            $total += $item['cantidad'] * $item['precio_unitario'];
        }

        $venta = Venta::create([
            'cliente_id' => $request->cliente_id,
            'total' => $total,
            'metodo_pago' => $request->metodo_pago,
        ]);

        foreach ($request->items as $item) {
            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $item['producto_id'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio_unitario'],
                'total' => $item['cantidad'] * $item['precio_unitario'],
            ]);
        }

        return response()->json(['message' => 'Venta registrada exitosamente'], 201);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
