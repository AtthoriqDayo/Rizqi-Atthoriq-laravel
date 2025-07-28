<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-white hover:text-gray-900 rounded-md focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="flex items-center my-4">
            <hr class="flex-grow border-gray-300">
            <span class="mx-4 text-gray-500 text-sm">OR</span>
            <hr class="flex-grow border-gray-300">
        </div>

        <a href="{{ route('google.redirect') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-white/30 border-2 border-white/70 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-white/50">
            <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" class="w-5 h-5 mr-2">
            Continue with Google
        </a>

        <div class="text-center mt-6">
            <p class="text-sm text-white dark:text-white">
                Tidak punya akun?
                <a href="{{ route('register') }}" class="font-medium text-white hover:text-indigo-500">
                    Daftar
                </a>
            </p>
        </div>

    </form>
</x-guest-layout>
