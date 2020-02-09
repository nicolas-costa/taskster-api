<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request) {

        $this->validate($request, [
            'login' => 'required:string',
            'password' => 'required:string'
        ]);

        if(!$token = Auth::attempt($request->only(['login', 'password']))) {
            return response()->json(['success' => false,
                'status' => 'Unauthorized'], 401);

        } else {
            return response()->json(['success' => true,
                'token' => $token], 200);
        }
    }
}
