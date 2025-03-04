<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OnCallAssignmentController;
use App\Http\Controllers\WardDisplayController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/sso-login', [AuthController::class, 'loginSSO'])->name('sso.login');
Route::post('/sso-logout', [AuthController::class, 'logoutSSO'])->name('sso.logout');

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::group(['prefix' => 'oncallassignment'], function () {
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

});


//Display
Route::group(['prefix' => 'warddisplay'], function () {
    Route::group(['prefix' => 'b5z2'], function () {
        Route::get('/', [WardDisplayController::class, 'indexb5z2'])->name('display.b5z2.index');
    });
});

Route::get('/refresh-cardiothoracic', [WardDisplayController::class, 'oncallCtSec'])->name('refresh.cardiothoracic');
