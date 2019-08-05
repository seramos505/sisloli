<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoria = [
            'Raspados',
            'Helados'   
        ];
        foreach($categoria as $key => $value){
            DB::table('categoria')->insert([
                'nombre' => $value,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
