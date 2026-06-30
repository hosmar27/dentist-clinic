<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dental Clinic Web</title>
    <style>
        /* Reset e Layout Principal (Flexbox) */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: Arial, Helvetica, sans-serif;
            background: #e2e8f0; 
            color: #2d3748; 
            display: flex;
            height: 100vh;
            overflow: hidden; /* Evita barra de rolagem na página inteira */
        }

        /* --- Barra Lateral (Sidebar) --- */
        .sidebar {
            width: 250px;
            background-color: #1a365d; /* Fundo azul escuro */
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar .brand {
            padding: 20px;
            color: #fff;
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
            border-bottom: 1px solid #2c5282;
            margin-bottom: 10px;
        }
        .sidebar a {
            color: #edf2f7;
            text-decoration: none;
            padding: 15px 20px;
            font-weight: bold;
            display: block;
            transition: all 0.2s ease-in-out;
            border-left: 4px solid transparent; /* Preparação para efeito de hover */
        }
        .sidebar a:hover {
            background-color: #2c5282;
            border-left: 4px solid #63b3ed; /* Detalhe lateral ao passar o mouse */
            padding-left: 25px; /* Leve movimento para a direita */
        }
        .sidebar .logout {
            margin-top: auto; /* Empurra o botão de logout para o final da tela */
            background-color: #c53030;
            border-left: none;
        }
        .sidebar .logout:hover {
            background-color: #9b2c2c;
            padding-left: 20px;
        }

        /* --- Área de Conteúdo Central --- */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto; /* Permite rolagem apenas no conteúdo */
        }

        /* --- Estilos unificados dos elementos da página --- */
        h1, h2 { color: #1a365d; margin-bottom: 15px; }
        hr { border: 0; height: 1px; background-color: #cbd5e0; margin-bottom: 20px; }
        
        button { 
            background: #3182ce !important; color: #f7fafc !important; 
            border: none; padding: 8px 12px; border-radius: 6px; 
            cursor: pointer; transition: background-color 0.2s ease-in-out;
            font-weight: bold;
        }
        button:hover { background: #2b6cb0 !important; opacity: 1 !important; }

        input, select { 
            background-color: #edf2f7; border: 1px solid #a0aec0 !important; 
            color: #2d3748; border-radius: 4px; padding: 6px; margin: 4px 0;
            transition: border-color 0.2s;
        }
        input:focus, select:focus { border-color: #3182ce !important; outline: none; }
        label { font-weight: bold; color: #2c5282; }

        table { width: 100%; border-collapse: collapse; background-color: #edf2f7; margin-top: 10px; }
        thead { background-color: #2c5282 !important; color: #edf2f7; }
        table th, table td { padding: 10px; border: 1px solid #cbd5e0 !important; text-align: left; }
        tbody tr:nth-child(even) { background-color: #e2e8f0; }
        tbody tr:hover { background-color: #cbd5e0; }
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="brand">Dental Clinic</div>
        
        @php $user = Auth::user(); @endphp

        @if($user && $user->is_admin == 1)
            <a href="/appointments">📅 All Appointments</a>
            <a href="/patients">👥 Patients</a>
            <a href="/dentists">🦷 Dentists</a>
            
        @elseif($user && $user->is_dentist == 1)
            <a href="/dentist/appointments">📅 My Schedule</a>
            
        @else
            <a href="/patient/appointments">📅 My Appointments</a>
            <a href="/appointments/new">➕ Book Appointment</a>
        @endif
        
        <a href="/profile">👤 My Profile</a>
        
        <a href="/logout" class="logout">🚪 Logout</a>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

</body>
</html>