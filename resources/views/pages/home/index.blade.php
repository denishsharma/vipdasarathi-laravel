@extends('layouts.general', ['title' => 'Home', 'activeNav' => 'home'])

@section('attached-navbar')
@endsection

@section('content')
    <x-layout.sidebar-main>
        <x-slot:sidebar>
            sidebar
        </x-slot:sidebar>

        main
    </x-layout.sidebar-main>
@endsection
