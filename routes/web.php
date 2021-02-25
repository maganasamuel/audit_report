<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdviserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CallController;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

//Advisers
Route::get('/profile/advisers/index', [AdviserController::class, 'index']);
Route::get('/advisercontroller/fetch_data', [AdviserController::class, 'fetch_data'])->name('adviser.fetch_data');
Route::post('/adviser/new_adviser', [AdviserController::class, 'new_adviser'])->name('adviser.new_adviser');
Route::post('/adviser/edit_adviser', [AdviserController::class, 'edit_adviser'])->name('adviser.edit_adviser');
Route::post('/adviser/update_adviser', [AdviserController::class, 'update_adviser'])->name('adviser.update_adviser');
Route::post('/adviser/confirm_adviser_deactivate', [AdviserController::class, 'confirm_adviser_deactivate'])->name('adviser.confirm_adviser_deactivate');
Route::post('/adviser/deactivate_adviser', [AdviserController::class, 'deactivate_adviser'])->name('adviser.deactivate_adviser');

//Users
Route::get('/usercontroller/fetch_data', [UserController::class, 'fetch_data'])->name('user.fetch_data');
Route::post('/user/new_user', [UserController::class, 'new_user'])->name('user.new_user');
Route::post('/user/edit_user', [UserController::class, 'edit_user'])->name('user.edit_user');
Route::post('/user/update_user', [UserController::class, 'update_user'])->name('user.update_user');
Route::post('/user/confirm_user_deactivate', [UserController::class, 'confirm_user_deactivate'])->name('user.confirm_user_deactivate');
Route::post('/user/deactivate_user', [UserController::class, 'deactivate_user'])->name('user.deactivate_user');

//Calls
Route::get('/calls/audit', [CallController::class, 'audit'])->name('calls.audit');
Route::get('/calls/survey', [CallController::class, 'survey'])->name('calls.survey');