<?php

namespace Tests\Feature;

use App\Enums\UserRoles;
use App\Models\Approval;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApprovalTest extends TestCase
{
    use RefreshDatabase, WithFaker, DatabaseMigrations;
    /**
     *
     * @return void
     */
    public function test_create_operation_is_not_been_persisted_in_users_table()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        Sanctum::actingAs($user);
        User::factory()->create();
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('approvals', 1);
    }

    /**
     *
     * @return void
     */
    public function test_admin_can_create_a_user_data_for_approval()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        Sanctum::actingAs($user);
        $response =  $this->postJson('api/users', [
            'email' => 'testuser@gamil.com',
            'password' => 'testuser',
            'role' => 'admin',
            'first_name' => 'test',
            'last_name' => 'user',
        ]);
        $response->assertOk();
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('approvals', 1);
    }

    /**
     *
     * @return void
     */
    public function test_an_admin_can_approve_pending_request_that_was_not_initiated_by_him()
    {
        $admins = User::withoutEvents(function () {
            $admin1 = User::factory()->create();
            $admin2 =  User::factory()->create();
            return compact('admin1', 'admin2');
        });
        Sanctum::actingAs($admins['admin1']);
        User::factory()->create();
        $this->assertDatabaseCount('approvals', 1);
        Sanctum::actingAs($admins['admin2']);
        $approval = Approval::first();
        $response =  $this->patchJson('api/requests/approve/' . $approval->id);
        $response->assertOk();
        $this->assertDatabaseCount('users', 3);
        
    }
     /**
     *
     * @return void
     */
    public function test_an_admin_can_not_approve_pending_request_that_was_initiated_by_him()
    {
        $admins = User::withoutEvents(function () {
            $admin1 = User::factory()->create();
            $admin2 =  User::factory()->create();
            return compact('admin1', 'admin2');
        });
        Sanctum::actingAs($admins['admin1']);
        User::factory()->create();
        $this->assertDatabaseCount('approvals', 1);
        $approval = Approval::first();
        $response =  $this->patchJson('api/requests/approve/' . $approval->id);
        $response->assertStatus(403);
        $this->assertDatabaseCount('users', 2);
        
    }

     /**
     *
     * @return void
     */
    public function test_an_admin_can_decline_pending_request_that_was_not_initiated_by_him()
    {
        $admins = User::withoutEvents(function () {
            $admin1 = User::factory()->create();
            $admin2 =  User::factory()->create();
            return compact('admin1', 'admin2');
        });
        Sanctum::actingAs($admins['admin1']);
        User::factory()->create();
        $this->assertDatabaseCount('approvals', 1);
        Sanctum::actingAs($admins['admin2']);
        $approval = Approval::first();
        $response =  $this->patchJson('api/requests/decline/' . $approval->id);
        $response->assertOk();
        $this->assertDatabaseCount('users', 2);
        
    }

    /**
     *
     * @return void
     */
    public function test_an_admin_can_not_decline_pending_request_that_was_initiated_by_him()
    {
        $admins = User::withoutEvents(function () {
            $admin1 = User::factory()->create();
            $admin2 =  User::factory()->create();
            return compact('admin1', 'admin2');
        });
        Sanctum::actingAs($admins['admin1']);
        User::factory()->create();
        $this->assertDatabaseCount('approvals', 1);
        $approval = Approval::first();
        $response =  $this->patchJson('api/requests/decline/' . $approval->id);
        $response->assertStatus(403);
        $this->assertDatabaseCount('users', 2);
        
    }
}
