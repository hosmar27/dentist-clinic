@extends('layouts.app')

@section('content')
    <header>
        <h1>Dentists Management</h1>
        <hr>
    </header>

    <section>
        <a href="/dentists/new">
            <button type="button" style="padding: 10px; cursor: pointer;">Register New Dentist</button>
        </a>
        <br><br>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>CPF / SSN</th>
                    <th>Phone</th>
                    <th>CIP</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dentists as $d)
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->email }}</td>
                    <td>{{ $d->cpf }}</td>
                    <td>{{ $d->phone }}</td>
                    <td>{{ $d->cip ?? '-' }}</td>
                    <td>
                        <span style="font-weight: bold; color: {{ $d->is_active ? '#2f855a' : '#c53030' }};">
                            {{ $d->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="/dentists/edit/{{ $d->id }}">
                            <button type="button">Edit</button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection