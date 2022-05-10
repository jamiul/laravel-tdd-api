<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_all_task_of_a_todo_list()
    {
        // prearation
        $task = $this->createTask();

        // action
        $response = $this->getJson(route('task.index'))->assertOk()->json();

        // assertion
        $this->assertEquals(1, count($response));
        $this->assertEquals($task->title, $response[0]['title']);
    }

    public function test_store_a_task_for_a_todo_list()
    {
        $task = Task::factory()->make();

        $response = $this->postJson(route('task.store'), [
            'title' => $task->title
        ])->assertOk()->json();

        $this->assertDatabaseHas('tasks', ['title' => $task->title]);
    }

    public function test_delete_a_task_from_database()
    {
        $task = $this->createTask();

        $response = $this->deleteJson(route('task.destroy', $task->id))->assertNoContent();

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
