<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class OrdenDetalle extends Model
{
    protected $table = 'orden_detalle';
    protected $fillable = [
        'idorden', 
        'idproducto',
        'cantidad',
        'precio',
        'descuento'
    ];
}
