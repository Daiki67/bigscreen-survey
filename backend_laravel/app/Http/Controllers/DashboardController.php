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
                    'question_6' => $this->getChartDataForQuestion(6),
                    'question_7' => $this->getChartDataForQuestion(7), 
                    'question_10' => $this->getChartDataForQuestion(10), 
                ],
                'RadarChartData' => [
                    'question_11' => $this->getChartDataForQuestion(11),
                    'question_12' => $this->getChartDataForQuestion(12),
                    'question_13' => $this->getChartDataForQuestion(13),
                    'question_14' => $this->getChartDataForQuestion(14),
                    'question_15' => $this->getChartDataForQuestion(15),
                ],

            ]);
            } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération des données'], 500);
        }    


    }

    
    private function getChartDataForQuestion(int $questionId)
    {
        return Answer::where('question_id', $questionId)
            ->whereNotNull('submission_id')
            ->select('value', DB::raw('count(*) as count'))
            ->groupBy('value')
            ->pluck('count', 'value');
    }

}
