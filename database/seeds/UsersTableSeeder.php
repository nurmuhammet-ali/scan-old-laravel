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
        $users = $this->getUsers();

        foreach ($users as $user) {
            User::create($user);
        }
    }

    public function getUsers() 
    {
        return [[
            'name' => 'Nurmuhammet Allanov',
            'email' => 'nurmuhammetali2000@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('helloworld')
        ]];
    }
}
