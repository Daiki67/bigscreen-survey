<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthController extends Controller
{
    /* public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'string|in:admin,user',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        if ($user && $token) {
            return response()->json([
                'message' => 'User registered successfully',
                'user' => new UserResource($user),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 201);
        } else {
            return response()->json([
                'message' => 'User registration failed'
            ], 500);
        }
    } */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        if ($user && $token) {
            return response()->json([
                'message' => 'User logged in successfully',
                'user' => new UserResource($user),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        } else {
            return response()->json([
                'message' => 'User login failed'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        // Récupère l'utilisateur authentifié via le token
        $user = $request->user();

        if ($user) {
            // Supprime le token d'accès personnel actuel utilisé pour cette requête
            $user->currentAccessToken()->delete();

            return response()->json(['message' => 'Déconnexion réussie.']);
        }

        return response()->json(['message' => 'Aucun utilisateur authentifié ou token valide.'], 401);
    }

    public function AuthAdmin() {
        if(Auth::check()){
            return response()->json([
                'authenticated' => true,
            ]);
        }

        return response()->json(['authenticated' => false]);

    }
    

}
