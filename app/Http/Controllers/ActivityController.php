<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityType;
use Illuminate\Contracts\Database\Query\Builder;

class ActivityController extends Controller {
    public function getAllActivityType(Request $request) {
        return ActivityType::query()
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
