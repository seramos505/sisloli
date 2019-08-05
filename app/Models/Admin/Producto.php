<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $fillable =[
        'idcategoria','idsabor','idtamano','codigo','nombre','precio_venta','stock','descripcion','condicion'
    ];
    public function categoria(){
        return $this->belongsTo('App\Models\Admin\Categoria');
    }
    public function sabor(){
        return $this->belongsTo('App\Models\Admin\Sabor');
    }
    public function tamano(){
        return $this->belongsTo('App\Models\Admin\Tamano');
    }
}
