<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio'
        ];

    public $timestamps = false; 
    
    // Relación de 1 a muchos con DetalleVenta
    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}
