<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function quiz()
    {
        return Quiz::all();
    }


    public function quizId(Request $request, $id){
        $quiz = Quiz::find($id);
        if($quiz) {
            return $quiz;
        }else{
            return Response('Quiz not found',404); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function quizDelete($id)
    {
        $foundQuiz = Quiz::find($id);
        if(!$foundQuiz){
            return Response('Quiz not found',404);
        }
        $foundQuiz->delete();
        return Response('Quiz succesfully deleted');
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function quizPublish(Request $request, $id)
    {
        $foundQuiz = Quiz::find($id);
        if(!$foundQuiz){
            return Response('Quiz not found',404);
        }
        $foundQuiz->isPublished = true;
        $foundQuiz->save();
        return Response($foundQuiz);
    }

    public function quizUnpublish(Request $request, $id)
    {
        $foundQuiz = Quiz::find($id);
        if(!$foundQuiz){
            return Response('Quiz not found',404);
        }
        $foundQuiz->isPublished = false;
        $foundQuiz->save();
        return Response($foundQuiz);
    }

    public function quizAdmin(Request $request)
    {
        $quizRequest = $request;
        if(!$quizRequest->label && !$quizRequest->published && !$quizRequest){
            return Response('Missing paramerters',400);
        }
        if(sizeof($quizRequest->questions) === 0){
            return Response('Quiz must have at least one question',400);
        }
        
        $quiz = new Quiz();
        $quiz->label = $quizRequest->label;
        $quiz->published = false;
        $quiz->save();

        foreach ($quizRequest->questions as $question) {
            $q = new Question();
            $q->label = $question['label'];
            $q->answer = $question['answer'];
            $q->earnings = $question['earnings'];
            $q->quiz_id = $quiz->id;
            $q->save();

            foreach ($question['choices'] as $choice){
                $c = new Choice();
                $c->question_id = $q->id;
                $c->label = $choice['label'];
                if($q->answer == $c->id){
                    $q->answer = $c->id;
                    $q->save();
                }
                $c->save();
            }
        }

        return Response('Quiz successfully created',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

}
