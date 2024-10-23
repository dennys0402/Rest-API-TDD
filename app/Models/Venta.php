<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id', 
        'total', 
        'metodo_pago'
    ];

    public $timestamps = false; // Desactiva las marcas de tiempo

    // Enumeración para Método de Pago
    const METODO_PAGO_EFECTIVO = 'Efectivo';
    const METODO_PAGO_TARJETA = 'Tarjeta';
    const METODO_PAGO_QR = 'QR';

    // Relación de muchos a uno con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación de 1 a muchos con DetalleVenta
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}
