<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quizzes';
    protected $fillable = ['title', 'user_id', 'answers_count'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }
}
