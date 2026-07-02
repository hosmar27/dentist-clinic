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
