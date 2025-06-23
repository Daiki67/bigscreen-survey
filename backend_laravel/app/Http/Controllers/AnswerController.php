<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Http\Resources\SubmissionResource; // N'oubliez pas d'importer votre ressource
use Illuminate\Http\JsonResponse;
use App\Models\Answer; // Assurez-vous d'importer le modèle Answer
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
            for ($i = 1; $i <= 20; $i++) {
                $answers[$i] = $this->getAnswersByQuestionId($i);
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
    

    private function getAnswersByQuestionId(int $questionId)
    {
        // Récupère les réponses pour une question spécifique
        return Answer::where('question_id', $questionId)
            ->whereNotNull('submission_id')
            ->select('value', DB::raw('COUNT(*) as count'))
            ->groupBy('value')
            ->get()
            ->map(function ($answer) {
                return $answer->value . ' (' . $answer->count . ')';
            });
    }
}
