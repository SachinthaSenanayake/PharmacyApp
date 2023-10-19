<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\CustomerController;
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

Route::prefix('admin')->middleware('auth','isadmin')->group(function(){
    Route::get('/dashboard',[LoginController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard',[CustomerController::class,'index']);
    Route::post('/dashboard',[CustomerController::class,'store']);
});

Route::get('/adminsignup', [LoginController::class, 'adminsignup'])->name('register-admin');
Route::post('/adminpostsignup', [LoginController::class, 'adminsignupsave'])->name('adminpostsignup'); 

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'login'])->name('postlogin');
Route::get('/dashboard',[LoginController::class,'userdashboard'])->name('user.userdashboard')->middleware('auth');
Route::get('/signup', [LoginController::class, 'signup'])->name('register-user');
Route::post('/postsignup', [LoginController::class, 'signupsave'])->name('postsignup'); 
Route::post('/logout',[LoginController::class,'logout'])->name('logout');

Route::get('/fetch-customer',[CustomerController::class,'fetchcustomer']);
Route::get('/edit-customer/{id}',[CustomerController::class,'edit']);
Route::get('/search-customer/{id}',[CustomerController::class,'search']);
Route::put('/update-customer/{id}',[CustomerController::class,'update']);
Route::delete('/delete-customer/{id}',[CustomerController::class,'delete']);