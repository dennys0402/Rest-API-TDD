<?php

use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\VentaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/clientes', [ClienteController::class,'index']);

Route::get('/clientes/{id}', [ClienteController::class,'show']);

Route::post('/clientes', [ClienteController::class, 'store']);


Route::get('/productos', [ProductoController::class,'index']);

Route::post('/productos', [ProductoController::class, 'store']);


Route::get('/ventas', [VentaController::class,'index']);

Route::post('/ventas', [VentaController::class, 'store']);