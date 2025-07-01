<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OnCallAssignmentController;
use App\Http\Controllers\PatManagementController;

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/sso-login', [AuthController::class, 'loginSSO'])->name('sso.login');
Route::post('/sso-logout', [AuthController::class, 'logoutSSO'])->name('sso.logout');

Route::group(['prefix' => 'dashboard','middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::group(['prefix' => 'oncallassignment','middleware' => 'auth'], function () {
    Route::get('/', [OnCallAssignmentController::class, 'index'])->name('ocassignment.index');

    Route::group(['prefix' => 'cardiothoracic'], function () {
        Route::post('/save', [OnCallAssignmentController::class, 'saveAssignedCT'])->name('ocassignment.ct.save');
        Route::post('/update', [OnCallAssignmentController::class, 'updateAssignedCT'])->name('ocassignment.ct.update');
        Route::get('/getlist', [OnCallAssignmentController::class, 'getAssignedCT'])->name('ocassignment.ct.get');
    });

    Route::group(['prefix' => 'cardiology'], function () {
        Route::post('/save', [OnCallAssignmentController::class, 'saveAssignedCD'])->name('ocassignment.cd.save');
        Route::post('/update', [OnCallAssignmentController::class, 'updateAssignedCD'])->name('ocassignment.cd.update');
        Route::get('/getlist', [OnCallAssignmentController::class, 'getAssignedCD'])->name('ocassignment.cd.get');
    });

    Route::group(['prefix' => 'nurse-manager'], function () {
        Route::post('/save', [OnCallAssignmentController::class, 'saveAssignedNM'])->name('ocassignment.nm.save');
        Route::post('/update', [OnCallAssignmentController::class, 'updateAssignedNM'])->name('ocassignment.nm.update');
        Route::get('/getlist', [OnCallAssignmentController::class, 'getAssignedNM'])->name('ocassignment.nm.get');
    });

    Route::group(['prefix' => 'anaesthesia'], function () {
        Route::post('/save', [OnCallAssignmentController::class, 'saveAssignedAnaes'])->name('ocassignment.anaes.save');
        Route::post('/update', [OnCallAssignmentController::class, 'updateAssignedAnaes'])->name('ocassignment.anaes.update');
        Route::get('/getlist', [OnCallAssignmentController::class, 'getAssignedAnaes'])->name('ocassignment.anaes.get');
    });

    Route::group(['prefix' => 'pchc'], function () {
        Route::post('/save', [OnCallAssignmentController::class, 'saveAssignedPchc'])->name('ocassignment.pchc.save');
        Route::post('/update', [OnCallAssignmentController::class, 'updateAssignedPchc'])->name('ocassignment.pchc.update');
        Route::get('/getlist', [OnCallAssignmentController::class, 'getAssignedPchc'])->name('ocassignment.pchc.get');
    });

    Route::group(['prefix' => 'other'], function () {
        Route::post('/save', [OnCallAssignmentController::class, 'saveAssignedOther'])->name('ocassignment.other.save');
        Route::post('/update', [OnCallAssignmentController::class, 'updateAssignedOther'])->name('ocassignment.other.update');
        Route::get('/getlist', [OnCallAssignmentController::class, 'getAssignedOther'])->name('ocassignment.other.get');
    });

    Route::group(['prefix' => 'ert'], function () {
        Route::post('/save', [OnCallAssignmentController::class, 'saveAssignedErt'])->name('ocassignment.ert.save');
        Route::post('/update', [OnCallAssignmentController::class, 'updateAssignedErt'])->name('ocassignment.ert.update');
        Route::get('/getlist', [OnCallAssignmentController::class, 'getAssignedErt'])->name('ocassignment.ert.get');
    });

    Route::group(['prefix' => 'sa'], function () {
        Route::post('/save', [OnCallAssignmentController::class, 'saveAssignedSa'])->name('ocassignment.sa.save');
        Route::post('/update', [OnCallAssignmentController::class, 'updateAssignedSa'])->name('ocassignment.sa.update');
        Route::get('/getlist', [OnCallAssignmentController::class, 'getAssignedSa'])->name('ocassignment.sa.get');
    });

});

Route::group(['prefix' => 'patmanagement','middleware' => 'auth'], function () {
    Route::get('/', [PatManagementController::class, 'index'])->name('patmanagement.index');
    Route::get('/getlist', [PatManagementController::class, 'getWardPatientList'])->name('patmanagement.getwardpatientlist');
    Route::get('/getpatientflag', [PatManagementController::class, 'getPatientFlag'])->name('patmanagement.getpatientflag');
    Route::post('/save', [PatManagementController::class, 'savePatientFlag'])->name('patmanagement.savepatientflag');
});

Route::group(['prefix' => 'scheduler'], function () {
    Route::get('/careprov', [DashboardController::class, 'getApiUpdateCareprovider'])->name('sceduler.careprov');
});


