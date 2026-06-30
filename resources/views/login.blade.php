<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Dental Clinic</title>
    <style>
        /* 1. Reset margins and use Flexbox to center everything on the screen */
        body {
            background: #f4f7fb !important;
            color: #222;
            font-family: Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* 2. Wrap the login area in a clean white card */
        main {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        /* 3. Improve button sizing and spacing */
        button {
            background: #0b74da;
            color: #fff;
            border: none;
            padding: 10px 12px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-top: 10px;
        }
        button:hover { opacity: 0.92; }

        /* 4. Make inputs span the full width of their container */
        input {
            border: 1px solid #dcdcdc;
            padding: 8px;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box; /* Ensures padding doesn't break the width */
            margin-top: 5px;
        }

        /* 5. Align labels properly above the inputs */
        .input-group {
            text-align: left;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <main>
        
        @if ($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 5px; text-align: left;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <header>
            <h1>Dental Clinic</h1>
            <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">
        </header>

        <section>
            <h2>System Access</h2>

            <form action="/login" method="POST">
                @csrf
                
                <div class="input-group">
                    <label for="email">E-mail: </label>
                    <input type="email" id="email" name="email" placeholder="example@clinic.com" required>
                </div>

                <div class="input-group">
                    <label for="password">Password: </label>
                    <input type="password" id="password" name="password" placeholder="Your access password" required>
                </div>

                <button type="submit">Login</button>
            </form>
        </section>
    </main>

</body>
</html>