<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Sabor extends Model
{
    protected $table = "sabor";
    protected $fillable = ['nombre','descripcion','condicion'];
    protected $guarded = ['id'];
    
    public function productos()
    {
        return $this->hasMany('App\Models\Admin\Producto');
    }
}
