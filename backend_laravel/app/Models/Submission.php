<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Modèle Eloquent pour la table 'submissions'
// Représente une soumission de réponses à un sondage
class Submission extends Model
{
    /** @use HasFactory<\Database\Factories\SubmissionFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Les attributs pouvant être assignés en masse.
     *
     * Champs :
     *   - url_token (string) : Jeton unique permettant d'identifier la soumission
     *
     * @var list<string>
     */
    protected $fillable = [
        'url_token', // string : jeton unique de la soumission
    ];

    /**
     * Relation : une soumission possède plusieurs réponses
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers() { 
        return $this->hasMany(Answer::class); 
    }
}
