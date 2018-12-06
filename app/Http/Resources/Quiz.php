<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Question;
use App\QuestionAnswer;
use App\Http\Resources\QuestionCollection;
use App\Http\Resources\Question as QuestionResource;
use App\Quiz as QuizModel;

class Quiz extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'questions_count' => $this->answers_count,
            'private' => (int)$this->isPrivate,
            'password' => (string)$this->password,
            'duration' => (int)$this->duration,
            'created_at' => (string)$this->created_at,
            'hash' => (string)$this->hash,
            'questions' => QuestionResource::collection(Question::where('quiz_id', $this->id)->get())
        ];
    }

    public function with($request)
    {
        return [
            'version' => '1.0',
            'author' => 'Roman "rvfch" Filatov',
            'author_url' => url('http://rvfch.github.io')
        ];
    }
}
