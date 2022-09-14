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
