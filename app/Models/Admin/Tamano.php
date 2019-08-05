<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Tamano extends Model
{
    protected $table = 'tamano';
    protected $fillable = ['nombre','descripcion','condicion'];

    public function productos()
    {
        return $this->hasMany('App\Models\Admin\Producto');
    }}
