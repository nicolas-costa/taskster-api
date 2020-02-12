<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController
{

    public function index(Request $request) {

        $me = Auth::user();

        $tasks = $me->tasksByOffset($request->offset);

        return response()->json(['success' => true,
                            'status' => $tasks]);
    }
}
