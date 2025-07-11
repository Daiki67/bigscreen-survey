<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Ressource API pour la représentation d'un utilisateur (User)
class UserResource extends JsonResource
{
    /**
     * Transforme la ressource en un tableau.
     * Rôle : Définir les champs retournés pour un utilisateur lors de la sérialisation JSON
     * Paramètres :
     *   - Request $request : la requête HTTP courante
     * Retour : array<string, mixed> Tableau associatif des champs à retourner
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, // Identifiant de l'utilisateur
            'name' => $this->name, // Nom de l'utilisateur
            'email' => $this->email, // Email de l'utilisateur
            'created_at' => $this->created_at, // Date de création
            'updated_at' => $this->updated_at, // Date de mise à jour
        ];
    }
}
