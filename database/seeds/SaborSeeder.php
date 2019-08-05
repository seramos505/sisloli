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
        $sabor = [
            'LoliTropical',
            'Dulce de Leche',
            'Chocolate',
            'Nancite',
            'Tamarindo',
            'Frambuesa',
            'Piña',
            'Coco',
            'Fresa',          
            'Mamon',
            'Limon'

        ];
        foreach($sabor as $key => $value){
            DB::table('sabor')->insert([
                'nombre' => $value,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
