<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller {
    public function index() {
        return view('pages.settings.master');
    }

    public function organization() {
        return view('pages.settings.organizations.index');
    }

    public function user() {
        return view('pages.settings.users.index');
    }

    public function disaster_type() {
        return view('pages.settings.disaster-types.index');
    }

    public function team_type() {
        return view('pages.settings.team-types.index');
    }

    public function task_type() {
        return view('pages.settings.task-types.index');
    }

    public function activity_type() {
        return view('pages.settings.activity-types.index');
    }

    public function demand_type() {
        return view('pages.settings.demand-types.index');
    }
}
