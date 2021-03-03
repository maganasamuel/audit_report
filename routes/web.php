<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdviserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use App\Models\Client;
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
    // if(!Auth::user()->is_admin == 1){
    //      return view('/users/home');
    // } else {
    //   return view('home');
    // }
  return view('welcome');
});

Route::get('/home', function () {
    if(Auth::user()->is_admin == 1){
        return view('home');
    } else {
        return view('/users/home');
    }
});

Auth::routes();


Auth::routes();



Route::group(['middleware' => 'auth'], function () {
  Route::get('/home', [UserController::class, 'home'])->name('users.home');
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});


Route::group(['middleware' => 'isAdmin'], function(){
  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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
});

//Calls
Route::get('/calls/audit', [CallController::class, 'audit'])->name('calls.audit');
Route::get('/calls/survey', [CallController::class, 'survey'])->name('calls.survey');
Route::post('/calls/store_audit', [CallController::class, 'store_audit'])->name('calls.store_audit');


//Normal Users
Route::get('/users/home', [UserController::class, 'home'])->name('users.home');

//Clients
Route::get('/profile/clients/index', [ClientController::class, 'index']);
Route::get('/clientcontroller/fetch_data', [ClientController::class, 'fetch_data'])->name('client.fetch_data');
Route::get('/pdfs/view-pdf', [ClientController::class, 'view_pdf'])->name('pdfs.view_pdf');
Route::get('/pdfs/edit-pdf', [ClientController::class, 'edit_pdf'])->name('pdfs.edit_pdf');
Route::post('/pdfs/update-pdf', [ClientController::class, 'update_pdf'])->name('pdfs.update_pdf');
//Mail
Route::get('send-email', function(Request $request){

  $client = Client::find($request->id);
  $pdf_title = public_path('pdfs/'.$client->audits[0]->pivot->pdf_title);

  $details = [
    'client_name' => $client->policy_holder,
    'client_no' => $client->policy_no,
    'pdf_title' => $pdf_title
  ];
   
  Mail::to(Auth::user()->email)->send(new \App\Mail\PdfMail($details));

  return view('profile.clients.index');
  
})->name('mails.send-mail');