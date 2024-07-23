<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Agent\SettingController;
use App\Http\Controllers\Api\Common\ProfileQuestionController;
use App\Http\Controllers\Api\Common\WalletController;
use App\Http\Controllers\Api\TrainerDietitian\ManageController;

// use App\Http\Controllers\Api\Agent\UserApiControllers;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// })


Route::controller(ProfileQuestionController::class)->group(function () {
    Route::get('v1/questions-list', 'index')->name('questions.list');
});

Route::namespace('Api\Customer')
    ->prefix('customers')
    ->as('customer.')
    // Add 'track.api.hits' middleware here
    ->group(function () {


        Route::middleware('auth:api')->middleware('auth:api', 'track.api.hits')->group(function () {
            Route::controller(UserApiControllers::class)->group(function () {
                Route::post('/create-profile', 'createProfile')->name('create.profile');
                Route::post('/update-user-profile', 'updateProfile')->name('update.user.profile');
                Route::post('/change-password', 'changePassword')->name('change.password');
                Route::post('/profile-image-update', 'profileImageupdate')->name('profile.image.update');
                Route::get('/user-details', 'userDetails')->name('user-details');
                Route::get('/user-workout-details', 'userWorkoutDetails')->name('user.workout.details');
                Route::post('/user-health-workout-save', 'userHealthWorkoutSave')->name('user.health.workout.save');
                Route::post('/trainer-list', 'trainerList')->name('trainer.list');
                Route::match(['get', 'post'], '/trainer-details', 'trainerDetails')->name('trainer.details');
                Route::match(['get', 'post'], '/trainer-customer-request', 'trainerCustomerRequest')->name('trainer.customer.request');
                Route::post('/subscription-plan-list', 'subscriptionPlanList')->name('subscription.plan.list');
                Route::post('/physically-condition-list', 'physicallyConditionList')->name('physically.condition.list');
                Route::post('/fitness-goal-list', 'fitnessGoalList')->name('fitness.goal.list');
                Route::post('/user-advance-update-details', 'userAdvanceUpdateDetails')->name('user.advance.update.details');
                Route::post('/diet-plan-list', 'dietPlanList')->name('diet.plan.list');
                Route::post('/workout-list', 'workoutList')->name('workout.list');
                Route::post('/user-food-item-save', 'userFoodItemSave')->name('user.food.item.save');
                Route::get('/notification', 'notification')->name('notification');
                Route::get('/transaction/{any}', 'transaction')->name('transaction');

                Route::post('/question-store', 'profileQuestionStore')->name('question.store');
                Route::post('/question-store', 'profileQuestionStore')->name('question.store');

                // Route::post('/payment-intent', 'paymentIntent')->name('payment.intent');

                Route::match(['get', 'post'], '/storetransaction', 'savetransaction')->name('storetransaction');

                Route::get('/getscriptiondetails', 'getscriptiondetails')->name('getscriptiondetails');
                Route::post('/deleteaccount', 'userDeleteAccount')->name('deleteaccount');

                // Route::post('/workout-list', 'workoutList')->name('workout.list');
            });
        });

        Route::controller(UserApiControllers::class)->group(function () {
            Route::post('/login', 'login')->name('login');
            Route::post('/flogin', 'flogin')->name('flogin');
            Route::get('/get-guidance', 'getGuidanceList')->name('get-guidance-list');
            Route::post('/login-verify', 'loginVerify')->name('login.verify');
            Route::post('/signup', 'signup')->name('signup');
            Route::post('/verify-otp', 'verifyOtp')->name('verify.otp');
            Route::post('/resend-otp', 'resendOtp')->name('resend.otp');
            Route::post('/login-send-otp', 'loginSendOtp')->name('loginSendOtp');
            Route::post('/forgot-password', 'forgotPassword')->name('forgot.password');
            Route::post('/create-password', 'createPassword')->name('create.password');
            Route::post('/reward-list', 'rewardList')->name('reward.list');
            Route::get('/reward-details/{any}', 'rewardDetails')->name('reward.details');
            Route::post('/rating-add/{any}', 'addRating')->name('reward.add');
            Route::post('/faq-list', 'faqList')->name('faq.list');
            Route::post('/privacy-policy-list', 'privacyPolicy')->name('privacy.policy');
            Route::get('/cms/{id}', 'cms')->name('cms');
            Route::get('/faq/{id}', 'faq')->name('faq');
            Route::post('/app-version', 'postAppVersion')->name('app-version');
            Route::get('/get-app-version', 'getAppVersion')->name('get-app-version');



            //Route::post('/workout-list', 'workoutList')->name('workout.list');

        });
        // Route::post('login', [UserApiControllers::class, 'login']);
    });


Route::namespace('Api\Common')
    ->prefix('common')
    ->as('common.')
    // Add 'track.api.hits' middleware here
    ->group(function () {
        Route::middleware('auth:api')->middleware('auth:api')->group(function () {
            Route::controller(WalletController::class)->group(function () {
                Route::get('/wallet-history', 'getWalletHistory')->name('wallet.history');
                Route::post('/recharge-wallet', 'rechargeWallet')->name('recharge.wallet');
            });
        });
    });

Route::namespace('Api\Customer')
    ->prefix('v1/customers') // Include "v1" in the prefix
    ->as('customer.')
    ->middleware('track.api.hits')
    ->group(function () {
        Route::middleware('auth:api')->middleware('auth:api', 'track.api.hits')->group(function () {
            Route::controller(UserApiControllers::class)->group(function () {

                Route::post('/create-profile', 'createProfile')->name('create.profile');
                Route::post('/update-user-profile', 'updateProfile')->name('update.user.profile');
                Route::post('/change-password', 'changePassword')->name('change.password');
                Route::post('/profile-image-update', 'profileImageupdate')->name('profile.image.update');
                Route::get('/user-details', 'userDetails')->name('user-details');
                Route::get('/user-workout-details', 'userWorkoutDetails')->name('user.workout.details');
                Route::post('/user-health-workout-save', 'userHealthWorkoutSave')->name('user.health.workout.save');
                Route::post('/trainer-list', 'trainerList')->name('trainer.list');
                Route::match(['get', 'post'], '/trainer-details', 'trainerDetails')->name('trainer.details');
                Route::match(['get', 'post'], '/trainer-customer-request', 'trainerCustomerRequest')->name('trainer.customer.request');
                Route::post('/subscription-plan-list', 'subscriptionPlanList')->name('subscription.plan.list');
                Route::post('/physically-condition-list', 'physicallyConditionList')->name('physically.condition.list');
                Route::post('/fitness-goal-list', 'fitnessGoalList')->name('fitness.goal.list');
                Route::post('/user-advance-update-details', 'userAdvanceUpdateDetails')->name('user.advance.update.details');
                Route::post('/diet-plan-list', 'dietPlanList')->name('diet.plan.list');
                Route::post('/workout-list', 'workoutList')->name('workout.list');
                Route::post('/user-food-item-save', 'userFoodItemSave')->name('user.food.item.save');
                Route::get('/notification', 'notification')->name('notification');
                Route::get('/transaction/{any}', 'transaction')->name('transaction');

                Route::post('/recharge', 'rechargeWallet')->name('recharge');

                // Route::post('/payment-intent', 'paymentIntent')->name('payment.intent');

                Route::match(['get', 'post'], '/storetransaction', 'savetransaction')->name('storetransaction');
                Route::match(['get', 'post'], '/start-pause-subscription', 'startPauseSubscription')->name('startPauseSubscription');

                Route::get('/getscriptiondetails', 'getscriptiondetails')->name('getscriptiondetails');
                Route::post('/deleteaccount', 'userDeleteAccount')->name('deleteaccount');
                Route::post('/screen_time', 'screenTime')->name('screen_time');
                Route::post('/notification-update', 'notificationUpdate')->name('notification-update');
                Route::get('/ecommerce-home', 'getEcommerceHome')->name('ecommerce.home');
                Route::get('/product-listing', 'getProductList')->name('product.listing');
                Route::get('/product-details/{any}', 'productDetails')->name('product.details');
                Route::get('/category-listing', 'getCategoryList')->name('category.listing');
                Route::get('/releted-product/{any}', 'reletedProduct')->name('releted.product');
                Route::post('/cart-insert', 'cartInsert')->name('cart.insert');
                Route::post('/addaddress', 'addAddress')->name('addaddress');
                Route::get('/getaddress', 'getAddress')->name('getaddress');
                Route::put('/editaddress', 'editAddress')->name('editaddress');
                Route::delete('/deleteaddress/{any}', 'deleteAddress')->name('deleteaddress');
                Route::get('/getcartdata', 'getCartData')->name('getcartdata');
                Route::get('/getshippinginfo', 'getShippingInfo')->name('getshippinginfo');
                Route::delete('/cartremove/{any}', 'cartRemove')->name('cartremove');
                Route::post('/addfevorite', 'addFevorite')->name('addfevorite');
                Route::get('/getfevoritelist', 'getFevoriteList')->name('getfevoritelist');
                Route::delete('/fevoritelistremove/{any}', 'fevoritelistRemove')->name('fevoritelistremove');
                Route::post('/placeorder', 'placeOrder')->name('placeorder');
                Route::post('/couponvalidate', 'couponValidate')->name('couponvalidate');
                Route::get('/orderlist', 'orderList')->name('orderlist');
                Route::post('/addrating', 'addRating')->name('addrating');

                // Route::post('/workout-list', 'workoutList')->name('workout.list');
            });
        });
        Route::controller(UserApiControllers::class)->group(function () {
            Route::post('/login', 'login')->name('login');
            Route::post('/flogin', 'flogin')->name('flogin');
            Route::get('/get-guidance', 'getGuidanceList')->name('get-guidance-list');
            Route::post('/login-verify', 'loginVerify')->name('login.verify');
            Route::post('/signup', 'signup')->name('signup');
            Route::post('/verify-otp', 'verifyOtp')->name('verify.otp');
            Route::post('/resend-otp', 'resendOtp')->name('resend.otp');
            Route::post('/login-send-otp', 'loginSendOtp')->name('loginSendOtp');
            Route::post('/forgot-password', 'forgotPassword')->name('forgot.password');
            Route::post('/create-password', 'createPassword')->name('create.password');
            Route::post('/reward-list', 'rewardList')->name('reward.list');
            Route::get('/reward-details/{any}', 'rewardDetails')->name('reward.details');
            Route::post('/rating-add/{any}', 'addRating')->name('reward.add');
            Route::post('/faq-list', 'faqList')->name('faq.list');
            Route::post('/privacy-policy-list', 'privacyPolicy')->name('privacy.policy');
            Route::get('/cms/{id}', 'cms')->name('cms');
            Route::get('/faq/{id}', 'faq')->name('faq');
            Route::post('/app-version', 'postAppVersion')->name('app-version');
            Route::get('/get-app-version', 'getAppVersion')->name('get-app-version');
            Route::get('/get-location/{pinCode}', 'getLocation')->name('get-location');

            //Route::post('/workout-list', 'workoutList')->name('workout.list');

        });
        // Route::post('login', [UserApiControllers::class, 'login']);
        Route::controller(UserApiControllers::class)->group(function () {
            Route::post('/payment-intent', 'paymentIntent')->name('payment.intent');
        });
    });


Route::namespace('Api\Trainer')->prefix('trainers')->as('trainers.')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::controller(TrainerApiController::class)->group(function () {
            Route::post('/create-profile', 'createProfile')->name('create.profile');
            //Route::post('/signup','signup')->name('signup');
            Route::post('/update-user-profile', 'updateProfile')->name('update.user.profile');
            Route::post('/change-password', 'changePassword')->name('change.password');
            Route::post('/profile-image-update', 'profileImageupdate')->name('profile.image.update');
            Route::get('/user-details', 'userDetailsv2')->name('user-details');
            Route::get('/user-workout-details', 'userWorkoutDetails')->name('user.workout.details');
            Route::post('/user-health-workout-save', 'userHealthWorkoutSave')->name('user.health.workout.save');
            Route::post('/trainer-list', 'trainerList')->name('trainer.list');
            Route::match(['get', 'post'], '/customer-request-list', 'customerRequestList')->name('customer.request.list');
            Route::post('/subscription-plan-list', 'subscriptionPlanList')->name('subscription.plan.list');
            Route::post('/physically-condition-list', 'physicallyConditionList')->name('physically.condition.list');
            Route::post('/fitness-goal-list', 'fitnessGoalList')->name('fitness.goal.list');
            Route::post('/user-advance-update-details', 'userAdvanceUpdateDetails')->name('user.advance.update.details');

            Route::post('/diet-plan-list', 'dietPlanList')->name('diet.plan.list');
            Route::get('/workout-list', 'workoutList')->name('workout.list');

            Route::post('/user-food-item-save', 'userFoodItemSave')->name('user.food.item.save');
            Route::get('/notification', 'notification')->name('notification');
            Route::match(['get', 'post'], '/customer-request-list', 'customerCallRequestList')->name('customer.call.request.list');
            Route::get('/dasboard', 'dasboardData')->name('dasboard');
            Route::post('/availibity', 'availibityProfile')->name('availibity');
            Route::get('/customer-list', 'customerList')->name('customer.list');
            Route::get('/food-list', 'foodList')->name('food-list');
            Route::post('/slot-update', 'slotUpdate')->name('slot-update');
            Route::post('/update-customer-food', 'updateCustomerFood')->name('update-customer-food');
            Route::post('/edit-customer-food/{any}', 'editCustomerFood')->name('edit-customer-food');
            Route::delete('/delete-customer-food/{any}', 'deleteCustomerFood')->name('delete-customer-food');
            Route::get('/customer-details/{any}', 'customerDetails')->name('customer-details');
            Route::post('/customer-workout-update', 'customerWorkoutUpdate')->name('customer-workout-update');
            Route::post('/live-session', 'liveSession')->name('live-session');
            Route::get('/newuser', 'newUserList')->name('newuser');
        });
    });

    Route::controller(TrainerApiController::class)->group(function () {
        Route::post('/signup', 'signup')->name('signup');
        Route::post('/flogin', 'flogin')->name('flogin');
        Route::post('/verify-otp', 'verifyOtp')->name('verify.otp');
        Route::post('/login', 'login')->name('login');
        Route::post('/login-verify', 'loginVerify')->name('login.verify');


        Route::get('/get-guidance', 'getGuidanceList')->name('get-guidance-list');
        Route::get('/get-bank', 'getBankList')->name('get-bank-list');
        Route::post('/resend-otp', 'resendOtp')->name('resend.otp');
        Route::post('/login-send-otp', 'loginSendOtp')->name('loginSendOtp');
        Route::post('/forgot-password', 'forgotPassword')->name('forgot.password');
        Route::post('/create-password', 'createPassword')->name('create.password');
        Route::post('/reward-list', 'rewardList')->name('reward.list');
        Route::get('/reward-details', 'rewardDetails')->name('reward.details');
        Route::post('/faq-list', 'faqList')->name('faq.list');
        Route::post('/privacy-policy-list', 'privacyPolicy')->name('privacy.policy');
        //Route::post('/workout-list', 'workoutList')->name('workout.list');

    });
    // Route::post('login', [UserApiControllers::class, 'login']);


});

Route::namespace('Api\Trainer')->prefix('v1/trainers')->as('trainers.')->group(function () {

    Route::middleware('auth:api')->group(function () {
        Route::controller(TrainerApiController::class)->group(function () {
            Route::post('/create-profile', 'createProfile')->name('create.profile');
            //Route::post('/signup','signup')->name('signup');
            Route::post('/update-user-profile', 'updateProfile')->name('update.user.profile');
            Route::post('/change-password', 'changePassword')->name('change.password');
            Route::post('/profile-image-update', 'profileImageupdate')->name('profile.image.update');
            Route::get('/user-details', 'userDetails')->name('user-details');
            Route::get('/user-workout-details', 'userWorkoutDetails')->name('user.workout.details');
            Route::post('/user-health-workout-save', 'userHealthWorkoutSave')->name('user.health.workout.save');
            Route::post('/trainer-list', 'trainerList')->name('trainer.list');
            Route::match(['get', 'post'], '/customer-request-list', 'customerRequestList')->name('customer.request.list');
            Route::post('/subscription-plan-list', 'subscriptionPlanList')->name('subscription.plan.list');
            Route::post('/physically-condition-list', 'physicallyConditionList')->name('physically.condition.list');
            Route::post('/fitness-goal-list', 'fitnessGoalList')->name('fitness.goal.list');
            Route::post('/user-advance-update-details', 'userAdvanceUpdateDetails')->name('user.advance.update.details');
            Route::post('/diet-plan-list', 'dietPlanList')->name('diet.plan.list');
            Route::post('/workout-list', 'workoutList')->name('workout.list');
            Route::post('/user-food-item-save', 'userFoodItemSave')->name('user.food.item.save');
            Route::get('/notification', 'notification')->name('notification');
            Route::match(['get', 'post'], '/customer-request-list', 'customerCallRequestList')->name('customer.call.request.list');
        });
    });

    Route::controller(TrainerApiController::class)->group(function () {
        Route::post('/signup', 'signup')->name('signup');
        Route::post('/flogin', 'flogin')->name('flogin');
        Route::post('/verify-otp', 'verifyOtp')->name('verify.otp');
        Route::post('/login', 'login')->name('login');
        Route::post('/login-verify', 'loginVerify')->name('login.verify');


        Route::get('/get-guidance', 'getGuidanceList')->name('get-guidance-list');
        Route::get('/get-bank', 'getBankList')->name('get-bank-list');
        Route::post('/resend-otp', 'resendOtp')->name('resend.otp');
        Route::post('/login-send-otp', 'loginSendOtp')->name('loginSendOtp');
        Route::post('/forgot-password', 'forgotPassword')->name('forgot.password');
        Route::post('/create-password', 'createPassword')->name('create.password');
        Route::post('/reward-list', 'rewardList')->name('reward.list');
        Route::get('/reward-details', 'rewardDetails')->name('reward.details');
        Route::post('/faq-list', 'faqList')->name('faq.list');
        Route::post('/privacy-policy-list', 'privacyPolicy')->name('privacy.policy');
        //Route::post('/workout-list', 'workoutList')->name('workout.list');

    });
    // Route::post('login', [UserApiControllers::class, 'login']);
});

Route::namespace('Api\Trainer')->prefix('v2/trainers')->as('trainers.')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::controller(TrainerApiController::class)->group(function () {
            Route::post('/create-profile', 'createProfile')->name('create.profile');
            //Route::post('/signup','signup')->name('signup');
            Route::post('/update-user-profile', 'updateProfile')->name('update.user.profile');
            Route::post('/change-password', 'changePassword')->name('change.password');
            Route::post('/profile-image-update', 'profileImageupdate')->name('profile.image.update');
            Route::get('/user-details', 'userDetailsv2')->name('user-details');
            Route::get('/user-workout-details', 'userWorkoutDetails')->name('user.workout.details');
            Route::post('/user-health-workout-save', 'userHealthWorkoutSave')->name('user.health.workout.save');
            Route::post('/trainer-list', 'trainerList')->name('trainer.list');
            Route::match(['get', 'post'], '/customer-request-list', 'customerRequestList')->name('customer.request.list');
            Route::post('/subscription-plan-list', 'subscriptionPlanList')->name('subscription.plan.list');
            Route::post('/physically-condition-list', 'physicallyConditionList')->name('physically.condition.list');
            Route::post('/fitness-goal-list', 'fitnessGoalList')->name('fitness.goal.list');
            Route::post('/user-advance-update-details', 'userAdvanceUpdateDetails')->name('user.advance.update.details');

            Route::post('/diet-plan-list', 'dietPlanList')->name('diet.plan.list');
            Route::post('/workout-list', 'workoutList')->name('workout.list');

            Route::post('/user-food-item-save', 'userFoodItemSave')->name('user.food.item.save');
            Route::get('/notification', 'notification')->name('notification');
            Route::match(['get', 'post'], '/customer-request-list', 'customerCallRequestList')->name('customer.call.request.list');
        });
    });
    Route::controller(TrainerApiController::class)->group(function () {
        Route::post('/signup', 'signup')->name('signup');
        Route::post('/flogin', 'flogin')->name('flogin');
        Route::post('/verify-otp', 'verifyOtp')->name('verify.otp');
        Route::post('/login', 'login')->name('login');
        Route::post('/login-verify', 'loginVerify')->name('login.verify');


        Route::get('/get-guidance', 'getGuidanceList')->name('get-guidance-list');
        Route::get('/get-bank', 'getBankList')->name('get-bank-list');
        Route::post('/resend-otp', 'resendOtp')->name('resend.otp');
        Route::post('/login-send-otp', 'loginSendOtp')->name('loginSendOtp');
        Route::post('/forgot-password', 'forgotPassword')->name('forgot.password');
        Route::post('/create-password', 'createPassword')->name('create.password');
        Route::post('/reward-list', 'rewardList')->name('reward.list');
        Route::get('/reward-details', 'rewardDetails')->name('reward.details');
        Route::post('/faq-list', 'faqList')->name('faq.list');
        Route::post('/privacy-policy-list', 'privacyPolicy')->name('privacy.policy');
        //Route::post('/workout-list', 'workoutList')->name('workout.list');

    });
    // Route::post('login', [UserApiControllers::class, 'login']);

    Route::controller(ManageController::class)->group(function () {
        Route::get('/questions-list', 'questionsList')->name('questions.list');
    });

});
