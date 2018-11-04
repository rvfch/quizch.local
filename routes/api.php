<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/*
*   Quiz API
*   QuizController
*/
//Route::get('quizzes', 'QuizController@index'); // all quizzes

Route::get('quizzes/{user_id}', 'QuizController@getUser'); // quizzes of user

Route::get('quiz/{id}', 'QuizController@show'); // single quiz

Route::post('quiz', 'QuizController@store'); // create new quiz

Route::put('quiz', 'QuizController@store'); // update quiz

Route::delete('quiz/{id}', 'QuizController@destroy'); // delete quiz

/*
*   Results API
*   ResultController
*/

Route::get('results/{user_id}', 'ResultController@show'); // Show all user's results

Route::post('result', 'ResultController@store'); // Add result to user

Route::put('result', 'ResultController@sotre'); // Update user's result

Route::delete('results/{user_id}', 'ResultController@destroy'); // Delete user's result