<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionCollection;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class UserQuestionController extends Controller
{
    /**
     * List user questions
     *
     * @return QuestionCollection
     */
    public function index()
    {
        $user = auth('api')->user();

        $questions = $user->questions()->paginate();
        return new QuestionCollection($questions);
    }
}
