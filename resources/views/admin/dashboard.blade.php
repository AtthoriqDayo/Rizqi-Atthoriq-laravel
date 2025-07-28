@extends('layouts.app')

@section('content')
<div class="p-8 text-gray-800">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Admin Dashboard - Manage Users</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Logout</button>
        </form>
    </div>

    <div class="bg-white/50 backdrop-blur-sm p-6 rounded-lg shadow-lg">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b">
                    <th class="p-4">ID</th>
                    <th class="p-4">Name</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b hover:bg-white/20">
                        <td class="p-4">{{ $user->id }}</td>
                        <td class="p-4">{{ $user->name }}</td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Are you sure you want to deactivate this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Deactivate</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
