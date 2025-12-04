<?php

namespace Tests\Feature\Api;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_notifications()
    {
        Notification::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/notifications');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_create_notification()
    {
        $data = [
            'type' => 'email',
            'channel' => 'email',
            'recipient' => 'test@example.com',
            'subject' => 'Test Notification',
            'message' => 'This is a test message',
            'service_name' => 'TestService',
        ];

        $response = $this->postJson('/api/v1/notifications', $data);

        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('notifications', $data);
    }

    public function test_can_show_notification()
    {
        $notification = Notification::factory()->create();

        $response = $this->getJson("/api/v1/notifications/{$notification->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $notification->id]);
    }

    public function test_can_mark_notification_as_read()
    {
        $notification = Notification::factory()->create(['read_at' => null]);

        $response = $this->patchJson("/api/v1/notifications/{$notification->id}/read");

        $response->assertStatus(200);

        $this->assertNotNull($notification->fresh()->read_at);
    }
}
