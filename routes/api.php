<?php

use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\QuizController;
use App\Http\Controllers\API\ScoreController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Score;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
    
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);        
});
//all quiz
Route::get('quiz', [QuizController::class, 'quiz']);
//one quiz
Route::get('quiz/{id}', [QuizController::class, 'quizId']);
Route::delete('quiz/{id}', [QuizController::class, 'quizDelete']);

//publié
Route::post('quiz/{id}/publish', [QuizController::class, 'quizPublish'])->middleware('IsAdmin');
//ne ps publié
Route::post('quiz/{id}/unpublish', [QuizController::class, 'quizUnpublish'])->middleware('IsAdmin');
//create quiz
Route::post('quiz', [QuizController::class, 'quizAdmin'])->middleware('IsAdmin');
Route::put('/quiz/{id}', [QuizController::class, 'editQuiz'])->middleware('IsAdmin');
//get questiosn from a quiz
Route::get('quiz/{id}/questions', [QuizController::class, 'getQuizQuestions']);
//get question choices
Route::get('question/{id}/choices', [QuestionController::class, 'getQuestionChoices']);
//return all scores
Route::get('score', [ScoreController::class, 'getScores']);

//get one specific score
Route::get('score/{id}', [ScoreController::class, 'getScoreById'])->middleware('IsLoggedIn');

//result when question is submit
Route::post('score', [ScoreController::class, 'scoreResult'])->middleware('IsLoggedIn');

Route::get('user/{userId}', [UserController::class, 'getUserInfo']);

Route::any('{any}', function(){
    return response()->json([
        'status' => 'error',
        'message' => 'Resource not found'], 404);
    })->where('any', '.*');