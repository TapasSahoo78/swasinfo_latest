<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\ProfileQuestion;
use Illuminate\Http\Request;

class ProfileQuestionController extends BaseController
{
    public function index()
    {
        // Fetch questions with their answers
        $questions = ProfileQuestion::with(['answers' => function ($query) {
            $query->select('id', 'profile_question_id', 'answer', 'input_type', 'comments');
        }])->select('id', 'question', 'group_wise')->get();

        // Group by 'group_wise'
        $groupedQuestions = $questions->groupBy('group_wise');

        return $this->responseJson(true, 200, 'Data available.', $groupedQuestions);
    }
}
