<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Query\Builder;

class UserController extends Controller {
    public function getAllUser(Request $request) {
        return User::query()
                   ->select(['first_name', 'last_name', 'slug', 'email'])
                   ->orderByDesc('created_at')
                   ->when(
                       $request->has('search'),
                       fn(Builder $query) => $query
                           ->where('first_name', 'like', '%' . $request->input('search') . '%')
                           ->orWhere('last_name', 'like', '%' . $request->input('search') . '%')
                           ->orWhere('slug', 'like', '%' . $request->input('search') . '%')
                           ->orWhere('email', 'like', '%' . $request->input('search') . '%')
                   )
                   ->when(
                       $request->exists('selected'),
                       fn(Builder $query) => $query->whereIn('slug', $request->input('selected', [])),
                       fn(Builder $query) => $query->limit(10)
                   )
                   ->get()
                   ->map(fn($user) => [
                       'name' => $user->first_name . ' ' . $user->last_name,
                       'slug' => $user->slug,
                       'email' => $user->email,
                   ]);
    }
}
