<?php

use App\Http\Controllers\AuditTrailController;
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
        Route::get('/pts/{token}',  'trackLink');
        Route::post('/store-user-location',  'storeUserLocation');
        Route::get('/link/{id}', 'handleLinkClick')->name('link.click');
        Route::post('/store-location',  'store');

    });
});

Route::controller(UserController::class)->group(function () {

    Route::group(['prefix' => '/users'], function () {

        Route::get('/user-logout', 'userLogout')->name('user-logout');
        Route::group(['middleware' => ['AdminAuth']], function () {
            Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');
            Route::get('/login', 'login')->name('users.login');
            Route::get('/', 'login');
            Route::post('auth-user-check', 'checkUser')->name('auth-user-check');
            Route::get('/users-profile', 'userProfile')->name('users-profile');
            Route::get('/users-register', 'userRegister');
            Route::get('/users-information', 'userInformation')->name('users.user-information');
            Route::get('/user-roles', 'userRoles')->name('user-roles');
            Route::get('/add-user-role', 'addUserRole')->name('add-user-role');
            Route::get('edit-role/{id}', 'editRole');
            Route::get('delete-role/{id}', 'deleteRole');
            Route::get('user-account-information/{id}', 'userAccountInformation');
            Route::get('edit-user-information/{id}', 'editUserInformation');
            Route::get('delete-user/{id}', 'deleteUser');

        });

        Route::post('save-role', 'saveUserRole')->name('save-role');
        Route::post('store-role-update', 'storeRoleUpdate')->name('store-role-update');
        Route::post('store-updated-information', 'storeUpdatedInformation')->name('store-updated-information');

    });

    Route::post('store-user', 'storeUser')->name('store-user');

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
        // Route::get('edit-record/{mc_id}/{item_id}', 'editRecord');
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

Route::controller(AuditTrailController::class)->group(function () {

    Route::get('audit-trail/today', 'today')->name('audit-trail/today');
    Route::get('audit-trail/audit-report', 'auditReport')->name('audit-trail/audit-report');
    Route::post('audit-trail/filter-audit-report', 'filterAuditReport')->name('audit-trail/filter-audit-report');
});
