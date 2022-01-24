<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScoreController extends Controller
{
   
    public function getScores()
    {
        $scores = Score::all();
        return Response($scores,200);
    }

    public function scoreResult(Request $request) 
    {
        $user = auth()->user();

        $answers = $request['answers'];
        $quiz_id = $request['quiz_id'];

        if($quiz_id == null){
            return Response('Quiz not found',404);
        }

        $foundScore = Score::where('user_id', $user['id'])->where('quiz_id',$quiz_id)->get();

        if($foundScore && count($foundScore)>0){
            return Response('You have already taken this quiz',400);
        }

        $foundQuestions = Question::where('quiz_id',$quiz_id)->get();

        if(count($foundQuestions) !== sizeof($answers)) {
            Response('Answer amount must match questions amount',400);
        }

        $finalScore = 0;

        foreach ($answers as $answer ) {
            $question = Question::find($answer['question_id']);
            if(!$question){
                return Response('question '.$answer['question_id'].' not found',404);
            }
            if($question->answer == $answer['answer']){
                $finalScore += $question->earnings;
            }
        }

        $scoreTotal = new Score();
        $scoreTotal->score  = $finalScore;
        $scoreTotal->user_id = $user->id;
        $scoreTotal->quiz_id = $quiz_id;
        $scoreTotal->save();

        return Response($finalScore);

    }


    public function getScoreById($id){
        $score = Score::find($id);
        return Response($score,200);
    }

}
