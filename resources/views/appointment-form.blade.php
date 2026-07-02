@extends('layouts.app')

@section('content')
    <header>
        <h1>{{ $appointment ? 'Appointment Details' : 'Schedule Appointment' }}</h1>
        <hr>
    </header>

    @php $currentUser = Auth::user(); @endphp

    <form action="{{ $appointment ? '/appointments/update/'.$appointment->id : '/appointments/save' }}" method="POST">
        @csrf

        <div style="margin-bottom: 15px;">
            <label>Patient</label><br>
            @if($currentUser->is_patient == 1)
                <input type="hidden" name="patient_id" value="{{ $currentUser->id }}">
                <input type="text" value="{{ $currentUser->name }}" readonly style="width: 300px; padding: 5px; background-color: #e2e8f0; color: #718096; cursor: not-allowed;">

            @elseif($currentUser->is_dentist == 1 && $appointment)
                <input type="text" value="{{ $appointment->patient->name ?? 'Unknown' }}" readonly style="width: 300px; padding: 5px; background-color: #e2e8f0; color: #718096; cursor: not-allowed;">

            @else
                <select name="patient_id" required style="width: 300px; padding: 5px;">
                    <option value="">-- select patient --</option>
                    @foreach(($patients ?? []) as $p)
                        <option value="{{ $p->id }}" {{ (old('patient_id', request()->get('patient_id') ?? ($appointment ? $appointment->patient_id : '')) == $p->id) ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        <div style="margin-bottom: 15px;">
            <label>Dentist</label><br>
            @if(($currentUser->is_patient == 1 || $currentUser->is_dentist == 1) && $appointment)
                <input type="text" value="{{ $appointment->dentist->name ?? 'Unknown' }}" readonly style="width: 300px; padding: 5px; background-color: #e2e8f0; color: #718096; cursor: not-allowed;">

            @else
                <select name="dentist_id" required style="width: 300px; padding: 5px;">
                    <option value="">-- select dentist --</option>
                    @foreach(($dentists ?? []) as $d)
                        <option value="{{ $d->id }}" {{ (old('dentist_id', $appointment ? $appointment->dentist_id : '') == $d->id) ? 'selected' : '' }}>
                            {{ $d->name }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        <div style="margin-bottom: 15px;">
            <label>Date & Time</label><br>
            @if($currentUser->is_patient == 1 && $appointment)
                <input type="datetime-local" value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') }}" readonly style="width: 300px; padding: 5px; background-color: #e2e8f0; color: #718096; cursor: not-allowed;" />
            @else
                <input name="appointment_date" type="datetime-local" required value="{{ $appointment ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') : '' }}" style="width: 300px; padding: 5px;" />
            @endif
        </div>

        @if($appointment)
            <div style="margin-bottom: 15px;">
                <label>Status</label><br>
                @if($currentUser->is_admin == 1 || $currentUser->is_dentist == 1)
                    <select name="status_id" style="width: 314px; padding: 5px;">
                        <option value="">-- select status --</option>
                        @foreach($statuses as $st)
                            <option value="{{ $st->id }}" {{ (old('status_id', $appointment->status_id) == $st->id) ? 'selected' : '' }}>
                                {{ ucfirst($st->status_name) }}
                            </option>
                        @endforeach
                    </select>
                @else
                    @php
                        $statusName = strtolower($appointment->statu->status_name ?? 'scheduled');

                        [$txtColor, $bgColor] = match($statusName) {
                            'confirmed' => ['#065f46', '#d1fae5'], // Verde
                            'cancelled' => ['#991b1b', '#fee2e2'], // Vermelho
                            'completed', 'finished' => ['#0f766e', '#ccfbf1'], // Teal
                            default => ['#1e40af', '#dbeafe'], // Azul
                        };
                    @endphp

                    <div style="margin-top: 6px;">
                        <span style="display: inline-block; padding: 8px 16px; border-radius: 50px; font-size: 0.85rem; font-weight: 700; color: {{ $txtColor }}; background-color: {{ $bgColor }}; text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 1px 2px rgba(0,0,0,0.02); cursor: not-allowed;">
                            {{ ucfirst($appointment->statu->status_name ?? 'Scheduled') }}
                        </span>
                    </div>
                @endif
            </div>
        @endif

        <br>

        @if($currentUser->is_patient == 1 && $appointment)
            @php
                $isCancelled = strtolower($appointment->statu->status_name ?? '') === 'cancelled';
            @endphp

            @if(!$isCancelled)
                <button type="submit" name="action" value="cancel" style="padding: 10px 20px; font-weight: bold; background-color: #c53030 !important; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                    Cancel Appointment
                </button>
            @else
                <span style="color: #c53030; font-weight: bold;">This appointment is cancelled.</span>
            @endif
        @else
            <button type="submit" style="padding: 10px 20px; font-weight: bold;">
                {{ $appointment ? 'Update Appointment' : 'Create Appointment' }}
            </button>
        @endif
    </form>
@endsection
