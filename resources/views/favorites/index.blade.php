@extends('users.header')

@section('title', 'Mes Favoris')

@section('styles')
<style>
    /* ══════════════════════════════════════════
       FAVORIS — Design System sidebar dark luxury
    ══════════════════════════════════════════ */

    /* ── Header ── */
    .favorites-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .favorites-title {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .favorites-title h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 34px;
        font-weight: 700;
        color: var(--text);
        margin: 0;
        letter-spacing: 0.02em;
    }

    .favorites-title i {
        font-size: 30px;
        color: #f09090;
        filter: drop-shadow(0 0 8px rgba(217,95,95,0.4));
    }

    .btn-back {
        background: transparent;
        color: var(--text-soft);
        padding: 10px 22px;
        border-radius: 50px;
        border: 1px solid var(--border);
        font-weight: 500;
        font-size: 13px;
        letter-spacing: 0.03em;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .btn-back:hover {
        border-color: var(--border-glow);
        color: var(--gold);
        background: var(--gold-dim);
    }

    /* ── Favorites Count ── */
    .favorites-count {
        background: var(--surface);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        padding: 18px 24px;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 16px;
        animation: fadeInUp 0.4s cubic-bezier(0.22,1,.36,1) both;
    }

    .count-icon {
        width: 52px;
        height: 52px;
        border-radius: var(--radius-sm);
        background: rgba(217,95,95,0.1);
        border: 1px solid rgba(217,95,95,0.22);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #f09090;
        flex-shrink: 0;
    }

    .count-info { flex: 1; }

    .count-label {
        font-size: 12px;
        font-weight: 500;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.07em;
        margin-bottom: 4px;
    }

    .count-value {
        font-family: 'Cormorant Garamond', serif;
        font-size: 28px;
        font-weight: 700;
        color: var(--text);
        line-height: 1;
    }

    /* ── Favorites Grid ── */
    .favorites-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .favorite-card {
        background: var(--surface);
        border-radius: var(--radius);
        overflow: hidden;
        border: 1px solid var(--border);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        position: relative;
        animation: fadeInUp 0.5s cubic-bezier(0.22,1,.36,1) both;
    }

    .favorite-card:hover {
        transform: translateY(-8px);
        border-color: var(--border-glow);
        box-shadow:
            0 20px 48px rgba(0,0,0,0.5),
            0 0 0 1px rgba(197,160,85,0.08),
            0 0 32px rgba(197,160,85,0.05);
    }

    .favorite-card:nth-child(1) { animation-delay: 0.04s; }
    .favorite-card:nth-child(2) { animation-delay: 0.08s; }
    .favorite-card:nth-child(3) { animation-delay: 0.12s; }
    .favorite-card:nth-child(4) { animation-delay: 0.16s; }
    .favorite-card:nth-child(5) { animation-delay: 0.20s; }
    .favorite-card:nth-child(6) { animation-delay: 0.24s; }

    /* ── Image ── */
    .favorite-image-wrapper {
        position: relative;
        height: 250px;
        background: var(--surface2);
        overflow: hidden;
    }

    .favorite-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.9;
        transition: transform 0.5s ease, opacity 0.3s ease;
    }

    .favorite-card:hover .favorite-image {
        transform: scale(1.07);
        opacity: 1;
    }

    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .no-image i { font-size: 56px; color: var(--text-muted); }

    /* Image Overlay */
    .image-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 40%, rgba(6,8,16,0.6) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .favorite-card:hover .image-overlay { opacity: 1; }

    /* ── Remove Button ── */
    .btn-remove-favorite {
        position: absolute;
        top: 14px;
        right: 14px;
        z-index: 2;
        width: 38px;
        height: 38px;
        border-radius: var(--radius-sm);
        border: 1px solid rgba(217,95,95,0.35);
        background: rgba(8,10,15,0.85);
        color: #f09090;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.25s ease;
        backdrop-filter: blur(10px);
    }

    .btn-remove-favorite:hover {
        background: rgba(217,95,95,0.2);
        border-color: rgba(217,95,95,0.55);
        transform: scale(1.08);
        box-shadow: 0 0 16px rgba(217,95,95,0.25);
    }

    .btn-remove-favorite i {
        font-size: 16px;
        animation: heartBeat 2s ease-in-out infinite;
    }

    /* ── Added Date Badge ── */
    .added-date-badge {
        position: absolute;
        bottom: 14px;
        left: 14px;
        background: rgba(8,10,15,0.88);
        border: 1px solid var(--border);
        color: var(--text-soft);
        padding: 6px 13px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(12px);
        z-index: 2;
        letter-spacing: 0.02em;
    }

    .added-date-badge i {
        font-size: 12px;
        color: #f09090;
    }

    /* ── Card Content ── */
    .favorite-content {
        padding: 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
        border-top: 1px solid var(--border);
    }

    .favorite-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 10px;
        line-height: 1.3;
        letter-spacing: 0.02em;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .favorite-location {
        display: flex;
        align-items: center;
        gap: 7px;
        color: var(--text-soft);
        font-size: 13px;
        margin-bottom: 18px;
    }

    .favorite-location i {
        font-size: 14px;
        color: #f09090;
        flex-shrink: 0;
    }

    /* ── Features ── */
    .favorite-features {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 18px;
        padding-bottom: 18px;
        border-bottom: 1px solid var(--border);
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--text-soft);
        font-weight: 500;
    }

    .feature-item i {
        font-size: 14px;
        color: var(--gold);
    }

    /* ── Footer ── */
    .favorite-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        gap: 12px;
    }

    .favorite-price {
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        font-weight: 700;
        color: var(--gold-light);
        letter-spacing: 0.02em;
        white-space: nowrap;
    }

    .btn-view-details {
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        color: #080a0f;
        padding: 10px 20px;
        border-radius: var(--radius-sm);
        border: none;
        font-weight: 700;
        font-size: 13px;
        letter-spacing: 0.04em;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.25s ease;
        white-space: nowrap;
    }

    .btn-view-details:hover {
        filter: brightness(1.12);
        box-shadow: 0 0 20px rgba(197,160,85,0.3);
        color: #080a0f;
        transform: translateY(-1px);
    }

    /* ── Empty State ── */
    .empty-state {
        background: var(--surface);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        padding: 80px 40px;
        text-align: center;
    }

    .empty-state-icon {
        width: 110px;
        height: 110px;
        margin: 0 auto 28px;
        border-radius: 50%;
        background: rgba(217,95,95,0.08);
        border: 1px solid rgba(217,95,95,0.18);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-state-icon i {
        font-size: 50px;
        color: #f09090;
        opacity: 0.7;
    }

    .empty-state h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 28px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 12px;
    }

    .empty-state p {
        color: var(--text-soft);
        font-size: 14px;
        margin-bottom: 32px;
        max-width: 420px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.65;
    }

    .btn-browse-properties {
        background: transparent;
        border: 1px solid var(--gold);
        color: var(--gold);
        padding: 13px 32px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 13px;
        letter-spacing: 0.05em;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-browse-properties::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .btn-browse-properties span { position: relative; z-index: 1; }
    .btn-browse-properties i  { position: relative; z-index: 1; }

    .btn-browse-properties:hover::before { opacity: 1; }
    .btn-browse-properties:hover {
        color: #080a0f;
        box-shadow: 0 0 22px rgba(197,160,85,0.3);
    }

    /* ── Pagination ── */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 32px;
    }

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

    /* ── Animations ── */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(22px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes heartBeat {
        0%, 100% { transform: scale(1); }
        50%       { transform: scale(1.18); }
    }

    /* ── Responsive ── */
    @media (max-width: 992px) {
        .favorites-header { flex-direction: column; align-items: flex-start; }
        .favorites-title h1 { font-size: 26px; }
        .btn-back { width: 100%; justify-content: center; }
        .favorites-grid { grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); }
    }

    @media (max-width: 576px) {
        .favorites-grid { grid-template-columns: 1fr; }
        .empty-state { padding: 60px 20px; }
        .empty-state-icon { width: 90px; height: 90px; }
        .empty-state-icon i { font-size: 42px; }
        .favorite-footer { flex-direction: column; align-items: stretch; }
        .btn-view-details { width: 100%; justify-content: center; }
    }
</style>
@endsection

@section('content')

<!-- Header -->
<div class="favorites-header">
    <div class="favorites-title">
        <i class="bi bi-heart-fill"></i>
        <h1>Mes Propriétés Favorites</h1>
    </div>
    <a href="{{ route('list') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i>
        Retour aux propriétés
    </a>
</div>

@if($favorites->count() > 0)

<!-- Count -->
<div class="favorites-count">
    <div class="count-icon">
        <i class="bi bi-heart-fill"></i>
    </div>
    <div class="count-info">
        <div class="count-label">Total de favoris</div>
        <div class="count-value">
            {{ $favorites->total() }} {{ $favorites->total() > 1 ? 'propriétés' : 'propriété' }}
        </div>
    </div>
</div>

<!-- Grid -->
<div class="favorites-grid">
    @foreach($favorites as $favorite)
    <div class="favorite-card">

        <div class="favorite-image-wrapper">
            @if($favorite->property->images->count() > 0)
                <img src="{{ asset('storage/' . $favorite->property->images->first()->image_url) }}"
                     class="favorite-image"
                     alt="{{ $favorite->property->title }}">
            @else
                <div class="no-image">
                    <i class="bi bi-image"></i>
                </div>
            @endif

            <div class="image-overlay"></div>

            <!-- Remove Button -->
            <form action="{{ route('favorites.remove', $favorite->id) }}" method="POST" style="display:inline;" class="remove-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-remove-favorite" title="Retirer des favoris">
                    <i class="bi bi-heart-fill"></i>
                </button>
            </form>

            <!-- Added Date -->
            <div class="added-date-badge">
                <i class="bi bi-clock"></i>
                <span>Ajouté {{ $favorite->created_at->diffForHumans() }}</span>
            </div>
        </div>

        <div class="favorite-content">
            <h3 class="favorite-title">{{ $favorite->property->title }}</h3>

            <div class="favorite-location">
                <i class="bi bi-geo-alt-fill"></i>
                <span>{{ $favorite->property->city }}</span>
            </div>

            @if($favorite->property->surface || $favorite->property->rooms || $favorite->property->bathrooms)
            <div class="favorite-features">
                @if($favorite->property->surface)
                <div class="feature-item">
                    <i class="bi bi-arrows-angle-expand"></i>
                    <span>{{ number_format($favorite->property->surface, 0, ',', ' ') }} m²</span>
                </div>
                @endif
                @if($favorite->property->rooms)
                <div class="feature-item">
                    <i class="bi bi-door-closed"></i>
                    <span>{{ $favorite->property->rooms }} pièces</span>
                </div>
                @endif
                @if($favorite->property->bathrooms)
                <div class="feature-item">
                    <i class="bi bi-droplet"></i>
                    <span>{{ $favorite->property->bathrooms }} sdb</span>
                </div>
                @endif
            </div>
            @endif

            <div class="favorite-footer">
                <div class="favorite-price">
                    {{ number_format($favorite->property->price, 0, ',', ' ') }} Ar
                </div>
                <a href="{{ route('properties.show', $favorite->property->id) }}" class="btn-view-details">
                    <i class="bi bi-eye"></i>
                    Voir détails
                </a>
            </div>
        </div>

    </div>
    @endforeach
</div>

@if($favorites->hasPages())
<div class="pagination-wrapper">
    {{ $favorites->links('pagination::bootstrap-5') }}
</div>
@endif

@else

<!-- Empty State -->
<div class="empty-state">
    <div class="empty-state-icon">
        <i class="bi bi-heart"></i>
    </div>
    <h3>Aucun favori pour le moment</h3>
    <p>Explorez nos propriétés et ajoutez vos coups de cœur à vos favoris pour les retrouver facilement.</p>
    <a href="{{ route('list') }}" class="btn-browse-properties">
        <i class="bi bi-house-door"></i>
        <span>Découvrir les propriétés</span>
    </a>
</div>

@endif

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Confirmation avant suppression
    document.querySelectorAll('.remove-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Retirer cette propriété de vos favoris ?')) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endsection