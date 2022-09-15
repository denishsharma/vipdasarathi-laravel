<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamType;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Query\Builder;

class TeamController extends Controller {
    public function index() {
        $heading = 'All Teams';
        $description = 'Here you will find all the teams. You can view the details of the team by clicking on the view button.';
        $status = null;
        return view('pages.teams.list.index', compact('heading', 'description', 'status'));
    }

    public function showActiveTeams() {
        $heading = 'Active Teams';
        $description = 'Here you will find all the active teams. You can view the details of the team by clicking on the view button.';
        $teams = Team::with('team_type')->whereStatus('active')->orderByDesc('created_at')->get();
        $status = 'active';
        return view('pages.teams.list.index', compact('heading', 'description', 'teams', 'status'));
    }

    public function showInactiveTeams() {
        $heading = 'Inactive Teams';
        $description = 'Here you will find all the inactive teams. You can view the details of the team by clicking on the view button.';
        $teams = Team::with('team_type')->whereStatus('inactive')->orderByDesc('created_at')->get();
        $status = 'inactive';
        return view('pages.teams.list.index', compact('heading', 'description', 'teams', 'status'));
    }

    public function getAllTeamType(Request $request) {
        return TeamType::query()
                       ->select(['name', 'slug'])
                       ->orderByDesc('created_at')
                       ->when(
                           $request->has('search'),
                           fn(Builder $query) => $query
                               ->where('name', 'like', '%' . $request->input('search') . '%')
                               ->orWhere('slug', 'like', '%' . $request->input('search') . '%')
                       )
                       ->when(
                           $request->exists('selected'),
                           fn(Builder $query) => $query->where('slug', $request->input('selected', '')),
                           fn(Builder $query) => $query->limit(10)
                       )->get();
    }

    public function showTeamDetailsOverview($slug) {
        $team = Team::with('team_type', 'users')->whereSlug($slug)->firstOrFail();
        return view('pages.teams.details.overview.index', compact('team'));
    }
}
