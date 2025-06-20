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

}
