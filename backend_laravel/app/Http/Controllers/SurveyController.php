<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\SubmissionResource;

// Contrôleur pour la gestion du sondage (questions, réponses, soumissions)
class SurveyController extends Controller
{
    /**
     * Méthode index
     * Rôle : Affiche toutes les questions du sondage
     * Paramètres : Aucun
     * Retour : AnonymousResourceCollection contenant toutes les questions sous forme de ressources
     */
    public function index()
    {
        // On récupère toutes les questions ordonnées par leur numéro
        $questions = Question::orderBy('id')->get();

        // Retourne une collection de QuestionResource
        return QuestionResource::collection($questions);
    }

    /**
     * Méthode store
     * Rôle : Valide et enregistre les réponses du sondage
     * Paramètres :
     *   - Request $request : la requête HTTP contenant les réponses de l'utilisateur
     * Retour : JsonResponse avec le message, le token unique et les réponses enregistrées
     */
    public function store(Request $request)
    {
        $rules = [];
        // Récupération de toutes les questions
        $questions = Question::all();

        foreach ($questions as $question) {
            $rule = 'required';
            if($question->id === 1) {
                $rule = '|email';
            }
            $rules['answer.' .$question->id] = $rule;
        }

        try {
            $validateData = $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation échouée.',
                'errors' => $e->errors(),
            ], 422);
        }

        // Création d'une nouvelle soumission
        $submission = Submission::create([
            'url_token' => Str::uuid(), // Génération d'un jeton unique
        ]);

        // Création d'une nouvelle réponse pour chaque question
        $answers = [];
        foreach($questions as $question){
            $answers[] = Answer::create([
                'submission_id' => $submission->id,
                'question_id' => $question->id,
                'value' => $validateData['answer'][$question->id], // Récupération de la réponse de l'utilisateur
            ]);
        }

        return response()->json([
            'message' => 'Réponses validées avec succès.',
            'urlToken' => $submission->url_token,
            'data' => $answers,
        ],201);
    }

    /**
     * Méthode showResults
     * Rôle : Affiche les réponses d'un utilisateur via son jeton unique
     * Paramètres :
     *   - string $token : le jeton unique de la soumission
     * Retour : JsonResponse avec la ressource de soumission complète ou un message d'erreur
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
