<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
   // return $request->user();
//});

// login and register api
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('password', [UserController::class, 'createpassword']);

//reset password
Route::post('forgotpassword', [ForgotPasswordController::class, 'sendResetLinkResponse']);
Route::post('password', [ForgotPasswordController::class, 'sendResetResponse']);
Route::post('notification', [ForgotPasswordController::class, 'sendPasswordResetNotification']);

// Write Api for company

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('company', [CompanyController::class, 'store']);
    Route::post('company/{id}', [CompanyController::class, 'update']);
    Route::post('post', [PostController::class, 'store']);
});
Route::get('image/{id}', [ImageController::class,'displayImage'])->name('logo.displayImage');

