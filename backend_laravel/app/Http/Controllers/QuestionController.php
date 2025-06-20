<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Http\Resources\QuestionResource; // N'oubliez pas d'importer votre ressource
use Illuminate\Http\JsonResponse;

class QuestionController extends Controller
{
    /**
     * Affiche la liste de toutes les questions du sondage.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
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

    // Exemple de méthode show pour une question spécifique
    /**
     * Affiche une question spécifique.
     *
     * @param  \App\Models\Question  $question
     * @return \App\Http\Resources\QuestionResource|\Illuminate\Http\JsonResponse
     */
    public function show(Question $question): QuestionResource|JsonResponse
    {
        return new QuestionResource($question);
    }
}