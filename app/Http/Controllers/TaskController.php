<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Task;

class TaskController
{

    public function index(Request $request) {

        $me = Auth::user();

        $tasks = $me->tasksByOffset($request->offset);

        return response()->json(['success' => true,
                            'status' => $tasks], 200);
    }

    public function show(Request $request) {

        $task = Auth::user()->tasks->find($request->task);

        return response()->json(['success' => true,
            'status' => $task], 200);
    }

}
