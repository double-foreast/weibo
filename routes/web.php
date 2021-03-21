<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\StaticPagesController;
Route::get('/', [StaticPagesController::class,'home'])->name('home');
Route::get('/help', [StaticPagesController::class,'help'])->name('help');
Route::get('/about', [StaticPagesController::class,'about'])->name('about');

use App\Http\Controllers\UsersController;
Route::get('/signup', [UsersController::class,'create'])->name('signup');
Route::resource('users', UsersController::class);
Route::get('/signup/confirm/{token}',[UsersController::class,'confirmEmail'])->name('confirm_email');

use App\Http\Controllers\SessionsController;
Route::get('/login',[SessionsController::class,'create'])->name('login');
Route::post('/login',[SessionsController::class,'store'])->name('login');
Route::get('/logout',[SessionsController::class,'destory'])->name('logout');

use App\Http\Controllers\PasswordController;
Route::get('password/email',[PasswordController::class,'getEmail'])->name('password.email');
Route::post('password/email',[PasswordController::class,'postEmail'])->name('password.email');
Route::get('password/reset/{token}',[PasswordController::class,'getReset'])->name('password.reset');
Route::post('password/reset',[PasswordController::class,'postReset'])->name('password.update');

use App\Http\Controllers\StatusesController;
Route::resource('statuses',StatusesController::class)->only(['store','destroy']);

