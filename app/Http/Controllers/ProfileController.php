<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $updateData = [];

        // Filtra os campos exatos que cada perfil tem permissão para alterar
        if ($user->is_admin == 1) {
            $updateData = $request->only(['name', 'phone']);
        } elseif ($user->is_dentist == 1) {
            $updateData = $request->only(['name', 'email', 'birth_date']);
        } else {
            // Considerado Paciente
            $updateData = $request->only(['name', 'email', 'birth_date']);
        }

        // A senha só é adicionada ao array de update se o usuário digitou algo
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        // Força a atualização do updated_at
        $updateData['updated_at'] = now();

        DB::table('users')->where('id', $user->id)->update($updateData);

        // Retorna para a página de perfil com uma mensagem de sucesso
        return redirect('/profile')->with('success', 'Profile updated successfully!');
    }
}
