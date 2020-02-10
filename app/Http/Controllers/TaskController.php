<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Task;

class TaskController
{

    public function index(Request $request) {

        $me = Auth::user();

        $tasks = Task::getByOffset($request->offset, $me->id);

        return response()->json(['success' => true,
                            'status' => $tasks]);
    }
}
