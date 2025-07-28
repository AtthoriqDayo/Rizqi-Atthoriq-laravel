@extends('layouts.app')

@section('content')
<div class="p-8 text-gray-800">
    <h1 class="text-3xl font-bold mb-6">Edit User: {{ $user->name }}</h1>

    <div class="bg-white/50 backdrop-blur-sm p-6 rounded-lg shadow-lg max-w-md mx-auto">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block mb-2">Name</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" class="w-full p-2 border rounded">
            </div>

            <div class="mb-6">
                <label for="email" class="block mb-2">Email (Cannot be changed)</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" class="w-full p-2 border rounded bg-gray-200" disabled>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded hover:bg-blue-600">Update User</button>
        </form>
    </div>
</div>
@endsection
