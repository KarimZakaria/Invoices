<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    /*
    **
    Run the database seeds.
    *
    @return void
    */
    public function run()
    {
        $user = User::create([
            'name' => 'Karim Zakaria',
            'email' => 'karimzakaria345@gmail.com',
            'password' => bcrypt('123456'),
            'roles_name' => ['Owner'],
            'image' => '1.jpeg',
            'status' => 'مفعل'
        ]);
        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
