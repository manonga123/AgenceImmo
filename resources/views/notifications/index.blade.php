@extends('layouts.layout')

@section('title', 'Mes Notifications')

@section('styles')
<style>
    .notifications-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .notifications-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .notifications-header h1 {
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--text);
        margin: 0;
    }

    .btn-mark-all {
        background: var(--surface2);
        border: 1px solid var(--border);
        color: var(--text-soft);
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-mark-all:hover {
        border-color: var(--gold);
        color: var(--gold);
        background: var(--gold-dim);
    }

    .notifications-list {
        background: var(--surface);
        border-radius: 16px;
        border: 1px solid var(--border);
        overflow: hidden;
    }

    .notification-item {
        display: flex;
        align-items: center;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        transition: all 0.2s ease;
        position: relative;
        background: var(--surface);
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-item.unread {
        background: rgba(197, 160, 85, 0.05);
        border-left: 3px solid var(--gold);
    }

    .notification-item:hover {
        background: var(--surface2);
    }

    .notification-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: var(--gold-dim);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.25rem;
        color: var(--gold);
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .notification-content {
        flex: 1;
        min-width: 0;
    }

    .notification-message {
        font-size: 1rem;
        color: var(--text);
        margin-bottom: 0.25rem;
        font-weight: 500;
    }

    .notification-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .notification-time {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .notification-type {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        background: var(--surface2);
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--gold);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .notification-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-left: 1rem;
    }

    .btn-eye {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--surface2);
        border: 1px solid var(--border);
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-eye:hover {
        border-color: var(--gold);
        color: var(--gold);
        background: var(--gold-dim);
    }

    .btn-eye.read {
        color: var(--success);
        border-color: var(--success);
    }

    .btn-eye.read:hover {
        color: var(--success);
        border-color: var(--success);
        background: rgba(61, 185, 122, 0.1);
    }

    .notification-badge {
        background: var(--danger);
        color: white;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.2rem 0.5rem;
        border-radius: 20px;
        margin-left: 0.5rem;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--surface);
        border-radius: 16px;
        border: 1px solid var(--border);
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        color: var(--text);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    .pagination {
        margin-top: 2rem;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .notification-item {
            flex-wrap: wrap;
            padding: 1rem;
        }

        .notification-content {
            width: calc(100% - 68px);
        }

        .notification-actions {
            width: 100%;
            margin-left: 0;
            margin-top: 1rem;
            justify-content: flex-end;
        }

        .notifications-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="notifications-container">
    <div class="notifications-header">
        <h1>
            Mes Notifications
            @if($query->total() > 0)
                <span class="notification-badge">{{ $query->total() }}</span>
            @endif
        </h1>
        @if($query->where('read', false)->count() > 0)
            <button class="btn-mark-all" onclick="markAllAsRead()">
                <i class="bi bi-check2-all"></i>
                Tout marquer comme lu
            </button>
        @endif
    </div>

    @if($query->count() > 0)
        <div class="notifications-list">
            @foreach($query as $notification)
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
                            <span class="notification-type">
                                @switch($notification->type)
                                    @case('inscription') Nouvelle inscription @break
                                    @case('new_produits') Nouveau produit @break
                                    @case('new_rendez_vous') Nouveau rendez-vous @break
                                    @case('rendez_vous_confirme') Rendez-vous confirmé @break
                                    @case('rendez_vous_rejete') Rendez-vous refusé @break
                                    @default Notification
                                @endswitch
                            </span>
                            @if($notification->emetteur)
                                <span>de {{ $notification->emetteur->name }}</span>
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
        </div>

        <div class="pagination">
            {{ $query->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="bi bi-bell-slash-fill"></i>
            <h3>Aucune notification</h3>
            <p>Vous n'avez pas encore de notifications.</p>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Marquer une notification comme lue/non lue
    function toggleRead(id) {
        fetch(`/notifications/${id}/toggle-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const notification = document.querySelector(`.notification-item[data-id="${id}"]`);
                const btn = notification.querySelector('.btn-eye');
                
                if (data.read) {
                    notification.classList.remove('unread');
                    btn.classList.add('read');
                    btn.querySelector('i').className = 'bi bi-eye-fill';
                    btn.title = 'Déjà lu';
                } else {
                    notification.classList.add('unread');
                    btn.classList.remove('read');
                    btn.querySelector('i').className = 'bi bi-eye';
                    btn.title = 'Marquer comme lu';
                }
            }
        })
        .catch(error => console.error('Erreur:', error));
    }

    // Marquer toutes les notifications comme lues
    function markAllAsRead() {
        if (!confirm('Voulez-vous marquer toutes les notifications comme lues ?')) {
            return;
        }

        fetch('{{ route("notifications.mark-all-read") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelectorAll('.notification-item').forEach(item => {
                    item.classList.remove('unread');
                    const btn = item.querySelector('.btn-eye');
                    btn.classList.add('read');
                    btn.querySelector('i').className = 'bi bi-eye-fill';
                    btn.title = 'Déjà lu';
                });
                
                document.querySelector('.btn-mark-all').remove();
            }
        })
        .catch(error => console.error('Erreur:', error));
    }

    // Rafraîchir les notifications toutes les 30 secondes
    setInterval(() => {
        fetch('{{ route("notifications.unread") }}', {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Mettre à jour le compteur dans le header
            updateNotificationCount(data.count);
        })
        .catch(error => console.error('Erreur:', error));
    }, 30000);

    function updateNotificationCount(count) {
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            if (count > 0) {
                badge.textContent = count;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }
    }
</script>
@endsection