<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Backend\NotificationController;
use App\Http\Controllers\API\Backend\PostController;
use App\Http\Controllers\API\Backend\SystemSettingsController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\Frontend\CustomerController;
use App\Http\Controllers\API\Frontend\PackageController;
use App\Http\Controllers\API\SeoDataController;
use App\Mail\GroupMemberMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Backend\CustomerController as BackendCustomerController;
use App\Http\Controllers\API\Backend\PackageController as BackendPackageController;
use App\Http\Controllers\API\Frontend\PostController as FrontendPostController;

Route::middleware(['guest'])->group(function () {
    Route::post('login', [LoginController::class, 'login'])->name('login');
//    Route::post('register', [RegisterController::class, 'register']);
//    Route::post('resend_otp', [RegisterController::class, 'resend_otp']);
//    Route::post('verify_email', [RegisterController::class, 'verify_email']);
    Route::post('forgot-password', [RegisterController::class, 'forgot_password']);
    Route::post('verify-otp', [RegisterController::class, 'verify_otp']);
    Route::post('reset-password', [RegisterController::class, 'reset_password']);
});

Route::middleware('auth:sanctum')->group(function () {
    //logout
    Route::post('logout', [LoginController::class, 'logout']);
    //profile routes
    Route::get('user', [LoginController::class, 'user']);
    Route::post('profile-update', [LoginController::class, 'profile_update']);
});

//fetch meta data
Route::get('/meta-data/{type}',[SeoDataController::class, 'show']);


//admin Routes
Route::middleware(['admin','auth:sanctum'])->prefix('admin')->group(function (){
    Route::get('/available-zip-codes',[BackendCustomerController::class,'availableZipCodes']);
    Route::get('/available-regions',[BackendCustomerController::class,'availableRegions']);
    Route::get('/customers',[BackendCustomerController::class,'index']);
    Route::get('/customer/group',[BackendCustomerController::class,'group']);
    //get single customer group
    Route::get('/customer/group/{id}',[BackendCustomerController::class,'singleGroup']);

    //notification routes
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/mark-as-read-all', [NotificationController::class, 'markAsReadAll']);
    Route::delete('/notifications/delete', [NotificationController::class, 'delete']);
    Route::delete('/notifications/delete-all', [NotificationController::class, 'deleteAll']);

    //package routes
    Route::controller(BackendPackageController::class)->prefix('packages')->group(function () {
        Route::get('/{type}','index');
        Route::post('/update/{package}','update');
    });

    //system settings routes
    Route::controller(SystemSettingsController::class)->prefix('system-settings')->group(function () {
        Route::get('/','index');
        Route::post('/update','update');
    });

    //send group member mail
    Route::post('/send-group-member-mail',[BackendCustomerController::class,'sendGroupMemberMail']);

    //Blogs routes
    Route::apiResource('/blogs',PostController::class);
    Route::post('/blogs/status/{id}',[PostController::class,'status']);
    Route::get('/tags',[PostController::class,'getTags']);

    //update meta data
    Route::post('/meta-data',[SeoDataController::class, 'update']);
});

//frontend routes
Route::prefix('customer')->group(function () {
    Route::post('subscribe',[CustomerController::class,'subscribe']);
    //get packages
    Route::get('packages',[PackageController::class,'index']);
    //customer data validation routes{
    Route::post('/personal-info-validate',[CustomerController::class,'personalInfoValidate']);
    Route::post('/address-validate',[CustomerController::class,'addressValidation']);
    Route::post('/company-info-validate',[CustomerController::class,'companyInfoValidation']);


    //contact mail
    Route::post('/contact',[ContactController::class,'contact']);

    //blog post routes
    Route::get('/blogs',[FrontendPostController::class,'index']);
    Route::get('/blogs/{slug}',[FrontendPostController::class,'show']);

    Route::get('/settings',[SystemSettingsController::class,'index']);
    Route::get('/incomplete-application/{id}',[CustomerController::class,'incompleteApplication']);
});

