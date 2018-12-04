<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Quiz;
use App\Question;
use App\Result;
use App\QuestionAnswer;
use Auth;
use App\Http\Resources\Quiz as QuizResource;

use Illuminate\Support\Facades\Hash;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::all();

        return QuizResource::collection($quizzes);
    }

    public function getUser($user_id)
    {
        $quizzes = Quiz::where('user_id', $user_id)->orderBy('id', 'desc')->get();

        return QuizResource::collection($quizzes);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $quiz = $request->isMethod('put') ? Quiz::findOrFail($request->input('id')) : new Quiz;

        $quiz->id = $request->input('id');
        $quiz->title = $request->input('title');
        $quiz->description = $request->input('description');
        $quiz->user_id = $request->input('user_id');
        $quiz->answers_count = $request->input('questions_count');
        $quiz->isPrivate = $request->input('private');
        $quiz->password = $request->input('password') != '' ? Hash::make($request->input('password')) : '';
        $quiz->duration = $request->input('duration');
        $quiz->hash = md5(Hash::make($quiz->id));

        $quiz->save();

        if(!$request->isMethod('put')) {
          $questionTemp = [];
          foreach($request->input('questions') as $i => $question) {
              $questionTemp[$i] = new Question(['quiz_id' => $quiz->id, 'question_text' => $question['question_text']]);
          }
          $quiz->questions()->saveMany($questionTemp);

          foreach($request->input('questions') as $i => $question) {
              $answerTemp = [];
              foreach($question['answers'] as $j => $answer) {
                  $answerTemp[$j] = new QuestionAnswer(['question_id' => $questionTemp[$i]->id, 'answer' => $answer['text'], 'correct' => $answer['correct']]);
              }
              $questionTemp[$i]->answers()->saveMany($answerTemp);
          }
        }

        return new QuizResource($quiz);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quiz = Quiz::where('hash', $id)->first();
        return new QuizResource($quiz);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $questions = Question::where('quiz_id', $id);
        foreach($questions as $i => $question) {
            $answer = Question::where('question_id', $question[$i]['id'])->delete();
        }

        $questions->delete();
        $quiz->delete();

        return new QuizResource($quiz);
    }
}
