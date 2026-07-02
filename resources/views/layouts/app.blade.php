<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dental Clinic Web</title>
    <style>
    /* Reset & Tipografia Moderna */
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        background: #f3f4f6; /* Fundo cinza bem suave */
        color: #1f2937; /* Texto escuro, mas não 100% preto (melhor leitura) */
        display: flex;
        height: 100vh;
        overflow: hidden;
    }

    /* --- Barra Lateral (Clean White Theme) --- */
    .sidebar {
        width: 260px;
        background-color: #ffffff;
        display: flex;
        flex-direction: column;
        border-right: 1px solid #e5e7eb;
        box-shadow: 4px 0 15px rgba(0,0,0,0.03);
        z-index: 10;
    }
    .sidebar .brand {
        padding: 24px 20px;
        color: #0f766e; /* Teal Odontológico / Saúde */
        text-align: center;
        font-size: 1.5em;
        font-weight: 800;
        border-bottom: 1px solid #f3f4f6;
        margin-bottom: 15px;
        letter-spacing: -0.5px;
    }
    .sidebar a {
        color: #4b5563;
        text-decoration: none;
        padding: 12px 20px;
        font-weight: 600;
        display: block;
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
        margin: 4px 12px;
        border-radius: 6px; /* Botões arredondados dentro da sidebar */
    }
    .sidebar a:hover {
        background-color: #f0fdfa; /* Fundo Teal bem claro */
        color: #0f766e;
        border-left: 4px solid #0d9488;
        transform: translateX(4px); /* Animação suave para a direita */
    }
    .sidebar .logout {
        margin-top: auto;
        margin-bottom: 20px;
        background-color: #fff1f2;
        color: #e11d48;
        border-left: none;
    }
    .sidebar .logout:hover {
        background-color: #ffe4e6;
        color: #be123c;
        transform: translateY(-2px); /* Animação de elevação */
    }

    /* --- Área de Conteúdo Central --- */
    .main-content {
        flex: 1;
        padding: 40px;
        overflow-y: auto;
    }

    /* --- Títulos e Botões --- */
    h1, h2 { color: #111827; margin-bottom: 8px; font-weight: 700; letter-spacing: -0.5px; }
    hr { border: 0; height: 1px; background-color: #e5e7eb; margin-bottom: 24px; }

    button {
        background: #0d9488 !important; /* Botões Teal (Saúde) */
        color: #ffffff !important;
        border: none; padding: 10px 18px; border-radius: 6px;
        cursor: pointer; transition: all 0.2s ease;
        font-weight: 600;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    button:hover {
        background: #0f766e !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    /* --- Formulários --- */
    input, select {
        background-color: #ffffff;
        border: 1px solid #d1d5db !important;
        color: #374151; border-radius: 6px; padding: 10px; margin: 4px 0;
        transition: all 0.2s;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02) inset;
    }
    input:focus, select:focus {
        border-color: #0d9488 !important;
        outline: none;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15) !important;
    }
    label { font-weight: 600; color: #4b5563; font-size: 0.9em; }

    /* --- Tabelas Modernas (Estilo SaaS) --- */
    table {
        width: 100%; border-collapse: separate; border-spacing: 0;
        background-color: #ffffff; margin-top: 20px;
        border-radius: 8px; overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border: 1px solid #e5e7eb;
    }
    thead { background-color: #f9fafb !important; }
    table th {
        padding: 14px 16px; text-align: left;
        color: #6b7280; font-weight: 600; font-size: 0.85em;
        text-transform: uppercase; letter-spacing: 0.05em;
        border-bottom: 1px solid #e5e7eb !important;
    }
    table td {
        padding: 16px; border-bottom: 1px solid #e5e7eb !important;
        color: #374151; font-size: 0.95em;
    }
    tbody tr:last-child td { border-bottom: none !important; }
    tbody tr:hover { background-color: #f3f6f9; }
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
