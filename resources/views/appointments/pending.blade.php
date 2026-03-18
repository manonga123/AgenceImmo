@extends('users.header')

@section('title', 'Demandes en Attente')

@section('styles')
<style>
    /* ══════════════════════════════════════════
       DEMANDES EN ATTENTE — Design System sidebar dark luxury
       (HTML inchangé — styles uniquement)
    ══════════════════════════════════════════ */

    /* ── Header ── */
    .appointments-header {
        margin-bottom: 32px;
    }

    .appointments-title {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }

    .appointments-title h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 34px;
        font-weight: 700;
        color: var(--text);
        margin: 0;
        letter-spacing: 0.02em;
    }

    .appointments-title i {
        font-size: 30px;
        color: #fbbf24;
        filter: drop-shadow(0 0 8px rgba(245,158,11,0.35));
    }

    /* ── Navigation Links ── */
    .nav-links {
        display: flex;
        gap: 10px;
        margin-bottom: 32px;
        flex-wrap: wrap;
    }

    .nav-link-custom {
        padding: 10px 20px;
        border-radius: 50px;
        background: transparent;
        color: var(--text-soft);
        font-weight: 500;
        font-size: 13px;
        letter-spacing: 0.02em;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.25s ease;
        border: 1px solid var(--border);
    }

    .nav-link-custom:hover {
        border-color: var(--border-glow);
        color: var(--gold);
        background: var(--gold-dim);
    }

    .nav-link-custom.active {
        background: rgba(245,158,11,0.12);
        border-color: rgba(245,158,11,0.35);
        color: #fbbf24;
        box-shadow: 0 0 14px rgba(245,158,11,0.1);
    }

    .nav-link-custom i { font-size: 14px; }

    /* ── Appointments Grid ── */
    .appointments-grid {
        display: grid;
        gap: 16px;
        margin-bottom: 32px;
    }

    .appointment-card {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 22px 24px;
        border: 1px solid var(--border);
        transition: all 0.3s ease;
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 20px;
        align-items: center;
        animation: fadeInUp 0.4s cubic-bezier(0.22,1,.36,1) both;
    }

    .appointment-card:hover {
        transform: translateY(-3px);
        border-color: rgba(245,158,11,0.28);
        box-shadow: 0 12px 36px rgba(0,0,0,0.4), 0 0 0 1px rgba(245,158,11,0.07);
    }

    .appointment-card:nth-child(1) { animation-delay: 0.04s; }
    .appointment-card:nth-child(2) { animation-delay: 0.08s; }
    .appointment-card:nth-child(3) { animation-delay: 0.12s; }
    .appointment-card:nth-child(4) { animation-delay: 0.16s; }

    /* ── Status Icon ── */
    .status-icon {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
        background: rgba(245,158,11,0.12);
        color: #fbbf24;
        border: 1px solid rgba(245,158,11,0.25);
    }

    /* ── Appointment Content ── */
    .appointment-content { flex: 1; }

    .appointment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
        gap: 16px;
    }

    .appointment-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 18px;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 6px 0;
        text-decoration: none;
        letter-spacing: 0.02em;
        transition: color 0.2s ease;
    }

    .appointment-title:hover { color: var(--gold-light); }

    .appointment-type {
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.05em;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .appointment-type.sent {
        background: rgba(85,133,224,0.12);
        color: #93b4f0;
        border: 1px solid rgba(85,133,224,0.22);
    }

    .appointment-type.received {
        background: rgba(245,158,11,0.12);
        color: #fbbf24;
        border: 1px solid rgba(245,158,11,0.22);
    }

    .appointment-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 10px;
        margin-bottom: 12px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 7px;
        color: var(--text-soft);
        font-size: 13px;
    }

    .info-item i {
        color: var(--gold);
        font-size: 14px;
        flex-shrink: 0;
    }

    .info-item strong { color: var(--text); font-weight: 600; }

    .appointment-message {
        background: var(--surface2);
        border-left: 2px solid rgba(245,158,11,0.5);
        padding: 11px 14px;
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        font-size: 13px;
        color: var(--text-soft);
        line-height: 1.6;
    }

    /* ── Actions ── */
    .appointment-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .btn-action {
        padding: 9px 16px;
        border-radius: var(--radius-sm);
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.03em;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        transition: all 0.25s ease;
        white-space: nowrap;
    }

    .btn-action.btn-confirm {
        background: linear-gradient(135deg, rgba(61,185,122,0.9), rgba(5,150,105,0.9));
        color: white;
    }

    .btn-action.btn-confirm:hover {
        filter: brightness(1.12);
        box-shadow: 0 0 16px rgba(61,185,122,0.3);
        transform: translateY(-1px);
    }

    .btn-action.btn-reject {
        background: rgba(217,95,95,0.15);
        color: #f09090;
        border: 1px solid rgba(217,95,95,0.3);
    }

    .btn-action.btn-reject:hover {
        background: rgba(217,95,95,0.25);
        border-color: rgba(217,95,95,0.5);
        box-shadow: 0 0 14px rgba(217,95,95,0.2);
        transform: translateY(-1px);
    }

    .btn-action.btn-cancel {
        background: transparent;
        color: var(--text-soft);
        border: 1px solid var(--border);
    }

    .btn-action.btn-cancel:hover {
        border-color: rgba(217,95,95,0.4);
        color: #f09090;
        background: rgba(217,95,95,0.08);
    }

    .btn-action.btn-details {
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        color: #080a0f;
        border: none;
    }

    .btn-action.btn-details:hover {
        filter: brightness(1.1);
        box-shadow: 0 0 16px rgba(197,160,85,0.28);
        transform: translateY(-1px);
    }

    /* ── Modal dark ── */
    .modal-content {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        color: var(--text);
    }

    .modal-header {
        border-bottom: 1px solid var(--border);
        padding: 20px 24px;
    }

    .modal-header .modal-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.2rem;
        color: var(--text);
    }

    .modal-body {
        padding: 24px;
        color: var(--text-soft);
        font-size: 14px;
    }

    .modal-body h6 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        color: var(--text);
        font-weight: 700;
        margin-bottom: 14px;
    }

    .modal-body hr {
        border-color: var(--border);
        opacity: 1;
        margin: 14px 0;
    }

    .modal-body strong { color: var(--text-soft); font-weight: 600; }
    .modal-body p { color: var(--text); margin-top: 4px; }

    .modal-body .alert-light {
        background: var(--surface2);
        border: 1px solid var(--border);
        color: var(--text-soft);
        border-radius: var(--radius-sm);
        padding: 12px 14px;
        font-size: 13px;
        line-height: 1.6;
    }

    .modal-body .badge.bg-warning {
        background: rgba(245,158,11,0.18) !important;
        color: #fbbf24;
        border: 1px solid rgba(245,158,11,0.3);
        font-weight: 600;
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 50px;
    }

    .modal-footer {
        border-top: 1px solid var(--border);
        padding: 16px 24px;
    }

    .modal-footer .btn-secondary {
        background: transparent;
        border: 1px solid var(--border);
        color: var(--text-soft);
        border-radius: var(--radius-sm);
        padding: 9px 20px;
        font-size: 13px;
        transition: all 0.2s ease;
    }

    .modal-footer .btn-secondary:hover {
        border-color: var(--border-glow);
        color: var(--text);
    }

    .btn-close { filter: invert(0.5) brightness(1.4); }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 70px 30px;
        background: var(--surface);
        border-radius: var(--radius);
        border: 1px solid var(--border);
    }

    .empty-state i {
        font-size: 64px;
        color: #fbbf24;
        opacity: 0.4;
        margin-bottom: 20px;
        display: block;
    }

    .empty-state h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 10px;
    }

    .empty-state p {
        color: var(--text-soft);
        font-size: 14px;
        margin-bottom: 0;
    }

    /* ── Pagination ── */
    .pagination .page-link {
        background: var(--surface2);
        border-color: var(--border);
        color: var(--text-soft);
        border-radius: var(--radius-sm) !important;
        margin: 0 3px;
        transition: all 0.2s ease;
    }

    .pagination .page-link:hover {
        background: var(--gold-dim);
        border-color: var(--border-glow);
        color: var(--gold);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        border-color: transparent;
        color: #080a0f;
        font-weight: 700;
    }

    /* ── Animation ── */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .appointment-card {
            grid-template-columns: auto 1fr;
            grid-template-rows: auto auto;
        }

        .appointment-actions {
            grid-column: 1 / -1;
            flex-direction: row;
            flex-wrap: wrap;
        }

        .btn-action { flex: 1; min-width: 120px; }
    }

    @media (max-width: 576px) {
        .appointments-title h1 { font-size: 26px; }
        .appointment-card { padding: 16px; gap: 14px; }
        .status-icon { width: 46px; height: 46px; font-size: 18px; }
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="appointments-header">
        <div class="appointments-title">
            <i class="bi bi-clock-history"></i>
            <h1>Demandes en Attente</h1>
        </div>
        
        <!-- Simple Navigation Links -->
        <div class="nav-links">
            <a href="{{ route('appointments.index') }}" class="nav-link-custom">
                <i class="bi bi-grid"></i>
                Toutes mes demandes
            </a>
            <a href="{{ route('appointments.pending') }}" class="nav-link-custom active">
                <i class="bi bi-clock"></i>
                Demandes en attente
            </a>
            <a href="{{ route('appointments.confirmed') }}" class="nav-link-custom">
                <i class="bi bi-check-circle"></i>
                Demandes confirmées
            </a>
        </div>
    </div>

    <!-- Appointments Grid -->
    @if($appointments->isEmpty())
        <div class="empty-state">
            <i class="bi bi-clock-history"></i>
            <h3>Aucune demande en attente</h3>
            <p>Vous n'avez aucune demande de visite en attente pour le moment.</p>
        </div>
    @else
        <div class="appointments-grid">
            @foreach($appointments as $appointment)
            <div class="appointment-card">
                <!-- Status Icon -->
                <div class="status-icon">
                    <i class="bi bi-clock-history"></i>
                </div>

                <!-- Appointment Content -->
                <div class="appointment-content">
                    <div class="appointment-header">
                        <a href="{{ route('properties.show', $appointment->property_id) }}" 
                           class="appointment-title">
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
                        <i class="bi bi-chat-left-text me-2"></i>
                        {{ $appointment->message }}
                    </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="appointment-actions">
                    @if($appointment->property->owner_id === auth()->id())
                        <!-- Je suis le propriétaire, je peux accepter/refuser -->
                        <form action="{{ route('appointments.accept', $appointment->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-action btn-confirm">
                                <i class="bi bi-check-lg"></i>
                                Accepter
                            </button>
                        </form>
                        <form action="{{ route('appointments.reject', $appointment->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-action btn-reject" 
                                    onclick="return confirm('Refuser cette demande ?')">
                                <i class="bi bi-x-lg"></i>
                                Refuser
                            </button>
                        </form>
                    @elseif($appointment->user_id === auth()->id())
                        <!-- Je suis le demandeur, je peux annuler -->
                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-cancel" 
                                    onclick="return confirm('Annuler cette demande ?')">
                                <i class="bi bi-x-circle"></i>
                                Annuler
                            </button>
                        </form>
                    @endif
                    
                    <button type="button" class="btn-action btn-details" 
                            data-bs-toggle="modal" 
                            data-bs-target="#appointmentDetail{{ $appointment->id }}">
                        <i class="bi bi-eye"></i>
                        Détails
                    </button>
                </div>
            </div>

            <!-- Modal pour les détails -->
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
                                <strong>Date de visite:</strong>
                                <p>{{ $appointment->visit_date->format('d/m/Y') }} à {{ $appointment->visit_time }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Statut:</strong>
                                <p>
                                    <span class="badge bg-warning">
                                        <i class="bi bi-clock me-1"></i>
                                        En attente
                                    </span>
                                </p>
                            </div>
                            
                            @if($appointment->message)
                            <div class="mb-3">
                                <strong>Message:</strong>
                                <p class="alert alert-light">{{ $appointment->message }}</p>
                            </div>
                            @endif
                            
                            <div class="row">
                                <div class="col-6">
                                    <strong>Demandeur:</strong>
                                    <p>{{ $appointment->user->first_name }} {{ $appointment->user->last_name }}</p>
                                </div>
                                <div class="col-6">
                                    <strong>Propriétaire:</strong>
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

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $appointments->links() }}
        </div>
    @endif
</div>
@endsection