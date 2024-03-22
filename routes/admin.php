<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\ContacUsController;
use Illuminate\Support\Facades\Route;

Route::namespace('Admin')->as('admin.')->middleware(['auth'])->group(function () {

    Route::controller(MenuController::class)->prefix('menu')->as('menu.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/add', 'create')->name('add');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/store', 'store')->name('store');
        Route::post('/update/{id}', 'update')->name('update');
    });
    Route::controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('home');
        Route::match(['get', 'post'], '/change-password', 'changePassword')->name('change.password');
        Route::match(['get', 'post'], '/profile', 'profile')->name('profile');
        Route::get('/admin-users', 'adminUser')->name('user.list');
        Route::match(['get', 'post'], '/admin-users/edit/{uuid}', 'adminUserEdit')->name('user.edit');
    });
    Route::controller(InvitationController::class)->as('invitation.')->group(function () {
        Route::get('/invitation-list', 'list')->name('list');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::match(['get', 'post'], '/{uuid}/attach-permission', 'attachPermission')->name('attach.permission');
    });
    Route::controller(RoleController::class)->as('role.')->prefix('roles')->group(function () {
        Route::get('/', 'listRoles')->name('list');
        Route::get('/add', 'addRoles')->name('add');
        Route::post('/save', 'saveRoles')->name('save');
        Route::match(['get', 'post'], '/{id}/attach-permission', 'attachPermission')->name('attach.permission');
    });
    Route::controller(CustomerController::class)->as('customer.')->middleware('permission:list-customers-user|view-customers-user|live-session')->prefix('customers')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/add', 'addCustomers')->name('add');
        Route::post('/save', 'store')->name('save');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editCustomers')->name('edit');
        Route::get('/delete/{uuid}', 'deleteCustomers')->name('delete');
        Route::get('/view-address/{uuid}', 'viewAddress')->name('view.address');
        Route::get('/view-details/{uuid}', 'viewDetails')->name('view.details');
        Route::match(['get', 'post'], '/update-address/{uuid}', 'editAddress')->name('update.address');
        Route::get('/transaction', 'transaction')->name('transaction');
        Route::get('/livesession', 'liveSession')->name('livesession');
    });
    Route::controller(TrainerController::class)->as('trainer.')->middleware('permission:add-trainers-dietitian|list-trainers-dietitian|edit-trainers-dietitian|delete-trainers-dietitian')->prefix('trainers')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'addTrainers')->name('add');
        Route::post('/save', 'store')->name('save');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editTrainers')->name('edit');
        Route::get('/delete/{uuid}', 'deleteTrainers')->name('delete');
        /* Route::get('/view-address/{uuid}', 'viewAddress')->name('view.address');
        Route::match(['get', 'post'], '/update-address/{uuid}', 'editAddress')->name('update.address'); */
    });

    Route::controller(DoctorController::class)->as('doctor.')->middleware('permission:add-doctor|list-doctor|edit-doctor|delete-doctor')->prefix('doctor')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'addDoctor')->name('add');
        Route::post('/save', 'store')->name('save');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editDoctor')->name('edit');
        Route::get('/delete/{uuid}', 'deleteDoctor')->name('delete');
        /* Route::get('/view-address/{uuid}', 'viewAddress')->name('view.address');
        Route::match(['get', 'post'], '/update-address/{uuid}', 'editAddress')->name('update.address'); */
    });

    Route::controller(FaqController::class)->as('cms.')->middleware('permission:faq|update-privacy-policy|term-and-condition|contact-us|help-and-support')->prefix('cms')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], 'faq', 'addFaq')->name('faq');
        Route::match(['get', 'post'], 'privacy-policy', 'addprivacy')->name('privacy.policy');
        Route::match(['get', 'post'], 'term-and-condition', 'addterm')->name('term.and.condition');
        Route::match(['get', 'post'], 'contact-us', 'addcontact')->name('contact.us');
        Route::match(['get', 'post'], 'helps-support', 'addHelpSupport')->name('helps.support');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editFaq')->name('edit');
        Route::get('/delete/{uuid}', 'deleteFaq')->name('delete');
    });
    Route::controller(RewardController::class)->as('reward.')->middleware('permission:add-rewards|list-rewards|edit-rewards|delete-rewards')->prefix('rewards')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], 'add', 'addReward')->name('add');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editReward')->name('edit');
        Route::get('/delete/{uuid}', 'deleteReward')->name('delete');
    });
    Route::controller(PagesController::class)->as('page.')->prefix('pages')->group(function () {
        Route::get('/', 'viewPage')->name('list');
        Route::match(['get', 'post'], 'add', 'addPage')->name('add');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editPage')->name('edit');
        Route::get('/delete/{uuid}', 'deletePage')->name('delete');
    });
    Route::controller(DietPlanController::class)->as('diet.')->middleware('permission:add-diet|add-food|edit-food|delete-food')->prefix('diet')->group(function () {
        Route::match(['get', 'post'], '/', 'dietPlanList')->name('plan.list');
        Route::match(['get', 'post'], '/diet-add', 'addDiet')->name('plan.add');
        Route::match(['get', 'post', 'put'], 'diet-edit/{uuid}', 'editDiet')->name('plan.edit');
        Route::get('/breakfast-list', 'dietBreakfastList')->name('breakfast.list');
        Route::match(['get', 'post'], '/breakfast-add', 'addBreakfast')->name('breakfast.add');
        Route::match(['get', 'post', 'put'], 'breakfast-edit/{uuid}', 'editBreakfast')->name('breakfast.edit');
        Route::get('/lunch-list', 'dietLunchList')->name('lunch.list');
        Route::get('/lunch-add', 'addLunch')->name('lunch.add');
        Route::match(['get', 'post', 'put'], 'lunch-edit/{uuid}', 'editLunch')->name('edit.lunch');
        Route::get('/food-list', 'dietFoodList')->name('food.list');
        Route::match(['get', 'post', 'put'], 'create-food-details/{uuid}', 'createFoodDetails')->name('create.food.details');
        Route::match(['get', 'post', 'put'], 'food-details/{uuid}', 'viewFoodDetails')->name('view.food.details');
        Route::match(['get', 'post'], '/food-add', 'addFood')->name('food.add');
        Route::match(['get', 'post', 'put'], 'food-edit/{uuid}', 'editFood')->name('edit.food');
        Route::get('/dinner-list', 'dietDinnerList')->name('dinner.list');
        Route::get('/dinner-add', 'addDinner')->name('dinner.add');
        Route::match(['get', 'post', 'put'], 'dinner-edit/{uuid}', 'editDinner')->name('edit.dinner');
        Route::post('/save', 'store')->name('save');
    });
    Route::controller(WorkoutPlanController::class)->as('workout.')->prefix('workout')->group(function () {
        Route::match(['get', 'post'], '/', 'WorkoutPlanList')->name('list');
        Route::match(['get', 'post'], '/workout-add', 'addWorkout')->name('add');
        Route::match(['get', 'post', 'put'], 'workout-edit/{uuid}', 'editWorkout')->name('edit');
        Route::match(['get', 'post', 'put'], 'view-details/{uuid}', 'viewWorkoutDetails')->name('view.details');
        Route::match(['get', 'post', 'put'], 'create-details/{uuid}', 'createWorkoutDetails')->name('create.details');
    });

    Route::controller(CategoryController::class)->as('product.category.')->prefix('product/category')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], 'add', 'addCategory')->name('add');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editCategory')->name('edit');
        Route::get('/delete/{uuid}', 'deleteCategory')->name('delete');
    });

    Route::controller(AttributeController::class)->as('product.points.')->prefix('product/points')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], 'add', 'addAttribute')->name('add');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editAttribute')->name('edit');
        Route::get('/delete/{uuid}', 'deleteAttribute')->name('delete');
    });
    Route::controller(ContacUsController::class)->as('contact-us.')->prefix('contact-us')->group(function () {
        Route::get('/', 'index')->name('list');
       
    });

    Route::controller(ProductController::class)->as('product.')->prefix('product')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], 'add/{uuid}', 'addProduct')->name('add');
        Route::match(['get', 'post'], 'addimport/{uuid}', 'addProductimport')->name('addimport');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editProduct')->name('edit');
        Route::get('/delete/{uuid}', 'deleteProduct')->name('delete');
        Route::get('/bannerlist', 'bannerList')->name('bannerlist');
        Route::match(['get', 'post'], 'addbanner', 'addBanner')->name('addbanner');
        Route::match(['get', 'post', 'put'], 'editbanner/{any}', 'editBanner')->name('editbanner');
        Route::get('/delete/{uuid}', 'deleteBanner')->name('delete');
    });

    Route::prefix('subscription')->as('subscription.')->group(function () {
        Route::controller(PlanCategoryController::class)->prefix('categories')->as('category.')->group(function () {
            Route::get('/', 'viewCategory')->name('list');
            Route::get('details/{uuid}', 'categoryDetails')->name('view');
            Route::match(['get', 'post'], 'add', 'addCategory')->name('add');
            Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editCategory')->name('edit');
            Route::post('/getCategories', 'getCategory')->name('get.categories');
            Route::get('/delete/{uuid}', 'deleteCategory')->name('delete');
        });
        Route::controller(CourseController::class)->as('course.')->prefix('courses')->group(function () {
            Route::get('/course-list', 'courseList')->name('list');
            Route::match(['get', 'post'], 'add', 'addCourse')->name('add');
            Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editCourse')->name('edit');
            Route::get('/delete/{uuid}', 'deleteCourse')->name('delete');
        });
        Route::controller(PlanController::class)->as('plan.')->prefix('plans')->group(function () {
            Route::get('/plan-list', 'planList')->name('list');
            Route::match(['get', 'post'], 'add', 'addPlan')->name('add');
            Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editPlan')->name('edit');
            Route::get('/delete/{uuid}', 'deletePlan')->name('delete');
        });
    });

    Route::controller(SalesController::class)->as('sales.')->middleware('permission:add-sales-manager|list-sales-manager|edit-sales-manager|delete-sales-manager')->prefix('sales')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'addSales')->name('add');
        Route::post('/save', 'store')->name('save');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editSales')->name('edit');
        Route::get('/delete/{uuid}', 'deleteSales')->name('delete');



        /* Route::get('/view-address/{uuid}', 'viewAddress')->name('view.address');
        Route::match(['get', 'post'], '/update-address/{uuid}', 'editAddress')->name('update.address'); */
    });

    Route::controller(SalesAgentController::class)
        ->as('agent.')
        ->middleware('permission:add-agent-manager|list-agent-manager|edit-agent-manager|delete-agent-manager')
        ->prefix('agent')
        ->group(function () {
            Route::get('/', 'index')->name('list');
            Route::match(['get', 'post'], '/add', 'addAgent')->name('add');
            Route::post('/save', 'store')->name('save');
            Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editAgent')->name('edit');
            Route::get('/delete/{uuid}', 'deleteAgent')->name('delete');
            Route::get('/report/{uuid}', 'reportAgent')
                ->name('report')
                ->withoutMiddleware('permission:add-agent-manager|list-agent-manager|edit-agent-manager|delete-agent-manager');

            Route::get('/reporttotal/{uuid}', 'reportTotalAgent')
                ->name('reporttotal')
                ->withoutMiddleware('permission:add-agent-manager|list-agent-manager|edit-agent-manager|delete-agent-manager');
            Route::post('import', 'import')->name('import');
            Route::match(['get', 'post', 'put'], 'reportexport/{uuid}', 'reportExportCsv')->name('reportexport');
            Route::get('/qrpage/{uuid}', 'qrPage')
                ->name('qrpage')
                ->withoutMiddleware('permission:add-agent-manager|list-agent-manager|edit-agent-manager|delete-agent-manager');
        });


    Route::controller(VendorController::class)
        ->as('vendor.')
        ->middleware('permission:add-agent-manager|list-agent-manager|edit-agent-manager|delete-agent-manager')
        ->prefix('vendor')
        ->group(function () {
            Route::get('/', 'index')->name('list');
            Route::match(['get', 'post'], '/add', 'addVendor')->name('add');
            Route::post('/save', 'store')->name('save');
            Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editVendor')->name('edit');
            Route::get('/delete/{uuid}', 'deleteVendor')->name('delete');
        });
});




Route::post('admin/logout', 'Auth\LoginController@adminLogout')->name('admin.logout');





Route::get('/', 'Admin\MfiController@mfiList')->name('mfi-list');
