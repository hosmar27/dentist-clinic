<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;

class DentistController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(function ($request, $next) {
                $user = Auth::user();
                
                if (! $user || ($user->is_admin ?? 0) !== 1) {
                    abort(403, 'Unauthorized action.');
                }

                return $next($request);
            }),
        ];
    }

    public function index(Request $request)
    {
        $dentists = DB::table('users')->where('is_dentist', 1)->orderBy('id', 'desc')->get();

        if ($request->wantsJson()) {
            return response()->json($dentists);
        }

        return view('dentists', ['dentists' => $dentists]);
    }

    public function create()
    {
        return view('dentist-form', ['dentist' => null]);
    }

    public function store(Request $request)
    {
        DB::table('users')->insert([
            'name'       => $request->name,
            'email'      => $request->email,
            'birth_date' => $request->birth_date,
            'cpf'        => $request->cpf,
            'phone'      => $request->phone,
            'cip'        => $request->cip,
            'password'   => Hash::make($request->password), // Encriptação obrigatória
            'is_active'  => $request->is_active,
            'is_patient' => 0,
            'is_dentist' => 1,
            'is_admin'   => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/dentists');
    }

    public function edit($id)
    {
        // Adicionado o filtro de segurança where('is_dentist', 1)
        $dentist = DB::table('users')->where('id', $id)->where('is_dentist', 1)->first();

        return view('dentist-form', ['dentist' => $dentist]);
    }

    public function update(Request $request, $id)
    {
        // Prepara todos os dados base para a atualização
        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'birth_date' => $request->birth_date,
            'cpf'        => $request->cpf,
            'phone'      => $request->phone,
            'cip'        => $request->cip ?? null,
            'is_active'  => $request->is_active,
            'updated_at' => now(),
        ];

        // Se o campo password foi preenchido, encripta e adiciona ao array de atualização
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Executa a atualização garantindo que é o utilizador correto e que tem a flag de dentista
        DB::table('users')->where('id', $id)->where('is_dentist', 1)->update($data);

        return redirect('/dentists');
    }
}