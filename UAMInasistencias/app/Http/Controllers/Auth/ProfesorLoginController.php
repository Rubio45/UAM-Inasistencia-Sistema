<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProfesorLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfesorLoginController extends Controller
{
    /**
     * Display the login view for professors.
     */
    public function create(): View
    {
        return view('auth.profesor.login');
    }

    /**
     * Handle an incoming authentication request for professors.
     */
    public function store(ProfesorLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('profesor.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session for professors.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
} 