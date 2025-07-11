<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Ressource API pour la représentation d'une soumission (Submission)
class SubmissionResource extends JsonResource
{
    /**
     * Transforme la ressource en un tableau.
     * Rôle : Définir les champs retournés pour une soumission lors de la sérialisation JSON
     * Paramètres :
     *   - Request $request : la requête HTTP courante
     * Retour : array<string, mixed> Tableau associatif des champs à retourner
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id, // Identifiant de la soumission
            'url_token' => $this->url_token, // Jeton unique de la soumission
            'created_at'=> $this->created_at, // Date de création
            'updated_at'=> $this->updated_at, // Date de mise à jour
            // Pour inclure les réponses associées, décommente si besoin :
            'answers' => AnswerResource::collection($this->whenLoaded('answers')), // Collection des réponses associées
        ];
    }
}
