<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
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
}
