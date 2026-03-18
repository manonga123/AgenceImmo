<style>
  :root {
    --l-gold:     #c5a055;
    --l-gold-l:   #e2c07a;
    --l-gold-dim: rgba(197,160,85,0.12);
    --l-surface:  #0d1018;
    --l-surface2: #111420;
    --l-border:   rgba(255,255,255,0.055);
    --l-border-g: rgba(197,160,85,0.2);
    --l-text:     #f0ede8;
    --l-soft:     #a8a49e;
    --l-muted:    #50535c;
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
    margin-bottom: 16px;
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
    margin: 24px 0;
  }

  /* ── CHECKBOX ITEM ── */
  .check-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 16px;
    background: var(--l-surface2);
    border: 1px solid var(--l-border);
    border-radius: var(--l-radius-sm);
    margin-bottom: 8px;
    cursor: pointer;
    transition: border-color var(--tr), background var(--tr);
    user-select: none;
  }

  .check-item:hover {
    border-color: var(--l-border-g);
    background: rgba(197,160,85,0.04);
  }

  .check-item:last-child { margin-bottom: 0; }

  /* Custom checkbox */
  .dark-checkbox {
    appearance: none;
    -webkit-appearance: none;
    width: 18px; height: 18px;
    border: 1.5px solid var(--l-muted);
    border-radius: 5px;
    background: transparent;
    cursor: pointer;
    flex-shrink: 0;
    position: relative;
    transition: all 0.2s ease;
  }

  .dark-checkbox:checked {
    background: var(--l-gold);
    border-color: var(--l-gold);
  }

  .dark-checkbox:checked::after {
    content: '';
    position: absolute;
    left: 4px; top: 1px;
    width: 6px; height: 10px;
    border: 2px solid #080a0f;
    border-top: none;
    border-left: none;
    transform: rotate(45deg);
  }

  .dark-checkbox:focus { outline: none; box-shadow: 0 0 0 3px rgba(197,160,85,0.15); }

  .check-label {
    font-size: 0.855rem;
    color: var(--l-soft);
    transition: color var(--tr);
    flex: 1;
  }

  .check-item:has(.dark-checkbox:checked) .check-label {
    color: var(--l-text);
  }

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
</style>

<div class="dark-card">

  {{-- HEADER --}}
  <div class="dark-card-header">
    <i class="bi bi-bell"></i>
    <h5>Notifications</h5>
  </div>

  <div class="dark-card-body">

    <form action="{{ route('settings.notifications.update') }}" method="POST">
      @csrf
      @method('PUT')

      {{-- ── EMAIL ── --}}
      <p class="section-eyebrow">Notifications par email</p>

      <div class="mb-4">
        @foreach([
          'Nouvelles demandes de visite',
          'Demandes de visite confirmées',
          'Nouvelles propriétés dans vos critères',
          'Messages des clients',
          'Rappels de rendez-vous',
          'Newsletter de l\'agence'
        ] as $notification)
        <label class="check-item" for="notif{{ $loop->index }}">
          <input
            class="dark-checkbox"
            type="checkbox"
            name="notifications[]"
            value="{{ Str::slug($notification) }}"
            id="notif{{ $loop->index }}"
            checked
          >
          <span class="check-label">{{ $notification }}</span>
        </label>
        @endforeach
      </div>

      <hr class="dark-hr">

      {{-- ── PUSH ── --}}
      <p class="section-eyebrow">Notifications push</p>

      <div class="mb-4">
        <label class="check-item" for="pushAll">
          <input class="dark-checkbox" type="checkbox" id="pushAll" checked>
          <span class="check-label">Activer les notifications push</span>
        </label>
        <label class="check-item" for="pushVisits">
          <input class="dark-checkbox" type="checkbox" id="pushVisits" checked>
          <span class="check-label">Rappels de visites</span>
        </label>
      </div>

      <button type="submit" class="btn-dark-gold">
        <i class="bi bi-check-lg"></i>
        <span>Enregistrer les préférences</span>
      </button>

    </form>

  </div>
</div>