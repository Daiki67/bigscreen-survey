<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

// Contrôleur pour la gestion de l'authentification des utilisateurs
class AuthController extends Controller
{
    /*
     * Méthode register (commentée)
     * Rôle : Inscrire un nouvel utilisateur dans la base de données
     * Paramètres :
     *   - Request $request : la requête HTTP contenant les informations d'inscription
     * Retour : JsonResponse avec le nouvel utilisateur et le token d'accès
     */
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

    /**
     * Méthode login
     * Rôle : Authentifier un utilisateur avec email et mot de passe, et générer un token d'accès
     * Paramètres :
     *   - Request $request : la requête HTTP contenant les identifiants de connexion
     * Retour : JsonResponse avec l'utilisateur, le token d'accès, ou un message d'erreur
     */
    public function login(Request $request)
    {
        /* Validation des données envoyées dans la requête via la validation de laravel */
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        /* Message d'erreur envoyé si les informations envoyées dans la requête ne correspondent pas */
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        /* Récupération de l'utilisateur connecté et création de token (admin) */
        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        /* Vérification si l'utilisateur et le token ont été créés avec succès */
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

    /**
     * Méthode logout
     * Rôle : Déconnecter l'utilisateur en supprimant le token d'accès courant
     * Paramètres :
     *   - Request $request : la requête HTTP contenant l'utilisateur authentifié
     * Retour : JsonResponse avec un message de succès ou d'erreur
     */
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

    /**
     * Méthode AuthAdmin
     * Rôle : Vérifier si un administrateur est authentifié
     * Paramètres : Aucun
     * Retour : JsonResponse indiquant si l'utilisateur est authentifié ou non
     */
    public function AuthAdmin() {
        if(Auth::check()){
            return response()->json([
                'authenticated' => true,
            ]);
        }

        return response()->json(['authenticated' => false]);
    }
}
