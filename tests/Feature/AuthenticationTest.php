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
     * User can login into the system with email and password
     *
     * @return void
     */
    public function test_user_can_login_with_valid_email_and_password()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create(['role' => UserRoles::ADMIN]);
        });
        $response =  $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user, 'sanctum');
    }
    /**
     * User can not login the system with invalid email or password
     *
     * @return void
     */
    public function test_user_can_not_login_with_invalid_email_or_password()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create(['role' => UserRoles::ADMIN]);
        });
        $response =  $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => 'password1'
        ]);
        $response->assertStatus(401);
        $this->assertFalse(auth('sanctum')->check());
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

    /**
     * An unauthenticated user can not access protected routes
     *
     * @return void
     */

    public function test_unauthenticated_user_cannot_access_protected_routes()
    {
        $this->withoutExceptionHandling();

        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->postJson('/api/auth/logout'); //This route is protected with auth:api
    }
}
