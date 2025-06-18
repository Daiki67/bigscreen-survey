<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        
    }
    public function show($id)
    {
        // Logic to retrieve and return a specific user by ID
    }
    public function store(Request $request)
    {
        // Logic to create a new user
    }
    public function update(Request $request, $id)
    {
        // Logic to update an existing user by ID
    }
    public function destroy($id)
    {
        // Logic to delete a user by ID
    }
    /* public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    } */
}
