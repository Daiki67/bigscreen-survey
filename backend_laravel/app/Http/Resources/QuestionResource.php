<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'id'      => $this->id,
            'title'   => $this->title,
            'type'    => $this->type,
            'options' => $this->options,
            'order'   => $this->order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // Pour inclure les réponses associées, décommente si besoin :
            'answers' => AnswerResource::collection($this->whenLoaded('answers')),
        ];
    }
}
