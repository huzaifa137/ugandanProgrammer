<?php

// use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\UserController;
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

Route::get('/original', 'LocationController@original');

Route::controller(LocationController::class)->group(function () {

    Route::group(['middleware' => ['AdminAuth']], function () {

        Route::group(['prefix' => '/tracking'], function () {

            Route::get('/tracking-overview', 'trackingDashboard');
            Route::get('/GPS-dashboard', 'GPSDashboard');
            Route::get('/generate-link', 'generateLink');
            Route::get('/create-track-link', 'createTrackLink');
            Route::get('/activate-track-link', 'activateTrackLink');
            Route::get('/de-activate-track-link', 'deActivateTrackLink');
        });

        Route::get('/generate-tracking-link', 'generateTrackingLink');
        Route::post('/save-tracking-link', 'saveTrackingLink');
        Route::get('/tracking-status-update/{id}', 'statusUpdate');
        Route::get('/pts/{token}', 'trackLink');
        Route::post('/store-user-location', 'storeUserLocation');
        Route::get('/link/{id}', 'handleLinkClick')->name('link.click');
        Route::post('/store-location', 'store');

    });
});

Route::controller(UserController::class)->group(function () {

    Route::group(['prefix' => '/users'], function () {

        Route::get('/user-logout', 'userLogout')->name('user-logout');
        Route::get('/student-logout', 'studentLogout')->name('student-logout');

        Route::group(['middleware' => ['AdminAuth']], function () {
            Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');
            Route::get('/login', 'login')->name('users.login');
            Route::get('/', 'login')->name('admin.dashboard');
            Route::post('auth-user-check', 'checkUser')->name('auth-user-check');
            Route::get('/users-profile', 'userProfile')->name('users-profile');
            Route::get('/users-register', 'userRegister');
            Route::get('/users-information', 'userInformation')->name('users.user-information');
            Route::get('user-account-information/{id}', 'userAccountInformation');
            Route::get('delete-user/{id}', 'deleteUser');
            Route::get('/register', 'register')->name('users.register');
            Route::get('/edit-user-information', 'editUserInformation');
            Route::get('/edit-specific-user/{userid}', 'editSpecificUser');
            Route::get('/terms-and-conditions', 'user_terms_and_conditions')->name('users.terms-and-conditions');
        });

        Route::post('store-internal-user', 'storeInternalUser')->name('store-internal-user');
        Route::post('update-internal-user', 'storeUpdatedInternalUser')->name('update-internal-user');
        Route::post('save-role', 'saveUserRole')->name('save-role');
        Route::post('store-role-update', 'storeRoleUpdate')->name('store-role-update');
        Route::post('store-updated-information', 'storeUpdatedInformation')->name('store-updated-information');

    });

    Route::group(['middleware' => ['AdminAuth']], function () {
        Route::get('/', 'dashboard')->name('dashboard');
    });

    Route::get('password/reset/{id}', 'createNewPassword')->name('password/reset');
    Route::post('auth.save', 'save')->name('auth.save');
    Route::post('regenerate-otp', 'regenerateOTP')->name('regenerate-otp');
    Route::post('user-generate-forgot-password-link', 'generateForgotPasswordLink')->name('user-generate-forgot-password-link');
    Route::post('user-store-new-password', 'store_new_password')->name('user-store-new-password');
    Route::post('supplier-user-otp-verification', 'supplierOtpVerification')->name('supplier-user-otp-verification');
    Route::get('reload-captcha', 'reload_captcha')->name('reload-captcha');
});

Route::controller(MasterDataController::class)->group(function () {

    Route::group(['prefix' => 'master-data'], function () {

        Route::get('master-code-to-data', 'masterCodeToData')->name('master-code-to-data');

        Route::get('/load-data', 'loadData')->name('load.data');
        Route::get('master-table', 'master_table')->name('master-table');
        Route::get('master-code', 'master_code')->name('master-code');
        Route::get('requisition-documents', 'requisitionDocuments');
        Route::get('travel-requisition-documents', 'travelRequisitionDocuments');
        Route::get('supplier-prequalification-criteria', 'supplierPrequalificationEvaluationCriteria');
        Route::post('store-prequalification-criteria', 'storePrequalificationCriteria')->name('store-prequalification-criteria');

        Route::get('edit-record/{id}', 'editRecord');
        Route::get('add-record', 'addRecord')->name('add-record');
        Route::get('add-code', 'addMasterCode')->name('add-code');
        Route::get('edit-code/{id}', 'editMasterCode');
        Route::get('master-code-list/{id}', 'masterCodeList')->name('master-code-list');
        Route::get('master-code-list', 'masterCodeList');
        Route::get('edit-supplier-document/{id}', 'editSupplierDocument');
        Route::post('/store-requisition-document', 'storeRequisitionDocument')->name('master-data/store-requisition-document');

    });

    Route::post('store-travel-requisition-document', 'storeTravelRequisitionDocument')->name('store-travel-requisition-document');
    Route::post('update-supplier-document', 'updateSupplierDocument')->name('update-supplier-document');
    Route::post('update-master-record', 'updateMasterrecord')->name('update-master-record');
    Route::post('update-master-code', 'updateMasterCode')->name('update-master-code');
    Route::post('send-master-code', 'sendMasterCode')->name('send-master-code');
    Route::post('add-new-record', 'addNewRecord')->name('add-new-record');

    Route::get('delete-supplier-document/{id}', 'deleteSupplierDocument');
    Route::get('delete-record/{id}', 'deleteRecord');
    Route::get('delete-code/{id}', 'deleteCode');

});

Route::controller(StudentController::class)->group(function () {

    Route::group(['prefix' => '/users'], function () {
        Route::group(['middleware' => ['AdminAuth']], function () {

            Route::get('/register', 'register')->name('users.register');
            Route::get('/terms-and-conditions', 'user_terms_and_conditions')->name('users.terms-and-conditions');
            Route::get('/user-otp', function () {
                $userId       = session('userId');
                $userEmail    = session('userEmail');
                $userPassword = session('userPassword');

                if (! $userId || ! $userEmail) {
                    return redirect()->route('users.login')->with('fail', 'You must be logged in');
                }

                return view('users.otp', compact(['userId', 'userEmail', 'userPassword']));
            });
        });

        Route::post('user-account-creation', 'userAccountCreation')->name('user-account-creation');
    });
    Route::get('/clear-session', 'flushSession');
});

Route::controller(CourseController::class)->group(function () {

    Route::group(['prefix' => '/courses'], function () {

        Route::group(['middleware' => ['AdminAuth']], function () {
            Route::get('/add-course', 'addCourse')->name('users.register');
            Route::get('/all-courses', 'allCourses')->name('all.courses');
            Route::post('/store-course', 'storeCourse')->name('store.course');
            Route::get('/course-information/{course}', 'courseInformation')->name('courses.show');
            Route::get('/edit-course-information/{course}', 'editcourseInformation')->name('edit.courses.show');

            Route::get('/course-module', 'courseModule')->name('courses.module');
            Route::get('/add-course-module', 'addCourseModule')->name('all.courses.module');

            Route::delete('/delete-course/{course}', 'deletecourseInformation')->name('delete.course');
            Route::delete('/delete-module/{id}', 'deleteModuleInformation')->name('delete.course.module');

            Route::post('/update-course-information', 'updateCourseInformation')->name('update.course.information');
            Route::post('/save-course-module', 'saveCourseModule')->name('save.course.module');
            Route::put('/update-module/{id}', 'updateModule')->name('update.course.module');

        });
        Route::post('user-course-creation', 'userAccountCreation')->name('user-course-creation');
    });
});

Route::controller(ModuleController::class)->group(function () {

    Route::group(['prefix' => '/courses'], function () {

        Route::group(['middleware' => ['AdminAuth']], function () {

            Route::get('/add-course-module', 'addCourseModule')->name('all.courses.module');
            Route::get('/module-information/{couresId}', 'moduleInformation')->name('module.information');

            Route::put('/update-module/{id}', 'updateModule')->name('update.course.module');
            Route::post('/save-course-module', 'saveCourseModule')->name('save.course.module');
            Route::delete('/delete-module/{id}', 'deleteModuleInformation')->name('delete.course.module');
        });
    });
});

Route::controller(LessonController::class)->group(function () {

    Route::group(['prefix' => '/lessons'], function () {

        Route::group(['middleware' => ['AdminAuth']], function () {

            Route::get('/lesson-details/{id}', 'showLesson')->name('lessons.details');
            Route::get('/module-details/{LessonId}', 'moduleDetails')->name('module.details');

            Route::put('/update-lesson/{id}', 'updateModuleLesson')->name('update.module.lesson');
            Route::post('/save-module-lesson', 'saveModuleLesson')->name('save.module.lesson');
            Route::post('/{lesson}/complete', 'lessonComplete')->name('lessons.complete');

            Route::delete('/delete-lesson/{id}', 'deleteModuleLesson')->name('delete.module.lesson');

        });
    });
});

Route::controller(QuizController::class)->group(function () {

    Route::group(['middleware' => ['AdminAuth']], function () {

        Route::group(['prefix' => '/quiz'], function () {
            Route::get('/create-quiz', 'createQuiz')->name('quizzes.create.quiz');
            Route::post('/store-quiz', 'storeQuiz')->name('quizzes.store.quiz');
            Route::get('/all-quizze-and-assignments', 'allQuizzesAndAssignments')->name('all.quizzes');

            Route::get('/all-quizzes', 'allQuizzes')->name('all.quizzes');
            Route::get('/questions/create/{quiz}', 'createQuestions')->name('questions.create');

            Route::post('/questions/{quiz}', 'storeQuestions')->name('questions.store');
            Route::get('/show-questions/{quiz}', 'showQuizQuestions')->name('quizzes.show.questions');

            Route::get('/on-take/{quiz}', 'showQuizForm')->name('quizzes.ontake');
            Route::post('/{quiz}/submit', 'submitQuiz')->name('quizzes.submit');
            Route::get('/attempts/{quiz}', 'attempts')->name('quizzes.attempts');
            Route::get('/show/{quiz}', 'showQuizForm')->name('quizzes.show');
            Route::delete('/delete-quiz-questions/{id}', 'deleteQuizQuestion')->name('questions.destroy');
            Route::delete('/delete-quiz/{quiz}', 'deleteQuiz');

        });

        Route::group(['prefix' => '/assignments'], function () {
            Route::get('/create-assignment', 'createAssignment')->name('create.assignments');
            Route::get('/all-assignments', 'allAssignment')->name('all.assignments');
            Route::post('/storeAssignment', 'storeAssignment')->name('store.assignments');
        });

        Route::get('/get-course-modules/{course_id}', 'getCourseModules');
        Route::get('/get-course-lessons/{module_id}', 'getModuleLesson');

    });
});

Route::controller(codEditorController::class)->group(function () {

    Route::group(['middleware' => ['AdminAuth']], function () {

        Route::group(['prefix' => '/code-editor'], function () {

            Route::get('/programming', 'programmingCodeEditor');
        });

        Route::group(['prefix' => '/certificates'], function () {

            Route::get('/{course}/certificate/preview', 'preview')->name('certificate.preview');
            Route::get('/certificate/template/{course}', 'template')->name('certificate.template');
            Route::get('/all-preview', 'previewAllCertificates')->name('certificates.all');

        });

    });
});

Route::controller(LocationController::class)->group(function () {
    Route::group(['middleware' => ['AdminAuth']], function () {
        Route::get('/{page}', 'index');
    });
});

Route::controller(StudentController::class)->group(function () {

    Route::group(['middleware' => ['StudentAuth']], function () {

        Route::group(['prefix' => '/student'], function () {

            Route::get('/dashboard', 'studentDashboard')->name('student.dashboard');
            Route::get('/profile', 'studentProfile')->name('student.profile');
            Route::get('/edit-student-profile', 'editStudentProfile');
            Route::get('/courses-and-lessons', 'coursesAndLessons')->name('student.courses.lessons');
            Route::get('/lessons-and-study', 'lessonsAndStudy')->name('student.lesson.study');
            Route::get('/cart', 'addCart')->name('student.cart');
            Route::get('/cart/remove/{id}', 'removeCart')->name('cart.remove');
            Route::get('/checkout', 'checkout')->name('student.checkout');
            Route::get('/courses/filter', 'filterCourses')->name('student.courses.filter');
            Route::get('/course-details/{id}', 'courseDetails')->name('course.details');
            Route::get('/course-study/{id}', 'courseStudy')->name('course.study');
            Route::get('/ongoing-lesson/{id}', 'lessonStudying')->name('lesson.ongoing');
            Route::get('/lesson-details/{id}', 'showLesson')->name('student.lessons.details');
            Route::get('/show/{quiz}', 'showQuizForm')->name('student.quizzes.show');
            Route::get('/all-preview', 'previewAllCertificates')->name('certificates.all');
            Route::get('/{course}/certificate/download', 'download')->name('certificate.download');

            Route::post('/{lesson}/complete', 'lessonComplete')->name('student.lessons.complete');
            Route::post('/{quiz}/submit', 'submitQuiz')->name('student.quizzes.submit');
            Route::post('/checkout-process', 'processCheckout')->name('checkout.process');
            Route::post('/add-to-cart/{id}', 'addToCartAction')->name('student.add.cart');
            Route::post('/enroll-course-cart-action/{id}', 'enrollCourseCartAction')->name('student.enroll.course.action');
            Route::post('/cart/update-quantity', 'updateQuantity')->name('cart.updateQuantity');
        });

    });
});
