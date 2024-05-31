<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\ProfileQuestion;
use Illuminate\Database\Seeder;

class QuestionAnsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            // [
            //     ['question' => 'What is your sleep schedule?', 'answer' => 'When do you usually sleep.Total hours you sleep __ hours', 'answer_two' => '', 'input_type' => 'time', 'lebel' => ''],
            //     ['question' => 'Even followed diet plan?', 'answer' => 'When was the last time', 'answer_two' => '', 'input_type' => 'radio and select', 'lebel' => ''],
            //     ['question' => 'Even followed exercise plan?', 'answer' => 'When was the last time', 'answer_two' => '', 'input_type' => 'radio and select', 'lebel' => '']
            // ],
            ['What is your sleep schedule?'],
            ['Even followed diet plan?'],
            ['Even followed exercise plan?']
        ];
        dd($questions);
        foreach ($questions as $key => $value) {
            ProfileQuestion::create([
                'created_by' => $value,
                'updated_by' => $value
            ]);
        }
    }
}
