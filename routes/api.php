<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\MediaImageController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\QuestionsController;
use App\Http\Controllers\Api\CategoriesController;

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
Route::post('register', [UserController::class, 'register'])->name('register');
Route::post('login', [UserController::class, 'login']);
Route::post('password', [UserController::class, 'createpassword']);

//reset password
Route::post('forgotpassword', [ForgotPasswordController::class, 'sendResetLinkResponse']);
Route::post('password', [ForgotPasswordController::class, 'sendResetResponse']);
Route::post('notification', [ForgotPasswordController::class, 'sendPasswordResetNotification']);

// Write Api for company

Route::group(['middleware' => ['auth:api']], function () {

    Route::post('changepassword',[UserController::class, 'changepassword']);
    
    Route::post('reset_password', [UserController::class, 'resetpassword']);
	Route::post('logout',[UserController::class, 'logout']);
    Route::post('company/store', [CompanyController::class, 'store']);
    Route::get('company/show/{id}', [CompanyController::class, 'show']);
    Route::post('company', [CompanyController::class,'websiteverify']);
    Route::post('invitepeople', [CompanyController::class,'invitepeople']);
    Route::get('getpeople/{email}/{company_id}', [CompanyController::class,'getpeople']);
    
    Route::post('post/store', [PostController::class, 'store']);
    Route::get('post/show/{id}/{post_type_id}', [PostController::class, 'show']);
    
    Route::post('follow',[UserController::class,'follow']);
    Route::get('getfollow',[UserController::class,'getfollow']);
    Route::get('getunfollow',[UserController::class,'getunfollow']);
    Route::post('userprofile',[UserController::class,'ProfileResponse']);
    Route::get('viewprofile/{id}',[UserController::class,'show']);
	Route::post('question/add',[QuestionsController::class,'getQuestionAnswer']);
    Route::post('categories/questions',[CategoriesController::class,'categorizethequestion']);
    Route::post('category/store', [CategoriesController::class, 'store']);
    Route::post('top/question',[QuestionsController::class,'TopQuestions']);
    Route::post('question/feed',[QuestionsController::class,'questionFeed']);
    Route::post('landing/page',[QuestionsController::class,'landingpage']);
	Route::get('get/answers',[QuestionsController::class,'getAnswersForQuestions']); 
	Route::post('question/answer',[QuestionsController::class,'answerforquestions']);
    Route::get('search/{name}',[QuestionsController::class,'search']);
	Route::get('question/{id}/answer',[QuestionsController::class,'viewAnswer'])->name('answer.viewAnswer');
    Route::post('question/upvote',[QuestionsController::class,'upVote']);
    Route::post('answer/reaction',[QuestionsController::class,'reaction']);
    Route::get('leaderboard', [QuestionsController::class,'leaderboard']);
    Route::get('audio/logo',[QuestionsController::class,'audio']);
});

Route::get('image/{id}', [ImageController::class,'displayImage'])->name('logo.displayImage');
Route::get('post/media/{post_id}', [MediaImageController::class,'mediaImage'])->name('media_url.mediaImage');
Route::get('post/media/thumbnail/{post_id}', [MediaImageController::class,'mediaThumbnail'])->name('media_url.mediaThumbnail');
Route::get('user/profile/images/{id}', [ImageController::class,'profilephoto'])->name('photo.profilephoto');
Route::get('question/answer',[ImageController::class,'viewAnswer'])->name('answer.viewAnswer');
Route::get('top/question/{id}',[ImageController::class,'ViewQuestion'])->name('question.viewQuestion');
Route::get('company/logo/{id}',[ImageController::class,'companyLogo'])->name('logo.companyLogo');
Route::get('answer/media/{id}',[ImageController::class,'mediafile'])->name('answer.mediafile');