<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskCompletedTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_task_status_can_be_changed()
    {
        $task = $this->createTask();

        $response = $this->patchJson(route('task.update', $task->id), ['status' => Task::STATUS_DONE]);

        $this->assertDatabaseHas('tasks', [
            'status' => Task::STATUS_DONE,
        ]);
    }
}
