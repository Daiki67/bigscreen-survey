<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Http\Resources\QuestionResource; // N'oubliez pas d'importer votre ressource
use Illuminate\Http\JsonResponse;

// Contrôleur pour la gestion des questions du sondage
class QuestionController extends Controller
{
    /**
     * Méthode index
     * Rôle : Affiche la liste de toutes les questions du sondage
     * Paramètres : Aucun
     * Retour : AnonymousResourceCollection contenant toutes les questions sous forme de ressources
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        // On récupère toutes les questions ordonnées par leur numéro
        $questions = Question::orderBy('order')->get();
        
        // Retourne une collection de QuestionResource
        return QuestionResource::collection($questions);
    }

    // Vous pouvez ajouter d'autres méthodes CRUD ici si vous en avez besoin pour l'admin :
    // show(Question $question), store(Request $request), update(Request $request, Question $question), destroy(Question $question)

    /**
     * Méthode show
     * Rôle : Affiche une question spécifique
     * Paramètres :
     *   - Question $question : l'instance de la question à afficher
     * Retour : QuestionResource ou JsonResponse avec la question demandée
     */
    public function show(Question $question): QuestionResource|JsonResponse
    {
        return new QuestionResource($question);
    }
}