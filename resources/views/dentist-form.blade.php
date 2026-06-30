@extends('layouts.app')

@section('content')
    <header>
        <h1>{{ $dentist ? 'Edit Dentist' : 'Register New Dentist' }}</h1>
        <a href="/dentists">← Back to list</a>
        <hr>
    </header>

    <form action="{{ $dentist ? '/dentists/update/'.$dentist->id : '/dentists/save' }}" method="POST">
        @csrf
        
        <div>
            <label>Full Name:</label><br>
            <input type="text" name="name" value="{{ $dentist ? $dentist->name : '' }}" required style="width: 300px; padding: 5px;">
        </div>
        <br>
        
        <div>
            <label>Email:</label><br>
            <input type="email" name="email" value="{{ $dentist ? $dentist->email : '' }}" required style="width: 300px; padding: 5px;">
        </div>
        <br>

        <div>
            <label>Birth Date:</label><br>
            <input type="date" name="birth_date" value="{{ $dentist ? $dentist->birth_date : '' }}" required style="width: 300px; padding: 5px;">
        </div>
        <br>

        <div>
            <label>CPF / SSN:</label><br>
            <input type="text" name="cpf" value="{{ $dentist ? $dentist->cpf : '' }}" required style="width: 300px; padding: 5px;">
        </div>
        <br>

        <div>
            <label>Phone:</label><br>
            <input type="text" name="phone" value="{{ $dentist ? $dentist->phone : '' }}" required style="width: 300px; padding: 5px;">
        </div>
        <br>

        <div>
            <label>CIP:</label><br>
            <input type="text" name="cip" value="{{ $dentist ? $dentist->cip : '' }}" style="width: 300px; padding: 5px;">
        </div>
        <br>

        <div>
            <label>Password {{ $dentist ? '(Leave blank to keep current)' : '' }}:</label><br>
            <input type="password" name="password" {{ $dentist ? '' : 'required' }} style="width: 300px; padding: 5px;">
        </div>
        <br>

        <div>
            <label>Account Status:</label><br>
            <select name="is_active" style="width: 314px; padding: 5px;">
                <option value="1" {{ ($dentist && $dentist->is_active == 1) ? 'selected' : '' }}>Active</option>
                <option value="0" {{ ($dentist && $dentist->is_active == 0) ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <br>

        <button type="submit" style="padding: 10px 20px; font-weight: bold;">
            {{ $dentist ? 'Update Dentist' : 'Save Dentist' }}
        </button>
    </form>
@endsection