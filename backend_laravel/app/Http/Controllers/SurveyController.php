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
     * Valide et enregistre les réponses du sondage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [];
        //Recupération de toutes les questions
        $questions = Question::all();

        // Vérification que l'utilisateur a répondu à toutes les questions
        /* if (!$questions) {
            return response()->json([
                'message' => 'Aucune question trouvée.',
            ], 404);
        }
        else {
            return response()->json([
                'message' => 'Questions trouvées avec succès.',
            ]);
        } */

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
            'url-token' => $submission->url_token,
            'data' => $answers,
        ],201);

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
