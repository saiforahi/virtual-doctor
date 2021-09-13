<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Appointment::create([
            'name'=> 'Neurology',
            'image'=>'neurology-2021-08-29-612b269112cf4.jpg'
        ]);
        \App\Models\Appointment::create([
            'name'=> 'Pathology',
            'image'=>'pathology-2021-08-29-612b277a22e01.jpg'
        ]);
    }
}