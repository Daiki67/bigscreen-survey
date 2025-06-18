<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminController extends Controller
{
    /**
     * Check if the authenticated user is an admin.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAdmin()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return response()->json(['message' => 'User is an admin']);
        }

        return response()->json(['message' => 'User is not an admin'], 403);
    }
    /**
     * Middleware to ensure the user is authenticated.
     */
}
