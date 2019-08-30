<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class Menu extends Model
{
    protected $table = "menu";
    protected $fillable = ['nombre', 'url', 'icono'];
    protected $guarded = ['id'];

    public function getHijos($padres, $line)
    {
        $children = [];
        foreach ($padres as $line1) {
            if ($line['id'] == $line1['parent_menu']) {
                $children = array_merge($children, [array_merge($line1, ['submenu' => $this->getHijos($padres, $line1)])]);
            }
        }
        return $children;
    }

    public function getPadres($front)
    {
        if ($front) {
            return $this->join('menu_rol','menu.id','=','menu_rol.menu_id')
                ->select('menu.*')
                ->whereIn('menu_rol.rol_id', Auth::user()->roles->pluck('id'))
                ->orderby('menu.parent_menu')
                ->orderby('menu.orden')
                ->distinct('menu.id')
                ->get()
                ->toArray();
        } else {
            return $this->orderby('parent_menu')
                ->orderby('orden')
                ->get()
                ->toArray();
        }
        // return $this->join('menu_rolss','menu.id','=','menu_rol.parent_menu')
        // ->where('menu_rol.rol_id', 2)
        // ->orderby('menu.parent_menu')
        // ->orderby('menu.orden')
        // ->get()
        // ->toArray();
    }

    // public static function getMenu($front = false)
    // {
    //     $menus = new Menu();
    //     $padres = $menus->getPadres($front);
    //     $menuAll = [];
    //     foreach ($padres as $line) {
    //         if ($line['parent_menu'] != 0)
    //             break;
    //         $item = [array_merge($line, ['submenu' => $menus->getHijos($padres, $line)])];
    //         $menuAll = array_merge($menuAll, $item);
    //     }
    //     return $menuAll;
    // }
}
