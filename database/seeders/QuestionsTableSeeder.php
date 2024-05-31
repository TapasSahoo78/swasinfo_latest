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
                    'group_wise' => 1,
                    'answer' => [
                        [
                            'When do you usually sleep.Total hours you sleep __ hours',
                            'time',
                            ''
                        ]
                    ]
                ],
                [
                    'question' => 'Even followed diet plan?',
                    'group_wise' => 1,
                    'answer' => [
                        [
                            'When was the last time',
                            'radio and select',
                            ''
                        ]
                    ]
                ],
                [
                    'question' => 'Even followed exercise plan?',
                    'group_wise' => 1,
                    'answer' => [
                        [
                            'When was the last time',
                            'radio and select',
                            ''
                        ]
                    ]
                ],
            ],

            [
                [
                    'question' => 'Any physical movement?',
                    'group_wise' => 2,
                    'answer' => [
                        [
                            'When was the last time',
                            'radio and select',
                            ''
                        ]
                    ]
                ]
            ],

            [
                [
                    'question' => 'Water intake per day?',
                    'group_wise' => 3,
                    'answer' => [
                        [
                            '',
                            'text',
                            'Glass/day'
                        ]
                    ]
                ],
            ],

            [
                [
                    'question' => 'Do you get tired easily?',
                    'group_wise' => 4,
                    'answer' => [
                        [
                            'Do you get tired during the day?',
                            'radio',
                            ''
                        ],
                        [
                            'Feel drizzing when you wake up?',
                            'radio',
                            ''
                        ]
                    ]
                ],
            ],

            [
                [
                    'question' => 'Do you smoke or drink?',
                    'group_wise' => 5,
                    'answer' => [
                        [
                            'How much do you smoke in a day?',
                            'select',
                            ''
                        ],
                        [
                            'How often do you drink?',
                            'select',
                            ''
                        ],
                        [
                            'What do you usally drink?',
                            'select',
                            ''
                        ]
                    ]
                ],
            ],

            [
                [
                    'question' => 'Currently under doctor care?',
                    'group_wise' => 6,
                    'answer' => [
                        [
                            'Do you take any medication?',
                            'radio',
                            ''
                        ],
                        [
                            'Have you been recently hospitalised?',
                            'radio',
                            ''
                        ],
                        [
                            'Do you suffer from asthma?',
                            'radio',
                            ''
                        ],
                        [
                            'Do you have high uric acid?',
                            'radio',
                            ''
                        ],
                        [
                            'Do you have diabities?',
                            'radio',
                            ''
                        ],
                        [
                            'Do you have high cholesterol?',
                            'radio',
                            ''
                        ],
                        [
                            'Do you suffer from high or low blood pressure?',
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
                    'group_wise' => $questionData['group_wise']
                ]);

                foreach ($questionData['answer'] as $answerData) {
                    DB::table('profile_answers')->insert([
                        'profile_question_id' => $questionId,
                        'answer' => $answerData[0],
                        'input_type' => $answerData[1],
                        'comments' => $answerData[2]
                    ]);
                }
            }
        }
    }
}
