@extends('layouts.layout')

@section('title', 'Connexion - Espace Client')

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

  *, *::before, *::after { box-sizing: border-box; }

  .auth-wrapper {
    min-height: 100vh;
    background: var(--bg);
    background-image:
      radial-gradient(ellipse at 15% 20%, rgba(201,169,110,0.07) 0%, transparent 50%),
      radial-gradient(ellipse at 85% 80%, rgba(108,99,255,0.05) 0%, transparent 50%);
    font-family: 'DM Sans', sans-serif;
  }

  .auth-container {
    display: flex;
    min-height: 100vh;
  }

  /* ── LEFT PANEL ── */
  .auth-bg {
    flex: 1;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    position: relative;
    overflow: hidden;
  }

  .auth-bg::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(13,15,20,0.85) 0%, rgba(201,169,110,0.12) 100%);
    pointer-events: none;
  }

  .auth-content {
    position: relative;
    z-index: 1;
    max-width: 500px;
    width: 100%;
  }

  .auth-brand {
    text-align: center;
    margin-bottom: 2.5rem;
  }

  .auth-brand .brand-icon {
    width: 72px;
    height: 72px;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 2rem;
    color: #0d0f14;
    box-shadow: 0 8px 32px rgba(201,169,110,0.35);
  }

  .auth-brand h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.5rem;
    letter-spacing: 0.02em;
  }

  .auth-brand p {
    color: rgba(232,230,225,0.65);
    font-size: 0.95rem;
    margin: 0;
  }

  .stats-box {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(201,169,110,0.2);
    border-radius: 20px;
    padding: 2rem;
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
    justify-content: center;
  }

  .stat-item {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    color: var(--text);
  }

  .stat-icon {
    width: 48px;
    height: 48px;
    background: rgba(201,169,110,0.15);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    color: var(--accent);
    flex-shrink: 0;
  }

  .stat-item .fw-bold {
    font-size: 1.05rem;
    color: var(--text);
  }

  .stat-item small {
    color: var(--muted);
    font-size: 0.78rem;
  }

  /* ── RIGHT PANEL ── */
  .auth-form-container {
    width: 100%;
    max-width: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2.5rem 2rem;
    background: var(--surface);
    border-left: 1px solid var(--border);
    overflow-y: auto;
  }

  .auth-form {
    width: 100%;
    max-width: 400px;
    animation: formIn 0.55s cubic-bezier(.22,1,.36,1) both;
  }

  @keyframes formIn {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .auth-form h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.4rem;
  }

  .auth-form .subtitle {
    color: var(--muted);
    font-size: 0.9rem;
    margin-bottom: 1.75rem;
  }

  /* Alerts */
  .alert-dark-success {
    background: rgba(76,175,125,0.12);
    border: 1px solid rgba(76,175,125,0.3);
    color: #6fcf97;
    border-radius: 12px;
    padding: 0.875rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 1.25rem;
    font-size: 0.875rem;
  }

  .alert-dark-danger {
    background: rgba(224,92,92,0.12);
    border: 1px solid rgba(224,92,92,0.3);
    color: #f08080;
    border-radius: 12px;
    padding: 0.875rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 1.25rem;
    font-size: 0.875rem;
  }

  /* Form Controls */
  .form-floating {
    margin-bottom: 1rem;
    position: relative;
  }

  .form-floating .form-control {
    background: var(--surface2) !important;
    border: 1px solid var(--border) !important;
    color: var(--text) !important;
    border-radius: 12px !important;
    height: 58px;
    padding: 1rem 1rem 0.25rem 1rem;
    font-size: 0.9rem;
    transition: border-color 0.2s, box-shadow 0.2s;
  }

  .form-floating .form-control:focus {
    border-color: var(--accent) !important;
    box-shadow: 0 0 0 3px rgba(201,169,110,0.15) !important;
    outline: none;
  }

  .form-floating .form-control.is-invalid {
    border-color: var(--danger) !important;
  }

  .form-floating label {
    color: var(--muted) !important;
    font-size: 0.875rem;
    padding: 1rem;
  }

  .form-floating > .form-control:focus ~ label,
  .form-floating > .form-control:not(:placeholder-shown) ~ label {
    color: var(--accent) !important;
    opacity: 1;
    transform: scale(0.82) translateY(-0.55rem) translateX(0.1rem);
  }

  .form-floating .form-control::placeholder {
    color: transparent;
  }

  /* Password toggle */
  .btn-eye {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    border: none;
    background: none;
    color: var(--muted);
    padding: 0.4rem;
    cursor: pointer;
    z-index: 10;
    transition: color 0.2s;
  }
  .btn-eye:hover { color: var(--accent); }

  /* Remember / Forgot */
  .auth-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
  }

  .form-check-input {
    background-color: var(--surface2) !important;
    border-color: var(--border) !important;
  }

  .form-check-input:checked {
    background-color: var(--accent) !important;
    border-color: var(--accent) !important;
  }

  .form-check-label {
    color: var(--muted);
    font-size: 0.875rem;
  }

  .forgot-link {
    color: var(--accent);
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition: color 0.2s;
  }
  .forgot-link:hover { color: var(--accent2); }

  /* Buttons */
  .btn-primary-dark {
    width: 100%;
    padding: 0.9rem 1.5rem;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    border: none;
    border-radius: 12px;
    color: #0d0f14;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    box-shadow: 0 4px 20px rgba(201,169,110,0.3);
  }
  .btn-primary-dark:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 28px rgba(201,169,110,0.4);
  }
  .btn-primary-dark:active { transform: translateY(0); }

  /* Divider */
  .divider {
    position: relative;
    text-align: center;
    margin: 1.75rem 0;
  }
  .divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0; right: 0;
    height: 1px;
    background: var(--border);
  }
  .divider span {
    position: relative;
    background: var(--surface);
    padding: 0 1rem;
    color: var(--muted);
    font-size: 0.8rem;
  }

  /* Social Login */
  .social-login {
    display: flex;
    gap: 0.875rem;
    justify-content: center;
    margin-bottom: 1.5rem;
  }

  .btn-social {
    width: 58px;
    height: 58px;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    cursor: pointer;
    transition: all 0.22s ease;
    color: var(--muted);
    text-decoration: none;
  }
  .btn-social:hover {
    border-color: var(--accent);
    color: var(--accent);
    background: rgba(201,169,110,0.08);
    transform: translateY(-2px);
  }

  /* Register link */
  .register-box {
    text-align: center;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border);
  }

  .register-box p {
    color: var(--muted);
    font-size: 0.875rem;
    margin-bottom: 0.875rem;
  }

  .btn-outline-dark-custom {
    display: block;
    width: 100%;
    padding: 0.8rem 1.5rem;
    background: transparent;
    border: 1px solid var(--border);
    border-radius: 12px;
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.22s ease;
    text-decoration: none;
    text-align: center;
  }
  .btn-outline-dark-custom:hover {
    border-color: var(--accent);
    color: var(--accent);
    background: rgba(201,169,110,0.06);
  }

  /* Responsive */
  @media (max-width: 991px) {
    .auth-bg { display: none; }
    .auth-form-container { max-width: 100%; border-left: none; }
  }

  @media (max-width: 480px) {
    .auth-form-container { padding: 2rem 1.25rem; }
  }
</style>
@endsection

@section('content')
<div class="auth-wrapper">
  <div class="auth-container">

    {{-- ── PANNEAU GAUCHE ── --}}
    <div class="auth-bg" style="background-image: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1920');">
      <div class="auth-content">

        <div class="auth-brand">
          <div class="brand-icon">
            <i class="bi bi-house"></i>
          </div>
          <h1>ImmoAgence</h1>
          <p>Votre partenaire de confiance pour tous vos projets immobiliers</p>
        </div>

        <div class="stats-box">
          <div class="stat-item">
            <div class="stat-icon"><i class="bi bi-house-door"></i></div>
            <div>
              <div class="fw-bold">+2 500</div>
              <small>Biens disponibles</small>
            </div>
          </div>
          <div class="stat-item">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <div>
              <div class="fw-bold">+15 000</div>
              <small>Clients satisfaits</small>
            </div>
          </div>
          <div class="stat-item">
            <div class="stat-icon"><i class="bi bi-award"></i></div>
            <div>
              <div class="fw-bold">20 ans</div>
              <small>D'expérience</small>
            </div>
          </div>
        </div>

      </div>
    </div>

    {{-- ── FORMULAIRE ── --}}
    <div class="auth-form-container">
      <div class="auth-form">

        <h2>Espace Client</h2>
        <p class="subtitle">Accédez à vos favoris, alertes et rendez-vous</p>

        @if(session('success'))
          <div class="alert-dark-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
          </div>
        @endif

        @if($errors->any())
          <div class="alert-dark-danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ $errors->first() }}
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="form-floating">
            <input type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   id="email"
                   name="email"
                   value="{{ old('email') }}"
                   placeholder="name@example.com"
                   required>
            <label for="email"><i class="bi bi-envelope me-2"></i>Adresse email</label>
          </div>

          <div class="form-floating position-relative">
            <input type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   id="password"
                   name="password"
                   placeholder="Mot de passe"
                   required>
            <label for="password"><i class="bi bi-key me-2"></i>Mot de passe</label>
            <button class="btn-eye" type="button" id="togglePassword">
              <i class="bi bi-eye"></i>
            </button>
          </div>

          <div class="auth-options">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="remember" name="remember">
              <label class="form-check-label" for="remember">Rester connecté</label>
            </div>
            <a href="#" class="forgot-link">Mot de passe oublié ?</a>
          </div>

          <button type="submit" class="btn-primary-dark mb-4">
            <i class="bi bi-box-arrow-in-right"></i>
            Accéder à mon espace
          </button>

          <div class="divider"><span>ou continuer avec</span></div>

          <div class="social-login">
            <button type="button" class="btn-social" title="Google">
              <i class="bi bi-google"></i>
            </button>
            <button type="button" class="btn-social" title="Facebook">
              <i class="bi bi-facebook"></i>
            </button>
            <button type="button" class="btn-social" title="Apple">
              <i class="bi bi-apple"></i>
            </button>
          </div>

          <div class="register-box">
            <p><i class="bi bi-star-fill text-warning me-1"></i> Première visite ?</p>
            <a href="{{ route('register') }}" class="btn-outline-dark-custom">
              Créer mon compte gratuitement
            </a>
          </div>

        </form>
      </div>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script>
  document.getElementById('togglePassword').addEventListener('click', function () {
    const input = document.getElementById('password');
    const icon  = this.querySelector('i');
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
  });
</script>
@endsection