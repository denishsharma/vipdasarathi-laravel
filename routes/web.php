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

Route::get('/', function () {
    return view('pages.home.index');
})->name('home');

Route::group(['prefix' => 'settings'], function () {
    Route::get('/', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::get('organization', [\App\Http\Controllers\SettingController::class, 'organization'])->name('settings.organization.index');
    Route::get('user', [\App\Http\Controllers\SettingController::class, 'user'])->name('settings.user.index');
});

Route::group(['prefix' => 'cases'], function () {
    Route::get('/', [\App\Http\Controllers\CaseController::class, 'index'])->name('cases.index');
    Route::get('/active', [\App\Http\Controllers\CaseController::class, 'showActiveCases'])->name('cases.index.active');
    Route::get('/pending', [\App\Http\Controllers\CaseController::class, 'showClosedCases'])->name('cases.index.pending');
    Route::get('/closed', [\App\Http\Controllers\CaseController::class, 'showPendingCases'])->name('cases.index.closed');
});
