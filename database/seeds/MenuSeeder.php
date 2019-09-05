<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus=[
            ["parent_menu" => 0,"nombre" => "Catalogo","url" => "javascript:;","orden" => 1,"icono" => "fas fa-clipboard-list"],
            ["parent_menu" => 0,"nombre" => "Ventas","url" => "javascript:;","orden" => 2,"icono" => "fas fa-cart-plus"],
            ["parent_menu" => 0,"nombre" => "Reportes","url" => "javascript:;","orden" => 3,"icono" => "fas fa-chart-pie"],
            ["parent_menu" => 0,"nombre" => "Acceso","url" => "javascript:;","orden" => 4,"icono" => "fas fa-users"],
            ["parent_menu" => 0,"nombre" => "Ayuda","url" => "ayuda","orden" => 5,"icono" => "fas fa-exclamation-circle"],
            ["parent_menu" => 1,"nombre" => "Productos","url" => "producto","orden" => 1,"icono" => "fab fa-product-hunt"],
            ["parent_menu" => 1,"nombre" => "Categorías","url" => "categoria","orden" => 2,"icono" => "fas fa-clipboard-check"],
            ["parent_menu" => 1,"nombre" => "Sabores","url" => "sabor","orden" => 3,"icono" => "fas fa-ice-cream"],
            ["parent_menu" => 1,"nombre" => "Tamaños","url" => "tamano","orden" => 4,"icono" => "fas fa-ruler"],
            ["parent_menu" => 2,"nombre" => "Ordenes","url" => "orden","orden" => 1,"icono" => "fas fa-cart-arrow-down"],
            ["parent_menu" => 2,"nombre" => "Clientes","url" => "cliente","orden" => 2,"icono" => "fas fa-user-tie"],
            ["parent_menu" => 3,"nombre" => "Ingresos","url" => "ventarango","orden" => 1,"icono" => "fas fa-circle"],
            ["parent_menu" => 3,"nombre" => "Ventas por Mes","url" => "venta-mes","orden" => 2,"icono" => "fas fa-circle"],
            ["parent_menu" => 4,"nombre" => "Usuarios","url" => "usuario","orden" => 1,"icono" => "fas fa-user"],
            ["parent_menu" => 4,"nombre" => "Roles","url" => "rol","orden" => 2,"icono" => "fas fa-scroll"],
            ["parent_menu" => 4,"nombre" => "Permisos","url" => "permiso","orden" => 3,"icono" => "fas fa-user-tag"],
            ["parent_menu" => 4,"nombre" => "Menus","url" => "menu","orden" => 4,"icono" => "fas fa-bars"]

        ];
        foreach($menus as $menu){
            DB::table('menu')->insert([
                'parent_menu' => $menu["parent_menu"],
                'nombre' => $menu["nombre"],
                'url' => $menu["url"],
                'orden' => $menu["orden"],
                'icono' => $menu["icono"], 
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
