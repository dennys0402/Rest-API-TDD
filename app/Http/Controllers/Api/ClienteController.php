<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        
        $data = [
            'total' => $clientes->count(),
            'data' => $clientes
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'ci_nit' => 'required|digits_between:1,20',
            'email' => 'required|string|email|max:255|unique:clientes'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'error en la validación de los datos',
                'errors' => $validator->errors(),
            ];
            return response()->json($data, 400);
        }

        $cliente = Cliente::create($request->all());

        return response()->json($cliente, 201);
    }

    public function show($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            $data = [
                'message' => 'cliente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'cliente' => $cliente,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request,$id)
    {
        //
    }


    public function destroy(string $id)
    {
        //       
    }
}
