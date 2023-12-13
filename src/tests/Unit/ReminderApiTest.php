<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

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
}
