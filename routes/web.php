<?php

use App\Http\Controllers\AdviserController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SpecificUserController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UserController;
use App\Models\Client;
use Illuminate\Http\Request;
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

Route::middleware(['auth'])->group(function () {
    // Calls
    Route::group(['prefix' => 'calls', 'as' => 'calls.'], function () {
        Route::get('audit', [AuditController::class, 'create'])->name('audit');
        Route::get('survey', [SurveyController::class, 'create'])->name('survey');
    });

    // Profile
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        // Cilents
        Route::group(['prefix' => 'clients', 'as' => 'clients.'], function () {
            Route::get('/', [ClientController::class, 'index'])->name('index');
            Route::group(['prefix' => '{client}'], function () {
                Route::get('/', [ClientController::class, 'show'])->name('show');
                Route::get('audits/{audit}/pdf', [AuditController::class, 'pdf'])->name('audits.pdf');
            });
        });
    });

    // Reports
    Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('{type}/pdf/{adviser}/{startDate}/{endDate}', [ReportController::class, 'pdf'])->name('pdf');
    });

    // Surveys
    Route::get('/surveys', [SurveyController::class, 'show_survey'])->name('surveys.index');
});

// Unknown routes
Route::get('/', function () {
    if (1 == ! Auth::user()->is_admin) {
        return view('/users/home');
    } else {
        return view('dashboard');
    }
    // return view('home');
})->middleware('auth');

Auth::routes();

Route::get('/home', function () {
    if (1 == Auth::user()->is_admin) {
        return view('home');
    } else {
        return view('/users/home');
    }
});

Route::group(['middleware' => 'isActive'], function () {
    Route::get('/home', [App\Http\Controllers\UserController::class, 'home'])->name('users.home');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::get('upgrade', function () {
        return view('pages.upgrade');
    })->name('upgrade');
    Route::get('map', function () {
        return view('pages.maps');
    })->name('map');
    Route::get('icons', function () {
        return view('pages.icons');
    })->name('icons');
    Route::get('table-list', function () {
        return view('pages.tables');
    })->name('table');
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::group(['middleware' => 'checkuser'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('checkuser');

    //Advisers
    Route::get('/profile/advisers/index', [AdviserController::class, 'index'])->middleware('checkuser');
    Route::get('/advisercontroller/fetch_data', [AdviserController::class, 'fetch_data'])->name('adviser.fetch_data')->middleware('checkuser');
    Route::post('/adviser/new_adviser', [AdviserController::class, 'new_adviser'])->name('adviser.new_adviser')->middleware('checkuser');
    Route::post('/adviser/edit_adviser', [AdviserController::class, 'edit_adviser'])->name('adviser.edit_adviser')->middleware('checkuser');
    Route::post('/adviser/update_adviser', [AdviserController::class, 'update_adviser'])->name('adviser.update_adviser')->middleware('checkuser');
    Route::post('/adviser/confirm_adviser_deactivate', [AdviserController::class, 'confirm_adviser_deactivate'])->name('adviser.confirm_adviser_deactivate')->middleware('checkuser');
    Route::post('/adviser/deactivate_adviser', [AdviserController::class, 'deactivate_adviser'])->name('adviser.deactivate_adviser')->middleware('checkuser');

    //Users
    Route::get('/usercontroller/fetch_data', [UserController::class, 'fetch_data'])->name('user.fetch_data')->middleware('checkuser');
    Route::post('/user/new_user', [UserController::class, 'new_user'])->name('user.new_user')->middleware('checkuser');
    Route::post('/user/edit_user', [UserController::class, 'edit_user'])->name('user.edit_user')->middleware('checkuser');
    Route::post('/user/update_user', [UserController::class, 'update_user'])->name('user.update_user')->middleware('checkuser');
    Route::post('/user/confirm_user_deactivate', [UserController::class, 'confirm_user_deactivate'])->name('user.confirm_user_deactivate')->middleware('checkuser');
    Route::post('/user/deactivate_user', [UserController::class, 'deactivate_user'])->name('user.deactivate_user')->middleware('checkuser');
});

//Normal Users
Route::get('/users/home', [UserController::class, 'home'])->name('users.home')->middleware('auth');
Route::post('/usercontroller/fetchdata', [UserController::class, 'fetch_data'])->name('users.fetch_data')->middleware('auth');

Route::get('/clientcontroller/fetch_data', [ClientController::class, 'fetch_data'])->name('client.fetch_data')->middleware('auth');
// Route::get('/pdfs/view-pdf', [ClientController::class, 'view_pdf'])->name('pdfs.view_pdf')->middleware('auth');
Route::get('/pdfs/edit-pdf', [ClientController::class, 'edit_pdf'])->name('pdfs.edit_pdf')->middleware('auth');
Route::post('/pdfs/update-pdf', [ClientController::class, 'update_pdf'])->name('pdfs.update_pdf')->middleware('auth');
Route::post('/pdfs/confirm_client_delete', [ClientController::class, 'confirm_client_delete'])->name('pdfs.confirm_client_delete')->middleware('auth');
Route::post('/pdfs/delete_client', [ClientController::class, 'delete_client'])->name('pdfs.delete_client')->middleware('auth');

//Specific User
Route::get('/specificusercontroller/fetch_data', [SpecificUserController::class, 'fetch_data'])->name('normal_users.fetch_data')->middleware('auth');

//Surveys

// Route::get('/surveycontroller/fetch_data', [CallController::class, 'fetch_data'])->name('surveys.fetch_data')->middleware('auth');
// Route::get('/calls/fetch_clients', [CallController::class, 'fetch_clients'])->name('calls.fetch_clients')->middleware('auth');
Route::get('/pdfs/view-survey', [ClientController::class, 'view_survey'])->name('pdfs.view_survey')->middleware('auth');
// Route::get('/pdfs/edit_survey', [CallController::class, 'edit_pdf'])->name('pdfs.edit_survey')->middleware('auth');
// Route::post('/pdfs/update_survey', [CallController::class, 'update_pdf'])->name('pdfs.update_survey')->middleware('auth');
// Route::post('/pdfs/confirm_cancel_survey', [CallController::class, 'confirm_cancel_survey'])->name('pdfs.confirm_cancel_survey')->middleware('auth');
// Route::post('/pdfs/cancel_survey', [CallController::class, 'cancel_survey'])->name('pdfs.cancel_survey')->middleware('auth');

Route::post('/fetch_advisers', [ReportController::class, 'fetch_adviser'])->name('reports.fetch_adviser')->middleware('auth');
// Route::post('/reports/pdf', [ReportController::class, 'view_pdf'])->name('reports.pdf')->middleware('auth');

//Mail
Route::get('send-email', function (Request $request) {
    $client = Client::find($request->id);
    $pdf_title = public_path('pdfs/' . $client->audits[0]->pivot->pdf_title);

    $details = [
        'client_name' => $client->policy_holder,
        'client_no' => $client->policy_no,
        'pdf_title' => $pdf_title,
    ];

    Mail::to(Auth::user()->email)
        ->cc('admin@eliteinsure.co.nz')
        ->send(new \App\Mail\PdfMail($details));

    return redirect('profile\clients\index')->with('message', 'Email has been sent successfully!');
})->name('mails.send-mail')->middleware('auth');
