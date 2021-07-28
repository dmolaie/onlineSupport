<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/**
 * routing group AllUser without ACL
 */
Route::group(['prefix' => 'v1/user', 'namespace' => 'App\Http\Controllers\User'], function () {
    Route::post('/register', 'UserController@register')->name('register');
    Route::post('/login', 'UserController@login')->name('login');
});

/**
 * routing group question customer
 */
Route::group(['prefix' => 'v1/question','middleware' => 'auth:sanctum', 'namespace' => 'App\Http\Controllers\Question'], function () {
    Route::post('/create', 'QuestionCustomersController@create')->name('questionCreate');
    Route::get('/listCustomerQuestion', 'QuestionCustomersController@listCustomerQuestion')->name('listCustomerQuestion');
});

/**
 * routing group question support
 */
Route::group(['prefix' => 'v1/question','middleware' => 'auth:sanctum', 'namespace' => 'App\Http\Controllers\Question'], function () {
    Route::post('/changeStatus', 'QuestionSupportController@changeStatus')->name('questionChangeStatus');
    Route::post('/listQuestionSupport', 'QuestionSupportController@listQuestionSupport')->name('listQuestionSupport');
});

/**
 * routing group answer customer
 */
Route::group(['prefix' => 'v1/answer','middleware' => 'auth:sanctum', 'namespace' => 'App\Http\Controllers\Answer'], function () {
    Route::post('/create', 'AnswerSupportController@create')->name('createAnswerCustomer');
});

/**
 * routing group answer support
 */
Route::group(['prefix' => 'v1/answer/support','middleware' => 'auth:sanctum', 'namespace' => 'App\Http\Controllers\Answer'], function () {
    Route::post('/create', 'AnswerSupportController@create')->name('createAnswerSupport');
    Route::post('/change-answered', 'AnswerSupportController@changeStatusAnswered')->name('createAnswerSupport');
});
