<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;


class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/calendar'])
            ->with(["access_type" => "offline", "prompt" => "consent"])
            ->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    // app/Http/Controllers/Auth/GoogleAuthController.php

public function callback()
{
    try {
        $googleUser = Socialite::driver('google')->user();
        $user = null;

        // Scenario 1: User is already logged in and is linking their account.
        if (Auth::check()) {
            $user = Auth::user();
        }
        // Scenario 2: User is not logged in. Find them by google_id or create them.
        else {
            $user = User::firstOrNew(['google_id' => $googleUser->getId()]);
            // If it's a new user, fill in their email too
            if (!$user->exists) {
                $user->email = $googleUser->getEmail();
            }
        }

        // Use the new refresh token if it exists, otherwise keep the old one.
        $refreshToken = $googleUser->refreshToken ?? $user->google_refresh_token;

        $tokenData = [
            'access_token' => $googleUser->token,
            'expires_in' => $googleUser->expiresIn,
            'refresh_token' => $refreshToken,
            'created' => time(),
        ];

        // Fill the user's details and save
        $user->fill([
            'name' => $user->name ?? $googleUser->getName(), // Keep existing name if they have one
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'google_token' => $tokenData,
            'google_refresh_token' => $refreshToken,
            'google_linked_at' => now(), // Mark account as linked
        ])->save();

        // Log them in if they weren't already
        if (!Auth::check()) {
            Auth::login($user);
        }

        return $user->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard');

    } catch (Exception $e) {
        report($e);
        return redirect('/')->with('error', 'Login failed. Please try again.');
    }
}    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
