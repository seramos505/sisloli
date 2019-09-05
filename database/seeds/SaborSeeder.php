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
            ['nombre'=>'LoliTropical','color'=>'#48cf2f'],
            ['nombre'=>'Dulce de Leche','color'=>'#48cf2f'],
            ['nombre'=>'Chocolate','color'=>'#48cf2f'],
            ['nombre'=>'Nancite','color'=>'#48cf2f'],
            ['nombre'=>'Tamarindo','color'=>'#48cf2f'],
            ['nombre'=>'Frambuesa','color'=>'#48cf2f'],
            ['nombre'=>'Piña','color'=>'#48cf2f'],
            ['nombre'=>'Coco','color'=>'#48cf2f'],
            ['nombre'=>'Fresa','color'=>'#48cf2f'],
            ['nombre'=>'Mamon','color'=>'#48cf2f'],
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
