<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'IMMO AGENCE')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ══════════════════════════════════════════
           TOKENS
        ══════════════════════════════════════════ */
        :root {
            --bg:        #0d0f14;
            --sidebar:   #0a0c10;
            --surface:   #13161d;
            --surface2:  #1a1e28;
            --border:    #1f2433;
            --border2:   #252a38;
            --accent:    #c9a96e;
            --accent2:   #e8c97a;
            --text:      #e8e6e1;
            --muted:     #6b7080;
            --muted2:    #4a5060;
            --success:   #4caf7d;
            --danger:    #e05c5c;
            --warning:   #e8a838;
            --blue:      #5b8dee;
            --radius:    14px;

            /* Compat ancien code */
            --primary-color:   #5b8dee;
            --primary-dark:    #3a6dd4;
            --primary-light:   rgba(91,141,238,0.12);
            --secondary-color: #0a0c10;
            --accent-color:    #c9a96e;
            --success-color:   #4caf7d;
            --warning-color:   #e8a838;
            --danger-color:    #e05c5c;
            --info-color:      #5b8dee;
            --bg-primary:      #13161d;
            --bg-secondary:    #1a1e28;
            --bg-dark:         #0a0c10;
            --text-primary:    #e8e6e1;
            --text-secondary:  #6b7080;
            --border-color:    #252a38;
            --shadow-sm:       0 1px 3px rgba(0,0,0,0.4);
            --shadow-md:       0 4px 16px rgba(0,0,0,0.4);
            --shadow-lg:       0 10px 30px rgba(0,0,0,0.5);
            --shadow-xl:       0 20px 50px rgba(0,0,0,0.6);
        }

        /* ══════════════════════════════════════════
           RESET
        ══════════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* ══════════════════════════════════════════
           WRAPPER
        ══════════════════════════════════════════ */
        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ══════════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════════ */
        .modern-sidebar {
            width: 268px;
            background: var(--sidebar);
            position: fixed;
            left: 0; top: 0;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
        }

        .modern-sidebar::-webkit-scrollbar { width: 4px; }
        .modern-sidebar::-webkit-scrollbar-track { background: transparent; }
        .modern-sidebar::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 4px; }

        /* ── Logo ── */
        .sidebar-header {
            padding: 28px 24px 20px;
            border-bottom: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .sidebar-header::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, var(--accent), transparent 60%);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 11px;
            text-decoration: none;
        }

        .logo-mark {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(201,169,110,0.2), rgba(201,169,110,0.05));
            border: 1px solid rgba(201,169,110,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--accent);
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }

        .logo-text strong {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text);
            letter-spacing: 0.04em;
        }

        .logo-text span {
            font-size: 0.65rem;
            color: var(--accent);
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-top: 2px;
            font-weight: 500;
        }

        /* ── User card ── */
        .sidebar-user {
            margin: 20px 16px 0;
            padding: 14px 16px;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(201,169,110,0.25), rgba(201,169,110,0.08));
            border: 1px solid rgba(201,169,110,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--accent);
            flex-shrink: 0;
        }

        .user-info h4 {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text);
            margin: 0 0 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        .user-info p {
            font-size: 0.72rem;
            color: var(--accent);
            margin: 0;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* ── Nav ── */
        .sidebar-nav {
            padding: 20px 12px;
            flex: 1;
        }

        .nav-section { margin-bottom: 28px; }

        .nav-section-title {
            font-size: 0.62rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted2);
            padding: 0 12px;
            margin-bottom: 8px;
        }

        .nav-list { list-style: none; padding: 0; margin: 0; }
        .nav-list-item { margin-bottom: 2px; }

        .nav-list-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 13px;
            border-radius: 10px;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 400;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-list-link::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(201,169,110,0.08), transparent);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .nav-list-link i {
            font-size: 16px;
            width: 18px;
            text-align: center;
            flex-shrink: 0;
            transition: color 0.2s;
        }

        .nav-list-link:hover {
            color: var(--text);
            background: rgba(255,255,255,0.04);
        }

        .nav-list-link:hover::before { opacity: 1; }

        .nav-list-link:hover { transform: translateX(3px); }

        .nav-list-link.active {
            color: var(--accent) !important;
            background: rgba(201,169,110,0.1);
            font-weight: 500;
        }

        .nav-list-link.active::before { opacity: 1; }

        .nav-list-link.active::after {
            content: '';
            position: absolute;
            left: 0; top: 18%; bottom: 18%;
            width: 2.5px;
            background: var(--accent);
            border-radius: 0 2px 2px 0;
        }

        .nav-list-link.active i { color: var(--accent); }

        /* ── Sidebar footer ── */
        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border);
            flex-shrink: 0;
        }

        .sidebar-footer-info {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 12px;
        }

        .sidebar-footer-info span {
            font-size: 0.68rem;
            color: var(--muted2);
            letter-spacing: 0.05em;
        }

        .sidebar-footer-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--success);
            box-shadow: 0 0 8px var(--success);
            flex-shrink: 0;
        }

        /* ══════════════════════════════════════════
           MAIN CONTENT
        ══════════════════════════════════════════ */
        .main-content {
            margin-left: 268px;
            flex: 1;
            padding: 32px;
            width: calc(100% - 268px);
            min-height: 100vh;
            background: var(--bg);
            background-image:
                radial-gradient(ellipse at 10% 5%,  rgba(201,169,110,0.04) 0%, transparent 45%),
                radial-gradient(ellipse at 90% 95%, rgba(91,141,238,0.03)  0%, transparent 45%);
        }

        /* ══════════════════════════════════════════
           ALERTS
        ══════════════════════════════════════════ */
        .alert {
            border-radius: 11px;
            border: none;
            padding: 14px 18px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.875rem;
            animation: alertIn 0.35s cubic-bezier(.22,1,.36,1) both;
        }

        @keyframes alertIn {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: rgba(76,175,125,0.1);
            border: 1px solid rgba(76,175,125,0.25);
            color: #7de0a8;
        }

        .alert-danger {
            background: rgba(224,92,92,0.1);
            border: 1px solid rgba(224,92,92,0.25);
            color: #f08080;
        }

        .alert i { font-size: 18px; flex-shrink: 0; }

        .btn-close { filter: invert(0.5); }

        /* ══════════════════════════════════════════
           MOBILE TOGGLE
        ══════════════════════════════════════════ */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            bottom: 24px; right: 24px;
            width: 52px; height: 52px;
            border-radius: 50%;
            background: var(--surface2);
            border: 1px solid var(--border2);
            color: var(--accent);
            font-size: 22px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5);
            cursor: pointer;
            z-index: 999;
            transition: all 0.25s ease;
            align-items: center;
            justify-content: center;
        }

        .mobile-menu-toggle:hover {
            background: rgba(201,169,110,0.15);
            transform: scale(1.08);
        }

        /* ══════════════════════════════════════════
           SIDEBAR OVERLAY
        ══════════════════════════════════════════ */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(3px);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active { opacity: 1; }

        /* ══════════════════════════════════════════
           PUBLIC LAYOUT
        ══════════════════════════════════════════ */
        .public-navbar {
            background: var(--sidebar);
            border-bottom: 1px solid var(--border);
            padding: 16px 0;
        }

        .public-navbar .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            color: var(--text);
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .public-navbar .navbar-brand i {
            font-size: 22px;
            color: var(--accent);
        }

        .btn-outline-primary-custom {
            border: 1.5px solid var(--border2);
            color: var(--muted);
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.25s ease;
            text-decoration: none;
        }

        .btn-outline-primary-custom:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .btn-primary-public {
            background: transparent;
            border: 1.5px solid var(--accent);
            color: var(--accent);
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .btn-primary-public:hover {
            background: var(--accent);
            color: #0d0f14;
            box-shadow: 0 0 20px rgba(201,169,110,0.3);
        }

        /* ══════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════ */
        @media (max-width: 992px) {
            .modern-sidebar {
                transform: translateX(-100%);
            }

            .modern-sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 20px;
            }

            .mobile-menu-toggle {
                display: flex;
            }

            .sidebar-overlay {
                display: block;
            }
        }

        @media (max-width: 576px) {
            .main-content { padding: 16px; }
        }
    </style>

    @yield('styles')
</head>
<body>
    @auth
    <div class="dashboard-wrapper">

        {{-- ══ SIDEBAR ══ --}}
        <nav class="modern-sidebar" id="sidebar">

            {{-- Logo --}}
            <div class="sidebar-header">
                <a href="/" class="sidebar-logo">
                    <div class="logo-mark">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </div>
                    <div class="logo-text">
                        <strong>IMMO AGENCE</strong>
                        <span>Immobilier Premium</span>
                    </div>
                </a>

                {{-- User --}}
                <div class="sidebar-user">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <h4>{{ Auth::user()->name }}</h4>
                        <p>{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                </div>
            </div>

            {{-- Nav --}}
            <div class="sidebar-nav">

                <div class="nav-section">
                    <div class="nav-section-title">Menu</div>
                    <ul class="nav-list">

                        <li class="nav-list-item">
                            <a href="{{ route('dashboard') }}" class="nav-list-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="bi bi-speedometer2"></i>
                                <span>Tableau de bord</span>
                            </a>
                        </li>

                        <li class="nav-list-item">
                            <a href="{{ route('properties.index') }}" class="nav-list-link {{ request()->routeIs('properties.index') ? 'active' : '' }}">
                                <i class="bi bi-list-ul"></i>
                                <span>Liste des propriétés</span>
                            </a>
                        </li>

                        @if(in_array(Auth::user()->role, ['owner', 'admin']))
                        <li class="nav-list-item">
                            <a href="{{ route('properties.create') }}" class="nav-list-link {{ request()->routeIs('properties.create') ? 'active' : '' }}">
                                <i class="bi bi-plus-circle"></i>
                                <span>Ajouter une propriété</span>
                            </a>
                        </li>
                        <li class="nav-list-item">
                            <a href="{{ route('mes-proprietes.index') }}" class="nav-list-link {{ request()->routeIs('mes-proprietes.index') ? 'active' : '' }}">
                                <i class="bi bi-house-check"></i>
                                <span>Mes propriétés</span>
                            </a>
                        </li>
                        @endif

                        <li class="nav-list-item">
                            <a href="{{ route('appointments.index') }}" class="nav-list-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}">
                                <i class="bi bi-calendar-check"></i>
                                <span>Demandes de visite</span>
                            </a>
                        </li>

                    </ul>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Compte</div>
                    <ul class="nav-list">

                        <li class="nav-list-item">
                            <a href="{{ route('settings.index') }}" class="nav-list-link {{ request()->routeIs('settings.index') ? 'active' : '' }}">
                                <i class="bi bi-gear"></i>
                                <span>Paramètres</span>
                            </a>
                        </li>

                        <li class="nav-list-item">
                            <a href="{{ route('logout') }}" class="nav-list-link"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               style="color: var(--muted);">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Déconnexion</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                                @csrf
                            </form>
                        </li>

                    </ul>
                </div>

            </div>

            {{-- Footer sidebar --}}
            <div class="sidebar-footer">
                <div class="sidebar-footer-info">
                    <div class="sidebar-footer-dot"></div>
                    <span>Système actif</span>
                </div>
            </div>

        </nav>

        {{-- ══ MAIN ══ --}}
        <main class="main-content">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')

        </main>

        {{-- Mobile toggle --}}
        <button class="mobile-menu-toggle" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>

        {{-- Overlay --}}
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    </div>

    @else

    {{-- ══ PUBLIC LAYOUT ══ --}}
    <nav class="navbar navbar-expand-lg public-navbar">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-house-heart-fill"></i>
                IMMO AGENCE
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('login') }}"    class="btn-outline-primary-custom">Connexion</a>
                <a href="{{ route('register') }}" class="btn-primary-public">Inscription</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        @yield('content')
    </div>

    @endauth

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        document.querySelectorAll('.nav-list-link').forEach(link => {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 992) {
                    setTimeout(() => toggleSidebar(), 200);
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                document.querySelectorAll('.alert').forEach(function (alert) {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>

    @yield('scripts')
</body>
</html>