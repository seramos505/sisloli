<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTablas([
            'categoria',
            'sabor',
            'tamano',
            'producto',
            'users',
            'menu',
            'cliente',
            'orden',
            'orden_detalle'
        ]); 
        $this->call(SaborSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(TamanoSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(ClienteSeeder::class);         
    }

    protected function truncateTablas(array $tablas)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        foreach ($tablas as $tabla) {
            DB::table($tabla)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
