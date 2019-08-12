<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = 'orden';
    protected $fillable =[
        'idusuario',
        'fecha_hora',
        'impuesto',
        'total',
        'estado'
    ];
    
}
