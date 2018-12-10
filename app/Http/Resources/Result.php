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
      $progressValue = ($this->right_answers / QuizModel::where('id', $this->quiz_id)->first()['answers_count']) * 100;
        return [
            'id' => (int)$this->id,
            'user_id' => (int)$this->user_id,
            'quiz_id' => (int)$this->quiz_id,
            'quiz_title' => (string)QuizModel::where('id', $this->quiz_id)->first()['title'],
            'right_answers' => (int)$this->right_answers,
            'questions_count' => (int)QuizModel::where('id', $this->quiz_id)->first()['answers_count'],
            'progressValue' => $progressValue,
            'resultColor' => ($progressValue <= 100 && $progressValue >= 70) ? 'success' : ($progressValue <= 69 && $progressValue >= 20) ? 'warning' : 'danger',
            'isPassed' => (int)$this->isPassed,
            'created_at' => (string)$this->created_at
        ];
    }
}
