<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // 1. Validação de segurança dos dados recebidos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'cpf' => 'required|string|max:20|unique:users',
            'phone' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'password' => 'required|string|min:6',
        ]);

        // 2. Inserção no banco de dados e captura do ID gerado
        $userId = DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'password' => Hash::make($request->password), // Criptografia garantida
            'is_active' => 1,
            'is_patient' => 1, // Trava de segurança: Cadastro externo é sempre paciente
            'is_dentist' => 0,
            'is_admin' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Autentica o usuário automaticamente após o cadastro (Login automático)
        Auth::loginUsingId($userId);

        // 4. Redireciona para o painel de apontamentos do paciente
        return redirect('/patient/appointments');
    }
}
