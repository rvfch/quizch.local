<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\Result;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::where('user_id', Auth::id())->first();
        return view('myquizzes')->with('quizzes', $quizzes);
    }

    public function newQuiz()
    {
        return view('newquiz');
    }

    public function showQuiz($id)
    {
        /*(Quiz::where('id', $id)->exists()) {
            $ifPassed = Result::where('quiz_id', $id)->exists() ? true : false;

            if((Quiz::where('id', $id)->select('isPrivate')->first()['isPrivate'] != 1)
            || (Quiz::where('id', $id)->select('user_id')->first()->user_id == Auth::id()))
            {
                if(!$ifPassed)
                    return view('quiz')->with('id', $id)->with('error', '0');
                else
                    return view('quiz')->with('id', $id)->with('error', 'passed');
            }
            else if(!Auth::user()->isAdmin) {
                return view('quiz')->with('error', 'private');
            } else {
                return view('quiz')->with('id', $id)->with('error', '0');
            }
        } else {
            return view('quiz')->with('error', 'dontexist');
        }*/

        return view('quiz');
    }

    public function results()
    {
        $results = Result::where('user_id', Auth::id())->first();
        return view('results')->with('results', $results);
    }
}
