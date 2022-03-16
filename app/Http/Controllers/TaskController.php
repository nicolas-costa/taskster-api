<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController
{
    public function index(Request $request): JsonResponse
    {
        $offset = $request->input('offset', 1);
        $me = Auth::user();

        $tasks = $me->tasksByOffset($offset);

        return response()
            ->json(
                [
                    'success' => true,
                    'status' => $tasks
                ]
            );
    }

    public function show(Request $request): JsonResponse
    {
        if($task = Auth::user()->tasks->find($request->task)) {
            return response()
                ->json(
                    [
                        'success' => true,
                        'status' => $task
                    ]
                );
        }

        return response()
            ->json(
                [
                    'success' => false,
                    'status' => 'Not found'
                ],
                404);
    }

    public function destroy(Request $request)
    {
        if($task = Auth::user()->tasks->find($request->task)) {

            $task->delete();

            return response()->json([], 204);
        }

        return response()
            ->json(
                [
                    'success' => false,
                    'status' => 'Not found'
                ],
                404);

    }
}
