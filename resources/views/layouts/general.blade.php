@extends('layouts.empty', ['title' => $title])

@section('body')
    <div class="grid grid-cols-1 divide-y divide-gray-100">
        <livewire:navigation.navigation-bar :active="$activeNav" />
        @yield('attached-navbar')
    </div>

    @yield('content')
@endsection
