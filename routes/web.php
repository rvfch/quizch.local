<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();




Route::any('/{all}', 'SpaController@index')->where(['all' => '.*']);

//Route::get('/dashboard', 'HomeController@index')->name('home');
//Route::get('/quiz/{id}', 'HomeController@showQuiz');
//Route::get('/quizdisplay/{id}', 'HomeController@displayQuiz');
//Route::get('/newquiz', 'HomeController@newQuiz');
//Route::get('/results', 'HomeController@results');
