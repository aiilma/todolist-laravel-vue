<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testIndex()
    {
        Task::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'total_tasks_count',
                    'tasks' => [
                        '*' => ['id', 'title', 'description', 'status', 'deadline']
                    ]
                ]
            ]);
    }

    public function testIndexWithStatusFilter()
    {
        Task::factory()->create(['user_id' => $this->user->id, 'status' => \App\Enums\TaskStatus::NEW->value]);
        Task::factory()->create(['user_id' => $this->user->id, 'status' => \App\Enums\TaskStatus::COMPLETED->value]);

        $response = $this->getJson('/api/tasks?status=' . \App\Enums\TaskStatus::NEW->value);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.tasks')
            ->assertJsonFragment(['status' => \App\Enums\TaskStatus::NEW->value]);
    }

    public function testIndexWithDeadlineFilter()
    {
        Task::factory()->create(['user_id' => $this->user->id, 'deadline' => now()->addDays(1)]);
        Task::factory()->create(['user_id' => $this->user->id, 'deadline' => now()->addDays(10)]);

        $response = $this->getJson('/api/tasks?deadline=' . now()->addDays(5)->toDateString());

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.tasks')
            ->assertJsonFragment(['deadline' => now()->addDays(1)->format('Y-m-d H:i:s')]);
    }

    public function testStore()
    {
        $taskData = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => \App\Enums\TaskStatus::NEW->value,
            'deadline' => now()->addDays(7)->toDateString(),
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201)
            ->assertJsonFragment($taskData);
    }

    public function testShow()
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'deadline' => now()->addDays(7)
        ]);
//        dump($task->deadline);

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'deadline' => $task->deadline ? $task->deadline->format('Y-m-d H:i:s') : null,
            ]);
    }

    public function testUpdate()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $updatedData = [
            'title' => 'Updated Task',
            'description' => 'Updated Description',
            'status' => \App\Enums\TaskStatus::COMPLETED->value,
            'deadline' => now()->addDays(10)->toDateString(),
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
    }

    public function testDestroy()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
