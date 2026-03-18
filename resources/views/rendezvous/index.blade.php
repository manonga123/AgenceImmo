@extends('layouts.layout')

@section('title', 'Mes Demandes de Visite')

@section('styles')
<style>
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
        font-size: 32px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        letter-spacing: -0.5px;
    }

    .appointments-title i {
        font-size: 36px;
        color: var(--info-color);
    }

    /* Simple Navigation Links */
    .nav-links {
        display: flex;
        gap: 12px;
        margin-bottom: 32px;
        flex-wrap: wrap;
    }

    .nav-link-custom {
        padding: 12px 24px;
        border-radius: 12px;
        background: white;
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: 2px solid var(--border-color);
        box-shadow: var(--shadow-sm);
    }

    .nav-link-custom:hover {
        background: var(--bg-secondary);
        color: var(--text-primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .nav-link-custom.active {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        border-color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .nav-link-custom i {
        font-size: 16px;
    }

    /* Stats Overview */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

   
    .stat-info h3 {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-secondary);
        margin: 0 0 4px 0;
    }

    .stat-info .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1;
    }

    /* Appointments Grid */
    .appointments-grid {
        display: grid;
        gap: 20px;
        margin-bottom: 32px;
    }

    .appointment-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 20px;
        align-items: center;
    }

    .appointment-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    /* Status Icon */
    .status-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        flex-shrink: 0;
    }

    .status-icon.pending {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        color: var(--warning-color);
    }

    .status-icon.confirmed {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: var(--success-color);
    }

    .status-icon.rejected {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: var(--danger-color);
    }

    .status-icon.cancelled {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
        color: var(--text-secondary);
    }

    /* Appointment Content */
    .appointment-content {
        flex: 1;
    }

    .appointment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
        gap: 16px;
    }

    .appointment-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 8px 0;
        text-decoration: none;
    }

    .appointment-title:hover {
        color: var(--primary-color);
    }

    .appointment-type {
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .appointment-type.sent {
        background: #dbeafe;
        color: var(--info-color);
    }

    .appointment-type.received {
        background: #fef3c7;
        color: var(--warning-color);
    }

    .appointment-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
        margin-bottom: 12px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-secondary);
        font-size: 14px;
    }

    .info-item i {
        color: var(--primary-color);
        font-size: 16px;
    }

    .info-item strong {
        color: var(--text-primary);
    }

    .appointment-message {
        background: var(--bg-secondary);
        border-left: 3px solid var(--primary-color);
        padding: 12px;
        border-radius: 8px;
        font-size: 14px;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    /* Appointment Actions */
    .appointment-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .btn-action {
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-action.btn-confirm {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-action.btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-action.btn-reject {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-action.btn-reject:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-action.btn-cancel {
        background: white;
        color: var(--text-secondary);
        border: 2px solid var(--border-color);
    }

    .btn-action.btn-cancel:hover {
        background: var(--bg-secondary);
        color: var(--danger-color);
        border-color: var(--danger-color);
    }

    .btn-action.btn-details {
        background: white;
        color: var(--info-color);
        border: 2px solid var(--info-color);
    }

    .btn-action.btn-details:hover {
        background: var(--info-color);
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
    }

    .empty-state i {
        font-size: 64px;
        color: var(--text-secondary);
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 20px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 8px;
    }

    .empty-state p {
        color: var(--text-secondary);
        margin-bottom: 0;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="appointments-header">
        <div class="appointments-title">
            <i class="bi bi-calendar-check"></i>
            <h1>Mes Demandes de Visite</h1>
        </div>
        
        <!-- Simple Navigation Links -->
        <div class="nav-links">
            <a href="{{ route('appointments.index') }}" class="nav-link-custom active">
                <i class="bi bi-grid"></i>
                Toutes mes demandes
            </a>
            <a href="{{ route('appointments.pending') }}" class="nav-link-custom">
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
            <i class="bi bi-calendar-x"></i>
            <h3>Aucune demande de visite</h3>
            <p>Vous n'avez aucune demande de visite pour le moment.</p>
        </div>
    @else
        <div class="appointments-grid">
            @foreach($appointments as $appointment)
            <div class="appointment-card">
                <!-- Status Icon -->
                <div class="status-icon {{ $appointment->status }}">
                    @if($appointment->status === 'pending')
                        <i class="bi bi-clock-history"></i>
                    @elseif($appointment->status === 'confirmed')
                        <i class="bi bi-check-circle-fill"></i>
                    @elseif($appointment->status === 'rejected')
                        <i class="bi bi-x-circle-fill"></i>
                    @else
                        <i class="bi bi-slash-circle"></i>
                    @endif
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
                    @if($appointment->status === 'pending' && $appointment->property->owner_id === auth()->id())
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
                    @elseif($appointment->user_id === auth()->id() && in_array($appointment->status, ['pending', 'confirmed']))
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
                                    @if($appointment->status === 'pending')
                                        <span class="badge bg-warning">En attente</span>
                                    @elseif($appointment->status === 'confirmed')
                                        <span class="badge bg-success">Confirmée</span>
                                    @elseif($appointment->status === 'rejected')
                                        <span class="badge bg-danger">Refusée</span>
                                    @else
                                        <span class="badge bg-secondary">Annulée</span>
                                    @endif
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