<?php

use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// customer/user

//login page
// Route::get('/account/login',[LoginController::class,'index'])->name('account.login');
// Route::post('/account/authenticate',[LoginController::class,'authenticate'])->name('account.authenticate');

// // succesful customer login after show the page 
// Route::get('/account/dashboard', [DashboardController::class, 'index'])->name('account.dashboard');

// // register
// Route::get('/account/register', [LoginController::class, 'register'])->name('account.register');
// Route::post('/account/process-register', [LoginController::class, 'processRegister'])->name('account.processRegister');


// LogOut

// Route::get('/account/logout',[LoginController::class,'logout'])->name('account.logout');



Route::group(['prefix'=>'account'],function(){
    // Guest Middleware or without login
  Route::group(['middleware'=>'guest'],function(){
    Route::get('login', [LoginController::class, 'index'])->name('account.login');
    Route::post('authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
    Route::get('register', [LoginController::class, 'register'])->name('account.register');
    Route::post('process-register', [LoginController::class, 'processRegister'])->name('account.processRegister');


  });
//   Authentiated Middleware or login then show the page

  Route::group(['middleware'=>'auth'],function(){
        Route::get('logout', [LoginController::class, 'logout'])->name('account.logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('account.dashboard');
  });

});


//Admin 

// Route::get('admin/login', [AdminLoginController::class, 'index'])->name('admin.login');
// Route::post('admin/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
// Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
// Route::get('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


Route::group(['prefix' => 'admin'], function () {
    // Guest Middleware for admin or without login
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });
    //   Authentiated Middleware for admin or login then show the page

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
});