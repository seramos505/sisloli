<?php

use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cliente')->insert([
            'nombre'=>'Cliente Vario'
        ]);
        DB::table('cliente')->insert([
            'nombre'=>'Maria Zoe',
            'tipo_documento' => 'cedula',
            'num_documento' => '041-120285-0002s',
            'direccion' => 'Gasolinera media Cuadra al este',
            'telefono' => '57572438',
            'email' => 'maria.zoe@gmail.com'
        ]);
    }
}
