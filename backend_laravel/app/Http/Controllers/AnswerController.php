<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use App\Models\Answer; // Assurez-vous d'importer le modèle Answer

// Contrôleur pour la gestion des réponses (answers)
class AnswerController extends Controller
{
    /**
     * Méthode index
     * Rôle : Affiche la liste des soumissions avec les réponses à chaque question.
     * Paramètres : Aucun
     * Retour : JsonResponse contenant toutes les réponses par soumission et par question
     */
    public function index(): JsonResponse
    {
        try {
            // Nombre total de soumissions
            $lenghtSubmissions = Submission::all()->count();

            // Tableau pour stocker les réponses par soumission et par question
            for ($i = 1; $i <= $lenghtSubmissions; $i++) {
                for ($j = 1; $j <= 20; $j++) {
                    // Appel de la méthode getAnswersByQuestionId pour chaque couple (soumission, question)
                    $answers[$i][$j] = $this->getAnswersByQuestionId($i, $j);
                }
            }
            // Retourne les réponses sous forme de JSON
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

    /**
     * Méthode getAnswersByQuestionId
     * Rôle : Récupère les réponses pour une question spécifique d'une soumission donnée.
     * Paramètres :
     *   - int $submissionId : l'identifiant de la soumission
     *   - int $questionId : l'identifiant de la question
     * Retour : Collection des valeurs de réponses pour la question donnée
     */
    private function getAnswersByQuestionId(int $submissionId, int $questionId)
    {
        // Récupère les réponses pour une question spécifique
        return Answer::where('submission_id', $submissionId)
            ->where('question_id', $questionId)
            ->select('value')
            ->get()
            ->map(function ($answer) {
                // Retourne uniquement la valeur de la réponse
                return $answer->value;
            });
    }
}
