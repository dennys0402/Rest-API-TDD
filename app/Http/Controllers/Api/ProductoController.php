<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        
        $data = [
            'total' => $productos->count(),
            'data' => $productos
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'error en la validación de los datos',
                'errors' => $validator->errors(),
            ];
            return response()->json($data, 400);
        }

        $producto = Producto::create($request->all());

        return response()->json($producto, 201);
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
