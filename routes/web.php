<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.pages.homepage');
})->name('frontend.home');

Route::get('/contact-us', function () {
    return view('frontend.pages.contact_us');
})->name('frontend.contact');

Route::get('/ecom', function () {
    return view('ecom.layouts.main');
})->name('frontend.ecom');

Route::get('/branch', function () {
    // return redirect('admin/login');
    return view('admin.branch.list');
});

Route::get('/features', function () {
    return view('frontend.pages.features');
})->name('frontend.features');
Route::get('/signup', function () {
    return view('frontend.pages.signup');
})->name('frontend.signup');


// Route::get('/selling-account', function () {
//     return view('frontend.pages.selling_account');
// })->name('selling.account');


Route::get('/home/{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/planexpires', [App\Http\Controllers\HomeController::class, 'userPlanExpires'])->name('planexpires');
Route::get('/send-notification', [App\Http\Controllers\HomeController::class, 'sendNotification'])->name('send-notification');
Route::get('/send-notificationtwo', [App\Http\Controllers\HomeController::class, 'sendNotificationTwo'])->name('send-notificationtwo');




Route::get('questions', function () {
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
    return response()->json([
        'status'        =>  true,
        'response_code' =>  200,
        'message'       =>  'Fetch Successfully.',
        'data'          =>  $questions
    ], 200);
});



Route::get('callback', function (Request $request) {
    return $request;
})->name('payment.callback');
