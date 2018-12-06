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
*   Auth API
*   AuthController
*   OAuth 2.0
*/
// log in
Route::post('/login', 'AuthController@login');
// log out
Route::middleware('auth:api')->post('/logout', 'AuthController@logout');
// register
Route::post('/register', 'AuthController@register');


/*
*   Quiz API
*   QuizController
*/

// return all quizzes
//Route::get('quizzes', 'QuizController@index');
// quizzes of user
Route::get('quizzes/{user_id}', 'QuizController@getUser');
// return quiz
Route::middleware('auth:api')->get('quiz/{id}', 'QuizController@show');
// create new quiz
Route::post('quiz', 'QuizController@store');
// update quiz
Route::put('quiz', 'QuizController@store');
// delete quiz
Route::delete('quiz/{id}', 'QuizController@destroy');

/*
*   Results API
*   ResultController
*/

// Show all user's results
Route::get('results/{user_id}', 'ResultController@show');
// Add result to user
Route::post('result', 'ResultController@store');
// Update user's result
Route::put('result', 'ResultController@sotre');
// Delete user's result
Route::delete('results/{user_id}', 'ResultController@destroy');
