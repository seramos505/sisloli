<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SaborSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sabores = [
            ['nombre'=>'LoliTropical','color'=>'#00755e'],
            ['nombre'=>'Dulce de Leche','color'=>'#603d02'],
            ['nombre'=>'Chocolate','color'=>'#45322e'],
            ['nombre'=>'Nancite','color'=>'#faed27'],
            ['nombre'=>'Tamarindo','color'=>'#4e3b31'],
            ['nombre'=>'Frambuesa','color'=>'#c51d34'],
            ['nombre'=>'Piña','color'=>'#f2e8cc'],
            ['nombre'=>'Coco','color'=>'#9a8c84'],
            ['nombre'=>'Fresa','color'=>'#ff0080'],
            ['nombre'=>'Mamon','color'=>'#ff8000'],
            ['nombre'=>'Limon','color'=>'#48cf2f']
        ];
        foreach($sabores as $sabor){
            DB::table('sabor')->insert([
                'nombre' => $sabor["nombre"],
                'color' => $sabor["color"],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
