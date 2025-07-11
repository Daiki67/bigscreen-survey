<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Ressource API pour la représentation d'une question (Question)
class QuestionResource extends JsonResource
{
    /**
     * Transforme la ressource en un tableau.
     * Rôle : Définir les champs retournés pour une question lors de la sérialisation JSON
     * Paramètres :
     *   - Request $request : la requête HTTP courante
     * Retour : array<string, mixed> Tableau associatif des champs à retourner
     */
    public function toArray($request)
    {
        return [
            'id'      => $this->id, // Identifiant de la question
            'title'   => $this->title, // Titre de la question
            'type'    => $this->type, // Type de la question (A, B, C, ...)
            'body'    => $this->body, // Corps/texte de la question
            'options' => $this->options, // Options de réponse (si applicable)
            'created_at' => $this->created_at, // Date de création
            'updated_at' => $this->updated_at, // Date de mise à jour
            // Pour inclure les réponses associées, décommente si besoin :
            'answers' => AnswerResource::collection($this->whenLoaded('answers')), // Collection des réponses associées
        ];
    }
}
