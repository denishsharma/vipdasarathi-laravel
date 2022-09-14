<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DisasterCase;

class CaseController extends Controller {
    public function index() {
        $heading = 'All Cases';
        $description = 'Here you will find all the cases. You can view the details of the case by clicking on the view button.';
        return view('pages.cases.list.index', compact('heading', 'description'));
    }

    public function showActiveCases() {
        $heading = 'Active Cases';
        $description = 'Here you will find all the active cases. You can view the details of the case by clicking on the view button.';
        $cases = DisasterCase::with('disaster_type')->whereStatus('active')->orderByDesc('created_at')->get();
        return view('pages.cases.list.index', compact('heading', 'description', 'cases'));
    }

    public function showPendingCases() {
        $heading = 'Pending Cases';
        $description = 'Here you will find all the pending cases. You can view the details of the case by clicking on the view button.';
        $cases = DisasterCase::with('disaster_type')->whereStatus('pending')->orderByDesc('created_at')->get();
        return view('pages.cases.list.index', compact('heading', 'description', 'cases'));
    }

    public function showClosedCases() {
        $heading = 'Closed Cases';
        $description = 'Here you will find all the closed cases. You can view the details of the case by clicking on the view button.';
        $cases = DisasterCase::with('disaster_type')->whereStatus('closed')->orderByDesc('created_at')->get();
        return view('pages.cases.list.index', compact('heading', 'description', 'cases'));
    }
}
