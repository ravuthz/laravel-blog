<?php

use Illuminate\Database\Seeder;

use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAuthor = Role::create(['name' => 'author']);
        $roleEditor = Role::create(['name' => 'editor']);

        $pCreate = Permission::create(['name' => 'create posts']);
        $pRead = Permission::create(['name' => 'read posts']);
        $pUpdate = Permission::create(['name' => 'update posts']);
        $pDelete = Permission::create(['name' => 'delete posts']);
        
        
        $roleAdmin->givePermissionTo($pCreate);
        $roleAdmin->givePermissionTo($pRead);
        $roleAdmin->givePermissionTo($pUpdate);
        $roleAdmin->givePermissionTo($pDelete);
        
        $roleAuthor->givePermissionTo($pCreate, $pRead);
        
        $roleEditor->givePermissionTo($pRead, $pUpdate);

        // $pCreate->assignRole($roleAuthor);
        // $pRead->assignRole($roleAuthor);
        // $pUpdate->assignRole($roleAuthor);
        // $pDelete->assignRole($roleAuthor);
        
        $admin = User::create([
            'name' => 'adminz', 
            'email' => 'adminz@gmail.com', 
            'password' => bcrypt('123123')
        ]);
        $admin->assignRole('admin');
        
        $author = User::create([
            'name' => 'author', 
            'email' => 'author@gmail.com',
            'password' => bcrypt('123123')
        ]);
        $author->assignRole('author');
        
         $editor = User::create([
            'name' => 'editor', 
            'email' => 'editor@gmail.com',
            'password' => bcrypt('123123')
        ]);
        $editor->assignRole('editor');
        
    }
}
