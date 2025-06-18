<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserController extends Controller
{
    public function checkUser()
    {
        if (Auth::check() && Auth::user()->is_user) {
            return response()->json(['message' => 'User is authenticated']);
        }

        return response()->json(['message' => 'User is not authenticated'], 401);
    }
}
