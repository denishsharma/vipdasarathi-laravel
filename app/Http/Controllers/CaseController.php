<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DisasterCase;
use App\Models\DisasterType;
use Illuminate\Contracts\Database\Query\Builder;

class CaseController extends Controller {
    public function index() {
        $heading = 'All Cases';
        $description = 'Here you will find all the cases. You can view the details of the case by clicking on the view button.';
        $status = null;
        return view('pages.cases.list.index', compact('heading', 'description', 'status'));
    }

    public function showActiveCases() {
        $heading = 'Active Cases';
        $description = 'Here you will find all the active cases. You can view the details of the case by clicking on the view button.';
        $cases = DisasterCase::with('disaster_type')->whereStatus('active')->orderByDesc('created_at')->get();
        $status = 'active';
        return view('pages.cases.list.index', compact('heading', 'description', 'cases', 'status'));
    }

    public function showPendingCases() {
        $heading = 'Pending Cases';
        $description = 'Here you will find all the pending cases. You can view the details of the case by clicking on the view button.';
        $cases = DisasterCase::with('disaster_type')->whereStatus('pending')->orderByDesc('created_at')->get();
        $status = 'pending';
        return view('pages.cases.list.index', compact('heading', 'description', 'cases', 'status'));
    }

    public function showClosedCases() {
        $heading = 'Closed Cases';
        $description = 'Here you will find all the closed cases. You can view the details of the case by clicking on the view button.';
        $cases = DisasterCase::with('disaster_type')->whereStatus('closed')->orderByDesc('created_at')->get();
        $status = 'closed';
        return view('pages.cases.list.index', compact('heading', 'description', 'cases', 'status'));
    }

    public function getAllDisasterType(Request $request) {
        return DisasterType::query()
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

    public function showCaseDetailsOverview($slug) {
        $case = DisasterCase::with('disaster_type')->whereSlug($slug)->firstOrFail();
        return view('pages.cases.details.overview.index', compact('case'));
    }
}
