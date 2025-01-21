<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::create([
            'name'          =>  "حسن السقا",
            'email'         =>  "hassan_alsakka@yahoo.com",
            'password'      =>  bcrypt('123456'),
            'user_status'   => 'active',
        ]);
        $superAdmin->attachRole('super_admin');

        $superAdmin = User::create([
            'name'          =>  "admin@share",
            'email'         =>  "admin@share.net.sa",
            'password'      =>  bcrypt('share@admin.net.sa'),
            'user_status'   => 'active',
        ]);
        $superAdmin->attachRole('super_admin');

        $superAdmin = User::create([
            'name'          =>  "جمعية البر",
            'email'         =>  "albir@albir.sa",
            'password'      =>  bcrypt('123456'),
            'user_status'   => 'active',
        ]);
        $superAdmin->attachRole('super_admin');
    }
}
