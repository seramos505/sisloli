<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = "menu";
    protected $fillable = ['nombre', 'url', 'icono'];
    protected $guarded = ['id'];

    public function getHijos($padres, $line)
    {
        $children = [];
        foreach ($padres as $line1) {
            if ($line['id'] == $line1['menu_id']) {
                $children = array_merge($children, [array_merge($line1, ['submenu' => $this->getHijos($padres, $line1)])]);
            }
        }
        return $children;
    }

    public function getPadres($front)
    {
        // if ($front) {
        //     return $this->join('menu_rol','menu.id','=','menu_rol.menu_id')
        //         ->where('menu_rol.rol_id', 3)
        //         ->orderby('menu.menu_id')
        //         ->orderby('menu.orden')
        //         ->get()
        //         ->toArray();
        // } else {
        //     return $this->orderby('menu_id')
        //         ->orderby('orden')
        //         ->get()
        //         ->toArray();
        // }
        return $this->join('menu_rolss','menu.id','=','menu_rol.menu_id')
        ->where('menu_rol.rol_id', 2)
        ->orderby('menu.menu_id')
        ->orderby('menu.orden')
        ->get()
        ->toArray();
    }

    // public static function getMenu($front = false)
    // {
    //     $menus = new Menu();
    //     $padres = $menus->getPadres($front);
    //     $menuAll = [];
    //     foreach ($padres as $line) {
    //         if ($line['menu_id'] != 0)
    //             break;
    //         $item = [array_merge($line, ['submenu' => $menus->getHijos($padres, $line)])];
    //         $menuAll = array_merge($menuAll, $item);
    //     }
    //     return $menuAll;
    // }
}
