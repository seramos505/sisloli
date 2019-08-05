<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $fillable = ['nombre','descripcion','condicion'];

    public function productos()
    {
        return $this->hasMany('App\Models\Admin\Producto');
    }
}
