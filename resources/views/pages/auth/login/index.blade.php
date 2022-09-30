@extends('layouts.empty', ['title' => 'Vipdasarathi - Login'])

@section('body')
    <section class="bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0 min-h-screen gap-10">
            <a class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-auto h-12 mr-2" src="{{ asset('images/logo-vipdasarathi.png') }}" alt="logo">
            </a>
            <livewire:forms.auth.login-form />
        </div>
    </section>
@endsection
