<style>
  :root {
    --l-gold:     #c5a055;
    --l-gold-l:   #e2c07a;
    --l-gold-dim: rgba(197,160,85,0.12);
    --l-surface:  #0d1018;
    --l-surface2: #111420;
    --l-surface3: #161924;
    --l-border:   rgba(255,255,255,0.055);
    --l-border-g: rgba(197,160,85,0.2);
    --l-text:     #f0ede8;
    --l-soft:     #a8a49e;
    --l-muted:    #50535c;
    --l-success:  #3db97a;
    --l-danger:   #d95f5f;
    --l-blue:     #5585e0;
    --l-radius:   14px;
    --l-radius-sm: 9px;
    --tr:         0.26s cubic-bezier(0.4,0,0.2,1);
  }

  /* ── CARD ── */
  .dark-card {
    background: var(--l-surface);
    border: 1px solid var(--l-border);
    border-radius: var(--l-radius);
    overflow: hidden;
    font-family: 'Inter', sans-serif;
  }

  .dark-card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 18px 24px;
    border-bottom: 1px solid var(--l-border);
    position: relative;
  }

  .dark-card-header::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0;
    width: 80px; height: 1px;
    background: linear-gradient(90deg, var(--l-gold), transparent);
    opacity: 0.5;
  }

  .dark-card-header i {
    font-size: 16px;
    color: var(--l-gold);
  }

  .dark-card-header h5 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.15rem;
    font-weight: 600;
    color: var(--l-text);
    margin: 0;
    letter-spacing: 0.02em;
  }

  .dark-card-body {
    padding: 28px 24px;
  }

  /* ── SECTION TITLE ── */
  .section-eyebrow {
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--l-gold);
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 18px;
  }

  .section-eyebrow::before {
    content: '';
    display: inline-block;
    width: 14px; height: 1px;
    background: var(--l-gold); opacity: 0.6;
  }

  /* ── DIVIDER ── */
  .dark-hr {
    border: none;
    border-top: 1px solid var(--l-border);
    margin: 28px 0;
    position: relative;
  }

  /* ── LABELS & INPUTS ── */
  .dark-label {
    display: block;
    font-size: 0.78rem;
    font-weight: 500;
    color: var(--l-soft);
    margin-bottom: 7px;
    letter-spacing: 0.02em;
  }

  .dark-input {
    width: 100%;
    padding: 11px 14px;
    background: var(--l-surface2);
    border: 1px solid var(--l-border);
    border-radius: var(--l-radius-sm);
    color: var(--l-text);
    font-family: 'Inter', sans-serif;
    font-size: 0.855rem;
    outline: none;
    transition: all 0.25s ease;
    box-sizing: border-box;
  }

  .dark-input:focus {
    border-color: var(--l-border-g);
    box-shadow: 0 0 0 3px rgba(197,160,85,0.08);
  }

  .dark-input::placeholder { color: var(--l-muted); }

  /* ── BUTTON ── */
  .btn-dark-gold {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 24px;
    border-radius: 50px;
    border: 1px solid var(--l-gold);
    background: transparent;
    color: var(--l-gold);
    font-family: 'Inter', sans-serif;
    font-size: 0.845rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.25s ease;
    letter-spacing: 0.04em;
    position: relative;
    overflow: hidden;
  }

  .btn-dark-gold::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, var(--l-gold), var(--l-gold-l));
    opacity: 0;
    transition: opacity 0.25s ease;
  }

  .btn-dark-gold span,
  .btn-dark-gold i { position: relative; z-index: 1; }

  .btn-dark-gold:hover::before { opacity: 1; }
  .btn-dark-gold:hover { color: #080a0f; box-shadow: 0 0 22px rgba(197,160,85,0.3); }

  /* ── SESSION LIST ── */
  .session-list { display: flex; flex-direction: column; gap: 10px; }

  .session-item {
    background: var(--l-surface2);
    border: 1px solid var(--l-border);
    border-radius: var(--l-radius-sm);
    padding: 14px 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    transition: border-color var(--tr);
  }

  .session-item:hover { border-color: var(--l-border-g); }

  .session-device {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--l-text);
    margin-bottom: 4px;
  }

  .session-meta {
    font-size: 0.75rem;
    color: var(--l-muted);
    line-height: 1.6;
  }

  .badge-current {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    background: rgba(61,185,122,0.15);
    color: var(--l-success);
    border: 1px solid rgba(61,185,122,0.3);
    white-space: nowrap;
    flex-shrink: 0;
  }

  .btn-dark-danger {
    padding: 7px 14px;
    border-radius: 50px;
    border: 1px solid rgba(217,95,95,0.35);
    background: transparent;
    color: var(--l-danger);
    font-family: 'Inter', sans-serif;
    font-size: 0.78rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.25s ease;
    white-space: nowrap;
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
  }

  .btn-dark-danger::before {
    content: '';
    position: absolute; inset: 0;
    background: rgba(217,95,95,0.1);
    opacity: 0;
    transition: opacity 0.25s ease;
  }

  .btn-dark-danger:hover::before { opacity: 1; }
  .btn-dark-danger:hover { box-shadow: 0 0 14px rgba(217,95,95,0.2); }

  /* ── 2FA TOGGLE ── */
  .twofa-row {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 16px 18px;
    background: var(--l-surface2);
    border: 1px solid var(--l-border);
    border-radius: var(--l-radius-sm);
    transition: border-color var(--tr);
  }

  .twofa-row:hover { border-color: var(--l-border-g); }

  .toggle-wrap {
    flex-shrink: 0;
    position: relative;
    width: 40px; height: 22px;
  }

  .toggle-wrap input {
    position: absolute;
    opacity: 0; width: 100%; height: 100%;
    cursor: pointer; margin: 0;
  }

  .toggle-track {
    display: block;
    width: 40px; height: 22px;
    background: var(--l-muted);
    border-radius: 11px;
    transition: background 0.25s ease;
    position: relative;
  }

  .toggle-thumb {
    position: absolute;
    top: 3px; left: 3px;
    width: 16px; height: 16px;
    background: var(--l-text);
    border-radius: 50%;
    transition: transform 0.25s ease;
    pointer-events: none;
  }

  .toggle-wrap input:checked ~ .toggle-track { background: var(--l-gold); }
  .toggle-wrap input:checked ~ .toggle-track .toggle-thumb { transform: translateX(18px); }

  .twofa-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--l-text);
    margin-bottom: 4px;
  }

  .twofa-hint {
    font-size: 0.78rem;
    color: var(--l-muted);
    line-height: 1.5;
  }
</style>

<div class="dark-card">

  {{-- HEADER --}}
  <div class="dark-card-header">
    <i class="bi bi-shield-lock"></i>
    <h5>Sécurité</h5>
  </div>

  <div class="dark-card-body">

    {{-- ── MOT DE PASSE ── --}}
    <p class="section-eyebrow">Changer le mot de passe</p>

    <form action="{{ route('settings.password.update') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <label class="dark-label">Mot de passe actuel</label>
          <input type="password" class="dark-input" name="current_password" required placeholder="••••••••">
        </div>
        <div class="col-md-6">
          <label class="dark-label">Nouveau mot de passe</label>
          <input type="password" class="dark-input" name="new_password" required placeholder="••••••••">
        </div>
        <div class="col-md-6">
          <label class="dark-label">Confirmer le mot de passe</label>
          <input type="password" class="dark-input" name="new_password_confirmation" required placeholder="••••••••">
        </div>
        <div class="col-12">
          <button type="submit" class="btn-dark-gold">
            <i class="bi bi-key"></i>
            <span>Mettre à jour le mot de passe</span>
          </button>
        </div>
      </div>
    </form>

    <hr class="dark-hr">

    {{-- ── SESSIONS ACTIVES ── --}}
    <p class="section-eyebrow">Sessions actives</p>

    <div class="session-list mb-4">
      @foreach($activeSessions as $session)
      <div class="session-item">
        <div>
          <div class="session-device">{{ $session->device }}</div>
          <div class="session-meta">
            {{ $session->ip_address }} — {{ $session->location }}<br>
            Dernière activité : {{ $session->last_activity->diffForHumans() }}
          </div>
        </div>
        @if($session->is_current)
          <span class="badge-current">Session actuelle</span>
        @else
          <button class="btn-dark-danger" onclick="logoutSession('{{ $session->id }}')">
            <i class="bi bi-box-arrow-right me-1"></i> Déconnecter
          </button>
        @endif
      </div>
      @endforeach
    </div>

    <hr class="dark-hr">


  </div>
</div>