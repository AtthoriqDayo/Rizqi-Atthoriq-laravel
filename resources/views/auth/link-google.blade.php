<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('To complete your profile, you must link your Google Account. This is required to access your Google Calendar.') }}
    </div>

    <div class="mt-4 flex items-center justify-between">
        <a href="{{ route('google.redirect') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            Link with Google
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
