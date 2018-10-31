<?php

namespace App\Http\Resources;


use App\QuestionAnswer;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Answers as AnswersResource;
use App\Http\Resources\QuestionCollection;

class Question extends JsonResource
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
            'id' => $this->id,
            'question_text' => $this->question_text,
            'answers' => AnswersResource::collection(QuestionAnswer::where('question_id',$this->id)->get())
        ];
        
    }
}
