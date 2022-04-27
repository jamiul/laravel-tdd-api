<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    private $todo;

    public function setUp(): void
    {
        parent::setUp();

        $this->todo =  TodoList::factory()->create([
            'name' => 'Todo 1',
        ]);
    }

    public function test_get_todo_list()
    {
        // preparation //prepare

        // action / perform
        $response = $this->getJson(route('todo-list.index'));

        // assertion / predict
        $this->assertEquals(1, count($response->json()));
        $this->assertEquals('Todo 1', $response->json()[0]['name']);
    }

    public function test_get_single_todo_list()
    {
        // preparation

        // action
        $response = $this->getJson(route('todo-list.show', $this->todo->id));

        // assertion
        $response->assertStatus(200);
        $this->assertEquals($response->json()[0]['name'], $this->todo->name);
    }
}
