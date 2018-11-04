<?php

namespace App\Http\Resources;

use App\Quiz as QuizModel;
use Illuminate\Http\Resources\Json\JsonResource;

class Result extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'user_id' => (int)$this->user_id,
            'quiz_id' => (int)$this->quiz_id,
            'total_questions' => (int)QuizModel::where('id', $this->quiz_id)->select('answers_count')->first()['answers_count'],
            'right_answers' => (int)$this->right_answers,
            'isPassed' => (int)$this->isPassed,
            'created_at' => (string)$this->created_at
        ];
    }
}
