@extends('layouts.app')

@section('content')
    <header>
        <h1>Patient Management</h1>
        <hr>
    </header>

    <section>
        <a href="/patients/new">
            <button type="button" style="padding: 10px; cursor: pointer;">Register New Patient</button>
        </a>

        <br><br>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>CPF / SSN</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->cpf }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>
                        <a href="/patients/edit/{{ $patient->id }}">
                            <button type="button">Edit</button>
                        </a>
                        <a href="/appointments/new?patient_id={{ $patient->id }}">
                            <button type="button" style="margin-left: 5px;">Schedule</button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection