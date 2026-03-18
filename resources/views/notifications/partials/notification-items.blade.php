@foreach($notifications as $notification)
    <div class="notification-item {{ !$notification->read ? 'unread' : '' }}" data-id="{{ $notification->idnotification }}">
        <div class="notification-icon">
            @switch($notification->type)
                @case('inscription')
                    <i class="bi bi-person-plus-fill"></i>
                    @break
                @case('new_produits')
                    <i class="bi bi-plus-circle-fill"></i>
                    @break
                @case('new_rendez_vous')
                    <i class="bi bi-calendar-plus-fill"></i>
                    @break
                @case('rendez_vous_confirme')
                    <i class="bi bi-check-circle-fill"></i>
                    @break
                @case('rendez_vous_rejete')
                    <i class="bi bi-x-circle-fill"></i>
                    @break
                @default
                    <i class="bi bi-bell-fill"></i>
            @endswitch
        </div>

        <div class="notification-content">
            <div class="notification-message">
                {{ $notification->message }}
            </div>
            <div class="notification-meta">
                <span class="notification-time">
                    <i class="bi bi-clock"></i>
                    {{ $notification->time->diffForHumans() }}
                </span>
                @if($notification->emetteur)
                    <span>par {{ $notification->emetteur->name }}</span>
                @endif
            </div>
        </div>

        <div class="notification-actions">
            <button class="btn-eye {{ $notification->read ? 'read' : '' }}"
                    onclick="toggleRead({{ $notification->idnotification }})"
                    title="{{ $notification->read ? 'Déjà lu' : 'Marquer comme lu' }}">
                <i class="bi {{ $notification->read ? 'bi-eye-fill' : 'bi-eye' }}"></i>
            </button>
        </div>
    </div>
@endforeach

@if($notifications->isEmpty())
    <div class="notification-empty">
        <i class="bi bi-bell"></i>
        <p>Aucune nouvelle notification</p>
    </div>
@endif