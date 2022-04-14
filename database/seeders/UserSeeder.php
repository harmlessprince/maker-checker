<?php

namespace Database\Seeders;

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

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
                'role' => UserRoles::ADMIN,
                'email_verified_at' => now(),
                'password' =>  Hash::make('password'),
                'remember_token' => Str::random(10),
            ],
            [
                'first_name' => 'Bruce',
                'last_name' => "Lee",
                'email' => 'brucelee@gmail.com',
                'role' => UserRoles::ADMIN,
                'email_verified_at' => now(),
                'password' =>  Hash::make('password'),
                'remember_token' => Str::random(10),
            ],
            [
                'first_name' => 'Will',
                'last_name' => "Smith",
                'email' => 'willsmith@gmail.com',
                'role' => UserRoles::USER,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]
        ];
        foreach ($users as $user) {
            if ($user['role'] != UserRoles::USER) {
                $newUser = new User($user);
                $newUser->saveQuietly();
            } else {
                if (!App::isProduction()) {
                    User::create($user);
                }
            }
        }
    }
}
