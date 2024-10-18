<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $loginInfo = ['isLogin' => false];
        if ($admin = auth()->admin()) {
            $loginInfo = [
                'isLogin' => true,
                'id' => $admin->id,
                'email' => 'admin@gmail.com',
                'name' => 'admin'
            ];
        }

        return response()->json($loginInfo);
    }
}
