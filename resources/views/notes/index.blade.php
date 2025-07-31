<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Form untuk membuat Note Baru --}}
            <div class="p-4 sm:p-8 bg-black/20 backdrop-blur-lg border-2 border-white/70 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Create New Note</h2>
                    <form method="post" action="{{ route('notes.store') }}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="content" :value="__('Content')" />
                            <textarea id="content" name="content" class="mt-1 block w-full bg-black/20 border-2 border-white/70 text-gray-200 rounded-md shadow-sm" rows="4" required></textarea>
                        </div>
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </form>
                </div>
            </div>

            {{-- Daftar Note yang sudah ada --}}
            <div class="p-4 sm:p-8 bg-black/20 backdrop-blur-lg border-2 border-white/70 shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Your Notes</h2>
                <div class="space-y-4">
                    @forelse ($notes as $note)
                        <div class="p-4 bg-white/10 rounded-lg flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-white">{{ $note->title }}</h3>
                                <p class="text-gray-300 mt-2 whitespace-pre-wrap">{{ $note->content }}</p>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <a href="{{ route('notes.edit', $note) }}" class="text-sky-300 hover:text-sky-200">Edit</a>
                                <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Are you sure you want to delete this note?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400">You have no notes yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
