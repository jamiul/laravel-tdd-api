<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    public function index()
    {
        $todos = TodoList::all();
        return response()->json($todos);
    }

    public function show(TodoList $todo_list)
    {
        return response($todo_list);
    }

    public function store(TodoListRequest $request)
    {
        $todo = TodoList::create($request->all());

        return $todo;
    }

    public function destroy(TodoList $todo_list)
    {
        $todo_list->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }

    public function update(TodoListRequest $request, TodoList $todo_list)
    {
        $todo_list->update($request->all());

        return response($todo_list);
    }
}
