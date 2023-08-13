<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return response()->json([
            'status' => 'sucess',
            'todos' => $todos
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()
            ]);
        } else {
            Todo::create($request->all());

            $todos = Todo::all();
            return response()->json([
                'status' => 'sucess',
                'todos' => $todos
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()
            ]);
        } else {
            $todo = Todo::find($request->id);
            if ($todo) {
                $todo->title = $request->title;
                $todo->save();
                return response()->json([
                    'status' => 'sucess',
                    'todos' => $todo
                ]);
            } else {
                return response()->json([
                    'message' => 'Todo not found'
                ]);
            }
        }
    }

    public function delete(Request $request)
    {
        $todo = Todo::find($request->id);
        if ($todo) {
            $todo->delete();
            return response()->json([
                'status' => 'sucess',
                'todos' => $todo
            ]);
        } else {
            return response()->json([
                'message' => 'Todo not found'
            ]);
        }
    }
}
