<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_belongs_to_a_todo()
    {
        $todo = $this->createTodo();
        $task = $this->createTask(['todo_list_id' => $todo->id]);

        $this->assertInstanceOf(TodoList::class, $task->todo_list);
    }
}
