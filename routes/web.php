<?php

use App\Http\Controllers\Api\PostManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserPostController;
use App\Http\Controllers\Api\CompanyController;

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
    return view('auth.login');
});

    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::get('leaderboard',[AuthController::class,'leaderboard'])->name('leaderboard');
    Route::get('top-question',[AuthController::class,'topquestion'])->name('topquestion');
    Route::get('ask-question',[AuthController::class,'askquestion'])->name('askquestion');
 
    Route::get('mentors',[AuthController::class,'mentors'])->name('mentors');
    Route::get('mentees',[AuthController::class,'mentees'])->name('mentees');
    //Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
    //Route::get('dashboard', [AuthController::class, 'dashboard']);
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');

    Route::group(['middleware' => ['auth:web']], function ()
    {
        Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('create',[UserController::class, 'create'])->name('create_user');
        Route::post('store',[UserController::class, 'store'])->name('store');
        Route::get('mentor',[UserController::class, 'mentor'])->name('mentor_report');
        Route::get('mentee',[UserController::class, 'mentee'])->name('mentee_report');
        Route::get('edit/{id}',[UserController::class, 'edit'])->name('user_edit');
        Route::patch('/update/{id}',[UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}',[UserController::class, 'destroy'])->name('delete');
        Route::get('user/profile/images/{id}', [ImageController::class,'profilephoto'])->name('photo.ProfileLogo');
    });
    
        Route::get('verify/{token}',[CompanyController::class, 'verify'])->name('emails.emailVerificationEmail');
        Route::post('account/verify/{token}', [CompanyController::class, 'companyVerify'])->name('company.Verify');

        Route::get('forgotpassword/{token}',[UserController::class, 'forgotpassword'])->name('emails.change_password');
        Route::put('updatepassword/{token}', [UserController::class, 'updatepassword'])->name('user.forgotpassword');

    // post management
    Route::resource('postmanagement',PostManagementController::class);
    Route::post('post/management',[PostManagementController::class,'index'])->name('post.management');
    Route::get('post/destroy/{id}',[PostManagementController::class,'destroy'])->name('post.destroy');

    // user post management

    Route::resource('userpost',UserPostController::class);
    Route::get('user/post',[UserPostController::class,'index'])->name('user.post');
    Route::get('user/destroy/{id}',[UserPostController::class,'destroy'])->name('user.destroy');