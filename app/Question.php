<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    protected $table = 'questions';
    protected $fillable = ['quiz_id', 'question_text'];
    protected $primaryKey = 'quiz_id';

    public function setQuizAttribute($input)
    {
        $this->attributes['quiz_id'] = $input ? $input : null;
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id')->withTrashed();
    }

    public function answers()
    {
        return $this->howMany(QuestionAnwser::class, 'question_id')->withTrashed();
    }
}
