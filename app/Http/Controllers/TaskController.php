<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskType;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Query\Builder;

class TaskController extends Controller {
    public function showTaskDetailsOverview($slug) {
        $task = Task::with('task_type')->whereSlug($slug)->firstOrFail();
        return view('pages.cases.details.tasks.details.overview.index', compact('task'));
    }

    public function showTaskDetailsActivities($slug) {
        $task = Task::with('task_type')->whereSlug($slug)->firstOrFail();
        return view('pages.cases.details.tasks.details.activities.index', compact('task'));
    }

    public function showTaskDetailsAttachments($slug) {
        $task = Task::with('task_type')->whereSlug($slug)->firstOrFail();
        return view('pages.cases.details.tasks.details.attachments.index', compact('task'));
    }

    public function showTaskDetailsTeams($slug) {
        $task = Task::with('task_type')->whereSlug($slug)->firstOrFail();
        return view('pages.cases.details.tasks.details.teams.index', compact('task'));
    }

    public function getAllTaskType(Request $request) {
        return TaskType::query()
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
}
