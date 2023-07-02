<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'normal user',
                'email' => 'normal@user.com',
                'password' => 'password',
            ]
        );

        User::create(
            [
                'name' => 'admin user',
                'email' => 'adming@user.com',
                'password' => 'password',
            ]
        );
    }
}
