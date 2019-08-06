<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'silvinho85nic@gmail.com',
            'name' => 'Silvio E. Ramos',
            'password' => bcrypt('12345678')
        ]);
    }
}
