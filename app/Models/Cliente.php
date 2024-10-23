<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'ci_nit',
        'email',
    ];

    public $timestamps = false; // Desactiva las marcas de tiempo

    // Relación de 1 a muchos con Venta
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}