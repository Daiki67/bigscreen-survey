<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'submission_id' => $this->submission_id,
            'question_id'   => $this->question_id,
            'value'         => $this->value,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            // Pour inclure les relations, décommente si besoin :
            'submission'    => new SubmissionResource($this->whenLoaded('submission')),
            'question'      => new QuestionResource($this->whenLoaded('question')),
        ];
    }
}
