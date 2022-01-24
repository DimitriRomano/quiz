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


    public function quizId($id){
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
        return Response('Quiz succesfully deleted',200);
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
        $foundQuiz->published = true;
        $foundQuiz->save();
        return Response($foundQuiz);
    }

    public function quizUnpublish(Request $request, $id)
    {
        $foundQuiz = Quiz::find($id);
        if(!$foundQuiz){
            return Response('Quiz not found',404);
        }
        $foundQuiz->published = false;
        $foundQuiz->save();
        return Response($foundQuiz);
    }

    public function quizAdmin(Request $request)
    {
        $quizRequest = $request;
        if(!$quizRequest->label && !$quizRequest->published && !$quizRequest){
            return Response('Missing parameters',400);
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
            $answer = $question['answer'];
            $q->label = $question['label'];
            $q->answer = null;
            $q->earnings = $question['earnings'];
            $q->quiz_id = $quiz->id;
            $q->save();

            foreach ($question['choices'] as $choice){
                $c = new Choice();
                $c->question_id = $q->id;
                $c->label = $choice['label'];
                $c->save();
                if($choice['id'] == $answer){
                    $q->answer = $c->id;
                    $q->save();
                }
            }
            $q->save();
        }

        return Response('Quiz successfully created',200);
    }

    public function getQuizQuestions($id){
        $quiz = Quiz::find($id);
        if($quiz !=null){
            return Response($quiz->question,200);
        }
    }

    public function editQuiz(Request $request,$id){
        $quiz = Quiz::find($id);

        if($quiz == null){
            return Response("Quiz doesn't exist",404);
        }

        $label = $request['label'];
        $questions = $request['questions'];

        if($label == null || $questions == null){
            return Response("Parameter missing ",400);
        }

        if(sizeof($questions) === 0){
            return Response('Quiz must have at least one question',400);
        }

        if(sizeof($questions[0]['choices']) === 0){
            return Response('Quiz must have at least one choice',400);
        }

        



        
    }


}
