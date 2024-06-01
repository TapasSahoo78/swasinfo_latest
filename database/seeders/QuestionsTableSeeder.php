<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsTableSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            [
                [
                    'question' => 'What is your sleep schedule?',
                    'slug' => 'sleep_schedule',
                    'group_wise' => 1,
                    'answer' => [
                        [
                            'When do you usually sleep.Total hours you sleep __ hours',
                            'total_sleep_hours',
                            'time',
                            ''
                        ]
                    ]
                ],
                [
                    'question' => 'Even followed diet plan?',
                    'slug' => 'is_followed_diet_plan',
                    'group_wise' => 1,
                    'answer' => [
                        [
                            'When was the last time',
                            'diet_plan_last_time',
                            'radio and select',
                            ''
                        ]
                    ]
                ],
                [
                    'question' => 'Even followed exercise plan?',
                    'slug' => 'is_followed_exercise_plan',
                    'group_wise' => 1,
                    'answer' => [
                        [
                            'When was the last time',
                            'exercise_plan_last_time',
                            'radio and select',
                            ''
                        ]
                    ]
                ],
            ],

            [
                [
                    'question' => 'Any physical movement?',
                    'slug' => 'any_physical_movement',
                    'group_wise' => 2,
                    'answer' => [
                        [
                            'When was the last time',
                            'physical_movement_last_time',
                            'radio and select',
                            ''
                        ]
                    ]
                ]
            ],

            [
                [
                    'question' => 'Water intake per day?',
                    'slug' => NULL,
                    'group_wise' => 3,
                    'answer' => [
                        [
                            '',
                            'water_intake_last_time',
                            'text',
                            'Glass/day'
                        ]
                    ]
                ],
            ],

            [
                [
                    'question' => 'Do you get tired easily?',
                    'slug' => NULL,
                    'group_wise' => 4,
                    'answer' => [
                        [
                            'Do you get tired during the day?',
                            'do_you_get_tired_during_the_day',
                            'radio',
                            ''
                        ],
                        [
                            'Feel drizzing when you wake up?',
                            'feel_drizzing_when_you_wakeup',
                            'radio',
                            ''
                        ]
                    ]
                ],
            ],

            [
                [
                    'question' => 'Do you smoke or drink?',
                    'slug' => NULL,
                    'group_wise' => 5,
                    'answer' => [
                        [
                            'How much do you smoke in a day?',
                            'how_much_do_you_smoke_in_a_day',
                            'select',
                            ''
                        ],
                        [
                            'How often do you drink?',
                            'how_often_do_you_drink',
                            'select',
                            ''
                        ],
                        [

                            'What do you usally drink?',
                            'what_do_you_usually_drink',
                            'select',
                            ''
                        ]
                    ]
                ],
            ],

            [
                [
                    'question' => 'Currently under doctor care?',
                    'slug' => NULL,
                    'group_wise' => 6,
                    'answer' => [
                        [
                            'Do you take any medication?',
                            'do_you_take_any_medication',
                            'radio',
                            ''
                        ],
                        [
                            'Have you been recently hospitalised?',
                            'have_you_been_recently_hospitalized',
                            'radio',
                            ''
                        ],
                        [
                            'Do you suffer from asthma?',
                            'do_you_suffer_from_asthma',
                            'radio',
                            ''
                        ],
                        [
                            'Do you have high uric acid?',
                            'do_you_have_high_uric_acid',
                            'radio',
                            ''
                        ],
                        [
                            'Do you have diabities?',
                            'do_you_have_diabities',
                            'radio',
                            ''
                        ],
                        [
                            'Do you have high cholesterol?',
                            'do_you_have_high_cholesterol',
                            'radio',
                            ''
                        ],
                        [
                            'Do you suffer from high or low blood pressure?',
                            'do_you_suffer_from_high_or_low_blood_pressure',
                            'radio',
                            ''
                        ]
                    ]
                ],
            ]
        ];

        foreach ($questions as $questionGroup) {
            foreach ($questionGroup as $questionData) {
                $questionId = DB::table('profile_questions')->insertGetId([
                    'question' => $questionData['question'],
                    'slug' => $questionData['slug'],
                    'group_wise' => $questionData['group_wise']
                ]);

                foreach ($questionData['answer'] as $answerData) {
                    DB::table('profile_answers')->insert([
                        'profile_question_id' => $questionId,
                        'answer' => $answerData[0],
                        'slug' => $answerData[1],
                        'input_type' => $answerData[2],
                        'comments' => $answerData[3]
                    ]);
                }
            }
        }
    }
}
