<?php

namespace Tests\Feature;

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase, WithFaker, DatabaseMigrations;
    /**
     * User can login into the system
     *
     * @return void
     */
    public function test_user_can_login_with_sanctum_token()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create(['role' => UserRoles::ADMIN]);
        });
        Sanctum::actingAs($user);
        $this->assertAuthenticatedAs($user, 'sanctum');
    }

    /**
     * User can logout into the system
     *
     * @return void
     */
    public function test_user_can_logout_with_sanctum_token()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create(['role' => UserRoles::ADMIN]);
        });
        Sanctum::actingAs($user);
        $this->postJson('api/auth/logout')->assertOk();
    }

    /**
     * An authenticated admin can register new user
     *
     * @return void
     */
    public function test_admin_can_register_new_user()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create(['role' => UserRoles::ADMIN]);
        });
        Sanctum::actingAs($user);
        $response =  $this->postJson('api/auth/register', [
            'email' => 'testuser@gamil.com',
            'password' => 'testuser',
            'role' => 'admin',
            'first_name' => 'test',
            'last_name' => 'user',
        ]);
        $response->assertCreated();
        $this->assertDatabaseCount('users', 2);
    }
}
