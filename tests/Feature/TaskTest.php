<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_all_task_of_a_todo_list()
    {
        $list = $this->createTodo();
        $task = $this->createTask(['todo_list_id' => $list->id]);
        $this->createTask(['todo_list_id' => 2]);

        $response = $this->getJson(route('todo-list.task.index', $list->id))->assertOk()->json();

        $this->assertEquals(1, count($response));
        $this->assertEquals($task->title, $response[0]['title']);
        $this->assertEquals($response[0]['todo_list_id'], $list->id);
    }

    public function test_store_a_task_for_a_todo_list()
    {
        $todo = $this->createTodo();
        $task = Task::factory()->make();

        $this->postJson(route('todo-list.task.store', $todo->id), [
            'title' => $task->title
        ])->assertCreated();

        $this->assertDatabaseHas('tasks', [
            'title' => $task->title,
            'todo_list_id' => $todo->id
        ]);
    }

    public function test_delete_a_task_from_database()
    {
        $task = $this->createTask();

        $response = $this->deleteJson(route('task.destroy', $task->id))->assertNoContent();

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_update_a_task_of_a_todo()
    {
        $task = $this->createTask();

        $response = $this->patchJson(route('task.update', $task->id), ['title' => 'New title'])->assertOk();

        $this->assertDatabaseHas('tasks', ['title' => 'New title']);
    }
}
