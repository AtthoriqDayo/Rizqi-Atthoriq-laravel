@extends('layouts.app')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Your Upcoming Events</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Logout</button>
        </form>
    </div>

    <div class="bg-white/50 backdrop-blur-sm p-6 rounded-lg shadow-lg">
        <ul class="space-y-4">
            @forelse ($events as $event)
                <li class="p-4 border-l-4 border-blue-500 rounded-r-lg bg-white">
                    <p class="font-semibold text-gray-800">{{ $event->getSummary() }}</p>
                    <p class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($event->getStart()->getDateTime())->format('M d, Y \a\t h:i A') }}
                    </p>
                </li>
            @empty
                <p class="text-gray-700">You have no upcoming events. ✨</p>
            @endforelse
        </ul>
        </div>
</div>
@endsection