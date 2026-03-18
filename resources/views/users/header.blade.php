<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Immo Agency')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/js/app.js'])

    <style>
        :root {
            --bg: #0d0f14;
            --surface: #13161d;
            --surface2: #1a1e28;
            --border: #252a38;
            --accent: #c9a96e;
            --accent2: #e8c97a;
            --text: #e8e6e1;
            --muted: #6b7080;
            --success: #4caf7d;
            --danger: #e05c5c;
            --primary: var(--accent);
            --primary-dark: #b8944a;
            --primary-light: var(--accent2);
            --secondary: var(--muted);
            --dark: var(--bg);
            --light: var(--surface2);
            --border-color: var(--border);
            --shadow: rgba(0, 0, 0, 0.5);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.4);
            --shadow-lg: rgba(0, 0, 0, 0.6);
            --text-primary: var(--text);
            --text-secondary: var(--muted);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            color: var(--text);
        }

        /* ===== HEADER ===== */
        .main-header {
            background: rgba(19, 22, 29, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
            animation: slideDown 0.5s ease-out;
        }

        .header-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }

        .logo-section { display: flex; align-items: center; gap: 1rem; }

        .logo {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            color: var(--bg); font-size: 1.5rem; font-weight: 800;
            box-shadow: 0 8px 20px rgba(201, 169, 110, 0.2);
            transition: transform 0.3s ease;
            text-decoration: none;
        }

        .logo:hover { transform: rotate(-5deg) scale(1.05); box-shadow: 0 8px 25px rgba(201, 169, 110, 0.4); }

        .brand-text {
            font-size: 1.5rem; font-weight: 800;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .search-container { flex: 1; max-width: 500px; position: relative; }

        .search-wrapper-header { position: relative; display: flex; align-items: center; }

        .search-input-header {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid var(--border);
            border-radius: 14px;
            background: var(--surface);
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            color: var(--text);
        }

        .search-input-header:focus {
            outline: none;
            border-color: var(--accent);
            background: var(--surface2);
            box-shadow: 0 8px 30px rgba(201, 169, 110, 0.15);
        }

        .search-input-header::placeholder { color: var(--muted); }

        .search-icon-header {
            position: absolute; left: 1rem;
            color: var(--muted); font-size: 1.1rem;
            pointer-events: none;
        }

        .nav-actions { display: flex; align-items: center; gap: 0.5rem; }

        .nav-item {
            position: relative;
            display: flex; flex-direction: column; align-items: center;
            padding: 0.625rem 1rem;
            text-decoration: none;
            color: var(--muted);
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .nav-item:hover { background: var(--surface); color: var(--accent); transform: translateY(-2px); }
        .nav-item.active { background: linear-gradient(135deg, var(--accent), var(--accent2)); color: var(--bg); }

        .nav-icon {
            width: 44px; height: 44px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; position: relative;
        }

        .nav-label { font-size: 0.75rem; font-weight: 600; margin-top: 0.25rem; white-space: nowrap; }

        .nav-badge {
            position: absolute; top: -4px; right: -4px;
            min-width: 20px; height: 20px; padding: 0 6px;
            background: var(--danger); color: var(--bg);
            border-radius: 10px; font-size: 0.7rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid var(--surface);
            animation: pulse-badge 2s ease-in-out infinite;
        }

        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .tooltip-nav {
            position: absolute; bottom: -40px; left: 50%;
            transform: translateX(-50%);
            background: var(--surface2); color: var(--text);
            padding: 0.5rem 0.875rem; border-radius: 8px;
            font-size: 0.8rem; font-weight: 500; white-space: nowrap;
            opacity: 0; visibility: hidden;
            transition: all 0.3s ease; pointer-events: none; z-index: 1001;
            border: 1px solid var(--border);
        }

        .tooltip-nav::before {
            content: '';
            position: absolute; bottom: 100%; left: 50%;
            transform: translateX(-50%);
            border: 6px solid transparent;
            border-bottom-color: var(--surface2);
        }

        .nav-item:hover .tooltip-nav { opacity: 1; visibility: visible; }

        .user-profile {
            position: relative;
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.5rem 1rem 0.5rem 0.5rem;
            background: var(--surface);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .user-profile:hover { background: var(--surface2); border-color: var(--accent); box-shadow: 0 8px 25px rgba(201, 169, 110, 0.2); }

        .user-avatar {
            width: 42px; height: 42px;
            border-radius: 10px;  /* Changé de 50% à 10px comme dans la première page */
            border: 2px solid var(--accent);
            box-shadow: 0 0 14px rgba(197,160,85,0.1);
            overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: var(--bg); font-weight: 700; font-size: 1rem;
        }

        .user-avatar img {
            width: 100%; height: 100%;
            object-fit: cover;
            border-radius: 10px;  /* Ajouté pour correspondre au parent */
            display: block;
        }

        .user-info { display: flex; flex-direction: column; }
        .user-name { font-weight: 700; font-size: 0.9rem; color: var(--text); line-height: 1.2; }
        .user-role { font-size: 0.75rem; color: var(--muted); font-weight: 500; }

        .dropdown-arrow { color: var(--muted); font-size: 0.75rem; transition: transform 0.3s ease; }
        .user-profile:hover .dropdown-arrow { transform: rotate(180deg); color: var(--accent); }

        .dropdown-menu-custom {
            position: absolute; top: calc(100% + 1rem); right: 0;
            background: var(--surface); border-radius: 16px;
            box-shadow: 0 10px 40px var(--shadow-lg);
            min-width: 240px;
            opacity: 0; visibility: hidden; transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--border); overflow: hidden; z-index: 1001;
        }

        .user-profile:hover .dropdown-menu-custom { opacity: 1; visibility: visible; transform: translateY(0); }

        .dropdown-header-custom {
            padding: 1.25rem; border-bottom: 1px solid var(--border);
            background: var(--surface2);
            display: flex; align-items: center; gap: 0.875rem;
        }

        .dropdown-avatar {
            width: 44px; height: 44px;
            border-radius: 10px;  /* Changé de 50% à 10px */
            border: 2px solid var(--accent);
            overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: var(--bg); font-weight: 700; font-size: 1rem; flex-shrink: 0;
        }

        .dropdown-avatar img {
            width: 100%; height: 100%;
            object-fit: cover;
            border-radius: 10px;  /* Ajouté */
            display: block;
        }

        .dropdown-header-text { display: flex; flex-direction: column; }
        .dropdown-name { font-weight: 700; color: var(--text); margin-bottom: 0.2rem; font-size: 0.9rem; }
        .dropdown-email { font-size: 0.78rem; color: var(--muted); }

        .dropdown-item-custom {
            display: flex; align-items: center; gap: 0.875rem;
            padding: 0.875rem 1.25rem;
            color: var(--text); text-decoration: none;
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--border);
            cursor: pointer;
        }

        .dropdown-item-custom:last-child { border-bottom: none; }
        .dropdown-item-custom:hover { background: var(--surface2); color: var(--accent); padding-left: 1.5rem; }
        .dropdown-item-custom i { width: 20px; font-size: 1.1rem; color: var(--muted); }
        .dropdown-item-custom:hover i { color: var(--accent); }
        .dropdown-item-custom.danger:hover { background: rgba(224, 92, 92, 0.1); color: var(--danger); }
        .dropdown-item-custom.danger:hover i { color: var(--danger); }

        .modal-logout {
            display: none; position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 2000;
            align-items: center; justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .modal-logout.active { display: flex; }

        .modal-logout-content {
            background: var(--surface); border-radius: 24px;
            padding: 2rem; max-width: 400px; width: 90%;
            border: 1px solid var(--border);
            box-shadow: 0 20px 60px var(--shadow-lg);
            animation: slideUp 0.3s ease;
        }

        .modal-logout-header { text-align: center; margin-bottom: 1.5rem; }

        .modal-logout-icon {
            width: 70px; height: 70px;
            background: rgba(224, 92, 92, 0.15);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
            color: var(--danger); font-size: 2rem;
        }

        .modal-logout-title { font-size: 1.5rem; font-weight: 700; color: var(--text); margin-bottom: 0.5rem; }
        .modal-logout-text { color: var(--muted); font-size: 0.95rem; line-height: 1.5; }
        .modal-logout-actions { display: flex; gap: 1rem; margin-top: 2rem; }

        .modal-logout-btn {
            flex: 1; padding: 0.875rem;
            border: none; border-radius: 12px;
            font-weight: 600; font-size: 0.95rem;
            cursor: pointer; transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .modal-logout-btn.cancel { background: var(--surface2); color: var(--text); border: 1px solid var(--border); }
        .modal-logout-btn.cancel:hover { background: var(--border); transform: translateY(-2px); }
        .modal-logout-btn.confirm { background: var(--danger); color: white; }
        .modal-logout-btn.confirm:hover { background: #c43b3b; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(224, 92, 92, 0.3); }

        .mobile-menu-btn {
            display: none; width: 42px; height: 42px;
            border: 1px solid var(--border); background: var(--surface);
            border-radius: 10px; align-items: center; justify-content: center;
            cursor: pointer; color: var(--text); font-size: 1.3rem;
            transition: all 0.3s ease;
        }

        .mobile-menu-btn:hover { background: var(--accent); color: var(--bg); border-color: var(--accent); }

        .scroll-top {
            position: fixed; bottom: 2rem; right: 2rem;
            width: 50px; height: 50px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border: none; border-radius: 50%;
            color: var(--bg); font-size: 1.3rem; cursor: pointer;
            opacity: 0; visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(201, 169, 110, 0.3);
            z-index: 999;
        }

        .scroll-top.visible { opacity: 1; visibility: visible; }
        .scroll-top:hover { transform: translateY(-5px); box-shadow: 0 12px 35px rgba(201, 169, 110, 0.4); }

        .main-content {
            margin-top: 88px;
            padding: 2rem;
            min-height: calc(100vh - 88px);
            background: var(--bg);
        }

        /* ===== NOTIFICATION DROPDOWN ===== */
        .notification-dropdown {
            position: absolute;
            top: calc(100% + 0.5rem); right: 0;
            width: 360px;
            background: var(--surface);
            border-radius: 16px;
            box-shadow: 0 10px 40px var(--shadow-lg);
            border: 1px solid var(--border);
            overflow: hidden;
            opacity: 0; visibility: hidden; transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1001;
        }

        .notification-dropdown.active { opacity: 1; visibility: visible; transform: translateY(0); }

        .notification-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            background: var(--surface2);
            display: flex; align-items: center; justify-content: space-between;
        }

        .notification-header h3 { font-size: 0.95rem; font-weight: 600; color: var(--text); margin: 0; }
        .notification-header a { color: var(--accent); text-decoration: none; font-size: 0.8rem; font-weight: 500; }
        .notification-header a:hover { text-decoration: underline; }

        .notification-list { max-height: 400px; overflow-y: auto; }

        .notification-item {
            display: flex; align-items: center;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .notification-item:hover { background: var(--surface2); }

        .notification-item.unread {
            background: rgba(201, 169, 110, 0.05);
            border-left: 3px solid var(--accent);
        }

        @keyframes slideInNotif {
            from { opacity: 0; transform: translateX(20px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .notification-icon-small {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: rgba(201, 169, 110, 0.1);
            display: flex; align-items: center; justify-content: center;
            margin-right: 0.875rem;
            color: var(--accent); font-size: 1rem; flex-shrink: 0;
        }

        .notification-content-small { flex: 1; min-width: 0; }

        .notification-message-small {
            font-size: 0.85rem; color: var(--text);
            margin-bottom: 0.2rem; font-weight: 500;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .notification-time-small {
            font-size: 0.7rem; color: var(--muted);
            display: flex; align-items: center; gap: 0.25rem;
        }

        .notification-empty { padding: 2rem; text-align: center; color: var(--muted); }
        .notification-empty i { font-size: 2.5rem; margin-bottom: 0.5rem; opacity: 0.5; display: block; }
        .notification-empty p { font-size: 0.9rem; margin: 0; }

        .notification-footer {
            padding: 0.875rem 1.25rem;
            border-top: 1px solid var(--border);
            background: var(--surface2); text-align: center;
        }

        .notification-footer a {
            color: var(--accent); text-decoration: none;
            font-size: 0.85rem; font-weight: 500;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        }

        .notification-footer a:hover { color: var(--accent2); }

        @media (max-width: 992px) {
            .search-container { max-width: 300px; }
            .nav-label { display: none; }
            .brand-text { display: none; }
            .notification-dropdown { width: 320px; }
        }

        @media (max-width: 768px) {
            .header-wrapper { padding: 0.875rem 1rem; gap: 1rem; }
            .search-container { display: none; }
            .nav-actions { gap: 0.25rem; }
            .nav-item { padding: 0.5rem; }
            .nav-icon { width: 40px; height: 40px; font-size: 1.1rem; }
            .user-info { display: none; }
            .dropdown-arrow { display: none; }
            .main-content { padding: 1rem; }
            .notification-dropdown { position: fixed; top: 80px; left: 1rem; right: 1rem; width: auto; }
        }

        @media (max-width: 576px) {
            .mobile-menu-btn { display: flex; }

            .nav-actions {
                position: fixed; top: 80px; left: 0; right: 0;
                background: var(--surface);
                flex-direction: column;
                padding: 1rem; gap: 0.5rem;
                box-shadow: 0 10px 40px var(--shadow-lg);
                transform: translateY(-120%);
                transition: transform 0.3s ease;
                z-index: 999;
                border-bottom: 1px solid var(--border);
            }

            .nav-actions.active { transform: translateY(0); }
            .nav-item { width: 100%; flex-direction: row; justify-content: flex-start; gap: 1rem; padding: 1rem; }
            .nav-label { display: block; }
        }

        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn   { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp  { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    @yield('styles')
</head>
<body>

    <header class="main-header">
        <div class="header-wrapper">

            <div class="logo-section">
                <a href="{{ route('list') }}" class="logo">
                    <i class="bi bi-house-heart"></i>
                </a>
                <span class="brand-text">Immo Agency</span>
            </div>

            <div class="search-container">
                <form action="{{ route('list') }}" method="GET">
                    <div class="search-wrapper-header">
                        <input type="text" name="search" class="search-input-header"
                               placeholder="Rechercher des propriétés, une ville..."
                               value="{{ request('search') }}">
                        <i class="bi bi-search search-icon-header"></i>
                    </div>
                </form>
            </div>

            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                <i class="bi bi-list"></i>
            </button>

            <nav class="nav-actions" id="navActions">

                <a href="{{ route('favorites.index') }}"
                   class="nav-item {{ request()->routeIs('favorites.index') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="bi bi-heart-fill"></i></div>
                    <span class="nav-label">Favoris</span>
                    <span class="tooltip-nav">Mes Favoris</span>
                </a>

                <!-- 🔔 Notifications -->
                <div class="nav-item" id="notificationBell" onclick="toggleNotifications(event)">
                    <div class="nav-icon">
                        <i class="bi bi-bell-fill"></i>
                        <span class="nav-badge" id="notificationCount" style="display:none;">0</span>
                    </div>
                    <span class="nav-label">Notifications</span>
                    <span class="tooltip-nav">Notifications</span>

                    <div class="notification-dropdown" id="notificationDropdown" onclick="event.stopPropagation()">
                        <div class="notification-header">
                            <h3>Notifications</h3>
                            <a href="{{ route('notifications.index') }}">Voir tout</a>
                        </div>
                        <div class="notification-list" id="notificationList">
                            <div class="notification-empty">
                                <i class="bi bi-bell"></i>
                                <p>Chargement des notifications...</p>
                            </div>
                        </div>
                        <div class="notification-footer">
                            <a href="#" onclick="markAllNotificationsRead(event)">
                                <i class="bi bi-check2-all"></i>
                                Marquer tout comme lu
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('list') }}"
                   class="nav-item {{ request()->routeIs('list') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="bi bi-buildings-fill"></i></div>
                    <span class="nav-label">Propriétés</span>
                    <span class="tooltip-nav">Propriétés</span>
                </a>

                <a href="{{ route('appointments.index') }}"
                   class="nav-item {{ request()->routeIs('appointments.index') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="bi bi-calendar-check-fill"></i></div>
                    <span class="nav-label">Rendez-vous</span>
                    <span class="tooltip-nav">Mes Rendez-vous</span>
                </a>
            </nav>

            <div class="user-profile">
                @auth
                <div class="user-avatar">
                    @if(auth()->user()->avatar_path)
                        <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}"
                             alt="{{ auth()->user()->name }}">
                    @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @endif
                </div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->role ?? 'Utilisateur') }}</div>
                </div>
                @else
                <div class="user-avatar"><i class="bi bi-person"></i></div>
                <div class="user-info"><div class="user-name">Invité</div></div>
                @endauth
                <i class="bi bi-chevron-down dropdown-arrow"></i>

                <div class="dropdown-menu-custom">
                    @auth
                    <div class="dropdown-header-custom">
                        <div class="dropdown-avatar">
                            @if(auth()->user()->avatar_path)
                                <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}"
                                     alt="{{ auth()->user()->name }}">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="dropdown-header-text">
                            <div class="dropdown-name">{{ auth()->user()->name }}</div>
                            <div class="dropdown-email">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <a href="" class="dropdown-item-custom">
                        <i class="bi bi-person-circle"></i><span>Mon Profil</span>
                    </a>
                    <a href="{{ route('settings.index') }}" class="dropdown-item-custom">
                        <i class="bi bi-gear-fill"></i><span>Paramètres</span>
                    </a>
                    <div class="dropdown-item-custom danger" onclick="showLogoutModal()">
                        <i class="bi bi-box-arrow-right"></i><span>Déconnexion</span>
                    </div>
                    @else
                    <div class="dropdown-header-custom">
                        <div class="dropdown-header-text">
                            <div class="dropdown-name">Connectez-vous</div>
                        </div>
                    </div>
                    <a href="{{ route('login') }}" class="dropdown-item-custom">
                        <i class="bi bi-box-arrow-in-right"></i><span>Se connecter</span>
                    </a>
                    <a href="{{ route('register') }}" class="dropdown-item-custom">
                        <i class="bi bi-person-plus"></i><span>S'inscrire</span>
                    </a>
                    @endauth
                </div>
            </div>

        </div>
    </header>

    <main class="main-content">
        @yield('content')
    </main>

    <button class="scroll-top" id="scrollTopBtn" onclick="scrollToTop()">
        <i class="bi bi-arrow-up"></i>
    </button>

    <div class="modal-logout" id="logoutModal">
        <div class="modal-logout-content">
            <div class="modal-logout-header">
                <div class="modal-logout-icon">
                    <i class="bi bi-box-arrow-right"></i>
                </div>
                <h3 class="modal-logout-title">Déconnexion</h3>
                <p class="modal-logout-text">Êtes-vous sûr de vouloir vous déconnecter ?</p>
            </div>
            <div class="modal-logout-actions">
                <button class="modal-logout-btn cancel"  onclick="hideLogoutModal()">Annuler</button>
                <button class="modal-logout-btn confirm" onclick="confirmLogout()">Se déconnecter</button>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ── Scroll to Top ──────────────────────────────────────────────────────
        window.addEventListener('scroll', function () {
            document.getElementById('scrollTopBtn').classList.toggle('visible', window.scrollY > 300);
        });
        function scrollToTop() { window.scrollTo({ top: 0, behavior: 'smooth' }); }

        // ── Mobile Menu ────────────────────────────────────────────────────────
        function toggleMobileMenu() {
            document.getElementById('navActions').classList.toggle('active');
        }
        document.addEventListener('click', function (e) {
            if (!e.target.closest('#navActions') && !e.target.closest('.mobile-menu-btn')) {
                document.getElementById('navActions').classList.remove('active');
            }
        });

        // ── Modal Déconnexion ──────────────────────────────────────────────────
        function showLogoutModal()  { document.getElementById('logoutModal').classList.add('active'); }
        function hideLogoutModal()  { document.getElementById('logoutModal').classList.remove('active'); }
        function confirmLogout()    { document.getElementById('logout-form').submit(); }

        document.addEventListener('click', function (e) {
            if (e.target === document.getElementById('logoutModal')) hideLogoutModal();
        });
        document.addEventListener('click', function(e) {
            const modalContent = document.querySelector('.modal-logout-content');
            if (modalContent && modalContent.contains(e.target)) {
                e.stopPropagation();
            }
        });
        document.addEventListener('keydown', e => { if (e.key === 'Escape') hideLogoutModal(); });

        // ── Helpers notifications ──────────────────────────────────────────────
        function updateBadge(count) {
            const badge = document.getElementById('notificationCount');
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }

        function getNotificationIcon(type) {
            return {
                inscription:          'bi-person-plus-fill',
                new_produits:         'bi-plus-circle-fill',
                new_rendez_vous:      'bi-calendar-plus-fill',
                rendez_vous_confirme: 'bi-check-circle-fill',
                rendez_vous_rejete:   'bi-x-circle-fill',
            }[type] || 'bi-bell-fill';
        }

        function formatTime(timestamp) {
            if (!timestamp) return '—';
            const diff = (Date.now() - new Date(timestamp)) / 1000;
            if (diff < 60)    return "À l'instant";
            if (diff < 3600)  return `Il y a ${Math.floor(diff / 60)} min`;
            if (diff < 86400) return `Il y a ${Math.floor(diff / 3600)} h`;
            return new Date(timestamp).toLocaleDateString('fr-FR');
        }

        // ── Ouvrir / fermer le dropdown ────────────────────────────────────────
        function toggleNotifications(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.classList.toggle('active');
            if (dropdown.classList.contains('active')) loadNotifications();
        }

        document.addEventListener('click', function (e) {
            if (!document.getElementById('notificationBell').contains(e.target)) {
                document.getElementById('notificationDropdown').classList.remove('active');
            }
        });

        // ── Chargement AJAX des notifications ─────────────────────────────────
        function loadNotifications() {
            fetch('{{ route("notifications.unread") }}', {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                updateBadge(data.count);
                const list = document.getElementById('notificationList');
                if (data.html) {
                    list.innerHTML = data.html;
                } else if (data.notifications && data.notifications.length > 0) {
                    list.innerHTML = data.notifications.map(n => `
                        <div class="notification-item unread"
                             onclick="window.location.href='{{ route('notifications.index') }}'">
                            <div class="notification-icon-small">
                                <i class="bi ${getNotificationIcon(n.type)}"></i>
                            </div>
                            <div class="notification-content-small">
                                <div class="notification-message-small">${n.message}</div>
                                <div class="notification-time-small">
                                    <i class="bi bi-clock"></i> ${formatTime(n.time)}
                                </div>
                            </div>
                        </div>`).join('');
                } else {
                    list.innerHTML = `<div class="notification-empty">
                        <i class="bi bi-bell"></i>
                        <p>Aucune nouvelle notification</p>
                    </div>`;
                }
            })
            .catch(() => {
                document.getElementById('notificationList').innerHTML = `
                    <div class="notification-empty">
                        <i class="bi bi-exclamation-triangle"></i>
                        <p>Erreur de chargement</p>
                    </div>`;
            });
        }

        // ── Marquer tout comme lu ──────────────────────────────────────────────
        function markAllNotificationsRead(event) {
            event.preventDefault();
            event.stopPropagation();
            fetch('{{ route("notifications.mark-all-read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept':       'application/json',
                    'Content-Type': 'application/json',
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    updateBadge(0);
                    loadNotifications();
                }
            });
        }
    </script>

    @yield('scripts')

</body>
</html>