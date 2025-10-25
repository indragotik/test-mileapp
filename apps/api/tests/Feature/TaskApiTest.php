<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    public function test_unauthorized_access_returns_401()
    {
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_get_tasks()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer mocked.jwt.token.123'
        ])->getJson('/api/tasks');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data',
                    'meta' => [
                        'total',
                        'page',
                        'perPage'
                    ]
                ]);
    }

    public function test_can_create_task()
    {
        $taskData = [
            'title' => 'Test Task',
            'status' => 'open',
            'priority' => 1
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer mocked.jwt.token.123'
        ])->postJson('/api/tasks', $taskData);

        $response->assertStatus(201)
                ->assertJsonFragment($taskData);
    }

    public function test_task_validation_errors()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer mocked.jwt.token.123'
        ])->postJson('/api/tasks', []);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['title', 'status']);
    }

    public function test_can_update_task()
    {
        $updateData = [
            'title' => 'Updated Task',
            'status' => 'in_progress',
            'priority' => 2
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer mocked.jwt.token.123'
        ])->putJson('/api/tasks/1', $updateData);

        $response->assertStatus(200)
                ->assertJsonFragment(['id' => 1]);
    }

    public function test_can_delete_task()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer mocked.jwt.token.123'
        ])->deleteJson('/api/tasks/1');

        $response->assertStatus(200)
                ->assertJsonFragment(['deleted' => 1]);
    }
}
