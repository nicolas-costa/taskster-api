<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request,
            [
                'login' => 'required|string|max:255',
                'password' => 'required|string|max:255'
            ]
        );

        $credentials = $request->only(['login', 'password']);

        if(!$token = Auth::attempt($credentials)) {
            return response()
                ->json(
                    [
                        'success' => false,
                        'status' => 'Unauthorized'
                    ],
                    401
                );

        } else {
            return response()
                ->json(
                    [
                        'success' => true,
                        'token' => $token
                    ]
                );
        }
    }
}
