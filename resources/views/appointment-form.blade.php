@extends('layouts.app')

@section('content')
    <header>
        <h1>{{ $appointment ? 'Edit Appointment' : 'Schedule Appointment' }}</h1>
        <hr>
    </header>

    <form action="{{ $appointment ? '/appointments/update/'.$appointment->id : '/appointments/save' }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 15px;">
            <label>Patient ID</label><br>
            <select name="patient_id" required style="width: 300px; padding: 5px;">
                <option value="">-- select patient --</option>
                @foreach(($patients ?? []) as $p)
                    <option value="{{ $p->id }}" {{ (old('patient_id', request()->get('patient_id') ?? ($appointment ? $appointment->patient_id : '')) == $p->id) ? 'selected' : '' }}>
                        {{ $p->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Dentist ID</label><br>
            <select name="dentist_id" required style="width: 300px; padding: 5px;">
                <option value="">-- select dentist --</option>
                @foreach(($dentists ?? []) as $d)
                    <option value="{{ $d->id }}" {{ (old('dentist_id', $appointment ? $appointment->dentist_id : '') == $d->id) ? 'selected' : '' }}>
                        {{ $d->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Date & Time</label><br>
            <input name="appointment_date" type="datetime-local" required value="{{ $appointment ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') : '' }}" style="width: 300px; padding: 5px;" />
        </div>

        <div style="margin-bottom: 15px;">
            <label>Status</label><br>
            <select name="status_id" style="width: 314px; padding: 5px;">
                <option value="">-- select status --</option>
                @foreach($statuses as $st)
                    <option value="{{ $st->id }}" {{ (old('status', $appointment ? $appointment->status : '') == $st->id) ? 'selected' : '' }}>
                        {{ ucfirst($st->status_name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <br>
        <button type="submit" style="padding: 10px 20px; font-weight: bold;">
            {{ $appointment ? 'Update Appointment' : 'Create Appointment' }}
        </button>
    </form>
@endsection