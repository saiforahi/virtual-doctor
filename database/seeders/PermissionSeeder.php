<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);
        Permission::create(['name' => 'read roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'read users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit companies']);
        Permission::create(['name' => 'delete companies']);
        Permission::create(['name' => 'read companies']);
        Permission::create(['name' => 'create companies']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'admin']);
        $role1->givePermissionTo('read roles');
        $role1->givePermissionTo('read users');
        $role1->givePermissionTo('read companies');

        $role2 = Role::create(['name' => 'moderator']);
        // $role2->givePermissionTo('publish articles');
        // $role2->givePermissionTo('unpublish articles');

        $role3 = Role::create(['name' => 'doctor']);
        $role4 = Role::create(['name' => 'patient']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Mr Admin',
            'email' => 'olsadev@gmail.com',
            'phone'=> '01XXXXXXXXX',
            'age' => '30',
            'is_active' => 1,
            'password' => Hash::make('123456'),
            'gender' => 'Male',
        ]);
        $user->assignRole($role1);

        // $user = \App\Models\User::factory()->create([
        //     'name' => 'Example Admin User',
        //     'email' => 'admin@example.com',
        // ]);
        // $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Mr Moderator',
            'email' => 'cse.hasan6@gmail.com',
            'phone'=> '01XXXXXXXXY',
            'age' => '30',
            'is_active' => 1,
            'password' => Hash::make('123456'),
            'gender' => 'Male',
        ]);
        \App\Models\Moderator::create([
            'user_id'=>$user->id,
        ]);
        $user->assignRole($role2);
        $user = \App\Models\User::factory()->create([
            'name' => 'Dr Hafiz',
            'email' => 'hafij.sabuj@gmail.com',
            'phone'=> '01737552551',
            'age' => '30',
            'image'=>'Mabia Mishu-2021-02-24-60362015aa588.jpg',
            'is_active' => 1,
            'password' => Hash::make('123456'),
            'gender' => 'Male',
        ]);
        \App\Models\Doctor::create([
            'user_id'=>$user->id,
            'department_id' => \App\Models\Department::where('name','Pathology')->first()->id
        ]);
        $user->assignRole($role3);
        $user = \App\Models\User::factory()->create([
            'name' => 'Shaif Azad',
            'email' => 'saiforahi@gmail.com',
            'phone'=> '01737552558',
            'age' => '30',
            'is_active' => 1,
            'password' => Hash::make('123456'),
            'gender' => 'Male',
        ]);
        \App\Models\Patient::create([
            'user_id'=>$user->id
        ]);
        $user->assignRole($role4);
    }
}