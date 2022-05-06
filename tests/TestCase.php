<?php

namespace Tests;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    public function createTodo($args = [])
    {
        return TodoList::factory()->create([
            'name' => $args['name'] ?? 'Todo 1',
        ]);
    }
}
