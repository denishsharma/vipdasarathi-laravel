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
    Route::get('disaster_type', [\App\Http\Controllers\SettingController::class, 'disaster_type'])->name('settings.disaster-type.index');
    Route::get('team_type', [\App\Http\Controllers\SettingController::class, 'team_type'])->name('settings.team-type.index');
    Route::get('task_type', [\App\Http\Controllers\SettingController::class, 'task_type'])->name('settings.task-type.index');
    Route::get('activity_type', [\App\Http\Controllers\SettingController::class, 'activity_type'])->name('settings.activity-type.index');
});

Route::group(['prefix' => 'cases'], function () {
    Route::get('/', [\App\Http\Controllers\CaseController::class, 'index'])->name('cases.index');
    Route::get('/active', [\App\Http\Controllers\CaseController::class, 'showActiveCases'])->name('cases.index.active');
    Route::get('/pending', [\App\Http\Controllers\CaseController::class, 'showPendingCases'])->name('cases.index.pending');
    Route::get('/closed', [\App\Http\Controllers\CaseController::class, 'showClosedCases'])->name('cases.index.closed');
});

Route::group(['prefix' => 'case'], function () {
    Route::get('{slug}/overview', [\App\Http\Controllers\CaseController::class, 'showCaseDetailsOverview'])->name('case.view.overview');
    Route::get('{slug}/demands', [\App\Http\Controllers\CaseController::class, 'showCaseDetailsOverview'])->name('case.view.demands');
    Route::get('{slug}/teams', [\App\Http\Controllers\CaseController::class, 'showCaseDetailsTeams'])->name('case.view.teams');
    Route::get('{slug}/tasks', [\App\Http\Controllers\CaseController::class, 'showCaseDetailsTasks'])->name('case.view.tasks');
    Route::get('{slug}/tickets', [\App\Http\Controllers\CaseController::class, 'showCaseDetailsOverview'])->name('case.view.tickets');
    Route::get('{slug}/shelters', [\App\Http\Controllers\CaseController::class, 'showCaseDetailsOverview'])->name('case.view.shelters');
});

Route::group(['prefix' => 'task'], function () {
    Route::get('{slug}/overview', [\App\Http\Controllers\TaskController::class, 'showTaskDetailsOverview'])->name('task.view.overview');
    Route::get('{slug}/activities', [\App\Http\Controllers\TaskController::class, 'showTaskDetailsActivities'])->name('task.view.activities');
    Route::get('{slug}/teams', [\App\Http\Controllers\TaskController::class, 'showTaskDetailsTeams'])->name('task.view.teams');
    Route::get('{slug}/attachments', [\App\Http\Controllers\TaskController::class, 'showTaskDetailsAttachments'])->name('task.view.attachments');
    Route::get('{slug}/tickets', [\App\Http\Controllers\TaskController::class, 'showTaskDetailsOverview'])->name('task.view.tickets');
});

Route::group(['prefix' => 'teams'], function () {
    Route::get('/', [\App\Http\Controllers\TeamController::class, 'index'])->name('teams.index');
    Route::get('/active', [\App\Http\Controllers\TeamController::class, 'showActiveTeams'])->name('teams.index.active');
    Route::get('/inactive', [\App\Http\Controllers\TeamController::class, 'showInactiveTeams'])->name('teams.index.inactive');
});

Route::group(['prefix' => 'team'], function () {
    Route::get('{slug}/overview', [\App\Http\Controllers\TeamController::class, 'showTeamDetailsOverview'])->name('team.view.overview');
    Route::get('{slug}/members', [\App\Http\Controllers\TeamController::class, 'showTeamDetailsMembers'])->name('team.view.members');
    Route::get('{slug}/tasks', [\App\Http\Controllers\TeamController::class, 'showTeamDetailsTasks'])->name('team.view.tasks');
});
