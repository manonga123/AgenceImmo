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
            --gold: #c9a96e;
            --gold-light: #e8c97a;
            --gold-dim: rgba(201,169,110,0.08);
            --border-glow: rgba(201,169,110,0.22);
            --text-soft: #a0a3ad;
            --text-muted: #6b7080;
            --radius: 14px;
            --radius-sm: 8px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            color: var(--text);
        }

        /* ═══════════════════════════════
           HEADER
        ═══════════════════════════════ */
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

        /* ── Nav ── */
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
            background: var(--danger); color: #fff;
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

        /* ── User profile ── */
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

        .user-profile:hover {
            background: var(--surface2);
            border-color: var(--accent);
            box-shadow: 0 8px 25px rgba(201, 169, 110, 0.2);
        }

        .user-avatar {
            width: 42px; height: 42px;
            border-radius: 10px;
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
            object-fit: cover; border-radius: 10px; display: block;
        }

        .user-info { display: flex; flex-direction: column; }
        .user-name { font-weight: 700; font-size: 0.9rem; color: var(--text); line-height: 1.2; }
        .user-role { font-size: 0.75rem; color: var(--muted); font-weight: 500; }

        .dropdown-arrow { color: var(--muted); font-size: 0.75rem; transition: transform 0.3s ease; }
        .user-profile:hover .dropdown-arrow { transform: rotate(180deg); color: var(--accent); }

        /* ── Dropdown menu ── */
        .dropdown-menu-custom {
            position: absolute; top: calc(100% + 1rem); right: 0;
            background: var(--surface); border-radius: 16px;
            box-shadow: 0 10px 40px var(--shadow-lg);
            min-width: 240px;
            opacity: 0; visibility: hidden; transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--border); overflow: hidden; z-index: 1001;
        }

        .user-profile:hover .dropdown-menu-custom {
            opacity: 1; visibility: visible; transform: translateY(0);
        }

        .dropdown-header-custom {
            padding: 1.25rem; border-bottom: 1px solid var(--border);
            background: var(--surface2);
            display: flex; align-items: center; gap: 0.875rem;
        }

        .dropdown-avatar {
            width: 44px; height: 44px;
            border-radius: 10px; border: 2px solid var(--accent);
            overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: var(--bg); font-weight: 700; font-size: 1rem; flex-shrink: 0;
        }

        .dropdown-avatar img {
            width: 100%; height: 100%;
            object-fit: cover; border-radius: 10px; display: block;
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
            background: transparent;
            width: 100%;
            border-left: none; border-right: none; border-top: none;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
        }

        .dropdown-item-custom:last-child { border-bottom: none; }

        .dropdown-item-custom:hover {
            background: var(--surface2);
            color: var(--accent);
            padding-left: 1.5rem;
        }

        .dropdown-item-custom i { width: 20px; font-size: 1.1rem; color: var(--muted); }
        .dropdown-item-custom:hover i { color: var(--accent); }

        .dropdown-item-custom.danger:hover {
            background: rgba(224, 92, 92, 0.1);
            color: var(--danger);
        }

        .dropdown-item-custom.danger:hover i { color: var(--danger); }

        /* ── Mobile menu ── */
        .mobile-menu-btn {
            display: none; width: 42px; height: 42px;
            border: 1px solid var(--border); background: var(--surface);
            border-radius: 10px; align-items: center; justify-content: center;
            cursor: pointer; color: var(--text); font-size: 1.3rem;
            transition: all 0.3s ease;
        }

        .mobile-menu-btn:hover { background: var(--accent); color: var(--bg); border-color: var(--accent); }

        /* ── Scroll top ── */
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

        /* ═══════════════════════════════════════════════════════
           NOTIFICATION DROPDOWN — NOUVEAU DESIGN
        ═══════════════════════════════════════════════════════ */
        .notification-dropdown {
            position: absolute;
            top: calc(100% + 0.6rem); right: -8px;
            width: 390px;
            background: var(--surface);
            border-radius: 20px;
            box-shadow:
                0 24px 64px rgba(0,0,0,0.7),
                0 0 0 1px rgba(201,169,110,0.08);
            border: 1px solid var(--border);
            overflow: hidden;
            opacity: 0; visibility: hidden; transform: translateY(-10px) scale(0.98);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1001;
        }

        .notification-dropdown.active {
            opacity: 1; visibility: visible;
            transform: translateY(0) scale(1);
        }

        /* Header du dropdown */
        .notif-dd-header {
            padding: 1.1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            background: var(--surface2);
            display: flex; align-items: center; justify-content: space-between;
        }

        .notif-dd-title-group { display: flex; align-items: center; gap: 10px; }

        .notif-dd-title {
            font-size: 0.95rem; font-weight: 700;
            color: var(--text); margin: 0;
        }

        .notif-dd-count {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: var(--bg);
            border-radius: 20px; font-size: 0.7rem; font-weight: 700;
            padding: 2px 9px; min-width: 22px; text-align: center;
            line-height: 1.6;
        }

        .notif-dd-actions { display: flex; align-items: center; gap: 12px; }

        .notif-dd-link {
            color: var(--muted); text-decoration: none;
            font-size: 0.78rem; font-weight: 500;
            transition: color 0.2s; cursor: pointer;
            background: none; border: none; font-family: 'Inter', sans-serif;
            padding: 0;
        }

        .notif-dd-link:hover { color: var(--accent); }

        /* Liste */
        .notif-dd-list {
            max-height: 420px; overflow-y: auto;
        }

        .notif-dd-list::-webkit-scrollbar { width: 4px; }
        .notif-dd-list::-webkit-scrollbar-track { background: transparent; }
        .notif-dd-list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        /* Item individuel */
        .notif-item {
            display: flex; align-items: center;
            padding: 0.85rem 1.1rem;
            border-bottom: 1px solid rgba(37, 42, 56, 0.6);
            transition: background 0.2s ease;
            cursor: pointer; position: relative; gap: 12px;
        }

        .notif-item:hover { background: rgba(201, 169, 110, 0.04); }

        .notif-item.unread {
            border-left: 2.5px solid var(--accent);
            padding-left: calc(1.1rem - 2.5px);
        }

        .notif-item:last-child { border-bottom: none; }

        /* Icône typée */
        .notif-type-icon {
            width: 40px; height: 40px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; flex-shrink: 0;
            transition: transform 0.2s ease;
        }

        .notif-item:hover .notif-type-icon { transform: scale(1.08); }

        .notif-type-icon.t-inscription   { background: rgba(76,175,125,0.12);  color: #4caf7d; }
        .notif-type-icon.t-produit        { background: rgba(201,169,110,0.12); color: var(--accent); }
        .notif-type-icon.t-rdv-new        { background: rgba(99,153,255,0.12);  color: #6399ff; }
        .notif-type-icon.t-rdv-confirme   { background: rgba(76,175,125,0.12);  color: #4caf7d; }
        .notif-type-icon.t-rdv-rejete     { background: rgba(224,92,92,0.12);   color: var(--danger); }

        /* Contenu texte */
        .notif-body { flex: 1; min-width: 0; }

        .notif-msg {
            font-size: 0.84rem; color: var(--text); font-weight: 500;
            line-height: 1.4; margin-bottom: 5px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .notif-meta { display: flex; align-items: center; gap: 7px; }

        .notif-pill {
            font-size: 0.65rem; font-weight: 600; padding: 2px 8px;
            border-radius: 20px; letter-spacing: 0.03em; text-transform: uppercase;
            line-height: 1.6; white-space: nowrap;
        }

        .p-inscription  { background: rgba(76,175,125,0.12);  color: #4caf7d; }
        .p-produit      { background: rgba(201,169,110,0.12); color: var(--accent); }
        .p-rdv-new      { background: rgba(99,153,255,0.12);  color: #6399ff; }
        .p-rdv-confirme { background: rgba(76,175,125,0.12);  color: #4caf7d; }
        .p-rdv-rejete   { background: rgba(224,92,92,0.12);   color: var(--danger); }

        .notif-time {
            font-size: 0.72rem; color: var(--muted);
            display: flex; align-items: center; gap: 3px;
        }

        /* Point non-lu */
        .notif-unread-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--accent); flex-shrink: 0;
            box-shadow: 0 0 6px rgba(201,169,110,0.5);
        }

        /* ── BOUTON SUPPRESSION ── */
        .notif-trash-btn {
            width: 30px; height: 30px; border-radius: 8px;
            background: transparent; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--muted);
            opacity: 0;
            transition: opacity 0.2s ease, background 0.2s ease, color 0.2s ease, transform 0.15s ease;
            flex-shrink: 0;
            padding: 0;
        }

        .notif-item:hover .notif-trash-btn { opacity: 1; }

        .notif-trash-btn:hover {
            background: rgba(224, 92, 92, 0.15);
            color: var(--danger);
            transform: scale(1.1);
        }

        .notif-trash-btn:active { transform: scale(0.95); }

        .notif-trash-btn i { font-size: 0.85rem; pointer-events: none; }

        /* Animation de suppression */
        @keyframes notifOut {
            0%   { opacity: 1; transform: translateX(0);   max-height: 80px; }
            60%  { opacity: 0; transform: translateX(20px); }
            100% { opacity: 0; transform: translateX(20px); max-height: 0; padding-top: 0; padding-bottom: 0; border: none; }
        }

        .notif-item.removing {
            animation: notifOut 0.3s ease forwards;
            pointer-events: none; overflow: hidden;
        }

        /* Empty state */
        .notif-empty {
            padding: 2.5rem 1.5rem; text-align: center; color: var(--muted);
        }

        .notif-empty i {
            font-size: 2.5rem; margin-bottom: 0.75rem;
            opacity: 0.35; display: block;
        }

        .notif-empty p { font-size: 0.88rem; margin: 0; }

        /* Footer */
        .notif-dd-footer {
            padding: 0.875rem 1.25rem;
            border-top: 1px solid var(--border);
            background: var(--surface2);
            display: flex; align-items: center; justify-content: space-between;
        }

        .notif-footer-link {
            color: var(--accent); text-decoration: none;
            font-size: 0.82rem; font-weight: 500;
            display: flex; align-items: center; gap: 5px;
            transition: color 0.2s;
            background: none; border: none; cursor: pointer;
            font-family: 'Inter', sans-serif; padding: 0;
        }

        .notif-footer-link:hover { color: var(--accent2); }

        /* ═══════════════════════════════════════════════════════
           MODAL DÉCONNEXION
        ═══════════════════════════════════════════════════════ */
        .modal-logout {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .modal-logout.active {
            display: flex;
            animation: fadeInBackdrop 0.25s ease forwards;
        }

        @keyframes fadeInBackdrop { from { opacity: 0; } to { opacity: 1; } }

        .modal-logout-content {
            background: var(--surface);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            max-width: 420px; width: 90%;
            border: 1px solid var(--border);
            box-shadow:
                0 32px 80px rgba(0,0,0,0.8),
                0 0 0 1px rgba(224,92,92,0.08),
                0 0 50px rgba(224,92,92,0.04);
            animation: slideUpModal 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        @keyframes slideUpModal {
            from { opacity: 0; transform: translateY(30px) scale(0.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-logout-header { text-align: center; margin-bottom: 1.75rem; }

        .modal-logout-icon {
            width: 76px; height: 76px;
            background: rgba(224, 92, 92, 0.12);
            border: 1px solid rgba(224, 92, 92, 0.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
            color: var(--danger); font-size: 2.2rem;
            animation: iconPulse 2s ease-in-out infinite;
        }

        @keyframes iconPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(224, 92, 92, 0.15); }
            50%       { box-shadow: 0 0 0 10px rgba(224, 92, 92, 0); }
        }

        .modal-logout-title { font-size: 1.5rem; font-weight: 700; color: var(--text); margin-bottom: 0.6rem; }
        .modal-logout-text  { color: var(--muted); font-size: 0.92rem; line-height: 1.6; margin: 0; padding: 0 0.5rem; }

        .modal-logout-divider {
            display: flex; align-items: center; gap: 10px;
            margin: 1.5rem 0;
        }

        .modal-logout-divider::before,
        .modal-logout-divider::after {
            content: ''; flex: 1; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(224,92,92,0.2), transparent);
        }

        .modal-logout-divider span { color: rgba(224,92,92,0.4); font-size: 9px; }

        .modal-logout-actions { display: flex; gap: 12px; }

        .modal-logout-btn {
            flex: 1; padding: 0.9rem;
            border: none; border-radius: 12px;
            font-weight: 700; font-size: 0.9rem; cursor: pointer;
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-family: 'Inter', sans-serif; letter-spacing: 0.03em;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }

        .modal-logout-btn.cancel {
            background: var(--surface2); color: var(--text); border: 1px solid var(--border);
        }

        .modal-logout-btn.cancel:hover {
            background: var(--border); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .modal-logout-btn.confirm {
            background: linear-gradient(135deg, #e05c5c, #c43b3b);
            color: #fff; border: 1px solid rgba(224,92,92,0.3);
        }

        .modal-logout-btn.confirm:hover {
            background: linear-gradient(135deg, #ef6b6b, #d94444);
            transform: translateY(-2px); box-shadow: 0 8px 20px rgba(224, 92, 92, 0.4);
        }

        .modal-logout-btn.confirm.loading { opacity: 0.75; pointer-events: none; }

        /* ── Responsive ── */
        @media (max-width: 992px) {
            .search-container { max-width: 300px; }
            .nav-label { display: none; }
            .brand-text { display: none; }
            .notification-dropdown { width: 340px; }
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

        /* ── Animations globales ── */
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn    { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp   { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        @keyframes bellRing {
            0%   { transform: rotate(0deg); }
            20%  { transform: rotate(-15deg); }
            40%  { transform: rotate(15deg); }
            60%  { transform: rotate(-10deg); }
            80%  { transform: rotate(10deg); }
            100% { transform: rotate(0deg); }
        }
        .bell-ring { animation: bellRing 0.6s ease; }
    </style>

    @yield('styles')
</head>
<body>

    <!-- ══════════════════════════════════════════════
         HEADER
    ══════════════════════════════════════════════ -->
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

                <!-- 🔔 Notifications -->
                <div class="nav-item" id="notificationBell" onclick="toggleNotifications(event)">
                    <div class="nav-icon">
                        <i class="bi bi-bell-fill"></i>
                        <span class="nav-badge" id="notificationCount" style="display:none;">0</span>
                    </div>
                    <span class="nav-label">Notifications</span>
                    <span class="tooltip-nav">Notifications</span>

                    <div class="notification-dropdown" id="notificationDropdown" onclick="event.stopPropagation()">

                        <!-- Header -->
                        <div class="notif-dd-header">
                            <div class="notif-dd-title-group">
                                <h3 class="notif-dd-title">Notifications</h3>
                                <span class="notif-dd-count" id="notifHeaderCount" style="display:none;">0</span>
                            </div>
                            <div class="notif-dd-actions">
                                <button class="notif-dd-link" onclick="markAllNotificationsRead(event)">
                                    <i class="bi bi-check2-all" style="margin-right:3px;"></i>Tout lire
                                </button>
                            </div>
                        </div>

                        <!-- Liste -->
                        <div class="notif-dd-list" id="notificationList">
                            <div class="notif-empty">
                                <i class="bi bi-bell"></i>
                                <p>Chargement des notifications...</p>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="notif-dd-footer">
                            <a href="{{ route('notifications.index') }}" class="notif-footer-link">
                                <i class="bi bi-eye"></i>
                                Voir toutes les notifications
                            </a>
                        </div>

                    </div><!-- /notification-dropdown -->
                </div><!-- /🔔 -->

            </nav>

            <!-- ── Profil utilisateur ── -->
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
                            <i class="bi bi-person-circle"></i>
                            <span>Mon Profil</span>
                        </a>

                        <a href="{{ auth()->user()->role === 'admin' ? route('settings.index') : route('settings.user') }}"
                           class="dropdown-item-custom">
                            <i class="bi bi-gear-fill"></i>
                            <span>Paramètres</span>
                        </a>

                        <button type="button"
                                class="dropdown-item-custom danger"
                                onclick="showLogoutModal()">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Déconnexion</span>
                        </button>

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

    <!-- ══════════════════════════════════════════════
         MODAL DÉCONNEXION
    ══════════════════════════════════════════════ -->
    <div class="modal-logout" id="logoutModal">
        <div class="modal-logout-content">
            <div class="modal-logout-header">
                <div class="modal-logout-icon">
                    <i class="bi bi-box-arrow-right"></i>
                </div>
                <h3 class="modal-logout-title">Déconnexion</h3>
                <p class="modal-logout-text">
                    Êtes-vous sûr de vouloir vous déconnecter ?<br>
                    Vous devrez vous reconnecter pour accéder à votre compte.
                </p>
            </div>

            <div class="modal-logout-divider"><span>◆</span></div>

            <div class="modal-logout-actions">
                <button class="modal-logout-btn cancel" onclick="hideLogoutModal()">
                    <i class="bi bi-x-lg"></i> Annuler
                </button>
                <button class="modal-logout-btn confirm" id="confirmLogoutBtn" onclick="confirmLogout()">
                    <i class="bi bi-box-arrow-right"></i> Se déconnecter
                </button>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // ══════════════════════════════════════════════════════
    //  MODAL DÉCONNEXION
    // ══════════════════════════════════════════════════════
    function showLogoutModal() {
        document.getElementById('logoutModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function hideLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.style.animation = 'fadeOutBackdrop 0.2s ease forwards';
        setTimeout(() => {
            modal.classList.remove('active');
            modal.style.animation = '';
            document.body.style.overflow = '';
        }, 200);
    }

    function confirmLogout() {
        const btn = document.getElementById('confirmLogoutBtn');
        btn.classList.add('loading');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Déconnexion...';
        document.getElementById('logout-form').submit();
    }

    document.getElementById('logoutModal').addEventListener('click', function (e) {
        if (e.target === this) hideLogoutModal();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('logoutModal');
            if (modal.classList.contains('active')) hideLogoutModal();
        }
    });

    const _style = document.createElement('style');
    _style.textContent = '@keyframes fadeOutBackdrop { from{opacity:1} to{opacity:0} }';
    document.head.appendChild(_style);

    // ══════════════════════════════════════════════════════
    //  SCROLL TO TOP
    // ══════════════════════════════════════════════════════
    window.addEventListener('scroll', function () {
        document.getElementById('scrollTopBtn').classList.toggle('visible', window.scrollY > 400);
    });

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // ══════════════════════════════════════════════════════
    //  MOBILE MENU
    // ══════════════════════════════════════════════════════
    function toggleMobileMenu() {
        document.getElementById('navActions').classList.toggle('active');
    }

    // ══════════════════════════════════════════════════════
    //  NOTIFICATIONS
    // ══════════════════════════════════════════════════════

    /** Mapping type → icône Bootstrap + classes CSS */
    function getNotifMeta(type) {
        const map = {
            inscription:          { icon: 'bi-person-plus-fill',   iconCls: 't-inscription',   pillCls: 'p-inscription',   label: 'Inscription' },
            new_produits:         { icon: 'bi-plus-circle-fill',    iconCls: 't-produit',        pillCls: 'p-produit',        label: 'Produit' },
            new_rendez_vous:      { icon: 'bi-calendar-plus-fill',  iconCls: 't-rdv-new',        pillCls: 'p-rdv-new',        label: 'Rendez-vous' },
            rendez_vous_confirme: { icon: 'bi-check-circle-fill',   iconCls: 't-rdv-confirme',   pillCls: 'p-rdv-confirme',   label: 'Confirmé' },
            rendez_vous_rejete:   { icon: 'bi-x-circle-fill',       iconCls: 't-rdv-rejete',     pillCls: 'p-rdv-rejete',     label: 'Refusé' },
        };
        return map[type] || { icon: 'bi-bell-fill', iconCls: 't-produit', pillCls: 'p-produit', label: type };
    }

    /** Formater le timestamp en texte relatif */
    function formatTime(timestamp) {
        if (!timestamp) return '—';
        const diff = (Date.now() - new Date(timestamp)) / 1000;
        if (diff < 60)    return "À l'instant";
        if (diff < 3600)  return `Il y a ${Math.floor(diff / 60)} min`;
        if (diff < 86400) return `Il y a ${Math.floor(diff / 3600)} h`;
        return new Date(timestamp).toLocaleDateString('fr-FR');
    }

    /** Mettre à jour les badges */
    function updateBadge(count) {
        const badge1 = document.getElementById('notificationCount');
        const badge2 = document.getElementById('notifHeaderCount');
        if (count > 0) {
            const label = count > 99 ? '99+' : count;
            badge1.textContent = label;
            badge2.textContent = label;
            badge1.style.display = 'flex';
            badge2.style.display = 'inline-block';
        } else {
            badge1.style.display = 'none';
            badge2.style.display = 'none';
        }
    }

    /** Construire le HTML d'un item de notification */
    function buildNotifItem(n) {
        const meta    = getNotifMeta(n.type);
        const unread  = !n.read;
        const timeStr = formatTime(n.time || n.created_at);

        return `
        <div class="notif-item${unread ? ' unread' : ''}"
             id="notif-item-${n.id}"
             onclick="window.location.href='{{ route('notifications.index') }}'">

            <div class="notif-type-icon ${meta.iconCls}">
                <i class="bi ${meta.icon}"></i>
            </div>

            <div class="notif-body">
                <div class="notif-msg" title="${n.message}">${n.message}</div>
                <div class="notif-meta">
                    <span class="notif-pill ${meta.pillCls}">${meta.label}</span>
                    <span class="notif-time">
                        <i class="bi bi-clock" style="font-size:0.65rem;"></i>
                        ${timeStr}
                    </span>
                </div>
            </div>

            ${unread ? '<div class="notif-unread-dot"></div>' : ''}

            <button class="notif-trash-btn"
                    onclick="deleteNotification(${n.id}, event)"
                    title="Supprimer cette notification">
                <i class="bi bi-trash3"></i>
            </button>

        </div>`;
    }

    /** Ouvrir / fermer le dropdown */
    function toggleNotifications(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('notificationDropdown');
        dropdown.classList.toggle('active');
        if (dropdown.classList.contains('active')) {
            loadNotifications(false);
        }
    }

    // Fermer en cliquant ailleurs
    document.addEventListener('click', function (e) {
        const bell = document.getElementById('notificationBell');
        if (bell && !bell.contains(e.target)) {
            document.getElementById('notificationDropdown').classList.remove('active');
        }
    });

    let lastCount = -1;

    /** Charger les notifications depuis l'API */
    function loadNotifications(silent = false) {
        fetch('{{ route("notifications.unread") }}', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            updateBadge(data.count);

            // Animation cloche si nouvelles notifications
            if (lastCount !== -1 && data.count > lastCount) {
                const bellIcon = document.querySelector('#notificationBell .nav-icon i');
                if (bellIcon) {
                    bellIcon.classList.add('bell-ring');
                    setTimeout(() => bellIcon.classList.remove('bell-ring'), 600);
                }
            }
            lastCount = data.count;

            // Mettre à jour la liste seulement si le dropdown est ouvert ou si ce n'est pas silencieux
            const isOpen = document.getElementById('notificationDropdown')?.classList.contains('active');
            if (!silent || isOpen) {
                const list = document.getElementById('notificationList');

                if (data.notifications && data.notifications.length > 0) {
                    list.innerHTML = data.notifications.map(buildNotifItem).join('');
                } else {
                    list.innerHTML = `
                        <div class="notif-empty">
                            <i class="bi bi-bell-slash"></i>
                            <p>Aucune nouvelle notification</p>
                        </div>`;
                }
            }
        })
        .catch(() => {
            if (!silent) {
                const list = document.getElementById('notificationList');
                if (list) list.innerHTML = `
                    <div class="notif-empty">
                        <i class="bi bi-exclamation-triangle"></i>
                        <p>Erreur de chargement</p>
                    </div>`;
            }
        });
    }

    /** Marquer toutes comme lues */
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
                lastCount = 0;
                // Mettre à jour visuellement les items sans recharger
                document.querySelectorAll('.notif-item.unread').forEach(el => {
                    el.classList.remove('unread');
                    const dot = el.querySelector('.notif-unread-dot');
                    if (dot) dot.remove();
                });
            }
        });
    }

    /** Supprimer une notification */
    function deleteNotification(id, event) {
        event.preventDefault();
        event.stopPropagation();

        const el = document.getElementById('notif-item-' + id);
        if (!el) return;

        // Animation de sortie immédiate
        el.classList.add('removing');

        fetch(`/notifications/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept':       'application/json',
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                // Retirer l'élément après l'animation
                setTimeout(() => {
                    el.remove();
                    // Vérifier s'il reste des notifications
                    const remaining = document.querySelectorAll('.notif-item').length;
                    if (remaining === 0) {
                        document.getElementById('notificationList').innerHTML = `
                            <div class="notif-empty">
                                <i class="bi bi-bell-slash"></i>
                                <p>Aucune nouvelle notification</p>
                            </div>`;
                    }
                    // Décrémenter le badge si la notif était non-lue
                    const wasUnread = el.classList.contains('unread');
                    if (wasUnread && lastCount > 0) {
                        lastCount--;
                        updateBadge(lastCount);
                    }
                }, 300);
            } else {
                // En cas d'erreur, annuler l'animation
                el.classList.remove('removing');
            }
        })
        .catch(() => {
            el.classList.remove('removing');
        });
    }

    // ── Polling automatique toutes les 10 secondes ──
    @auth
    loadNotifications(true);
    setInterval(() => loadNotifications(true), 10000);
    @endauth
    </script>

    @yield('scripts')

</body>
</html>