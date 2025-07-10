<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Http\Resources\SubmissionResource; // N'oubliez pas d'importer votre ressource
use Illuminate\Http\JsonResponse;
use App\Models\Answer; // Assurez-vous d'importer le modèle Answer
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    /**
     * Affiche la liste des soumissions avec pagination.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): JsonResponse
    {
        try {

            $lenghtSubmissions = Submission::all()->count();

            for ($i = 1; $i <= $lenghtSubmissions; $i++) {
                for ($j = 1; $j <= 20; $j++) { 
                    $answers[$i][$j] = $this->getAnswersByQuestionId($i, $j);
                }
            }
            // Retourne les soumissions paginées
            return response()->json([
                'DataAnswersQuestion' => $answers,
                'message' => 'Liste des soumissions récupérée avec succès.',
            ]);
        } catch (\Exception $e) {
            // En cas d'erreur, retourne une réponse JSON avec le message d'erreur
            return response()->json([
                'error' => 'Erreur lors de la récupération des soumissions : ' . $e->getMessage(),
            ], 500);
        }
    }


    private function getAnswersByQuestionId(int $submissionId, int $questionId)
    {
        // Récupère les réponses pour une question spécifique
        return Answer::where('submission_id', $submissionId)
            ->where('question_id', $questionId)
            ->select('value')
            ->get()
            ->map(function ($answer) {
                return $answer->value;
            });
    }
}
