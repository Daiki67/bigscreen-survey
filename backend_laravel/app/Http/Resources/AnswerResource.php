<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Ressource API pour la représentation d'une réponse (Answer)
class AnswerResource extends JsonResource
{
    /**
     * Transforme la ressource en un tableau.
     * Rôle : Définir les champs retournés pour une réponse lors de la sérialisation JSON
     * Paramètres :
     *   - Request $request : la requête HTTP courante
     * Retour : array<string, mixed> Tableau associatif des champs à retourner
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id, // Identifiant de la réponse
            'submission_id' => $this->submission_id, // Identifiant de la soumission
            'question_id'   => $this->question_id, // Identifiant de la question
            'value'         => $this->value, // Valeur de la réponse
            'created_at'    => $this->created_at, // Date de création
            'updated_at'    => $this->updated_at, // Date de mise à jour
            // Pour inclure les relations, décommente si besoin :
            'submission'    => new SubmissionResource($this->whenLoaded('submission')), // Relation vers la soumission
            'question'      => new QuestionResource($this->whenLoaded('question')), // Relation vers la question
        ];
    }
}
