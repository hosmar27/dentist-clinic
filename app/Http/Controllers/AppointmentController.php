<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'dentist', 'statu'])->orderBy('appointment_date', 'desc');

        if ($request->filled('status_id')) {
            $query->where('id', $request->status_id);
        }
        $appointments = $query->get();
        $statuses = DB::table('status')->get();

        if ($request->wantsJson()) {
            return response()->json($appointments);
        }

        return view('appointments', [
            'appointments' => $appointments,
            'statuses'     => $statuses // Passando os status para a view
        ]);
    }

    public function create()
    {
        // Buscar usuários com as respectivas flags
        $patients = DB::table('users')->orderBy('name')->where('is_patient', 1)->get();
        $dentists = DB::table('users')->orderBy('name')->where('is_dentist', 1)->get();
        $statuses = DB::table('status')->get();

        // Corrigido para apontar para a view do formulário (sem a barra inicial)
        return view('appointment-form', [
            'appointment' => null,
            'patients' => $patients,
            'dentists' => $dentists,
            'statuses' => $statuses
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->only(['patient_id', 'dentist_id', 'appointment_date', 'status_id']);

        if ($request->wantsJson()) {
            $appointment = Appointment::create($data);

            return response()->json($appointment, 201);
        }

        DB::table('appointments')->insert(array_merge($data, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        return redirect('/appointments');
    }

    public function show(Request $request, $id)
    {
        $appointment = DB::table('appointments')->where('id', $id)->first();
        $patients = DB::table('users')->orderBy('name')->where('is_patient', 1)->get();
        $dentists = DB::table('users')->orderBy('name')->where('is_dentist', 1)->get();
        $statuses = DB::table('status')->get();

        return view('appointment-form', [
            'appointment' => $appointment, 
            'patients'    => $patients, 
            'dentists'    => $dentists,
            'status'      => $statuses
        ]);
    }

    public function edit($id)
    {
        $appointment = DB::table('appointments')->where('id', $id)->first();
        $patients = DB::table('users')->orderBy('name')->where('is_patient', 1)->get();
        
        // Corrigido para a tabela 'users'
        $dentists = DB::table('users')->orderBy('name')->where('is_dentist', 1)->get();
        $statuses = DB::table('status')->get();

        return view('appointment-form', [
            'appointment' => $appointment, // Corrigido: agora envia os dados reais em vez de null
            'patients' => $patients,
            'dentists' => $dentists,
            'statuses' => $statuses
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['patient_id', 'dentist_id', 'appointment_date', 'status']);

        /* Se for utilizar a API via JSON futuramente, basta descomentar
        if ($request->wantsJson()) {
            $appointment = Appointment::findOrFail($id);
            $appointment->update($data);

            return response()->json($appointment);
        }
        */

        DB::table('appointments')->where('id', $id)->update(array_merge($data, [
            'updated_at' => now(),
        ]));

        return redirect('/appointments');
    }

    public function destroy(Request $request, $id)
    {
        /* Se for utilizar a API via JSON futuramente, basta descomentar
        if ($request->wantsJson()) {
            Appointment::findOrFail($id)->delete();

            return response()->json(null, 204);
        }
        */

        DB::table('appointments')->where('id', $id)->delete();

        return redirect('/appointments');
    }

    public function dentistAppointments()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        // Busca apenas os agendamentos onde o dentist_id é igual ao ID do usuário logado
        $appointments = Appointment::with(['patient', 'statu'])
            ->where('dentist_id', $user->id)
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('dentist-appointments', ['appointments' => $appointments]);
    }

    public function patientAppointments()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        // Busca apenas os agendamentos onde o patient_id é igual ao ID do usuário logado
        $appointments = Appointment::with(['dentist', 'statu'])
            ->where('patient_id', $user->id)
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('patient-appointments', ['appointments' => $appointments]);
    }
}