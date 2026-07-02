@extends('layouts.app')

@section('content')
    <header>
        <h1>Appointments</h1>
        <hr>
    </header>

    <section>
        <h2>All Appointments</h2>

        <div style="margin-bottom: 20px; background: #edf2f7; padding: 15px; border-radius: 6px; border: 1px solid #cbd5e0;">
            <form action="/appointments" method="GET" style="display: flex; align-items: center; gap: 15px; margin: 0;">
                <label for="status_filter" style="font-weight: bold; color: #2c5282;">Filter by Status:</label>

                <select name="status_id" id="status_filter" style="padding: 6px; border-radius: 4px; border: 1px solid #a0aec0; width: 200px;">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $st)
                        <option value="{{ $st->id }}" {{ request('status_id') == $st->id ? 'selected' : '' }}>
                            {{ ucfirst($st->status_name) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" style="margin: 0; padding: 8px 16px;">Filter</button>

                @if(request('status_id'))
                    <a href="/appointments" style="color: #c53030; font-weight: bold; text-decoration: none;">Clear Filter</a>
                @endif
            </form>
        </div>

        <table style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Dentist</th>
                    <th>Date Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $a)
                <tr>
                    <td>{{ $a->id }}</td>
                    <td>{{ $a->patient->name ?? 'N/A' }}</td>
                    <td>{{ $a->dentist->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($a->appointment_date)->format('d/m/Y H:i') }}</td>
                    <td>
                        @php
                            // Padroniza para minúsculo para facilitar a verificação
                            $statusName = strtolower($a->statu->status_name ?? 'scheduled');

                            // Define as cores [Texto, Fundo] combinando com o novo tema clínico
                            [$txtColor, $bgColor] = match($statusName) {
                                'confirmed' => ['#065f46', '#d1fae5'], // Verde Esmeralda (Sucesso)
                                'cancelled' => ['#991b1b', '#fee2e2'], // Vermelho (Cancelado)
                                'completed', 'finished' => ['#0f766e', '#ccfbf1'], // Teal (Concluído - Cor da Clínica)
                                default => ['#1e40af', '#dbeafe'], // Azul (Pendente / Agendado)
                            };
                        @endphp

                        <span style="display: inline-block; padding: 6px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; color: {{ $txtColor }}; background-color: {{ $bgColor }}; text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
                            {{ ucfirst($a->statu->status_name ?? 'Scheduled') }}
                        </span>
                    </td>
                    <td>
                        <a href="/appointments/edit/{{ $a->id }}">
                            <button type="button">Edit</button>
                        </a>
                        <form action="/appointments/delete/{{ $a->id }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" onclick="return confirm('Delete appointment #{{ $a->id }}?')" style="background-color: #c53030 !important;">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">No appointments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
