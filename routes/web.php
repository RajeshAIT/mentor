<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\UserPostController;
use App\Http\Controllers\Api\MediaImageController;
use App\Http\Controllers\Api\ContentpageController;
use App\Http\Controllers\Api\PostManagementController;

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
    return view('pages.index');
})->name('admin_login');
Route::get('/admin-login', function () {
    return view('auth.login');
})->name('login_page');
    // Total no.of Mentor and Mentees
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

    //content page module
    Route::get('content/{url_title}',[ContentpageController::class,'viewContentPage'])->name('view_content_page');
    //content page module

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

        //Admin Profile Page
        Route::get('profileedit/{id}',[UserController::class, 'userprofileedit'])->name('profileedit');
        Route::post('/updateprofile/{id}',[UserController::class, 'updateprofile'])->name('updateprofile');



        //video report module
        Route::get('video-report',[UserController::class, 'videoReport'])->name('video_report');
        Route::delete('video/delete/{id}',[UserController::class, 'videoDelete'])->name('video_delete');
        //video report module

        //post report module
        Route::get('post-report',[UserController::class, 'postReport'])->name('post_report'); 
        Route::delete('post/delete/{id}',[UserController::class, 'postDelete'])->name('post_delete');
        //post report module

        //privacy policy module module
        Route::get('content-page',[ContentpageController::class, 'contentPageIndex'])->name('content_page_index');
        Route::get('content-page/add',[ContentpageController::class, 'contentPageAddIndex'])->name('content_page_add');

        Route::post('add-content-page',[ContentpageController::class, 'addContentPage'])->name('content_page');
        Route::get('content-page/edit/{id}',[ContentpageController::class, 'contentPageEditIndex'])->name('content_page_edit');
        Route::delete('content-page/delete/{id}',[ContentpageController::class, 'contentPageDelete'])->name('content_delete');

    });
    
        Route::get('verify/{token}',[CompanyController::class, 'verify'])->name('emails.emailVerificationEmail');
        Route::post('account/verify/{token}', [CompanyController::class, 'companyVerify'])->name('company.Verify');

        Route::get('forgotpassword/{token}',[UserController::class, 'forgotpassword'])->name('emails.change_password');
        Route::post('updatepassword/{token}', [UserController::class, 'updatepassword'])->name('user.forgotpassword');

    // post management
    Route::resource('postmanagement',PostManagementController::class);
    Route::post('post/management',[PostManagementController::class,'index'])->name('post.management');
    Route::get('post/destroy/{id}',[PostManagementController::class,'destroy'])->name('post.destroy');

    // Company Records module
    Route::resource('companylist',CompanyController::class);
    Route::get('company',[CompanyController::class,'companyindex'])->name('companyindex');
    Route::get('company/destroy/{id}',[CompanyController::class,'companydestroy'])->name('companydestroy');
    Route::get('company/show/{id}', [CompanyController::class, 'companyshow'])->name('companyshow');

    
    // user post management

    Route::resource('userpost',UserPostController::class);
    Route::get('user/post',[UserPostController::class,'index'])->name('user.post');
    Route::get('user/destroy/{id}',[UserPostController::class,'destroy'])->name('user.destroy');
    

    //invalid response
    Route::get('invalid-try',[UserController::class, 'invalidEmail'])->name('invalid_email');
    //invalid response

    //invalid response
    Route::get('video-url/{id}',[UserController::class, 'videoURL'])->name('video_url');
    Route::get('get-media/{id}',[UserController::class, 'getMedia'])->name('get_media');
    //invalid response



    // Display company show detail
    Route::get('logo/{id}',[ImageController::class,'companyLogo'])->name('companieslogo');


    Route::get('post/media/{post_id}', [MediaImageController::class,'mediaImage'])->name('postmediaImage');
    
    //Bar-Chart
    Route::post('chartfilter',[UserController::class, 'chartFilter'])->name('chartFilter');
    