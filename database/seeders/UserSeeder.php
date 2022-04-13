<?php

namespace Database\Seeders;

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Support\Str;
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
        $users = [
            [
                'first_name' => 'John',
                'last_name' => "Doe",
                'email' => 'johndoe@gmail.com',
                'role' => UserRoles::SUPER_ADMIN,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ],
            [
                'first_name' => 'Bruce',
                'last_name' => "Lee",
                'email' => 'brucelee@gmail.com',
                'role' => UserRoles::ADMIN,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ],
            [
                'first_name' => 'Will',
                'last_name' => "Smith",
                'email' => 'willsmith@gmail.com',
                'role' => UserRoles::ADMINISTRATOR,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
