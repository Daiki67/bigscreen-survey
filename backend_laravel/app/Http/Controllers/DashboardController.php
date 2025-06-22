<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use PhpParser\Node\Stmt\TryCatch;

class DashboardController extends Controller
{
    /**
     * Affiche les statistiques du tableau de bord.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {

        try {

            return response()->json([
                
                'PieChartData' => [
                    'question_6' => $this->getPieChartDataForQuestion(6),
                    'question_7' => $this->getPieChartDataForQuestion(7),
                    'question_10' => $this->getPieChartDataForQuestion(10),
                ],
                
                'RadarChartData' => $this->getRadarQualityAnswersByQuestionId(),
                
                'message' => 'Statistiques du tableau de bord récupérées avec succès.',
            ]);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Erreur lors de la récupération des données'], 500);

        }


    }


    private function getPieChartDataForQuestion(int $questionId)
    {
        return Answer::where('question_id', $questionId)
            ->whereNotNull('submission_id')
            ->select('value', DB::raw('count(*) as count'))
            ->groupBy('value')
            ->pluck('count', 'value');
    }

    private function getRadarQualityAnswersByQuestionId()
    {
        // Récupère les réponses pour une question spécifique
        return Answer::whereIn('question_id', [11, 12, 13, 14, 15])
            ->whereNotNull('submission_id')
            ->select('value', DB::raw('count(*) as count'))
            ->groupBy('value')
            ->orderBy('value')
            ->get();
    }

}
