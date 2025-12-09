<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Http\Controllers\JobsController;

use Illuminate\Auth\Middleware\Authenticate as MiddlewareAuthenticate;

//public route
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs.index');

//public for testing


//guest account routes
Route::get('/account/registration', [AccountController::class, 'registration'])->name('account.registration');
Route::post('/account/process-registration', [AccountController::class, 'processRegistration'])->name('account.processRegistration');

Route::get('/account/login', [AccountController::class, 'login'])->name('account.login');
Route::post('/account/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');

//Route::get('/account/profile',action:[AccountController::class,'profile'])->name('account.profile')->middleware(Authenticate::class);




//Authenticate route
Route::middleware(Authenticate::class)->group(function () {

    Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::put('/account/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::post('/account/update-profile-pic',  [AccountController::class, 'updateProfilePic'])->name('account.updateProfilePic');
    Route::get('/account/logout', [AccountController::class, 'logout'])->name('account.logout');
    Route::get('/account/create-Job', [AccountController::class, 'createJob'])->name('account.createJob');
        Route::post('/account/save-Job', [AccountController::class, 'saveJob'])->name('account.saveJob');
        Route::get('/account/my-Jobs',[AccountController::class,'myJobs'])->name('account.myJobs');
        Route::get('/account/edit-Jobs/{jobId}',[AccountController::class,'editJobs'])->name('account.editJobs');
        Route::post('/account/update-Jobs/{jobId}',[AccountController::class,'updateJobs'])->name('account.updateJobs');
        Route::post('/account/delete-Jobs/{jobId}',[AccountController::class,'deleteJobs'])->name('account.deleteJobs');

});


