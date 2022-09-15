<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Query\Builder;

class AddressController extends Controller {
    public function getAllState(Request $request) {
        $country = Country::where('name', 'india')->first();
        return State::query()
                    ->select(['id', 'name'])
                    ->where('country_id', $country->id)
                    ->orderBy('name')
                    ->when(
                        $request->has('search'),
                        fn(Builder $query) => $query
                            ->where('name', 'like', '%' . $request->input('search') . '%')
                            ->where('country_id', $country->id)
                    )
                    ->get()
                    ->map(fn(State $state) => [
                        'id' => $state->id,
                        'name' => ucwords($state->name),
                        'country_id' => $state->country_id,
                    ]);
    }
}
