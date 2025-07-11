<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Modèle Eloquent pour la table 'answers'
// Représente une réponse à une question d'un sondage
class Answer extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Les attributs pouvant être assignés en masse.
     *
     * Champs :
     *   - submission_id (int) : Clé étrangère vers la table 'submissions', identifie la soumission liée
     *   - question_id (int)   : Clé étrangère vers la table 'questions', identifie la question liée
     *   - value (string|int)  : Valeur de la réponse donnée par l'utilisateur
     *
     * @var list<string>
     */
    protected $fillable = [
        'submission_id',
        'question_id',
        'value',
    ];  

    /**
     * Relation : une réponse appartient à une soumission
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function submission() { 
        return $this->belongsTo(Submission::class); 
    }

    /**
     * Relation : une réponse appartient à une question
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question() {  
        return $this->belongsTo(Question::class);
    }

}
