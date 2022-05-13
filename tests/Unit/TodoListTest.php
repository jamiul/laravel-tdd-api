<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_todo_can_has_many_tasks()
    {
        $todo = $this->createTodo();
        $task = $this->createTask(['todo_list_id' => $todo->id]);

        $this->assertInstanceOf(Collection::class, $todo->tasks);
        $this->assertInstanceOf(Task::class, $todo->tasks->first());
    }
}
