<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Contracts\Database\Eloquent\Builder;

class OrganizationController extends Controller {
    public function getAllOrganization(Request $request) {
        return Organization::query()
                           ->select(['name', 'slug', 'level'])
                           ->orderByDesc('created_at')
                           ->when(
                               $request->has('search'),
                               fn(Builder $query) => $query
                                   ->where('name', 'like', '%' . $request->input('search') . '%')
                                   ->orWhere('level', 'like', '%' . $request->input('search') . '%')
                           )
                           ->when(
                               $request->exists('selected'),
                               fn(Builder $query) => $query->where('slug', $request->input('selected', '')),
                               fn(Builder $query) => $query->limit(10)
                           )->get()
                           ->map(fn(Organization $organization) => [
                               'name' => $organization->name,
                               'slug' => $organization->slug,
                               'level' => $organization->level(),
                           ]);
    }
}
