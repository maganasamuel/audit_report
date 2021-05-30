<?php

use App\Http\Controllers\AdviserController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SurveyController;
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

Auth::routes();

Route::redirect('/', '/home');

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Calls
    Route::group(['prefix' => 'calls', 'as' => 'calls.'], function () {
        Route::group(['prefix' => 'audit', 'as' => 'audit'], function () {
            Route::get('/', [AuditController::class, 'create']);
            Route::get('{audit}/pdf', [AuditController::class, 'pdf'])->name('.pdf');
        });

        Route::group(['prefix' => 'survey', 'as' => 'survey'], function () {
            Route::get('/', [SurveyController::class, 'create']);
            Route::get('{survey}/pdf', [SurveyController::class, 'pdf'])->name('.pdf');
        });
    });

    // Profile
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');

        // Advisers
        Route::group(['prefix' => 'advisers', 'as' => 'advisers.'], function () {
            Route::get('/', [AdviserController::class, 'index'])->name('index');
        });

        // Cilents
        Route::group(['prefix' => 'clients', 'as' => 'clients.'], function () {
            Route::get('/', [ClientController::class, 'index'])->name('index');
            Route::group(['prefix' => '{client}'], function () {
                Route::get('/', [ClientController::class, 'show'])->name('show');
                Route::get('audits/{audit}/pdf', [AuditController::class, 'pdf'])->name('audits.pdf');
                Route::get('surveys/{survey}/pdf', [SurveyController::class, 'pdf'])->name('surveys.pdf');
            });
        });
    });

    // Reports
    Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('{type}/pdf/{adviser}/{startDate}/{endDate}', [ReportController::class, 'pdf'])->name('pdf');
    });

    // Surveys
    // Route::get('/surveys', [SurveyController::class, 'show_survey'])->name('surveys.index');
});
