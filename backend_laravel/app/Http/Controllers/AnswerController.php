<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Http\Resources\SubmissionResource; // N'oubliez pas d'importer votre ressource
use Illuminate\Http\JsonResponse;

class AnswerController extends Controller
{
    /**
     * Affiche la liste des soumissions avec pagination.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        // On utilise la pagination pour la performance
        // On charge les relations 'answers' et 'answers.question' pour éviter le problème N+1
        $submissions = Submission::with('answers.question')
            ->latest() // Les plus récentes d'abord
            ->paginate(10);

        // Retourne une collection de SubmissionResource avec pagination
        return SubmissionResource::collection($submissions);
    }

    /**
     * Affiche une soumission spécifique et ses réponses.
     *
     * @param  \App\Models\Submission  $submission
     * @return \App\Http\Resources\SubmissionResource|\Illuminate\Http\JsonResponse
     */
    public function show(Submission $submission): SubmissionResource|JsonResponse
    {
        // Charge les relations 'answers' et 'answers.question' pour la soumission spécifique
        $submission->load('answers.question');

        // Retourne la ressource de soumission complète
        return new SubmissionResource($submission);
    }
}
