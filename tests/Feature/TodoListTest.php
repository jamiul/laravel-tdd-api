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

    public function test_store_new_todo()
    {
        // preparation
        $todo = TodoList::factory()->make(); // make factory does not save to database

        // action
        $response = $this->postJson(route('todo-list.store'), ['name' => $todo->name])
            ->assertCreated()
            ->json();

        // assertion
        $this->assertEquals($todo->name, $response['name']);
        $this->assertDatabaseHas('todo_lists', ['name' =>  $todo->name]);
    }

    public function test_todo_list_required_name_field()
    {
        $this->withExceptionHandling();

        $this->postJson(route('todo-list.store'))
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name');
    }

    public function test_delete_todo()
    {
        $this->deleteJson(route('todo-list.destroy', $this->todo->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('todo_lists', ['name' => $this->todo->name]);
    }

    public function test_update_todo()
    {
        $this->patchJson(route('todo-list.update', $this->todo->id), ['name' => 'updated todo lsit'])
            ->assertOk();

        $this->assertDatabaseHas('todo_lists', ['name' => $this->todo->name]);
    }

    public function test_todo_name_field_required_while_updating()
    {
        $this->withExceptionHandling();

        $this->patchJson(route('todo-list.update', $this->todo->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }
}
