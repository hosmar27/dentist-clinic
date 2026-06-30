@extends('layouts.app')

@section('content')
    <header>
        <h1>My Schedule</h1>
        <hr>
    </header>

    <section>
        <table style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient</th>
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
                    <td>{{ \Carbon\Carbon::parse($a->appointment_date)->format('Y-m-d H:i') }}</td>
                    <td>{{ ucfirst($a->statu->status_name ?? '') }}</td>
                    <td>
                        <a href="/appointments/edit/{{ $a->id }}">
                            <button type="button">Edit Status</button>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">You have no appointments scheduled.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection