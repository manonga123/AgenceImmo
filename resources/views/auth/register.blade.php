@extends('layouts.layout')

@section('title', 'Inscription - Rejoignez-nous')

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
      radial-gradient(ellipse at 10% 15%, rgba(201,169,110,0.07) 0%, transparent 50%),
      radial-gradient(ellipse at 90% 85%, rgba(108,99,255,0.05) 0%, transparent 50%);
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
    background: linear-gradient(135deg, rgba(13,15,20,0.88) 0%, rgba(201,169,110,0.1) 100%);
    pointer-events: none;
  }

  .auth-content {
    position: relative;
    z-index: 1;
    max-width: 540px;
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

  /* Benefits box */
  .benefits-box {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(201,169,110,0.2);
    border-radius: 20px;
    padding: 2rem;
  }

  .benefits-box h5 {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .benefits-box h5::before {
    content: '';
    display: inline-block;
    width: 18px;
    height: 2px;
    background: var(--accent);
    border-radius: 2px;
  }

  .benefit-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.25rem;
  }

  .benefit-item:last-child { margin-bottom: 0; }

  .benefit-icon {
    width: 42px;
    height: 42px;
    background: rgba(201,169,110,0.15);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: var(--accent);
    flex-shrink: 0;
    margin-top: 0.1rem;
  }

  .benefit-item .fw-semibold {
    color: var(--text);
    font-size: 0.9rem;
    margin-bottom: 0.2rem;
  }

  .benefit-item small {
    color: var(--muted);
    font-size: 0.8rem;
    line-height: 1.4;
  }

  /* ── RIGHT PANEL ── */
  .auth-form-container {
    width: 100%;
    max-width: 520px;
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
    max-width: 440px;
    padding: 0.5rem 0;
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

  /* Alert */
  .alert-dark-danger {
    background: rgba(224,92,92,0.12);
    border: 1px solid rgba(224,92,92,0.3);
    color: #f08080;
    border-radius: 12px;
    padding: 0.875rem 1rem;
    margin-bottom: 1.25rem;
    font-size: 0.875rem;
  }

  .alert-dark-danger strong {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
  }

  .alert-dark-danger ul {
    margin: 0;
    padding-left: 1.25rem;
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

  .form-floating .form-control::placeholder { color: transparent; }

  .form-hint {
    color: var(--muted);
    font-size: 0.78rem;
    margin-top: 0.35rem;
    padding-left: 0.25rem;
    display: block;
  }

  /* Password toggle */
  .btn-eye {
    position: absolute;
    right: 14px;
    top: 29px;
    border: none;
    background: none;
    color: var(--muted);
    padding: 0.4rem;
    cursor: pointer;
    z-index: 10;
    transition: color 0.2s;
  }
  .btn-eye:hover { color: var(--accent); }

  /* Password strength */
  .password-strength small {
    font-size: 0.78rem;
    transition: color 0.2s;
  }

  /* Terms checkbox */
  .terms-box {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1.25rem;
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
    font-size: 0.85rem;
    line-height: 1.5;
  }

  .form-check-label a {
    color: var(--accent);
    text-decoration: none;
    font-weight: 500;
  }
  .form-check-label a:hover { color: var(--accent2); }

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
    margin-bottom: 1.5rem;
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
    margin: 0 0 1.5rem;
  }
  .divider::before {
    content: '';
    position: absolute;
    top: 50%; left: 0; right: 0;
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

  /* Social */
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
  }
  .btn-social:hover {
    border-color: var(--accent);
    color: var(--accent);
    background: rgba(201,169,110,0.08);
    transform: translateY(-2px);
  }

  /* Login link */
  .login-box {
    text-align: center;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border);
    color: var(--muted);
    font-size: 0.875rem;
  }

  .login-box a {
    color: var(--accent);
    font-weight: 500;
    text-decoration: none;
    transition: color 0.2s;
  }
  .login-box a:hover { color: var(--accent2); }

  /* Trust badges */
  .trust-badges {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 1.25rem;
  }

  .trust-badge {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 0.4rem 0.85rem;
    font-size: 0.78rem;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 0.35rem;
  }

  .trust-badge i.success { color: var(--success); }
  .trust-badge i.info    { color: #60a5fa; }
  .trust-badge i.warning { color: var(--accent); }

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
    <div class="auth-bg" style="background-image: url('https://images.unsplash.com/photo-1582407947304-fd86f028f716?w=1920');">
      <div class="auth-content">

        <div class="auth-brand">
          <div class="brand-icon">
            <i class="bi bi-house-heart"></i>
          </div>
          <h1>Rejoignez ImmoConnect</h1>
          <p>Créez votre compte et trouvez le bien de vos rêves</p>
        </div>

        <div class="benefits-box">
          <h5>Vos avantages exclusifs</h5>

          <div class="benefit-item">
            <div class="benefit-icon"><i class="bi bi-bell-fill"></i></div>
            <div>
              <div class="fw-semibold">Alertes personnalisées</div>
              <small>Soyez alerté des nouveaux biens correspondant à vos critères</small>
            </div>
          </div>

          <div class="benefit-item">
            <div class="benefit-icon"><i class="bi bi-heart-fill"></i></div>
            <div>
              <div class="fw-semibold">Favoris illimités</div>
              <small>Sauvegardez tous vos coups de cœur en un clic</small>
            </div>
          </div>

          <div class="benefit-item">
            <div class="benefit-icon"><i class="bi bi-calendar-check-fill"></i></div>
            <div>
              <div class="fw-semibold">Prise de RDV simplifiée</div>
              <small>Planifiez vos visites directement en ligne 24h/24</small>
            </div>
          </div>

          <div class="benefit-item">
            <div class="benefit-icon"><i class="bi bi-headset"></i></div>
            <div>
              <div class="fw-semibold">Accompagnement personnalisé</div>
              <small>Un conseiller dédié pour votre projet immobilier</small>
            </div>
          </div>
        </div>

      </div>
    </div>

    {{-- ── FORMULAIRE ── --}}
    <div class="auth-form-container">
      <div class="auth-form">

        <h2>Créer mon compte</h2>
        <p class="subtitle">Gratuit et sans engagement</p>

        @if($errors->any())
          <div class="alert-dark-danger">
            <strong><i class="bi bi-exclamation-triangle-fill"></i> Erreur(s) détectée(s) :</strong>
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
          @csrf

          <div class="row g-3 mb-1">
            <div class="col-md-6">
              <div class="form-floating">
                <input type="text"
                       class="form-control @error('first_name') is-invalid @enderror"
                       id="first_name"
                       name="first_name"
                       value="{{ old('first_name') }}"
                       placeholder="Prénom"
                       required>
                <label for="first_name"><i class="bi bi-person me-2"></i>Prénom</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input type="text"
                       class="form-control @error('last_name') is-invalid @enderror"
                       id="last_name"
                       name="last_name"
                       value="{{ old('last_name') }}"
                       placeholder="Nom"
                       required>
                <label for="last_name"><i class="bi bi-person me-2"></i>Nom</label>
              </div>
            </div>
          </div>

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

          <div class="form-floating">
            <input type="tel"
                   class="form-control @error('phone') is-invalid @enderror"
                   id="phone"
                   name="phone"
                   value="{{ old('phone') }}"
                   placeholder="Téléphone"
                   required>
            <label for="phone"><i class="bi bi-telephone me-2"></i>Téléphone</label>
            <span class="form-hint">Format : 06 12 34 56 78</span>
          </div>

          <div class="form-floating position-relative">
            <input type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   id="password"
                   name="password"
                   placeholder="Mot de passe"
                   required>
            <label for="password"><i class="bi bi-lock me-2"></i>Mot de passe</label>
            <button class="btn-eye" type="button" id="togglePassword">
              <i class="bi bi-eye"></i>
            </button>
            <div class="password-strength mt-1 ms-1">
              <small class="text-muted" id="strengthText">Minimum 8 caractères</small>
            </div>
          </div>

          <div class="form-floating position-relative">
            <input type="password"
                   class="form-control"
                   id="password_confirmation"
                   name="password_confirmation"
                   placeholder="Confirmer le mot de passe"
                   required>
            <label for="password_confirmation"><i class="bi bi-lock-fill me-2"></i>Confirmer le mot de passe</label>
            <button class="btn-eye" type="button" id="togglePasswordConfirm">
              <i class="bi bi-eye"></i>
            </button>
          </div>

          <div class="terms-box">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="terms" required>
              <label class="form-check-label" for="terms">
                J'accepte les <a href="#">conditions générales d'utilisation</a>
                et la <a href="#">politique de confidentialité</a>
              </label>
            </div>
          </div>

          <button type="submit" class="btn-primary-dark">
            <i class="bi bi-person-plus-fill"></i>
            Créer mon compte gratuit
          </button>

          <div class="divider"><span>ou s'inscrire avec</span></div>

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

          <div class="login-box">
            Vous avez déjà un compte ?
            <a href="{{ route('login') }}">Se connecter</a>
          </div>

          <div class="trust-badges">
            <span class="trust-badge">
              <i class="bi bi-shield-check success"></i> Données sécurisées
            </span>
            <span class="trust-badge">
              <i class="bi bi-lock-fill info"></i> Connexion SSL
            </span>
            <span class="trust-badge">
              <i class="bi bi-award warning"></i> Certifié
            </span>
          </div>

        </form>
      </div>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script>
  // Toggle password
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

  // Toggle password confirmation
  document.getElementById('togglePasswordConfirm').addEventListener('click', function () {
    const input = document.getElementById('password_confirmation');
    const icon  = this.querySelector('i');
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
  });

  // Password strength
  document.getElementById('password').addEventListener('input', function () {
    const val = this.value;
    const el  = document.getElementById('strengthText');
    if (val.length === 0) {
      el.textContent = 'Minimum 8 caractères';
      el.style.color = 'var(--muted)';
    } else if (val.length < 8) {
      el.textContent = 'Mot de passe trop court';
      el.style.color = 'var(--danger)';
    } else if (val.length >= 12 && /[A-Z]/.test(val) && /[0-9]/.test(val)) {
      el.textContent = 'Mot de passe fort ✓';
      el.style.color = 'var(--success)';
    } else {
      el.textContent = 'Mot de passe moyen';
      el.style.color = 'var(--accent)';
    }
  });
</script>
@endsection