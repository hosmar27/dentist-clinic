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
                @foreach($patients as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->cpf }}</td>
                    <td>{{ $p->phone }}</td>
                    <td>
                        <a href="/appointments/new?patient_id={{ $p->id }}">
                            <button type="button" style="background-color: #2f855a !important;">Book Appointment</button>
                        </a>

                        <a href="/patients/edit/{{ $p->id }}">
                            <button type="button">Edit</button>
                        </a>

                        <form action="/patients/delete/{{ $p->id }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete patient {{ $p->name }}? This will permanently remove all their associated appointments.')"
                                    style="background-color: #c53030 !important;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection
