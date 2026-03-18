@extends('layouts.layout')

@section('title', 'Paramètres')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  :root {
    --bg:       #0d0f14;
    --surface:  #13161d;
    --surface2: #1a1e28;
    --border:   #252a38;
    --accent:   #c9a96e;
    --accent2:  #e8c97a;
    --text:     #e8e6e1;
    --muted:    #6b7080;
    --success:  #4caf7d;
    --danger:   #e05c5c;
    --radius:   16px;
  }

  /* ── RESET ── */
  .settings-wrapper *, .settings-wrapper *::before, .settings-wrapper *::after {
    box-sizing: border-box;
  }

  /* ── PAGE WRAPPER ── */
  .settings-wrapper {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    background-image:
      radial-gradient(ellipse at 15% 20%, rgba(201,169,110,0.06) 0%, transparent 50%),
      radial-gradient(ellipse at 85% 80%, rgba(108,99,255,0.05) 0%, transparent 50%);
    min-height: 100vh;
    padding: 40px 24px;
    color: var(--text);
  }

  /* ── PAGE TITLE ── */
  .settings-page-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem;
    font-weight: 600;
    color: var(--text);
    letter-spacing: 0.01em;
    margin-bottom: 32px;
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .settings-page-title svg {
    color: var(--accent);
  }

  .settings-page-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: linear-gradient(to right, var(--border), transparent);
    margin-left: 16px;
  }

  /* ── LAYOUT ── */
  .settings-layout {
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 28px;
    max-width: 1100px;
    margin: 0 auto;
    animation: pageIn 0.6s cubic-bezier(.22,1,.36,1) both;
  }

  @keyframes pageIn {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ── SIDEBAR ── */
  .settings-sidebar {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(0,0,0,0.4);
    height: fit-content;
    position: sticky;
    top: 24px;
  }

  .sidebar-header {
    padding: 24px 24px 16px;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(135deg, var(--surface2) 0%, var(--surface) 100%);
    position: relative;
    overflow: hidden;
  }

  .sidebar-header::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, var(--accent), transparent);
  }

  .sidebar-header h6 {
    font-family: 'Playfair Display', serif;
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--text);
    margin: 0;
    letter-spacing: 0.02em;
  }

  .sidebar-nav {
    padding: 12px;
    list-style: none;
    margin: 0;
  }

  .sidebar-nav li {
    margin-bottom: 2px;
  }

  .sidebar-nav a {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 11px 14px;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 400;
    color: var(--muted);
    text-decoration: none;
    transition: all 0.22s ease;
    position: relative;
    overflow: hidden;
  }

  .sidebar-nav a::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(201,169,110,0.08), transparent);
    opacity: 0;
    transition: opacity 0.22s;
  }

  .sidebar-nav a:hover {
    color: var(--text);
    background: rgba(255,255,255,0.04);
  }

  .sidebar-nav a:hover::before { opacity: 1; }

  .sidebar-nav a.active {
    color: var(--accent);
    background: rgba(201,169,110,0.1);
    font-weight: 500;
  }

  .sidebar-nav a.active::before { opacity: 1; }

  .sidebar-nav a.active::after {
    content: '';
    position: absolute;
    left: 0; top: 20%; bottom: 20%;
    width: 2.5px;
    background: var(--accent);
    border-radius: 0 2px 2px 0;
  }

  .sidebar-nav a svg {
    flex-shrink: 0;
    opacity: 0.7;
    transition: opacity 0.2s;
  }

  .sidebar-nav a:hover svg,
  .sidebar-nav a.active svg {
    opacity: 1;
  }

  /* Séparateur de section */
  .nav-divider {
    height: 1px;
    background: var(--border);
    margin: 10px 14px;
    opacity: 0.6;
  }

  .nav-section-label {
    font-size: 0.68rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--muted);
    padding: 8px 14px 4px;
    opacity: 0.6;
    font-weight: 500;
  }

  /* ── CONTENT PANEL ── */
  .settings-content {
    min-width: 0;
  }

  .tab-pane {
    display: none;
  }

  .tab-pane.show.active {
    display: block;
    animation: paneIn 0.4s cubic-bezier(.22,1,.36,1) both;
  }

  @keyframes paneIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ── CARD (pour chaque section) ── */
  .settings-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(0,0,0,0.4), 0 0 0 1px rgba(201,169,110,0.04);
  }

  .settings-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 24px 32px;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(135deg, var(--surface2) 0%, var(--surface) 100%);
    position: relative;
    overflow: hidden;
  }

  .settings-card-header::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, var(--accent), transparent);
  }

  .settings-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.15rem;
    font-weight: 600;
    letter-spacing: 0.01em;
    color: var(--text);
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
  }

  .settings-card-title svg {
    color: var(--accent);
    flex-shrink: 0;
  }

  /* ── RESPONSIVE ── */
  @media (max-width: 768px) {
    .settings-layout {
      grid-template-columns: 1fr;
    }

    .settings-sidebar {
      position: static;
    }

    .sidebar-nav {
      display: flex;
      flex-wrap: wrap;
      gap: 4px;
      padding: 10px;
    }

    .sidebar-nav li { margin: 0; }

    .sidebar-nav a {
      padding: 9px 14px;
      font-size: 0.82rem;
    }

    .nav-divider,
    .nav-section-label { display: none; }

    .settings-page-title { font-size: 1.3rem; }
  }

  @media (max-width: 480px) {
    .settings-wrapper { padding: 24px 14px; }
    .settings-card-header { padding: 20px 20px; }
  }
</style>
@endsection

@section('content')
<div class="settings-wrapper">

  {{-- Titre de page --}}
  <h1 class="settings-page-title">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/>
      <path d="M12 2v2M12 20v2M2 12h2M20 12h2"/>
    </svg>
    Paramètres
  </h1>

  <div class="settings-layout">

    {{-- ── SIDEBAR ── --}}
    <aside class="settings-sidebar">
      <div class="sidebar-header">
        <h6>Navigation</h6>
      </div>
      <ul class="sidebar-nav" id="settingsNav">

        {{-- Section principale --}}
        <li>
          <a href="#profile" class="active" data-tab="profile">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            Profil
          </a>
        </li>
        <li>
          <a href="#security" data-tab="security">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            Sécurité
          </a>
        </li>
        

       

      </ul>
    </aside>

    {{-- ── CONTENT ── --}}
    <div class="settings-content">
      <div id="settingsTabContent">

        {{-- Profil --}}
        <div class="tab-pane show active" id="profile">
          @include('settings.sections.profile')
        </div>

        {{-- Sécurité --}}
        <div class="tab-pane" id="security">
          @include('settings.sections.security')
        </div>

        {{-- Notifications --}}
        <div class="tab-pane" id="notifications">
          @include('settings.sections.notifications')
        </div>

        {{-- Admin : Agence --}}
        @if(auth()->user()->role === 'admin')
        <div class="tab-pane" id="agency">
          @include('settings.sections.agency')
        </div>

        {{-- Admin : Utilisateurs --}}
        <div class="tab-pane" id="users">
          @include('settings.sections.users')
        </div>
        @endif

        {{-- Owner --}}
        @if(auth()->user()->role === 'owner')
        <div class="tab-pane" id="owner-settings">
          @include('settings.sections.owner')
        </div>
        @endif

      </div>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  const navLinks = document.querySelectorAll('#settingsNav a[data-tab]');
  const panes    = document.querySelectorAll('#settingsTabContent .tab-pane');

  function showTab(tabId) {
    // Panes
    panes.forEach(p => {
      p.classList.remove('show', 'active');
    });
    const target = document.getElementById(tabId);
    if (target) {
      target.classList.add('show', 'active');
    }

    // Nav links
    navLinks.forEach(a => {
      a.classList.toggle('active', a.dataset.tab === tabId);
    });
  }

  // Clic sur nav
  navLinks.forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      const tabId = this.dataset.tab;
      showTab(tabId);
      // Mettre à jour l'URL sans rechargement
      const url = new URL(window.location);
      url.searchParams.set('tab', tabId);
      history.replaceState(null, '', url);
    });
  });

  // Lire le paramètre tab dans l'URL au chargement
  const urlParams = new URLSearchParams(window.location.search);
  const tabParam  = urlParams.get('tab');
  if (tabParam && document.getElementById(tabParam)) {
    showTab(tabParam);
  }

});
</script>
@endsection