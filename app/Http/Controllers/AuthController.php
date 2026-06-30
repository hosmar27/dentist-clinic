<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // NOVO: Descobre quem acabou de logar
            $user = Auth::user();
            
            // Redireciona para a tela correta dependendo do nível de acesso
            if ($user->is_admin == 1) {
                return redirect()->intended('/appointments');
            } elseif ($user->is_dentist == 1) {
                return redirect()->intended('/dentist/appointments');
            } else {
                return redirect()->intended('/patient/appointments');
            }
        }

       return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}