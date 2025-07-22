<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Modèle Eloquent pour la table 'users'
// Représente un utilisateur de l'application (admin ou simple utilisateur)
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Les attributs pouvant être assignés en masse.
     *
     * Champs :
     *   - name (string)     : Nom de l'utilisateur
     *   - email (string)    : Adresse email de l'utilisateur
     *   - password (string) : Mot de passe de l'utilisateur (hashé)
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',     // string : nom de l'utilisateur
        'email',    // string : email de l'utilisateur
        'password', // string : mot de passe (hashé)
    ];

    /**
     * Les attributs à masquer lors de la sérialisation.
     *
     * Champs :
     *   - password (string)        : Mot de passe (jamais exposé)
     *   - remember_token (string)  : Jeton de session (jamais exposé)
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',        // string : mot de passe
        'remember_token',  // string : jeton de session
    ];

    /**
     * Les attributs à caster automatiquement.
     *
     * Champs :
     *   - email_verified_at (datetime) : Date de vérification de l'email
     *   - password (hashed)           : Mot de passe hashé
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // date de vérification de l'email
            'password' => 'hashed',           // mot de passe hashé
        ];
    }
}
