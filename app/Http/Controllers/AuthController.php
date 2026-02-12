<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nip'       => 'required|string',
            'password'  => 'required|string',
        ]);

        $nip = str_replace(' ', '', $credentials['nip']);

        $user = User::where('nip', $nip)->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'nip' => 'NIP atau password salah.',
            ])->withInput($request->except('password'));
        }

        Auth::login($user);

        $request->session()->regenerate();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'verifikator':
                return redirect()->route('verifikator.dashboard');
            case 'pemohon':
            default:
                return redirect()->route('dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}