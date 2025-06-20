<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\SubmissionResource;

class SurveyController extends Controller
{
    /**
     * Affiche toutes les questions du sondage.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        // On récupère toutes les questions ordonnées par leur numéro
        $questions = Question::orderBy('id')->get();

        // Retourne une collection de QuestionResource
        return QuestionResource::collection($questions);
    }

    /**
     * Affiche les réponses d'un utilisateur via son jeton unique.
     *
     * @param  string  $token
     * @return \App\Http\Resources\SubmissionResource|\Illuminate\Http\JsonResponse
     */
    public function showResults(string $token)
    {
        // Récupère la soumission via le token, ou renvoie une erreur 404 si non trouvée
        $submission = Submission::where('url_token', $token)->first();

        if (!$submission) {
            return response()->json(['message' => 'Sondage non trouvé.'], 404);
        }

        // On charge les réponses et les questions associées pour optimiser les requêtes
        // 'answers.question' permet de charger les questions liées à chaque réponse
        $submission->load('answers.question');

        // Retourne la ressource de soumission complète
        return response()->json([
            'message' => 'Résultats du sondage récupérés avec succès.',
            'submission' => new SubmissionResource($submission),
        ]);
    }
}
