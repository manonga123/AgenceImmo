@php
    $statusColors = [
        'pending' => 'warning',
        'confirmed' => 'success',
        'rejected' => 'danger',
        'cancelled' => 'secondary'
    ];
    
    $statusIcons = [
        'pending' => 'bi-clock',
        'confirmed' => 'bi-check-circle',
        'rejected' => 'bi-x-circle',
        'cancelled' => 'bi-calendar-x'
    ];
@endphp

<tr>
    <td>
        @if($appointment->user_id === auth()->id())
            <span class="badge bg-info">
                <i class="bi bi-arrow-up-right me-1"></i> Envoyée
            </span>
        @else
            <span class="badge bg-warning">
                <i class="bi bi-arrow-down-left me-1"></i> Reçue
            </span>
        @endif
    </td>
    <td>
        <a href="{{ route('properties.show', $appointment->property_id) }}" class="text-decoration-none">
            {{ $appointment->property->title }}
        </a>
        <br>
        <small class="text-muted">
            @if($appointment->user_id === auth()->id())
                Propriétaire: {{ $appointment->owner->first_name }}
            @else
                Demandeur: {{ $appointment->user->first_name }}
            @endif
        </small>
    </td>
    <td>
        <strong>{{ $appointment->visit_date->format('d/m/Y') }}</strong>
        <br>
        <small class="text-muted">{{ $appointment->visit_time }}</small>
    </td>
    <td>
        <span class="badge bg-{{ $statusColors[$appointment->status] }}">
            <i class="bi {{ $statusIcons[$appointment->status] }} me-1"></i>
            {{ ucfirst($appointment->status) }}
        </span>
    </td>
    <td>
        <!-- Actions selon le statut et la propriété -->
        @if($appointment->user_id === auth()->id())
            {{-- Je suis celui qui a fait la demande --}}
            @if(in_array($appointment->status, ['pending', 'confirmed']))
                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                            onclick="return confirm('Annuler cette demande de visite ?')"
                            title="Annuler la demande">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </form>
            @endif
        @elseif($appointment->property->owner_id === auth()->id())
            {{-- Je suis le propriétaire --}}
            @if($appointment->status === 'pending')
                <div class="btn-group btn-group-sm">
                    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="btn btn-success btn-sm" title="Accepter">
                            <i class="bi bi-check"></i>
                        </button>
                    </form>
                    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="btn btn-danger btn-sm" title="Refuser">
                            <i class="bi bi-x"></i>
                        </button>
                    </form>
                </div>
            @elseif($appointment->status === 'confirmed')
                <button class="btn btn-sm btn-outline-success" disabled>
                    <i class="bi bi-check me-1"></i> Confirmée
                </button>
            @endif
        @endif
        
        <!-- Bouton pour voir les détails -->
        <button type="button" class="btn btn-sm btn-outline-info" 
                data-bs-toggle="modal" 
                data-bs-target="#appointmentDetail{{ $appointment->id }}"
                title="Voir les détails">
            <i class="bi bi-eye"></i>
        </button>
    </td>
    <td>
        <small>{{ $appointment->created_at->format('d/m/Y') }}</small>
        <br>
        <small class="text-muted">{{ $appointment->created_at->format('H:i') }}</small>
    </td>
</tr>

<!-- Modal pour les détails de la demande -->
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
                        <span class="badge bg-{{ $statusColors[$appointment->status] }}">
                            <i class="bi {{ $statusIcons[$appointment->status] }} me-1"></i>
                            {{ ucfirst($appointment->status) }}
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