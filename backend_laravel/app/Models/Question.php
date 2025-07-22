<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Modèle Eloquent pour la table 'questions'
// Représente une question du sondage
class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Les attributs pouvant être assignés en masse.
     *
     * Champs :
     *   - title (string)   : Titre de la question
     *   - type (string)    : Type de la question (A, B, C, ...)
     *   - options (array)  : Options de réponse possibles (null ou tableau)
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',    // string : titre de la question
        'type',     // string : type de la question
        'options',  // array|null : options de réponse
    ];

    /**
     * Les attributs à caster automatiquement.
     *
     * Champs :
     *   - options (array) : Les options sont stockées en JSON et castées en tableau
     */
    protected $casts = [
        'options' => 'array',
    ];

    /**
     * Relation : une question possède plusieurs réponses
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()  {
        return $this->hasMany(Answer::class);
    }

}
