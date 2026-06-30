<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'dentist', 'statu'])->orderBy('appointment_date', 'desc');

        if ($request->filled('status_id')) {
            // CORREÇÃO: Filtrar pela coluna correta 'status_id', não 'id'
            $query->where('status_id', $request->status_id);
        }

        $appointments = $query->get();
        $statuses = DB::table('status')->get();

        if ($request->wantsJson()) {
            return response()->json($appointments);
        }

        return view('appointments', [
            'appointments' => $appointments,
            'statuses' => $statuses,
        ]);
    }

    public function create()
    {
        $patients = DB::table('users')->orderBy('name')->where('is_patient', 1)->get();
        $dentists = DB::table('users')->orderBy('name')->where('is_dentist', 1)->get();
        $statuses = DB::table('status')->get();

        return view('appointment-form', [
            'appointment' => null,
            'patients' => $patients,
            'dentists' => $dentists,
            'statuses' => $statuses,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->only(['patient_id', 'dentist_id', 'appointment_date']);

        // REGRA DE NEGÓCIO: Se for paciente, ignoramos o que vem do form e forçamos o ID dele
        if ($user->is_patient == 1) {
            $data['patient_id'] = $user->id;
        }

        // Força o status inicial (Ex: 1 = Scheduled)
        $data['status_id'] = 1;

        DB::table('appointments')->insert(array_merge($data, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        if ($user->is_admin == 1) {
            return redirect('/appointments');
        } elseif ($user->is_dentist == 1) {
            return redirect('/dentist/appointments');
        } else {
            return redirect('/patient/appointments');
        }
    }

    public function show(Request $request, $id)
    {
        // CORREÇÃO: Usando o Model para carregar o relacionamento 'statu'
        $appointment = Appointment::with('statu')->find($id);

        $patients = DB::table('users')->orderBy('name')->where('is_patient', 1)->get();
        $dentists = DB::table('users')->orderBy('name')->where('is_dentist', 1)->get();
        $statuses = DB::table('status')->get();

        return view('appointment-form', [
            'appointment' => $appointment,
            'patients' => $patients,
            'dentists' => $dentists,
            'statuses' => $statuses, // CORREÇÃO: Estava 'status', alterado para 'statuses' para bater com a View
        ]);
    }

    public function edit($id)
    {
        // CORREÇÃO: Usando o Model para carregar o relacionamento 'statu'
        $appointment = Appointment::with('statu')->find($id);

        $patients = DB::table('users')->orderBy('name')->where('is_patient', 1)->get();
        $dentists = DB::table('users')->orderBy('name')->where('is_dentist', 1)->get();
        $statuses = DB::table('status')->get();

        return view('appointment-form', [
            'appointment' => $appointment,
            'patients' => $patients,
            'dentists' => $dentists,
            'statuses' => $statuses,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $data = [];

        if ($user->is_admin == 1) {
            // ADMIN: Pode atualizar tudo (Paciente, Dentista, Data e Status)
            $data = $request->only(['patient_id', 'dentist_id', 'appointment_date']);
            if ($request->has('status_id')) {
                $data['status_id'] = $request->status_id;
            }
        } elseif ($user->is_dentist == 1) {
            // DENTISTA: Só pode atualizar Data e Status
            $data = $request->only(['appointment_date']);
            if ($request->has('status_id')) {
                $data['status_id'] = $request->status_id;
            }
        } else {
            // PACIENTE: Só pode CANCELAR
            if ($request->action === 'cancel') {
                $cancelledStatus = DB::table('status')->whereRaw('LOWER(status_name) = ?', ['cancelled'])->first();
                if ($cancelledStatus) {
                    $data['status_id'] = $cancelledStatus->id;
                }
            }
        }

        // Só faz o update se houver dados permitidos para alterar
        if (! empty($data)) {
            DB::table('appointments')->where('id', $id)->update(array_merge($data, [
                'updated_at' => now(),
            ]));
        }

        if ($user->is_admin == 1) {
            return redirect('/appointments');
        } elseif ($user->is_dentist == 1) {
            return redirect('/dentist/appointments');
        } else {
            return redirect('/patient/appointments');
        }
    }

    public function destroy(Request $request, $id)
    {
        // Envelopa em uma transação para garantir segurança e integridade dos dados
        DB::transaction(function () use ($id) {
            // 1. Remove primeiro todos os agendamentos vinculados a este paciente
            DB::table('appointments')->where('patient_id', $id)->delete();

            // 2. Remove o registro do paciente na tabela users
            DB::table('users')->where('id', $id)->where('is_patient', 1)->delete();
        });

        return redirect('/patients');
    }

    // Importante: Adicione (Request $request) nos parâmetros do método
    public function dentistAppointments(Request $request)
    {
        $user = Auth::user();

        // 1. Inicia a query buscando apenas os agendamentos deste dentista
        $query = Appointment::with(['patient', 'statu'])
            ->where('dentist_id', $user->id)
            ->orderBy('appointment_date', 'asc');

        // 2. Se o usuário aplicou o filtro, adiciona a condição na query
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        // 3. Executa a query
        $appointments = $query->get();

        // 4. Busca todos os status para popular o filtro na tela
        $statuses = DB::table('status')->get();

        return view('dentist-appointments', [
            'appointments' => $appointments,
            'statuses' => $statuses,
        ]);
    }

    public function patientAppointments()
    {
        $user = Auth::user();

        $appointments = Appointment::with(['dentist', 'statu'])
            ->where('patient_id', $user->id)
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('patient-appointments', ['appointments' => $appointments]);
    }
}
