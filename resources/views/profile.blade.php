@extends('layouts.app')

@section('content')
    <header>
        <h1>My Profile</h1>
        <hr>
    </header>

    <section>
        @if(session('success'))
            <div style="background: #c6f6d5; color: #22543d; padding: 10px; margin-bottom: 15px; border-radius: 5px; font-weight: bold;">
                {{ session('success') }}
            </div>
        @endif

        <form action="/profile" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label>Name</label><br>
                <input type="text" name="name" value="{{ $user->name }}" required style="width: 300px; padding: 5px;">
            </div>

            @if($user->is_dentist == 1 || $user->is_patient == 1)
                <div style="margin-bottom: 15px;">
                    <label>Email</label><br>
                    <input type="email" name="email" value="{{ $user->email }}" required style="width: 300px; padding: 5px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label>Birth Date</label><br>
                    <input type="date" name="birth_date" value="{{ $user->birth_date }}" required style="width: 300px; padding: 5px;">
                </div>
            @endif

            @if($user->is_admin == 1)
                <div style="margin-bottom: 15px;">
                    <label>Phone</label><br>
                    <input type="text" name="phone" value="{{ $user->phone }}" required style="width: 300px; padding: 5px;">
                </div>
            @endif

            <div style="margin-bottom: 15px;">
                <label>CPF</label><br>
                <input type="text" value="{{ $user->cpf }}" readonly style="width: 300px; padding: 5px; background-color: #e2e8f0; color: #718096; cursor: not-allowed;">
            </div>

            @if($user->is_dentist == 1)
                <div style="margin-bottom: 15px;">
                    <label>CIP</label><br>
                    <input type="text" value="{{ $user->cip }}" readonly style="width: 300px; padding: 5px; background-color: #e2e8f0; color: #718096; cursor: not-allowed;">
                </div>
            @endif

            <div style="margin-bottom: 15px;">
                <label>New Password <small>(leave blank to keep current)</small></label><br>
                <input type="password" name="password" style="width: 300px; padding: 5px;">
            </div>

            <br>
            <button type="submit" style="padding: 10px 20px; font-weight: bold;">Update Profile</button>
        </form>
    </section>
@endsection