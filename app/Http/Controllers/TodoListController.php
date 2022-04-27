<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;

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
}
