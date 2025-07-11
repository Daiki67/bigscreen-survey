<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

// Contrôleur pour la gestion des statistiques du tableau de bord
class DashboardController extends Controller
{
    /**
     * Méthode index
     * Rôle : Affiche les statistiques du tableau de bord (données pour les graphiques)
     * Paramètres : Aucun
     * Retour : JsonResponse contenant les données pour les graphiques (pie chart, radar chart)
     */
    public function index(): JsonResponse
    {

        try {

            return response()->json([

                // Données pour les graphiques en camembert (pie chart) pour les questions 6, 7 et 10
                'PieChartData' => [
                    'question_6' => $this->getPieChartDataForQuestion(6),
                    'question_7' => $this->getPieChartDataForQuestion(7),
                    'question_10' => $this->getPieChartDataForQuestion(10),
                ],

                // Données pour le graphique radar (questions 11 à 15)
                'RadarChartData' => $this->getRadarQualityAnswersByQuestionId(),

                'message' => 'Statistiques du tableau de bord récupérées avec succès.',
            ]);
        } catch (\Exception $e) {

            // En cas d'erreur, retourne une réponse JSON avec le message d'erreur
            return response()->json(['error' => 'Erreur lors de la récupération des données'], 500);

        }


    }

    /**
     * Méthode getPieChartDataForQuestion
     * Rôle : Récupère les données pour un graphique en camembert pour une question donnée
     * Paramètres :
     *   - int $questionId : l'identifiant de la question
     * Retour : Collection des valeurs et leur nombre d'occurrences pour la question
     */
    private function getPieChartDataForQuestion(int $questionId)
    {
        /* Récupère le nombre de réponses pour les id ciblés */
        return Answer::where('question_id', $questionId)
            ->whereNotNull('submission_id')
            ->select('value', DB::raw('count(*) as count'))
            ->groupBy('value')
            ->pluck('count', 'value');
    }

    /**
     * Méthode getRadarQualityAnswersByQuestionId
     * Rôle : Récupère les données pour le graphique radar (questions 11 à 15)
     * Paramètres : Aucun
     * Retour : Collection des réponses groupées par valeur pour les questions 11 à 15
     */
    private function getRadarQualityAnswersByQuestionId()
    {
        // Récupère le nombre de réponses pour les questions 11 à 15
        return Answer::whereIn('question_id', [11, 12, 13, 14, 15])
            ->whereNotNull('submission_id')
            ->select('value', DB::raw('count(*) as count'))
            ->groupBy('value')
            ->orderBy('value')
            ->get();
    }

}
