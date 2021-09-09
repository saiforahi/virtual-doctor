<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'Golam Kibria Papel',
            'email' => 'admin@gmail.com',
            'phone' => '01780208855',
            'gender' => 'Male',
            'age' => '30',
            'is_active' => 1,
            'password' => bcrypt('Admin@2020'),
        ]);
        $user=User::where('email','admin@mail.com')->first();
        $user->assignRole('Super-Admin');
    }
}