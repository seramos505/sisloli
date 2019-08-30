<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

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
            'password' => bcrypt('12345678'),
            'image' => 'user2-160x160.jpg'
        ]);

        DB::table('users')->insert([
            'email' => 'mayra@gmail.com',
            'name' => 'Mayra Mendieta',
            'password' => bcrypt('12345678'),
            'image' => 'avatar3.png'
        ]);

        Permission::create(['name' => 'listar-producto']);
        Permission::create(['name' => 'nuevo-producto']);
        Permission::create(['name' => 'editar-producto']);
        Permission::create(['name' => 'desactivar-producto']);
        Permission::create(['name' => 'activar-producto']);

        Permission::create(['name' => 'listar-categoria']);
        Permission::create(['name' => 'nuevo-categoria']);
        Permission::create(['name' => 'editar-categoria']);
        Permission::create(['name' => 'desactivar-categoria']);
        Permission::create(['name' => 'activar-categoria']);


        $role = Role::create(['name' => 'administrador']);
        $role->givePermissionTo('listar-producto');
        $role->givePermissionTo('nuevo-producto');
        $role->givePermissionTo('editar-producto');
        $role->givePermissionTo('desactivar-producto');
        $role->givePermissionTo('activar-producto');
        
        $user=User::find(1);   
        $user->assignRole($role);

        $role = Role::create(['name' => 'vendedor']);
        $role->givePermissionTo('listar-producto');
        $role->givePermissionTo('listar-categoria');
        
        $user=User::find(2);   
        $user->assignRole($role);

        //Menu Roles
        for ($i=1; $i <= 17 ; $i++) { 
            DB::table('menu_rol')->insert([
                'rol_id' => 1,
                'menu_id' => $i,                
            ]);
        }
        DB::table('menu_rol')->insert([
            'rol_id' => 2,
            'menu_id' => 2,                
        ]);
        DB::table('menu_rol')->insert([
            'rol_id' => 2,
            'menu_id' => 10,                
        ]);

    }
}
