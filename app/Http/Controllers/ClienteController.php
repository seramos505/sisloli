<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Cliente;

class ClienteController extends Controller
{
    public function selectCliente(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $clientes = Cliente::select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['clientes' => $clientes];
    }
}
