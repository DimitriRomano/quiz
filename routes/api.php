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

Route::get('quiz', [QuizController::class, 'quiz']);
Route::get('quiz/{id}', [QuizController::class, 'quizId']);
Route::delete('quiz/{id}', [QuizController::class, 'quizDelete']);

Route::post('quiz/{id}/publish', [QuizController::class, 'quizPublish'])->middleware('isAdmin');
Route::post('quiz/{id}/unpublish', [QuizController::class, 'quizUnpublish'])->middleware('isAdmin');
Route::post('quiz', [QuizController::class, 'quizAdmin'])->middleware('isAdmin');
Route::put('/quiz/{id}', [QuizController::class, 'editQuiz'])->middleware('isAdmin');
Route::get('quiz/{id}/questions', [QuizController::class, 'getQuizQuestions']);
Route::get('question/{id}/choices', [QuestionController::class, 'getQuestionChoices']);
Route::get('score', [ScoreController::class, 'getScores']);

Route::get('score/{id}', [ScoreController::class, 'getScoreById'])->middleware('isLoggedIn');
Route::post('score', [ScoreController::class, 'scoreResult'])->middleware('isLoggedIn');
Route::get('user/{userId}', [UserController::class, 'getUserInfo']);

Route::any('{any}', function(){
    return response()->json([
        'status' => 'error',
        'message' => 'Resource not found'], 404);
    })->where('any', '.*');