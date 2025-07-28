@extends('layouts.app')

@section('content')
    {{-- Top Right Navigation Links --}}
    <div class="fixed top-0 right-0 p-6 text-end">
        @auth
            {{-- If user is logged in, show a link to the dashboard --}}
            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-400 hover:text-white focus:outline-none">Dashboard</a>
        @else
            {{-- If user is a guest, show Log in and Register links --}}
            <a href="{{ route('login') }}" class="font-semibold text-gray-400 hover:text-white focus:outline-none">Log in</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ms-4 font-semibold text-gray-400 hover:text-white focus:outline-none">Register</a>
            @endif
        @endauth
    </div>

    {{-- Centered Login Box --}}
    <div class="flex items-center justify-center min-h-screen">
        <div class="text-center p-10 bg-white/30 backdrop-blur-sm rounded-xl shadow-lg">
            <svg class="w-24 h-24 mx-auto mb-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">MyActivity</h1>
            <p class="text-lg text-gray-700 mb-6">Link your Google Calendar and manage your day.</p>
            <a href="{{ route('google.redirect') }}" class="inline-flex items-center px-6 py-3 bg-white text-gray-700 font-semibold rounded-lg shadow-md hover:bg-gray-100 transition">
                <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" class="w-6 h-6 mr-3">
                Continue with Google
            </a>
        </div>
    </div>
@endsection
