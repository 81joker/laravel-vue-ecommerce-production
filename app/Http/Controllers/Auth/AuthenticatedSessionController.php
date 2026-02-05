<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Helpers\Cart;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        Cart::moveCartItemsIntoDb();
        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function github()
    {
        // send the user to request to GitHub
        return Socialite::driver('github')->redirect();
    }

    public function githubRedirect()
    {
        // get auth request back from github to authenticate user
         $user = Socialite::driver('github')->user();

        // if the user doesn't exist, create a new user
        // if they do, log them in
        // either way, authenticate the user into the application and redirect afterwards
        // $user->token
        
        $user = User::firstOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                // 'email' => $user->getEmail(),
                // 'avatar' => $user->getAvatar(),
                'password' => Hash::make(Str::random(16)), // Set a default password or handle it as needed
                ]
        );
        Auth::login($user, true);

        return redirect('/');
    }
    public function google()
    {
        // send the user to request to Google
        return Socialite::driver('google')->redirect();
    }

    public function googleRedirect()
    {
        // get auth request back from google to authenticate user
         $user = Socialite::driver('google')->user();

        // if the user doesn't exist, create a new user
        // if they do, log them in
        // either way, authenticate the user into the application and redirect afterwards
        // $user->token
        $user = User::firstOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                // 'email' => $user->getEmail(),
                // 'avatar' => $user->getAvatar(),
                'password' => Hash::make(Str::random(16)), // Set a default password or handle it as needed
                ]
        );
        Auth::login($user, true);

        return redirect('/');
    }
}
