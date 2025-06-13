<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => UserRoleEnum::ADMIN,
        ]);

        User::create([
            'photo' => 'foto-marketing/default.jpg',
            'name' => 'Marketing',
            'phone' => '6285933450505',
            'email' => 'marketing@gmail.com',
            'password' => bcrypt('password'),
            'role' => UserRoleEnum::MARKETING,
        ]);
    }
}
