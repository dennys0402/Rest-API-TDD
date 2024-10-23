<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id', 
        'producto_id', 
        'cantidad', 
        'precio_unitario', 
        'total'
    ];

    public $timestamps = false; // Desactiva las marcas de tiempo

    // Relación de muchos a uno con Venta
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    // Relación de muchos a uno con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
