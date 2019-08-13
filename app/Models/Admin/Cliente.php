<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    protected $fillable = ['nombre','tipo_documento','num_documento','direccion','telefono','email'];
}
