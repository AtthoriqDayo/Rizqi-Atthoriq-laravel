<x-app-layout>
    <div class="py-12">
        <h2 class="font-semibold text-xl leading-tight text-center">
            {{ __('Admin Dashboard - Manage Users') }}
        </h2>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-black/20 backdrop-blur-lg overflow-hidden shadow-sm sm:rounded-lg border-2 border-white/70">
                <div class="p-6">

                    <table class="w-full text-left text-gray-200">
                        <thead>
                            <tr class="border-b border-white/20">
                                <th class="p-4">Name</th>
                                <th class="p-4">Email</th>
                                <th class="p-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b border-white/10 hover:bg-white/10">
                                    <td class="p-4">{{ $user->name }}</td>
                                    <td class="p-4">{{ $user->email }}</td>
                                    <td class="p-4">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-sky-300 hover:text-sky-200">Edit</a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Are you sure you want to deactivate this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300">Deactivate</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
