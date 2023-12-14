<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Reminder;

class ReminderApiTest extends TestCase
{
    public function testUserCanCreateSession()
    {
        $response = $this->postJson('/api/session', [
            'email' => 'alice@mail.com',
            'password' => '123456',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['ok', 'data']);
    }

    public function testUserCanAccessProtectedRoute()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson('/api/session');

        $response->assertStatus(200)
            ->assertJsonStructure(['ok', 'data']);
    }

    public function testUserCanCreateReminder()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/reminders', [
            'title' => 'Meeting with tiga',
            'description' => 'Discuss about new project related to new system tiga',
            'remind_at' => 1801246725,
            'event_at' => 1801223205,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(["data" => ['id', 'title', 'description', 'remind_at', 'event_at']]);
    }

    public function testUserCanListReminders()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/reminders?limit=5');

        $response->assertStatus(200)
            ->assertJsonStructure(["data" => ['reminders', 'limit']]);
    }

    public function testUserCanViewReminder()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $reminder = Reminder::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/reminders/' . $reminder->id);

        $response->assertStatus(200)
            ->assertJson(["ok" => true, "data" => ['id' => $reminder->id, 'title' => $reminder->title]]);
    }

    public function testUserCanUpdateReminder()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $reminder = Reminder::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson('/api/reminders/' . $reminder->id, [
            'title' => 'Meeting with Wewe edit 6',
            'description' => 'Discuss about new project related to new system again edit 6',
            'remind_at' => 1901246768,
            'event_at' => 1901223506,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                "ok" => true,
                "data" => [
                    'id' => $reminder->id,
                    'title' => 'Meeting with Wewe edit 6',
                    'description' => 'Discuss about new project related to new system again edit 6',
                    'remind_at' => 1901246768,
                    'event_at' => 1901223506,
                ]
            ]);
    }

    public function testUserCanDeleteReminder()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $reminder = Reminder::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/reminders/' . $reminder->id);

        $response->assertStatus(200);

        $this->deleteJson($reminder);
    }
}
