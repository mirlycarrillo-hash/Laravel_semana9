<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'ProductosApp') | DAI</title>
    <style>
        /* ── Variables CSS globales con tonos cálidos oscuros ── */
        :root {
            --primary:      #D35400; /* Terracota cálido */
            --primary-dk:   #2E1A16; /* Chocolate muy oscuro para fondos */
            --accent:       #F39C12; /* Ámbar / Oro cálido para iluminaciones */
            --bg:           #1C100E; /* Fondo general ultra oscuro cálido */
            --card-bg:      #2A1815; /* Fondo de tarjetas (un poco más claro que el fondo) */
            --text:         #F5EEF0; /* Texto claro suave */
            --text-light:   #A08A85; /* Texto secundario apagado */
            --border:       #4A2E2B; /* Bordes sutiles */
            --radius:       12px;
            --shadow:       0 0 15px rgba(243, 156, 18, 0.15); /* Efecto Glow Ámbar */
        }

        /* ── Reset y base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            background: var(--bg);
            color: var(--text); 
            min-height: 100vh; 
        }
        a { color: var(--accent); text-decoration: none; transition: color .2s; }
        a:hover { color: var(--primary); text-decoration: none; }

        /* ── Navbar Estilo Oscuro ── */
        .navbar {
            background: var(--primary-dk);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--border);
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        }
        .navbar .brand { color: #fff; font-size: 1.4rem; font-weight: 700; letter-spacing: .5px; }
        .navbar .brand span { color: var(--accent); }
        .navbar nav a {
            color: rgba(255,255,255,.85);
            margin-left: 1.2rem;
            font-size: .95rem;
            font-weight: 500;
            transition: all .2s;
        }
        .navbar nav a:hover { color: var(--accent); }
        
        .navbar .carrito-btn {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: .5rem 1.2rem;
            border-radius: 20px;
            cursor: pointer;
            font-size: .9rem;
            font-weight: 600;
            transition: all .2s;
            box-shadow: 0 0 10px rgba(211, 84, 0, 0.4);
        }
        .navbar .carrito-btn:hover {
            background: var(--accent);
            box-shadow: 0 0 15px rgba(243, 156, 18, 0.6);
        }

        /* ── Contenido principal ── */
        .main-content { max-width: 1200px; margin: 2rem auto; padding: 0 1.5rem; }

        /* ── Tarjetas con el efecto Glow de tu diseño anterior ── */
        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* ── Botones ── */
        .btn {
            display: inline-block; 
            padding: .6rem 1.4rem;
            border-radius: 8px; 
            font-weight: 600; 
            font-size: .9rem;
            cursor: pointer; 
            border: none;
            transition: all .2s;
            text-align: center;
        }
        .btn-primary { 
            background: var(--primary); 
            color: #fff; 
            box-shadow: 0 4px 10px rgba(211, 84, 0, 0.3);
        }
        .btn-primary:hover { 
            background: var(--accent); 
            color: #fff; 
            box-shadow: 0 0 12px rgba(243, 156, 18, 0.5);
        }
        .btn-success { background: #27AE60; color: #fff; }
        .btn-success:hover { background: #1E8449; }
        .btn-danger  { background: #C0392B; color: #fff; }
        .btn-outline {
            background: transparent; 
            border: 2px solid var(--primary);
            color: var(--primary); 
        }
        .btn-outline:hover {
            background: var(--primary); 
            color: #fff; 
        }
        .btn-sm { padding: .35rem .85rem; font-size: .82rem; }

        /* ── Galería de productos en Grid ── */
        .galeria-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .producto-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform .25s, box-shadow .25s;
            display: flex; 
            flex-direction: column;
        }
        .producto-card:hover { 
            transform: translateY(-6px);
            box-shadow: 0 0 20px rgba(243, 156, 18, 0.4); 
            border-color: var(--accent);
        }
        .producto-card img {
            width: 100%; 
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid var(--border);
        }
        .producto-card .no-foto {
            width: 100%; height: 200px; background: #221210;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-light); font-size: .9rem;
            border-bottom: 1px solid var(--border);
        }
        .producto-card .card-body {
            padding: 1rem; flex-grow: 1; display: flex; flex-direction: column;
        }
        .producto-card .card-body h3 { font-size: 1.05rem; margin-bottom: .3rem; color: #fff; }
        .producto-card .card-body .marca { color: var(--text-light); font-size: .85rem; margin-bottom: .6rem; }
        .producto-card .card-body .precio {
            font-size: 1.3rem; font-weight: 700; color: var(--accent); margin-top: auto;
        }
        .producto-card .card-footer {
            padding: .8rem 1rem;
            border-top: 1px solid var(--border);
            background: rgba(0,0,0,0.1);
            display: flex; gap: .5rem;
            justify-content: space-between; align-items: center;
        }

        /* ── Badges con tonos que combinan ── */
        .badge-categoria {
            background: #4A2E2B;
            color: #F1948A; 
            padding: .25rem .65rem;
            border-radius: 20px;
            font-size: .78rem; font-weight: 600;
        }
        .badge-stock-ok   { background: rgba(39, 174, 96, 0.2); color: #2ECC71; }
        .badge-stock-warn { background: rgba(230, 126, 34, 0.2); color: #E67E22; }
        .badge-stock-low  { background: rgba(192, 57, 43, 0.2); color: #E74C3C; }

        /* ── Tablas adaptadas al modo oscuro ── */
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th { background: var(--primary-dk); color: var(--accent); padding: .8rem 1rem; text-align: left; font-size: .9rem; border-bottom: 2px solid var(--border); }
        td { padding: .75rem 1rem; border-bottom: 1px solid var(--border); font-size: .92rem; color: var(--text); }
        tr:hover td { background: rgba(255,255,255,0.02); }

        /* ── Alertas sutiles ── */
        .alert { padding: .9rem 1.2rem; border-radius: var(--radius); margin-bottom: 1rem; font-size: .95rem; }
        .alert-success { background: rgba(39, 174, 96, 0.15); border-left: 4px solid #27AE60; color: #2ECC71; }
        .alert-danger  { background: rgba(192, 57, 43, 0.15); border-left: 4px solid #C0392B; color: #E74C3C; }
        .alert-info    { background: rgba(46, 134, 193, 0.15); border-left: 4px solid #2E86C1; color: #3498DB; }

        /* ── Formularios elegantes ── */
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; font-weight: 600; margin-bottom: .4rem; font-size: .92rem; color: var(--text-light); }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: .65rem .9rem;
            background: rgba(0,0,0,0.2);
            border: 1.5px solid var(--border);
            border-radius: 8px; font-size: .95rem; color: #fff;
            transition: all .2s;
        }
        .form-group input:focus, .form-group select:focus {
            outline: none; border-color: var(--accent);
            box-shadow: 0 0 8px rgba(243, 156, 18, 0.3);
        }

        /* ── Footer ── */
        .site-footer {
            text-align: center; padding: 1.5rem; margin-top: 3rem;
            color: var(--text-light); font-size: .85rem;
            border-top: 1px solid var(--border);
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="navbar">
    <a href="{{ route('home') }}" class="brand">Productos<span>App</span></a>
    <nav>
        @auth
            <a href="{{ route('productos.galeria') }}">Galeria</a>
            <a href="{{ route('productos.index') }}">Productos</a>
            <a href="{{ route('categorias.index') }}">Categorias</a>
            <a href="{{ route('carrito.index') }}" class="carrito-btn">
                Carrito
                @if(session('carrito') && count(session('carrito')) > 0)
                    ({{ count(session('carrito')) }})
                @endif
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-outline btn-sm" style="margin-left:1rem">
                    Cerrar sesion
                </button>
            </form>
        @else
            <a href="{{ route('login') }}">Iniciar sesion</a>
        @endauth
    </nav>
</div>

<div class="main-content">
    {{-- Mensajes flash de sesion --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    @yield('contenido')
</div>

<div class="site-footer">
    Desarrollo de Aplicaciones en Internet &mdash; Ciclo III &mdash; {{ date('Y') }}
</div>

@stack('scripts')
</body>
</html>