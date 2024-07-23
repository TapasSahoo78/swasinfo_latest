<?php

namespace App\Http\Controllers\Api\TrainerDietitian;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\ProfileQuestion;
use Illuminate\Http\Request;

class ManageController extends BaseController
{
    public function questionsList()
    {
        // Fetch questions with their answers
        $questions = ProfileQuestion::with(['answers' => function ($query) {
            $query->select('id', 'profile_question_id', 'answer', 'slug', 'input_type', 'comments');
        }])->select('id', 'question', 'slug', 'group_wise')->get();

        // Group by 'group_wise'
        $groupedQuestions = $questions->groupBy('group_wise');
        $arryMain = [];

        foreach ($groupedQuestions as $mkey => $main) {
            $arryMain[$mkey] = [];  // Initialize an array for each mkey
            foreach ($main as $value) {
                $answers = [];
                foreach ($value->answers as $answer) {
                    $answers[] = [
                        'answer' => $answer->answer,
                        'slug' => $answer->slug,
                        'input_type' => $answer->input_type,
                        'comments' => $answer->comments,
                        'user_ans' => 1
                    ];
                }

                $arryMain[$mkey][] = [
                    'id' => $value->id,
                    'question' => $value->question,
                    'slug' => $value->slug,
                    'group_wise' => $value->group_wise,
                    'answers' => $answers
                ];
            }
        }

        return $this->responseJson(true, 200, 'Data available.', $arryMain);
    }
}
