<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Dental Clinic</title>
    <style>
        body { font-family: sans-serif; background-color: #f7fafc; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .register-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h1 { text-align: center; color: #2d3748; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #4a5568; }
        input { width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; font-weight: bold; background-color: #2b6cb0; color: white; border: none; border-radius: 4px; cursor: pointer; margin-top: 10px; }
        .error-messages { background-color: #fed7d7; color: #c53030; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 14px; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #2b6cb0; text-decoration: none; font-size: 14px; font-weight: bold; }
    </style>
</head>
<body>

    <div class="register-box">
        <h1>Create Account</h1>

        @if ($errors->any())
            <div class="error-messages">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/register" method="POST">
            @csrf

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>CPF / SSN</label>
                <input type="text" name="cpf" value="{{ old('cpf') }}" required>
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required>
            </div>

            <div class="form-group">
                <label>Birth Date</label>
                <input type="date" name="birth_date" value="{{ old('birth_date') }}" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit">Register as Patient</button>
        </form>

        <a href="/" class="back-link">← Back to Login</a>
    </div>

</body>
</html>
