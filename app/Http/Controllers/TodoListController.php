<?php

namespace App\Http\Controllers;

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

    public function show(TodoList $todo)
    {
        return response()->json([$todo]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $todo = TodoList::create($request->all());

        return $todo;
    }

    public function destroy(TodoList $todo)
    {
        $todo->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }

    public function update(Request $request, TodoList $todo)
    {
        $request->validate([
            'name' => ['required']
        ]);

        $todo->update($request->all());

        return response($todo);
    }
}
