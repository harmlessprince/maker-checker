<?php

namespace Tests\Feature;

use App\Events\ApprovalSubmittedEvent;
use App\Listeners\ApprovalSubmittedListener;
use App\Models\Approval;
use App\Models\User;
use App\Notifications\RequestSubmittedNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApprovableTraitTest extends TestCase
{
    use RefreshDatabase, WithFaker, DatabaseMigrations;
    /**
     *
     * @return void
     */
    public function test_prevent_duplicate_request_submitting()
    {

        $users = User::withoutEvents(function () {
            $user1 = User::factory()->create();
            $user2 =  User::factory()->create();
            $user3 = User::factory()->create();
            return compact('user1', 'user2', 'user3');
        });
        Sanctum::actingAs($users['user1']);
        $user = User::find($users['user3']->id);
        $response = $this->patchJson('api/users/' . $user->id, [
            'email' => 'test@gmail.com'
        ]);
        $response->assertOk();
        $response = $this->patchJson('api/users/' . $user->id, [
            'email' => 'test@gmail.com'
        ]);
        $response->assertStatus(409);
    }

    /**
     *
     * @return void
     */
    public function test_approval_submitted_event_is_dispatched()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        Sanctum::actingAs($user);
        User::factory()->create();
        $approval =  Approval::get()->first();
        Event::fake();
        ApprovalSubmittedEvent::dispatch($approval);
        Event::assertDispatched(ApprovalSubmittedEvent::class);
    }
    /**
     *
     * @return void
     */
    public function test_approval_submitted_notification_is_sent()
    {
        $user = User::withoutEvents(function () {
            User::factory()->create();
            User::factory()->create();
            return User::factory()->create();
        });
        Sanctum::actingAs($user);
        // Sanctum::actingAs($users['user1']);
        User::factory()->create();
        $approval =  Approval::get()->first();
        Notification::fake();
        $event = new ApprovalSubmittedEvent($approval);
        $listener = new ApprovalSubmittedListener();
        $listener->handle($event);
        $users = User::where('id', '<>', auth()->id())->get();
        Notification::assertSentTo($users , RequestSubmittedNotification::class);
    }
}
