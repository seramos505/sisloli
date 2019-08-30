<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Menu;


class MenuController extends Controller
{
 
    public static function getMenu(Request $request)
    {
        $front = $request->front;
        $menus = new Menu();
        $padres = $menus->getPadres($front);
        $menuAll = [];
        foreach ($padres as $line) {
            if ($line['parent_menu'] != 0)
                break;
            $item = [array_merge($line, ['submenu' => $menus->getHijos($padres, $line)])];
            $menuAll = array_merge($menuAll, $item);
        }
        return $menuAll;
    }
}
