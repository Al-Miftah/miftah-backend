<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionCollection;

class UserQuestionController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();

        $questions = $user->questions()->paginate();
        return new QuestionCollection($questions);
    }
}
