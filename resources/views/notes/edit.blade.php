<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-black/20 backdrop-blur-lg border-2 border-white/70 shadow sm:rounded-lg">
                <form method="post" action="{{ route('notes.update', $note) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $note->title)" required />
                    </div>
                    <div>
                        <x-input-label for="content" :value="__('Content')" />
                        <textarea id="content" name="content" class="mt-1 block w-full bg-black/20 border-2 border-white/70 text-gray-200 rounded-md shadow-sm" rows="10" required>{{ old('content', $note->content) }}</textarea>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
                        <a href="{{ route('notes.index') }}" class="text-gray-300">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
