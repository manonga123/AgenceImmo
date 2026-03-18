<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'IMMO AGENCE')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg:           #080a0f;
            --sidebar-bg:   #060810;
            --surface:      #0d1018;
            --surface2:     #111420;
            --surface3:     #161924;
            --border:       rgba(255,255,255,0.055);
            --border-glow:  rgba(197,160,85,0.22);
            --gold:         #c5a055;
            --gold-light:   #e2c07a;
            --gold-dim:     rgba(197,160,85,0.12);
            --text:         #f0ede8;
            --text-soft:    #a8a49e;
            --text-muted:   #50535c;
            --success:      #3db97a;
            --danger:       #d95f5f;
            --radius-sm:    8px;
            --radius:       14px;
            --sidebar-w:    278px;
            --tr:           0.26s cubic-bezier(0.4,0,0.2,1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ── Noise grain ── */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
            background-size: 180px;
            pointer-events: none;
            z-index: 0;
        }

        .dashboard-wrapper { display: flex; min-height: 100vh; position: relative; z-index: 1; }

        /* ════════════════════════════
           SIDEBAR
        ════════════════════════════ */
        .modern-sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            position: fixed; left: 0; top: 0;
            height: 100vh;
            overflow-y: auto; overflow-x: hidden;
            transition: transform var(--tr);
            z-index: 1000;
            display: flex; flex-direction: column;
            border-right: 1px solid var(--border);
        }

        /* Ligne dorée droite */
        .modern-sidebar::after {
            content: '';
            position: absolute; right: 0; top: 0; bottom: 0; width: 1px;
            background: linear-gradient(180deg, transparent 0%, var(--gold) 35%, var(--gold) 65%, transparent 100%);
            opacity: 0.12; pointer-events: none;
        }

        .modern-sidebar::-webkit-scrollbar { width: 3px; }
        .modern-sidebar::-webkit-scrollbar-track { background: transparent; }
        .modern-sidebar::-webkit-scrollbar-thumb { background: rgba(197,160,85,0.18); border-radius: 4px; }

        /* ── Logo ── */
        .sidebar-header {
            padding: 30px 26px 22px;
            position: relative; flex-shrink: 0;
        }

        .sidebar-logo {
            display: flex; align-items: center; gap: 13px; text-decoration: none;
        }

        .logo-inner {
            width: 42px; height: 42px; border-radius: 12px;
            background: linear-gradient(145deg, rgba(197,160,85,0.18), rgba(197,160,85,0.04));
            border: 1px solid rgba(197,160,85,0.28);
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); font-size: 18px; flex-shrink: 0;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.06), 0 0 20px rgba(197,160,85,0.08);
        }

        .logo-text { display: flex; flex-direction: column; line-height: 1; }
        .logo-text strong {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.12rem; font-weight: 700;
            color: var(--text); letter-spacing: 0.07em; text-transform: uppercase;
        }
        .logo-text span {
            font-size: 0.59rem; color: var(--gold);
            letter-spacing: 0.22em; text-transform: uppercase;
            margin-top: 4px; font-weight: 500; opacity: 0.8;
        }

        .logo-sep {
            margin: 20px 0 0;
            height: 1px;
            background: linear-gradient(90deg, rgba(197,160,85,0.35) 0%, transparent 70%);
        }

        /* ── User card ── */
        .sidebar-user {
            margin: 20px 18px 0;
            padding: 14px 16px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            display: flex; align-items: center; gap: 12px;
            position: relative; overflow: hidden;
            transition: border-color var(--tr);
        }
        .sidebar-user::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, var(--gold), transparent 60%);
            opacity: 0.28;
        }
        .sidebar-user:hover { border-color: var(--border-glow); }

        /* ── AVATAR PHOTO (cercle dans la sidebar) ── */
        .user-avatar {
            width: 40px; height: 40px; border-radius: 10px;
            background: linear-gradient(135deg, rgba(197,160,85,0.22), rgba(197,160,85,0.06));
            border: 1px solid rgba(197,160,85,0.3);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.05rem; font-weight: 700;
            color: var(--gold-light); flex-shrink: 0;
            box-shadow: 0 0 14px rgba(197,160,85,0.1);
            overflow: hidden; /* ← important pour que l'img soit bien clippée */
        }
        .user-avatar img {
            width: 100%; height: 100%;
            object-fit: cover; border-radius: 10px;
            display: block;
        }

        .user-info h4 {
            font-size: 0.855rem; font-weight: 500; color: var(--text);
            margin: 0 0 4px; white-space: nowrap; overflow: hidden;
            text-overflow: ellipsis; max-width: 152px; letter-spacing: 0.01em;
        }
        .user-badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 0.6rem; color: var(--gold);
            letter-spacing: 0.13em; text-transform: uppercase; font-weight: 600;
        }
        .user-badge::before {
            content: '';
            display: inline-block; width: 5px; height: 5px; border-radius: 50%;
            background: var(--gold); box-shadow: 0 0 6px var(--gold);
        }

        /* ── Nav ── */
        .sidebar-nav { padding: 22px 14px; flex: 1; }
        .nav-section { margin-bottom: 30px; }

        .nav-section-title {
            font-size: 0.57rem; font-weight: 700; letter-spacing: 0.18em;
            text-transform: uppercase; color: var(--text-muted);
            padding: 0 12px; margin-bottom: 8px;
            display: flex; align-items: center; gap: 10px;
        }
        .nav-section-title::after {
            content: ''; flex: 1; height: 1px; background: var(--border);
        }

        .nav-list { list-style: none; padding: 0; margin: 0; }
        .nav-list-item { margin-bottom: 2px; }

        .nav-list-link {
            display: flex; align-items: center; gap: 11px;
            padding: 10px 13px; border-radius: var(--radius-sm);
            color: var(--text-soft); text-decoration: none;
            font-size: 0.85rem; font-weight: 400;
            transition: all 0.2s ease; position: relative;
            letter-spacing: 0.01em;
            cursor: pointer;
        }

        .nav-icon {
            width: 31px; height: 31px; border-radius: 8px;
            background: transparent; border: 1px solid transparent;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .nav-list-link:hover { color: var(--text); background: rgba(255,255,255,0.04); }
        .nav-list-link:hover .nav-icon {
            background: rgba(197,160,85,0.09);
            border-color: rgba(197,160,85,0.18);
            color: var(--gold);
        }

        .nav-list-link.active {
            color: var(--gold-light) !important;
            background: linear-gradient(90deg, rgba(197,160,85,0.11) 0%, rgba(197,160,85,0.02) 100%);
            font-weight: 500;
        }
        .nav-list-link.active .nav-icon {
            background: rgba(197,160,85,0.15);
            border-color: rgba(197,160,85,0.32);
            color: var(--gold);
            box-shadow: 0 0 12px rgba(197,160,85,0.1);
        }
        .nav-list-link.active::before {
            content: '';
            position: absolute; left: 0; top: 22%; bottom: 22%;
            width: 2px;
            background: linear-gradient(180deg, transparent, var(--gold), transparent);
            border-radius: 0 2px 2px 0;
        }

        /* ── Sidebar footer ── */
        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border); flex-shrink: 0;
        }
        .footer-row { display: flex; align-items: center; justify-content: space-between; }
        .status-wrap { display: flex; align-items: center; gap: 8px; }
        .status-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--success); box-shadow: 0 0 8px var(--success);
            position: relative;
        }
        .status-dot::before {
            content: '';
            position: absolute; inset: -3px; border-radius: 50%;
            background: rgba(61,185,122,0.18);
            animation: pulseGreen 2.2s ease-in-out infinite;
        }
        @keyframes pulseGreen {
            0%, 100% { transform: scale(1); opacity: 0.7; }
            50%       { transform: scale(1.8); opacity: 0; }
        }
        .status-label { font-size: 0.71rem; color: var(--text-muted); }
        .footer-version { font-size: 0.61rem; color: var(--text-muted); letter-spacing: 0.08em; }

        /* Styles pour la modal de déconnexion */
        .modal-logout {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .modal-logout.active {
            display: flex;
        }

        .modal-logout-content {
            background: var(--surface);
            border-radius: 24px;
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            border: 1px solid rgba(197,160,85,0.22);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(197,160,85,0.15);
            animation: slideUp 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .modal-logout-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .modal-logout-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .modal-logout-icon {
            width: 70px;
            height: 70px;
            background: rgba(217,95,95,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: var(--danger);
            font-size: 2rem;
            border: 1px solid rgba(217,95,95,0.3);
        }

        .modal-logout-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.5rem;
            font-family: 'Cormorant Garamond', serif;
        }

        .modal-logout-text {
            color: var(--text-soft);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .modal-logout-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .modal-logout-btn {
            flex: 1;
            padding: 0.875rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .modal-logout-btn.cancel {
            background: var(--surface2);
            color: var(--text);
            border: 1px solid var(--border);
        }

        .modal-logout-btn.cancel:hover {
            background: var(--surface3);
            transform: translateY(-2px);
            border-color: rgba(197,160,85,0.3);
        }

        .modal-logout-btn.confirm {
            background: var(--danger);
            color: white;
            border: 1px solid rgba(217,95,95,0.5);
        }

        .modal-logout-btn.confirm:hover {
            background: #c43b3b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(217,95,95,0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ════════════════════════════
           TOPBAR
        ════════════════════════════ */
        .topbar {
            position: fixed; top: 0;
            left: var(--sidebar-w); right: 0; height: 62px;
            background: rgba(8,10,15,0.88);
            backdrop-filter: blur(22px); -webkit-backdrop-filter: blur(22px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 36px; z-index: 100;
            transition: left var(--tr), box-shadow 0.3s ease;
        }
        .topbar::after {
            content: '';
            position: absolute; bottom: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(197,160,85,0.18), transparent);
        }

        .topbar-left { display: flex; flex-direction: column; gap: 2px; }
        .topbar-greeting {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.05rem; font-weight: 600;
            color: var(--text); letter-spacing: 0.02em;
        }
        .topbar-date { font-size: 0.72rem; color: var(--text-muted); letter-spacing: 0.04em; }

        .topbar-actions { display: flex; align-items: center; gap: 8px; }
        .topbar-btn {
            width: 37px; height: 37px; border-radius: 10px;
            background: var(--surface2); border: 1px solid var(--border);
            color: var(--text-soft); display: flex; align-items: center;
            justify-content: center; font-size: 16px; cursor: pointer;
            transition: all 0.2s ease; text-decoration: none;
        }
        .topbar-btn:hover {
            border-color: var(--border-glow);
            color: var(--gold); background: var(--gold-dim);
        }
        .topbar-sep { width: 1px; height: 22px; background: var(--border); margin: 0 4px; }

        /* ── AVATAR TOPBAR (petit cercle en haut à droite) ── */
        .topbar-avatar {
            width: 37px; height: 37px; border-radius: 10px;
            background: linear-gradient(135deg, rgba(197,160,85,0.2), rgba(197,160,85,0.05));
            border: 1px solid rgba(197,160,85,0.3);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Cormorant Garamond', serif; font-weight: 700;
            font-size: 0.95rem; color: var(--gold-light);
            cursor: pointer; text-decoration: none; transition: all 0.2s ease;
            overflow: hidden; /* ← important pour clipper l'image */
        }
        .topbar-avatar img {
            width: 100%; height: 100%;
            object-fit: cover; border-radius: 10px;
            display: block;
        }
        .topbar-avatar:hover { box-shadow: 0 0 18px rgba(197,160,85,0.2); }

        /* ════════════════════════════
           MAIN CONTENT
        ════════════════════════════ */
        .main-content {
            margin-left: var(--sidebar-w);
            padding-top: 62px;
            flex: 1; min-height: 100vh;
            background: var(--bg); position: relative;
        }
        .main-content::before {
            content: '';
            position: fixed;
            top: 0; left: var(--sidebar-w); right: 0; bottom: 0;
            background:
                radial-gradient(ellipse 55% 35% at 12% 8%, rgba(197,160,85,0.045) 0%, transparent 55%),
                radial-gradient(ellipse 45% 45% at 88% 92%, rgba(85,133,224,0.03) 0%, transparent 55%);
            pointer-events: none; z-index: 0;
        }
        .content-inner { padding: 36px 40px; position: relative; z-index: 1; }

        /* ════════════════════════════
           ALERTS
        ════════════════════════════ */
        .alert {
            border-radius: var(--radius-sm); border: none;
            padding: 13px 18px; margin-bottom: 24px;
            display: flex; align-items: center; gap: 11px;
            font-size: 0.855rem;
            animation: alertIn 0.4s cubic-bezier(.22,1,.36,1) both;
            backdrop-filter: blur(10px);
        }
        @keyframes alertIn {
            from { opacity: 0; transform: translateY(-10px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .alert-success {
            background: rgba(61,185,122,0.08);
            border: 1px solid rgba(61,185,122,0.2);
            color: #6ee8aa;
        }
        .alert-danger {
            background: rgba(217,95,95,0.08);
            border: 1px solid rgba(217,95,95,0.22);
            color: #f09090;
        }
        .alert i { font-size: 17px; flex-shrink: 0; }
        .btn-close { filter: invert(0.4) brightness(1.5); }

        /* ════════════════════════════
           PUBLIC LAYOUT
        ════════════════════════════ */
        .public-navbar {
            background: rgba(6,8,16,0.96);
            border-bottom: 1px solid var(--border);
            padding: 16px 0;
            backdrop-filter: blur(20px);
            position: sticky; top: 0; z-index: 1000;
        }
        .public-navbar::after {
            content: '';
            position: absolute; bottom: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(197,160,85,0.28), transparent);
        }
        .public-navbar .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700; color: var(--text); font-size: 1.12rem;
            display: flex; align-items: center; gap: 10px;
            letter-spacing: 0.06em; text-transform: uppercase;
        }
        .public-navbar .navbar-brand i { color: var(--gold); font-size: 21px; }

        .btn-outline-nav {
            border: 1px solid var(--border); color: var(--text-soft);
            padding: 9px 22px; border-radius: 50px;
            font-weight: 500; font-size: 0.84rem;
            transition: all 0.25s ease; text-decoration: none; letter-spacing: 0.02em;
        }
        .btn-outline-nav:hover { border-color: rgba(197,160,85,0.4); color: var(--gold); }

        .btn-gold {
            background: transparent; border: 1px solid var(--gold);
            color: var(--gold); padding: 9px 24px; border-radius: 50px;
            font-weight: 600; font-size: 0.84rem;
            text-decoration: none; transition: all 0.25s ease;
            letter-spacing: 0.04em; position: relative; overflow: hidden; display: inline-block;
        }
        .btn-gold::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            opacity: 0; transition: opacity 0.25s ease;
        }
        .btn-gold span { position: relative; z-index: 1; }
        .btn-gold:hover::before { opacity: 1; }
        .btn-gold:hover { color: #080a0f; box-shadow: 0 0 22px rgba(197,160,85,0.32); }

        /* ════════════════════════════
           MOBILE TOGGLE
        ════════════════════════════ */
        .mobile-menu-toggle {
            display: none;
            position: fixed; bottom: 26px; right: 26px;
            width: 52px; height: 52px; border-radius: 14px;
            background: var(--surface3);
            border: 1px solid var(--border-glow);
            color: var(--gold); font-size: 21px;
            box-shadow: 0 8px 28px rgba(0,0,0,0.55), 0 0 0 1px rgba(197,160,85,0.08);
            cursor: pointer; z-index: 999;
            transition: all 0.25s ease;
            align-items: center; justify-content: center;
        }
        .mobile-menu-toggle:hover {
            background: rgba(197,160,85,0.1);
            box-shadow: 0 8px 28px rgba(0,0,0,0.55), 0 0 20px rgba(197,160,85,0.14);
            transform: scale(1.05);
        }

        /* ════════════════════════════
           OVERLAY
        ════════════════════════════ */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.72); backdrop-filter: blur(4px);
            z-index: 999; opacity: 0; transition: opacity 0.3s ease;
        }
        .sidebar-overlay.active { opacity: 1; }

        /* ════════════════════════════
           RESPONSIVE
        ════════════════════════════ */
        @media (max-width: 1100px) {
            .modern-sidebar { transform: translateX(-100%); }
            .modern-sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .main-content::before { left: 0; }
            .topbar { left: 0; }
            .mobile-menu-toggle { display: flex; }
            .sidebar-overlay { display: block; }
            .content-inner { padding: 22px; }
        }
        @media (max-width: 576px) {
            .content-inner { padding: 14px; }
            .topbar { padding: 0 18px; }
            .topbar-date { display: none; }
        }
    </style>

    @yield('styles')
</head>
<body>
    @auth
    <div class="dashboard-wrapper">

        {{-- ═══════════ SIDEBAR ═══════════ --}}
        <nav class="modern-sidebar" id="sidebar">

            <div class="sidebar-header">
                <a href="/" class="sidebar-logo">
                    <div class="logo-inner">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.6"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </div>
                    <div class="logo-text">
                        <strong>IMMO AGENCE</strong>
                        <span>Immobilier Premium</span>
                    </div>
                </a>
                <div class="logo-sep"></div>

                {{-- ── User card avec PHOTO ── --}}
                <div class="sidebar-user">
                    <div class="user-avatar">
                        @if(Auth::user()->avatar_path)
                            {{-- Photo réelle de l'utilisateur --}}
                            <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}"
                                 alt="{{ Auth::user()->name }}">
                        @else
                            {{-- Fallback : initiale si pas de photo --}}
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="user-info">
                        <h4>{{ Auth::user()->name }}</h4>
                        <div class="user-badge">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                </div>
            </div>

            <div class="sidebar-nav">

                <div class="nav-section">
                    
                    <ul class="nav-list">

                        <li class="nav-list-item">
                            <a href="{{ route('dashboard') }}"
                               class="nav-list-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
                                <span>Tableau de bord</span>
                            </a>
                        </li>

                        <li class="nav-list-item">
                            <a href="{{ route('properties.index') }}"
                               class="nav-list-link {{ request()->routeIs('properties.index') ? 'active' : '' }}">
                                <span class="nav-icon"><i class="bi bi-building"></i></span>
                                <span>Liste des propriétés</span>
                            </a>
                        </li>

                        @if(in_array(Auth::user()->role, ['owner', 'admin']))
                        <li class="nav-list-item">
                            <a href="{{ route('properties.create') }}"
                               class="nav-list-link {{ request()->routeIs('properties.create') ? 'active' : '' }}">
                                <span class="nav-icon"><i class="bi bi-plus-circle"></i></span>
                                <span>Ajouter une propriété</span>
                            </a>
                        </li>
                        <li class="nav-list-item">
                            <a href="{{ route('mes-proprietes.index') }}"
                               class="nav-list-link {{ request()->routeIs('mes-proprietes.index') ? 'active' : '' }}">
                                <span class="nav-icon"><i class="bi bi-house-check"></i></span>
                                <span>Mes propriétés</span>
                            </a>
                        </li>
                        @endif

                        <li class="nav-list-item">
                            <a href="{{ route('appointments.index') }}"
                               class="nav-list-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}">
                                <span class="nav-icon"><i class="bi bi-calendar-event"></i></span>
                                <span>Demandes de visite</span>
                            </a>
                        </li>

                    </ul>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Compte</div>
                    <ul class="nav-list">

                        <li class="nav-list-item">
                            <a href="{{ route('settings.index') }}"
                               class="nav-list-link {{ request()->routeIs('settings.index') ? 'active' : '' }}">
                                <span class="nav-icon"><i class="bi bi-sliders"></i></span>
                                <span>Paramètres</span>
                            </a>
                        </li>

                        <li class="nav-list-item">
                            <div class="nav-list-link" onclick="showLogoutModal()" style="color: var(--text-muted); cursor: pointer;">
                                <span class="nav-icon"><i class="bi bi-box-arrow-right"></i></span>
                                <span>Déconnexion</span>
                            </div>
                        </li>

                    </ul>
                </div>

            </div>

          

        </nav>

        {{-- ═══════════ TOPBAR ═══════════ --}}
        <header class="topbar" id="topbar">
            <div class="topbar-left">
                
                <div class="topbar-date" id="topbar-date"></div>
            </div>
            <div class="topbar-actions">
                <a href="#" class="topbar-btn" title="Notifications">
                    <i class="bi bi-bell"></i>
                </a>
                <div class="topbar-sep"></div>

                {{-- ── Avatar topbar avec PHOTO ── --}}
                <a href="{{ route('settings.index') }}" class="topbar-avatar" title="Mon profil">
                    @if(Auth::user()->avatar_path)
                        <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}"
                             alt="{{ Auth::user()->name }}">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </a>
            </div>
        </header>

        {{-- ═══════════ MAIN ═══════════ --}}
        <main class="main-content">
            <div class="content-inner">

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>{{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @yield('content')

            </div>
        </main>

        <button class="mobile-menu-toggle" onclick="toggleSidebar()">
            <i class="bi bi-layout-sidebar"></i>
        </button>

        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    </div>

    {{-- MODAL DE CONFIRMATION DE DÉCONNEXION --}}
    <div class="modal-logout" id="logoutModal">
        <div class="modal-logout-content">
            <div class="modal-logout-header">
                <div class="modal-logout-icon">
                    <i class="bi bi-box-arrow-right"></i>
                </div>
                <h3 class="modal-logout-title">Déconnexion</h3>
                <p class="modal-logout-text">Êtes-vous sûr de vouloir vous déconnecter ? Vous devrez vous reconnecter pour accéder à votre compte.</p>
            </div>
            <div class="modal-logout-actions">
                <button class="modal-logout-btn cancel" onclick="hideLogoutModal()">Annuler</button>
                <button class="modal-logout-btn confirm" onclick="confirmLogout()">Se déconnecter</button>
            </div>
        </div>
    </div>

    {{-- Formulaire de déconnexion caché --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    @else

    {{-- ═══════════ PUBLIC ═══════════ --}}
    <nav class="navbar navbar-expand-lg public-navbar">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-house-heart-fill"></i>
                IMMO AGENCE
            </a>
            <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('login') }}" class="btn-outline-nav">Connexion</a>
                <a href="{{ route('register') }}" class="btn-gold"><span>Inscription</span></a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        @yield('content')
    </div>

    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }

        document.querySelectorAll('.nav-list-link').forEach(link => {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 1100) setTimeout(() => toggleSidebar(), 200);
            });
        });

        // Date topbar
        (function () {
            const el = document.getElementById('topbar-date');
            if (!el) return;
            el.textContent = new Date().toLocaleDateString('fr-FR', {
                weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
            });
        })();

        // Shadow topbar au scroll
        window.addEventListener('scroll', function () {
            const tb = document.getElementById('topbar');
            if (tb) tb.style.boxShadow = window.scrollY > 10 ? '0 4px 28px rgba(0,0,0,0.45)' : 'none';
        });

        // Auto-dismiss alerts
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                document.querySelectorAll('.alert').forEach(function (a) {
                    bootstrap.Alert.getOrCreateInstance(a).close();
                });
            }, 5000);
        });

        // ===== FONCTIONS POUR LA MODAL DE DÉCONNEXION =====
        function showLogoutModal() {
            document.getElementById('logoutModal').classList.add('active');
        }

        function hideLogoutModal() {
            document.getElementById('logoutModal').classList.remove('active');
        }

        function confirmLogout() {
            document.getElementById('logout-form').submit();
        }

        // Fermer la modal si on clique en dehors
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('logoutModal');
            if (!modal) return;
            
            if (event.target === modal) {
                hideLogoutModal();
            }
        });

        // Empêcher la fermeture si on clique dans la modal
        document.addEventListener('DOMContentLoaded', function() {
            const modalContent = document.querySelector('.modal-logout-content');
            if (modalContent) {
                modalContent.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            }
        });

        // Fermer avec la touche Echap
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideLogoutModal();
            }
        });
    </script>

    @yield('scripts')
</body>
</html>