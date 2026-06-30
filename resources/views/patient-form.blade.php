@extends('layouts.app')

@section('content')
    <header>
        <h1>{{ $patient ? 'Edit Patient' : 'Register New Patient' }}</h1>
        <a href="/patients">← Back to list</a>
        <hr>
    </header>

    <form action="{{ $patient ? '/patients/update/'.$patient->id : '/patients/save' }}" method="POST">
        @csrf

        <div>
            <label>Full Name:</label><br>
            <input type="text" name="name" value="{{ $patient ? $patient->name : '' }}" required style="width: 300px; padding: 5px;">
        </div>
        <br>
        
        <div>
            <label>Email:</label><br>
            <input type="email" name="email" value="{{ $patient ? $patient->email : '' }}" required style="width: 300px; padding: 5px;">
        </div>
        <br>

        <div>
            <label>CPF / SSN:</label><br>
            <input type="text" name="cpf" value="{{ $patient ? $patient->cpf : '' }}" required style="width: 300px; padding: 5px;">
        </div>
        <br>
        
        <div>
            <label>Phone:</label><br>
            <input type="text" name="phone" value="{{ $patient ? $patient->phone : '' }}" required style="width: 300px; padding: 5px;">
        </div>
        <br>
        
        <div>
            <label>Birth Date:</label><br>
            <input type="date" name="birth_date" value="{{ $patient ? $patient->birth_date : '' }}" required style="width: 300px; padding: 5px;">
        </div>
        <br>

        <div style="margin-bottom: 15px;">
            <label>Password</label> 
            <small style="color: #718096;">{{ $patient ? '(Leave blank to keep current)' : '' }}</small><br>
            
            <input type="password" name="password" {{ $patient ? '' : 'required' }} style="width: 300px; padding: 5px; margin-top: 5px;">
        </div>
        <br>

        <div>
            <label>Account Status:</label><br>
            <select name="is_active" style="width: 314px; padding: 5px;">
                <option value="1" {{ ($patient && $patient->is_active == 1) ? 'selected' : '' }}>Active</option>
                <option value="0" {{ ($patient && $patient->is_active == 0) ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <br>

        <button type="submit" style="padding: 10px 20px; font-weight: bold;">
            {{ $patient ? 'Update Data' : 'Save Patient' }}
        </button>
    </form>
@endsection