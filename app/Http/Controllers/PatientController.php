<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // <-- IMPORTAÇÃO OBRIGATÓRIA ADICIONADA AQUI

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $patients = DB::table('users')->where('is_patient', 1)->orderBy('id', 'desc')->get();

        if ($request->wantsJson()) {
            return response()->json($patients);
        }

        return view('patients', ['patients' => $patients]);
    }

    public function create()
    {
        return view('patient-form', ['patient' => null]);
    }

    public function store(Request $request)
    {
        DB::table('users')->insert([
            'name'       => $request->name,
            'email'      => $request->email,
            'cip'        => 0,
            'cpf'        => $request->cpf,
            'phone'      => $request->phone,
            'birth_date' => $request->birth_date,
            'password'   => Hash::make($request->password), // Criptografia segura
            'is_active'  => $request->is_active,
            'is_patient' => 1,
            'is_dentist' => 0,
            'is_admin'   => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/patients');
    }

    public function edit($id)
    {
        // Correção: Adicionado o valor 1 no filtro is_patient
        $patient = DB::table('users')->where('id', $id)->where('is_patient', 1)->first();

        return view('patient-form', ['patient' => $patient]);
    }

    public function update(Request $request, $id)
    {
        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'cpf'        => $request->cpf,
            'phone'      => $request->phone,
            'birth_date' => $request->birth_date,
            'is_active'  => $request->is_active,
            'updated_at' => now(),
        ];

        // Lógica de senha preservada (está correta!)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id', $id)->update($data);

        return redirect('/patients');
    }

    public function destroy(Request $request, $id)
    {
        // Correção: Apontando para a tabela correta (users)
        DB::table('users')->where('id', $id)->delete();

        return redirect('/patients');
    }
}