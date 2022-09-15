<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/organization/all', [\App\Http\Controllers\OrganizationController::class, 'getAllOrganization'])->name('api.organization.all');
Route::get('/disaster-type/all', [\App\Http\Controllers\CaseController::class, 'getAllDisasterType'])->name('api.disaster-type.all');
Route::get('/states/all', [\App\Http\Controllers\AddressController::class, 'getAllState'])->name('api.states.all');
Route::get('/team-type/all', [\App\Http\Controllers\TeamController::class, 'getAllTeamType'])->name('api.team-type.all');
Route::get('/user/all', [\App\Http\Controllers\UserController::class, 'getAllUser'])->name('api.user.all');
