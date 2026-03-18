@extends('layouts.layout')

@section('title', 'Demandes en Attente')

@section('styles')
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
    --l-success:  #3db97a;
    --l-danger:   #d95f5f;
    --l-warning:  #e0a030;
    --l-blue:     #5585e0;
    --l-radius:   14px;
    --tr:         0.26s cubic-bezier(0.4,0,0.2,1);
  }

  .appt-zone {
    font-family: 'Inter', sans-serif;
    animation: zoneIn 0.5s cubic-bezier(.22,1,.36,1) both;
  }

  @keyframes zoneIn {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ── PAGE HEADER ── */
  .page-head {
    display: flex; justify-content: space-between;
    align-items: flex-start; flex-wrap: wrap;
    gap: 20px; margin-bottom: 36px;
    padding-bottom: 28px;
    border-bottom: 1px solid var(--l-border);
    position: relative;
  }

  .page-head::after {
    content: ''; position: absolute;
    bottom: -1px; left: 0; width: 120px; height: 1px;
    background: linear-gradient(90deg, var(--l-warning), transparent);
    opacity: 0.5;
  }

  .page-eyebrow {
    font-size: 0.6rem; font-weight: 700;
    letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--l-warning); margin-bottom: 8px;
    display: flex; align-items: center; gap: 8px;
  }

  .page-eyebrow::before {
    content: ''; display: inline-block;
    width: 18px; height: 1px; background: var(--l-warning); opacity: 0.6;
  }

  .page-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem; font-weight: 700;
    color: var(--l-text); margin: 0;
    letter-spacing: 0.02em; line-height: 1.1;
  }

  .page-subtitle { font-size: 0.82rem; color: var(--l-muted); margin-top: 6px; }

  /* ── NAV LINKS ── */
  .nav-links { display: flex; gap: 10px; margin-bottom: 32px; flex-wrap: wrap; }

  .nav-link-custom {
    padding: 10px 20px; border-radius: 50px;
    border: 1px solid var(--l-border);
    background: transparent; color: var(--l-soft);
    font-size: 0.845rem; font-weight: 500;
    text-decoration: none; display: flex; align-items: center; gap: 8px;
    transition: all 0.25s ease; letter-spacing: 0.03em;
    position: relative; overflow: hidden;
  }

  .nav-link-custom::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(224,160,48,0.18), rgba(224,160,48,0.06));
    opacity: 0; transition: opacity 0.25s ease;
  }

  .nav-link-custom span,
  .nav-link-custom i { position: relative; z-index: 1; }

  .nav-link-custom:hover { border-color: rgba(224,160,48,0.35); color: var(--l-warning); }
  .nav-link-custom:hover::before { opacity: 1; }

  .nav-link-custom.active {
    border-color: rgba(224,160,48,0.55); color: var(--l-warning);
    box-shadow: 0 0 18px rgba(224,160,48,0.18);
  }

  .nav-link-custom.active::before { opacity: 1; }
  .nav-link-custom i { font-size: 14px; }

  /* ── CARDS GRID ── */
  .appointments-grid { display: grid; gap: 16px; margin-bottom: 32px; }

  .appointment-card {
    background: var(--l-surface);
    border: 1px solid var(--l-border);
    border-radius: var(--l-radius);
    padding: 22px 24px;
    display: grid; grid-template-columns: auto 1fr auto;
    gap: 20px; align-items: center;
    transition: all 0.32s cubic-bezier(0.4,0,0.2,1);
    position: relative; overflow: hidden;
  }

  .appointment-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, var(--l-warning), transparent);
    opacity: 0; transition: opacity var(--tr);
  }

  .appointment-card:hover {
    transform: translateY(-4px);
    border-color: rgba(224,160,48,0.25);
    box-shadow: 0 20px 50px rgba(0,0,0,0.5);
  }

  .appointment-card:hover::before { opacity: 1; }

  /* ── STATUS ICON ── */
  .status-icon {
    width: 60px; height: 60px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; flex-shrink: 0;
    background: rgba(224,160,48,0.15);
    color: var(--l-warning);
    border: 1px solid rgba(224,160,48,0.3);
  }

  /* ── CONTENT ── */
  .appointment-content { flex: 1; }

  .appointment-header {
    display: flex; justify-content: space-between;
    align-items: flex-start; margin-bottom: 12px; gap: 16px;
  }

  .appointment-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem; font-weight: 600;
    color: var(--l-text); margin: 0 0 6px 0; text-decoration: none;
    transition: color var(--tr);
  }

  .appointment-title:hover { color: var(--l-warning); }

  .appointment-type {
    padding: 3px 10px; border-radius: 20px;
    font-size: 0.65rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.07em; white-space: nowrap;
  }

  .appointment-type.sent     { background: rgba(85,133,224,0.15); color: var(--l-blue);    border: 1px solid rgba(85,133,224,0.2); }
  .appointment-type.received { background: rgba(224,160,48,0.12); color: var(--l-warning); border: 1px solid rgba(224,160,48,0.2); }

  .appointment-info {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 10px; margin-bottom: 12px;
  }

  .info-item { display: flex; align-items: center; gap: 8px; color: var(--l-muted); font-size: 0.82rem; }
  .info-item i { color: var(--l-warning); font-size: 14px; }
  .info-item strong { color: var(--l-soft); }

  .appointment-message {
    background: var(--l-surface2);
    border-left: 2px solid var(--l-warning);
    padding: 10px 14px; border-radius: 8px;
    font-size: 0.82rem; color: var(--l-muted); line-height: 1.6;
  }

  /* ── ACTIONS ── */
  .appointment-actions { display: flex; flex-direction: column; gap: 8px; }

  .btn-action {
    padding: 9px 16px; border-radius: 50px;
    font-size: 0.82rem; font-weight: 500;
    border: 1px solid var(--l-border);
    cursor: pointer; display: flex; align-items: center;
    justify-content: center; gap: 7px;
    transition: all 0.25s ease; white-space: nowrap;
    position: relative; overflow: hidden;
    font-family: 'Inter', sans-serif; letter-spacing: 0.03em;
    background: transparent;
  }

  .btn-action span,
  .btn-action i { position: relative; z-index: 1; }

  .btn-action::before {
    content: ''; position: absolute; inset: 0;
    opacity: 0; transition: opacity 0.25s ease;
  }

  .btn-action.btn-confirm { border-color: rgba(61,185,122,0.4); color: var(--l-success); }
  .btn-action.btn-confirm::before { background: linear-gradient(135deg, rgba(61,185,122,0.18), rgba(61,185,122,0.06)); }
  .btn-action.btn-confirm:hover::before { opacity: 1; }
  .btn-action.btn-confirm:hover { box-shadow: 0 0 16px rgba(61,185,122,0.2); }

  .btn-action.btn-reject { border-color: rgba(217,95,95,0.4); color: var(--l-danger); }
  .btn-action.btn-reject::before { background: linear-gradient(135deg, rgba(217,95,95,0.18), rgba(217,95,95,0.06)); }
  .btn-action.btn-reject:hover::before { opacity: 1; }
  .btn-action.btn-reject:hover { box-shadow: 0 0 16px rgba(217,95,95,0.2); }

  .btn-action.btn-cancel { border-color: var(--l-border); color: var(--l-muted); }
  .btn-action.btn-cancel:hover { border-color: rgba(217,95,95,0.4); color: var(--l-danger); }

  .btn-action.btn-details { border-color: rgba(224,160,48,0.35); color: var(--l-warning); }
  .btn-action.btn-details::before { background: linear-gradient(135deg, rgba(224,160,48,0.18), rgba(224,160,48,0.06)); }
  .btn-action.btn-details:hover::before { opacity: 1; }
  .btn-action.btn-details:hover { box-shadow: 0 0 16px rgba(224,160,48,0.2); }

  /* ── EMPTY STATE ── */
  .empty-state {
    background: var(--l-surface); border: 1px solid var(--l-border);
    border-radius: var(--l-radius); padding: 90px 40px;
    text-align: center; position: relative; overflow: hidden;
  }

  .empty-state::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, var(--l-warning), transparent);
    opacity: 0.22;
  }

  .empty-icon {
    width: 100px; height: 100px; margin: 0 auto 26px;
    border-radius: 50%; background: var(--l-surface2);
    border: 1px solid var(--l-border);
    display: flex; align-items: center; justify-content: center;
    font-size: 40px; color: var(--l-muted); opacity: 0.35;
  }

  .empty-state h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.55rem; font-weight: 700; color: var(--l-text); margin-bottom: 10px; }
  .empty-state p  { color: var(--l-muted); font-size: 0.875rem; max-width: 380px; margin: 0 auto; line-height: 1.7; }

  /* ── MODAL ── */
  .modal-content {
    background: var(--l-surface2); border: 1px solid var(--l-border-g);
    border-radius: var(--l-radius); color: var(--l-text);
  }

  .modal-header { border-bottom: 1px solid var(--l-border); padding: 18px 22px; }
  .modal-title  { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; color: var(--l-text); }
  .btn-close    { filter: invert(1) brightness(0.6); }
  .modal-body   { padding: 20px 22px; color: var(--l-soft); font-size: 0.875rem; }
  .modal-body h6 { color: var(--l-warning); font-family: 'Cormorant Garamond', serif; font-size: 1rem; }
  .modal-body hr { border-color: var(--l-border); }
  .modal-body strong { color: var(--l-soft); }
  .modal-body p  { color: var(--l-muted); }
  .modal-footer  { border-top: 1px solid var(--l-border); padding: 14px 22px; }
  .alert-light   { background: var(--l-surface); border: 1px solid var(--l-border); color: var(--l-muted); border-radius: 8px; }
</style>
@endsection

@section('content')
<div class="appt-zone">

  {{-- HEADER --}}
  <div class="page-head">
    <div>
      
      <h1 class="page-title">Demandes en Attente</h1>
      <p class="page-subtitle">Consultez et traitez les demandes en cours de traitement</p>
    </div>
  </div>

  {{-- NAV --}}
  <div class="nav-links">
    <a href="{{ route('appointments.index') }}" class="nav-link-custom">
      <i class="bi bi-grid"></i> <span>Toutes les demandes</span>
    </a>
    <a href="{{ route('appointments.pending') }}" class="nav-link-custom active">
      <i class="bi bi-clock"></i> <span>En attente</span>
    </a>
    <a href="{{ route('appointments.confirmed') }}" class="nav-link-custom">
      <i class="bi bi-check-circle"></i> <span>Confirmées</span>
    </a>
  </div>

  {{-- GRID --}}
  @if($appointments->isEmpty())
    <div class="empty-state">
      <div class="empty-icon"><i class="bi bi-clock-history"></i></div>
      <h3>Aucune demande en attente</h3>
      <p>Il n'y a aucune demande en attente pour le moment.</p>
    </div>
  @else
    <div class="appointments-grid">
      @foreach($appointments as $appointment)
      <div class="appointment-card">

        {{-- Status Icon --}}
        <div class="status-icon">
          <i class="bi bi-clock-history"></i>
        </div>

        {{-- Content --}}
        <div class="appointment-content">
          <div class="appointment-header">
            <a href="{{ route('properties.show', $appointment->property_id) }}" class="appointment-title">
              {{ $appointment->property->title }}
            </a>
            <span class="appointment-type {{ $appointment->user_id === auth()->id() ? 'sent' : 'received' }}">
              @if($appointment->user_id === auth()->id())
                <i class="bi bi-arrow-up-right"></i> Envoyée
              @else
                <i class="bi bi-arrow-down-left"></i> Reçue
              @endif
            </span>
          </div>
          <div class="appointment-info">
            <div class="info-item">
              <i class="bi bi-calendar"></i>
              <strong>{{ $appointment->visit_date->format('d/m/Y') }}</strong>
            </div>
            <div class="info-item">
              <i class="bi bi-clock"></i>
              <strong>{{ $appointment->visit_time }}</strong>
            </div>
            <div class="info-item">
              <i class="bi bi-person"></i>
              @if($appointment->user_id === auth()->id())
                Propriétaire: <strong>{{ $appointment->owner->first_name }}</strong>
              @else
                Demandeur: <strong>{{ $appointment->user->first_name }}</strong>
              @endif
            </div>
          </div>
          @if($appointment->message)
          <div class="appointment-message">
            <i class="bi bi-chat-left-text me-2"></i>{{ $appointment->message }}
          </div>
          @endif
        </div>

        {{-- Actions --}}
        <div class="appointment-actions">
          @if($appointment->status === 'pending' && $appointment->property->owner_id === auth()->id())
            <form action="{{ route('appointments.accept', $appointment->id) }}" method="POST">
              @csrf @method('PATCH')
              <button type="submit" class="btn-action btn-confirm">
                <i class="bi bi-check-lg"></i> <span>Accepter</span>
              </button>
            </form>
            <form action="{{ route('appointments.reject', $appointment->id) }}" method="POST">
              @csrf @method('PATCH')
              <button type="submit" class="btn-action btn-reject" onclick="return confirm('Refuser cette demande ?')">
                <i class="bi bi-x-lg"></i> <span>Refuser</span>
              </button>
            </form>
          @elseif($appointment->user_id === auth()->id())
            <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST">
              @csrf @method('DELETE')
              <button type="submit" class="btn-action btn-cancel" onclick="return confirm('Annuler cette demande ?')">
                <i class="bi bi-x-circle"></i> <span>Annuler</span>
              </button>
            </form>
          @endif
          <button type="button" class="btn-action btn-details"
                  data-bs-toggle="modal"
                  data-bs-target="#appointmentDetail{{ $appointment->id }}">
            <i class="bi bi-eye"></i> <span>Détails</span>
          </button>
        </div>
      </div>

      {{-- Modal --}}
      <div class="modal fade" id="appointmentDetail{{ $appointment->id }}" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Détails de la demande</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <h6>{{ $appointment->property->title }}</h6>
              <hr>
              <div class="mb-3">
                <strong>Date de visite :</strong>
                <p>{{ $appointment->visit_date->format('d/m/Y') }} à {{ $appointment->visit_time }}</p>
              </div>
              <div class="mb-3">
                <strong>Statut :</strong>
                <p><span class="badge bg-warning">En attente</span></p>
              </div>
              @if($appointment->message)
              <div class="mb-3">
                <strong>Message :</strong>
                <p class="alert alert-light">{{ $appointment->message }}</p>
              </div>
              @endif
              <div class="row">
                <div class="col-6">
                  <strong>Demandeur :</strong>
                  <p>{{ $appointment->user->first_name }} {{ $appointment->user->last_name }}</p>
                </div>
                <div class="col-6">
                  <strong>Propriétaire :</strong>
                  <p>{{ $appointment->owner->first_name }} {{ $appointment->owner->last_name }}</p>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div class="d-flex justify-content-center">
      {{ $appointments->links() }}
    </div>
  @endif

</div>
@endsection