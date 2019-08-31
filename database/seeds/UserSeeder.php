<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Models\Admin\Menu;

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
            'password' => bcrypt('123'),
            'image' => 'silvio.jpg'
        ]);

        DB::table('users')->insert([
            'email' => 'mayra@gmail.com',
            'name' => 'Mayra Mendieta',
            'password' => bcrypt('123'),
            'image' => 'mayra.jpg'
        ]);

        DB::table('users')->insert([
            'email' => 'isis@gmail.com',
            'name' => 'Isis Romero',
            'password' => bcrypt('123'),
            'image' => 'avatar.jpg'
        ]);

        DB::table('users')->insert([
            'email' => 'vanesa@gmail.com',
            'name' => 'Vanesa',
            'password' => bcrypt('123'),
            'image' => 'avatar.jpg'
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

        Permission::create(['name' => 'listar-sabor']);
        Permission::create(['name' => 'nuevo-sabor']);
        Permission::create(['name' => 'editar-sabor']);
        Permission::create(['name' => 'desactivar-sabor']);
        Permission::create(['name' => 'activar-sabor']);

        Permission::create(['name' => 'listar-tamano']);
        Permission::create(['name' => 'nuevo-tamano']);
        Permission::create(['name' => 'editar-tamano']);
        Permission::create(['name' => 'desactivar-tamano']);
        Permission::create(['name' => 'activar-tamano']);

        Permission::create(['name' => 'listar-orden']);
        Permission::create(['name' => 'nuevo-orden']);
        Permission::create(['name' => 'ver-orden']);
        Permission::create(['name' => 'desactivar-orden']);


        $role = Role::create(['name' => 'administrador']);
        foreach (Permission::all() as $permission) {
            $role->givePermissionTo($permission->name);           
        }        
        $user=User::find(1);   
        $user->assignRole($role);


        $role = Role::create(['name' => 'vendedor']);
        $role->givePermissionTo('listar-producto');
        $role->givePermissionTo('listar-categoria');
        $role->givePermissionTo('listar-sabor');
        $role->givePermissionTo('listar-tamano');
        $role->givePermissionTo('listar-orden');
        $role->givePermissionTo('nuevo-orden');
        $role->givePermissionTo('ver-orden');
        $role->givePermissionTo('desactivar-orden');   
        
        $user=User::find(2);   
        $user->assignRole($role);

        //Menu Roles
        foreach (Menu::all() as $Menu) {            
            DB::table('menu_rol')->insert([
                'rol_id' => 1,
                'menu_id' => $Menu->id,                
            ]);          
        }
        // for ($i=1; $i <= 17 ; $i++) { 
        //     DB::table('menu_rol')->insert([
        //         'rol_id' => 1,
        //         'menu_id' => $i,                
        //     ]);
        // }
        DB::table('menu_rol')->insert([
            'rol_id' => 2,
            'menu_id' => 1,                
        ]);
        DB::table('menu_rol')->insert([
            'rol_id' => 2,
            'menu_id' => 6,                
        ]);
        DB::table('menu_rol')->insert([
            'rol_id' => 2,
            'menu_id' => 7,                
        ]);
        DB::table('menu_rol')->insert([
            'rol_id' => 2,
            'menu_id' => 8,                
        ]);
        DB::table('menu_rol')->insert([
            'rol_id' => 2,
            'menu_id' => 9,                
        ]);
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
