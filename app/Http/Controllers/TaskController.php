<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Task;

class TaskController extends Controller
{

    private $validationRules = [
        'title' => 'required|string',
        'content' => 'required|string',
        'user_id' => 'required|integer'

    ];

    public function index(Request $request) {

        $me = Auth::user();

        $tasks = $me->tasksByOffset($request->offset);

        return response()->json(['success' => true,
                            'status' => $tasks], 200);
    }

    public function create(Request $request) {

        $this->validate($request, $this->validationRules);

        $task = Task::create($request->all());

        return response()->json(['success' => true,
            'status' => $task], 201);
    }

    public function update(Request $request) {

        $this->validate($request, $this->validationRules);

        if($task = Auth::user()->tasks->find($request->taskId)) {
            $task->update($request->all());

            return response()->json([], 204);
        }

        return response()->json(['success' => false,
            'status' => 404]);
    }

    public function show(Request $request) {

        if($task = Auth::user()->tasks->find($request->task)) {
            return response()->json(['success' => true,
                'status' => $task], 200);
        }

        return response()->json(['success' => false,
            'status' => 'Not found'], 404);
    }

    public function destroy(Request $request) {

        if($task = Auth::user()->tasks->find($request->task)) {
            $task->delete();

            return response()->json([], 204);
        }

        return response()->json(['success' => false,
            'status' => 'Not found'], 404);
    }
}
