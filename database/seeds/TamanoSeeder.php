<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TamanoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tamano = [
            '10 Onzas',
            '12 Onzas',
            '16 Onzas'   
        ];
        foreach($tamano as $key => $value){
            DB::table('tamano')->insert([
                'nombre' => $value,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
