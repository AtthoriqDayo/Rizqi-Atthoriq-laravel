<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('To-Do List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Form untuk membuat To-Do Baru --}}
            <div class="p-4 sm:p-8 bg-black/20 backdrop-blur-lg border-2 border-white/70 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Add New To-Do</h2>
                    <form method="post" action="{{ route('todos.store') }}" class="mt-6 space-y-4">
                        @csrf
                        <input type="hidden" name="user_timezone" id="user_timezone_create">
                        <div>
                            <x-input-label for="task" :value="__('Task')" />
                            <x-text-input id="task" name="task" type="text" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="due_at" :value="__('Add to Calendar (Optional)')" />
                            <x-text-input id="due_at" name="due_at" type="datetime-local" class="mt-1 block w-full" />
                        </div>
                        <x-primary-button>{{ __('Add Task') }}</x-primary-button>
                    </form>
                </div>
            </div>

            {{-- Daftar To-Do yang sudah ada --}}
            <div class="p-4 sm:p-8 bg-black/20 backdrop-blur-lg border-2 border-white/70 shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Your Tasks</h2>
                <div class="space-y-3">
                    @forelse ($todos as $todo)
                        <div class="flex justify-between items-center p-3 bg-white/10 rounded-lg">
                            {{-- Task and Checkbox --}}
                            <form action="{{ route('todos.update', $todo) }}" method="POST" class="flex items-center flex-grow">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_completed_update" value="1">
                                <input type="checkbox" name="is_completed" value="1" class="rounded"
                                    onchange="this.form.submit()" {{ $todo->is_completed ? 'checked' : '' }}>
                                <span class="ms-3 {{ $todo->is_completed ? 'line-through text-gray-400' : 'text-white' }}">
                                    {{ $todo->task }}
                                </span>
                            </form>
                            {{-- Action Buttons --}}
                            <div class="flex items-center flex-shrink-0 ml-4">
                                <a href="{{ route('todos.edit', $todo) }}" class="text-sky-300 hover:text-sky-200 text-sm">Edit</a>
                                <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="ml-2" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400">Your to-do list is empty. Great job!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.getElementById('user_timezone_create').value = Intl.DateTimeFormat().resolvedOptions().timeZone;
</script>
