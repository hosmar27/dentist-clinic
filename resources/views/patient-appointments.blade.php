@extends('layouts.app')

@section('content')
    <header>
        <h1>My Appointments</h1>
        <hr>
    </header>

    <section>
        <div style="margin-bottom: 20px;">
            <a href="/appointments/new">
                <button type="button">+ Book New Appointment</button>
            </a>
        </div>

        <table style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Dentist</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $a)
                <tr>
                    <td>{{ $a->id }}</td>
                    <td>{{ $a->dentist->name ?? 'Not assigned' }}</td>
                    <td>{{ \Carbon\Carbon::parse($a->appointment_date)->format('Y-m-d H:i') }}</td>
                    <td>
                        @php
                            $statusName = strtolower($a->statu->status_name ?? '');
                            $statusColor = '#2b6cb0'; // Azul padrão (scheduled)
                            if($statusName == 'cancelled') $statusColor = '#c53030'; // Vermelho
                            if($statusName == 'confirmed') $statusColor = '#2f855a'; // Verde
                        @endphp
                        <span style="font-weight: bold; color: {{ $statusColor }};">
                            {{ ucfirst($statusName) }}
                        </span>
                    </td>
                    <td>
                        <a href="/appointments/edit/{{ $a->id }}">
                            <button type="button">View / Edit</button>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px; color: #4a5568;">
                        You have no appointments scheduled at the moment.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection