<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    public function getQuestionChoices($id) {
        $question = Question::find($id);
        if($question == null){
            return Response("Question doesn't exist",404);
        }else{
            return Response($question->choice,200);
        }

    }
}
