<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit To-Do') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-black/20 backdrop-blur-lg border-2 border-white/70 shadow sm:rounded-lg">
                <form method="post" action="{{ route('todos.update', $todo) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_timezone" id="user_timezone_edit">
                    <div>
                        <x-input-label for="task" :value="__('Task')" />
                        <x-text-input id="task" name="task" type="text" class="mt-1 block w-full" :value="old('task', $todo->task)" required />
                    </div>
                    <div>
                        <x-input-label for="due_at" :value="__('Update Calendar Time (Optional)')" />
                        <x-text-input id="due_at" name="due_at" type="datetime-local" class="mt-1 block w-full"
                                      :value="old('due_at', $todo->due_at ? $todo->due_at->format('Y-m-d\TH:i') : '')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
                        <a href="{{ route('todos.index') }}" class="text-gray-300">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.getElementById('user_timezone_edit').value = Intl.DateTimeFormat().resolvedOptions().timeZone;
</script>
