@extends('users.header')

@section('title', 'Mes Favoris')

@section('styles')
<style>
/* ══════════════════════════════
   FAVORIS — Clean & Attractive
══════════════════════════════ */

.fav-wrap {
    max-width: 1160px;
    margin: 0 auto;
    padding: 40px 24px 80px;
}

/* ── Header ── */
.fav-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 36px;
    flex-wrap: wrap;
    gap: 16px;
}

.fav-header-left {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.fav-header-left h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 30px;
    font-weight: 700;
    color: var(--text);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.fav-header-left h1 i {
    font-size: 22px;
    color: #e07878;
}

.fav-header-left span {
    font-size: 13px;
    color: var(--text-muted);
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 20px;
    border-radius: 50px;
    border: 1px solid var(--border);
    background: transparent;
    color: var(--text-soft);
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-back:hover {
    border-color: var(--border-glow);
    color: var(--gold);
    background: var(--gold-dim);
}

/* ── Grid ── */
.fav-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
}

/* ── Card ── */
.fav-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    opacity: 0;
    transform: translateY(16px);
    animation: fadeUp 0.4s cubic-bezier(0.22,1,.36,1) forwards;
}

.fav-card:nth-child(1) { animation-delay: 0.04s; }
.fav-card:nth-child(2) { animation-delay: 0.08s; }
.fav-card:nth-child(3) { animation-delay: 0.12s; }
.fav-card:nth-child(4) { animation-delay: 0.16s; }
.fav-card:nth-child(5) { animation-delay: 0.20s; }
.fav-card:nth-child(6) { animation-delay: 0.24s; }

.fav-card:hover {
    transform: translateY(-5px);
    border-color: rgba(197,160,85,0.25);
    box-shadow: 0 16px 40px rgba(0,0,0,0.35);
}

/* Photo */
.card-photo {
    position: relative;
    height: 210px;
    background: var(--surface2);
    overflow: hidden;
    flex-shrink: 0;
}

.card-photo img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.fav-card:hover .card-photo img { transform: scale(1.05); }

.card-photo-empty {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
}
.card-photo-empty i { font-size: 44px; color: var(--text-muted); }

/* Remove button */
.btn-remove {
    position: absolute;
    top: 12px; right: 12px;
    width: 36px; height: 36px;
    border-radius: 10px;
    border: 1px solid rgba(224,100,100,0.3);
    background: rgba(8,10,15,0.78);
    backdrop-filter: blur(8px);
    color: #e07878;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 14px;
}

.btn-remove:hover {
    background: rgba(224,100,100,0.18);
    border-color: rgba(224,100,100,0.55);
    transform: scale(1.08);
}

/* Card body */
.card-body {
    padding: 18px 18px 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.card-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
}

.card-city {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 600;
    color: var(--gold);
    letter-spacing: 0.06em;
    text-transform: uppercase;
}
.card-city i { font-size: 11px; }

.card-date {
    font-size: 11px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 4px;
}
.card-date i { font-size: 11px; color: #e07878; }

.card-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 19px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 12px;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Features */
.card-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    margin-bottom: 14px;
}

.chip {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 50px;
    font-size: 12px;
    color: var(--text-soft);
    font-weight: 500;
}

.chip i { font-size: 11px; color: var(--gold); }

/* Footer */
.card-foot {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding-top: 12px;
    border-top: 1px solid var(--border);
    margin-top: auto;
}

.card-price {
    font-family: 'Cormorant Garamond', serif;
    font-size: 22px;
    font-weight: 700;
    color: var(--gold-light);
}

.btn-details {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 18px;
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    color: #080a0f;
    border: none;
    border-radius: 10px;
    font-size: 12.5px;
    font-weight: 700;
    letter-spacing: 0.03em;
    cursor: pointer;
    transition: all 0.22s ease;
    white-space: nowrap;
}

.btn-details:hover {
    filter: brightness(1.1);
    box-shadow: 0 6px 18px rgba(197,160,85,0.3);
    transform: translateY(-1px);
}

/* ══════════════════════════
   MODAL — Rich info panel
══════════════════════════ */
.modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9000;
    background: rgba(4,6,12,0.88);
    backdrop-filter: blur(10px);
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.modal-backdrop.open { display: flex; }

.modal-box {
    width: 100%;
    max-width: 760px;
    max-height: 90vh;
    overflow-y: auto;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 18px;
    animation: modalIn 0.35s cubic-bezier(0.22,1,.36,1);
    scrollbar-width: thin;
}

@keyframes modalIn {
    from { opacity: 0; transform: translateY(-20px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}

/* Modal header */
.modal-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 22px 24px 18px;
    border-bottom: 1px solid var(--border);
    gap: 16px;
}

.modal-head-left { flex: 1; }

.modal-property-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 24px;
    font-weight: 700;
    color: var(--text);
    line-height: 1.25;
    margin-bottom: 6px;
}

.modal-property-loc {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    color: var(--gold);
    font-weight: 500;
}

.modal-property-loc i { font-size: 13px; }

.modal-close {
    width: 34px; height: 34px;
    flex-shrink: 0;
    border-radius: 9px;
    border: 1px solid var(--border);
    background: transparent;
    color: var(--text-muted);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    cursor: pointer;
    transition: all 0.2s ease;
    line-height: 1;
}

.modal-close:hover {
    border-color: rgba(224,100,100,0.4);
    color: #e07878;
    background: rgba(224,100,100,0.1);
}

/* Modal body */
.modal-body {
    padding: 22px 24px;
}

/* Price banner */
.modal-price-banner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 22px;
}

.mpb-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 4px;
}

.mpb-price {
    font-family: 'Cormorant Garamond', serif;
    font-size: 32px;
    font-weight: 700;
    color: var(--gold-light);
    line-height: 1;
}

.mpb-currency {
    font-size: 14px;
    color: var(--gold);
    font-family: inherit;
}

.mpb-badge {
    padding: 7px 16px;
    border-radius: 50px;
    background: rgba(197,160,85,0.12);
    border: 1px solid rgba(197,160,85,0.3);
    font-size: 12px;
    font-weight: 600;
    color: var(--gold-light);
    letter-spacing: 0.04em;
}

/* Specs grid */
.modal-section-title {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.modal-section-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
}

.modal-specs-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 22px;
}

.spec-box {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 14px 16px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    transition: border-color 0.2s ease;
}

.spec-box:hover { border-color: rgba(197,160,85,0.25); }

.spec-icon {
    width: 32px; height: 32px;
    border-radius: 9px;
    background: var(--gold-dim);
    border: 1px solid rgba(197,160,85,0.18);
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
    color: var(--gold);
    margin-bottom: 2px;
}

.spec-value {
    font-family: 'Cormorant Garamond', serif;
    font-size: 22px;
    font-weight: 700;
    color: var(--text);
    line-height: 1;
}

.spec-label {
    font-size: 11px;
    color: var(--text-muted);
    font-weight: 500;
    letter-spacing: 0.04em;
}

/* Info rows */
.modal-info-rows {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 22px;
}

.info-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 11px 16px;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 10px;
    gap: 12px;
}

.info-row-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
}

.info-row-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    background: var(--gold-dim);
    border: 1px solid rgba(197,160,85,0.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px;
    color: var(--gold);
    flex-shrink: 0;
}

.info-row-key {
    font-size: 13px;
    color: var(--text-soft);
    font-weight: 500;
}

.info-row-val {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    text-align: right;
}

/* Description */
.modal-desc {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 16px 18px;
    font-size: 13.5px;
    line-height: 1.7;
    color: var(--text-soft);
    margin-bottom: 22px;
}

/* Favorite info strip */
.modal-fav-strip {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    background: rgba(224,100,100,0.07);
    border: 1px solid rgba(224,100,100,0.18);
    border-radius: 10px;
    font-size: 12.5px;
    color: var(--text-soft);
}

.modal-fav-strip i { color: #e07878; font-size: 14px; flex-shrink: 0; }
.modal-fav-strip strong { color: var(--text); }

/* Modal footer */
.modal-foot {
    padding: 16px 24px;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-modal-close {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 22px;
    border-radius: 50px;
    border: 1px solid var(--border);
    background: transparent;
    color: var(--text-soft);
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}
.btn-modal-close:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); }

/* ── Empty state ── */
.empty-state {
    text-align: center;
    padding: 80px 40px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
}

.empty-state-icon {
    width: 90px; height: 90px;
    margin: 0 auto 24px;
    border-radius: 50%;
    background: rgba(224,100,100,0.08);
    border: 1px solid rgba(224,100,100,0.18);
    display: flex; align-items: center; justify-content: center;
}

.empty-state-icon i { font-size: 40px; color: #e07878; opacity: 0.75; }

.empty-state h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 26px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 10px;
}

.empty-state p {
    font-size: 14px;
    color: var(--text-soft);
    line-height: 1.65;
    max-width: 380px;
    margin: 0 auto 28px;
}

.btn-explore {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 12px 28px;
    border-radius: 50px;
    border: 1px solid var(--gold);
    color: var(--gold);
    background: transparent;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s ease;
    letter-spacing: 0.04em;
}

.btn-explore:hover {
    background: var(--gold);
    color: #080a0f;
    box-shadow: 0 6px 20px rgba(197,160,85,0.28);
}

/* Pagination */
.pagination-wrap { display: flex; justify-content: center; margin-top: 32px; }
.pagination .page-link { background: var(--surface2) !important; border-color: var(--border) !important; color: var(--text-soft) !important; border-radius: 8px !important; margin: 0 3px; transition: all 0.2s !important; }
.pagination .page-link:hover { background: var(--gold-dim) !important; border-color: var(--border-glow) !important; color: var(--gold) !important; }
.pagination .page-item.active .page-link { background: linear-gradient(135deg, var(--gold), var(--gold-light)) !important; border-color: transparent !important; color: #080a0f !important; font-weight: 700 !important; }

/* Animations */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 768px) {
    .fav-grid { grid-template-columns: 1fr; }
    .modal-specs-grid { grid-template-columns: repeat(2, 1fr); }
    .modal-price-banner { flex-direction: column; align-items: flex-start; gap: 10px; }
    .card-foot { flex-direction: column; align-items: stretch; }
    .btn-details { justify-content: center; }
}

@media (max-width: 480px) {
    .fav-header { flex-direction: column; align-items: flex-start; }
    .btn-back { align-self: flex-start; }
    .modal-specs-grid { grid-template-columns: 1fr 1fr; }
}
</style>
@endsection

@section('content')
<div class="fav-wrap">

    <!-- Header -->
    <div class="fav-header">
        <div class="fav-header-left">
            <h1><i class="bi bi-heart-fill"></i> Mes Propriétés Favorites</h1>
            @if(isset($favorites) && $favorites->count() > 0)
            <span>{{ $favorites->total() }} {{ $favorites->total() > 1 ? 'propriétés sauvegardées' : 'propriété sauvegardée' }}</span>
            @endif
        </div>
        <a href="{{ route('list') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            Retour aux propriétés
        </a>
    </div>

    @if($favorites->count() > 0)

    <!-- Grid -->
    <div class="fav-grid">
        @foreach($favorites as $favorite)
        <div class="fav-card">

            <!-- Photo -->
            <div class="card-photo">
                @if($favorite->property->images->count() > 0)
                    <img src="{{ asset('storage/' . $favorite->property->images->first()->image_url) }}"
                         alt="{{ $favorite->property->title }}">
                @else
                    <div class="card-photo-empty">
                        <i class="bi bi-image"></i>
                    </div>
                @endif

                <!-- Remove -->
                <form action="{{ route('favorites.remove', $favorite->id) }}" method="POST" class="remove-form" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-remove" title="Retirer des favoris">
                        <i class="bi bi-heart-fill"></i>
                    </button>
                </form>
            </div>

            <!-- Body -->
            <div class="card-body">
                <div class="card-meta">
                    <div class="card-city">
                        <i class="bi bi-geo-alt-fill"></i>
                        {{ $favorite->property->city }}
                    </div>
                    <div class="card-date">
                        <i class="bi bi-clock"></i>
                        {{ $favorite->created_at->diffForHumans() }}
                    </div>
                </div>

                <h3 class="card-title">{{ $favorite->property->title }}</h3>

                <div class="card-chips">
                    @if($favorite->property->surface)
                    <div class="chip">
                        <i class="bi bi-arrows-angle-expand"></i>
                        {{ number_format($favorite->property->surface, 0, ',', ' ') }} m²
                    </div>
                    @endif
                    @if($favorite->property->rooms)
                    <div class="chip">
                        <i class="bi bi-door-closed"></i>
                        {{ $favorite->property->rooms }} pièces
                    </div>
                    @endif
                    @if($favorite->property->bathrooms)
                    <div class="chip">
                        <i class="bi bi-droplet-fill"></i>
                        {{ $favorite->property->bathrooms }} sdb
                    </div>
                    @endif
                </div>

                <div class="card-foot">
                    <div class="card-price">
                        {{ number_format($favorite->property->price, 0, ',', ' ') }}
                        <small style="font-size:14px; color:var(--gold)">Ar</small>
                    </div>
                    <button class="btn-details" onclick="openModal({{ $favorite->property->id }}, {{ $favorite->id }})">
                        <i class="bi bi-eye-fill"></i>
                        Voir détails
                    </button>
                </div>
            </div>

        </div>
        @endforeach
    </div>

    @if($favorites->hasPages())
    <div class="pagination-wrap">
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
        <p>Explorez nos propriétés et ajoutez vos coups de cœur pour les retrouver facilement.</p>
        <a href="{{ route('list') }}" class="btn-explore">
            <i class="bi bi-house-door-fill"></i>
            Découvrir les propriétés
        </a>
    </div>

    @endif

</div>

<!-- ─── MODAL ─── -->
<div id="propModal" class="modal-backdrop">
    <div class="modal-box">

        <div class="modal-head">
            <div class="modal-head-left">
                <div class="modal-property-name" id="mName">—</div>
                <div class="modal-property-loc">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span id="mCity">—</span>
                </div>
            </div>
            <button class="modal-close" onclick="closeModal()">×</button>
        </div>

        <div class="modal-body">

            <!-- Price banner -->
            <div class="modal-price-banner">
                <div>
                    <div class="mpb-label">Prix de vente</div>
                    <div class="mpb-price">
                        <span id="mPrice">—</span>
                        <span class="mpb-currency"> Ar</span>
                    </div>
                </div>
                <div class="mpb-badge" id="mType">Propriété</div>
            </div>

            <!-- Specs -->
            <div class="modal-section-title">Caractéristiques</div>
            <div class="modal-specs-grid" id="mSpecsGrid">
                <!-- Injected by JS -->
            </div>

            <!-- Info rows -->
            <div class="modal-section-title">Informations</div>
            <div class="modal-info-rows" id="mInfoRows">
                <!-- Injected by JS -->
            </div>

            <!-- Description -->
            <div id="mDescWrap" style="display:none;">
                <div class="modal-section-title">Description</div>
                <div class="modal-desc" id="mDesc"></div>
            </div>

            <!-- Favorite strip -->
            <div class="modal-fav-strip">
                <i class="bi bi-heart-fill"></i>
                <span>Ajouté à vos favoris <strong id="mDate">—</strong></span>
            </div>

        </div>

        <div class="modal-foot">
            <button class="btn-modal-close" onclick="closeModal()">
                <i class="bi bi-x-lg"></i> Fermer
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const propData = {
    @foreach($favorites as $favorite)
    {{ $favorite->property->id }}: {
        favId:      {{ $favorite->id }},
        name:       @json($favorite->property->title),
        city:       @json($favorite->property->city),
        price:      {{ $favorite->property->price }},
        surface:    {{ $favorite->property->surface ?? 'null' }},
        rooms:      {{ $favorite->property->rooms ?? 'null' }},
        bathrooms:  {{ $favorite->property->bathrooms ?? 'null' }},
        type:       @json($favorite->property->type ?? 'Propriété'),
        status:     @json($favorite->property->status ?? null),
        description:@json($favorite->property->description ?? ''),
        addedAt:    @json($favorite->created_at->format('d/m/Y à H\hi')),
        addedRel:   @json($favorite->created_at->diffForHumans()),
        address:    @json($favorite->property->address ?? null),
    }@if(!$loop->last),@endif
    @endforeach
};

function openModal(propId) {
    const p = propData[propId];
    if (!p) return;

    document.getElementById('mName').textContent  = p.name;
    document.getElementById('mCity').textContent  = p.city;
    document.getElementById('mPrice').textContent = Number(p.price).toLocaleString('fr-FR');
    document.getElementById('mType').textContent  = p.type;
    document.getElementById('mDate').textContent  = p.addedAt;

    // Specs grid
    const specs = [];
    if (p.surface)    specs.push({ icon: 'bi-arrows-angle-expand', val: Number(p.surface).toLocaleString('fr-FR') + ' m²', label: 'Surface' });
    if (p.rooms)      specs.push({ icon: 'bi-door-closed',         val: p.rooms,     label: 'Pièces' });
    if (p.bathrooms)  specs.push({ icon: 'bi-droplet-fill',        val: p.bathrooms, label: 'Salles de bain' });

    const grid = document.getElementById('mSpecsGrid');
    grid.innerHTML = specs.length
        ? specs.map(s => `
            <div class="spec-box">
                <div class="spec-icon"><i class="bi ${s.icon}"></i></div>
                <div class="spec-value">${s.val}</div>
                <div class="spec-label">${s.label}</div>
            </div>`).join('')
        : '<p style="color:var(--text-muted);font-size:13px;grid-column:1/-1">Non renseigné</p>';

    // Info rows
    const rows = [
        { icon: 'bi-building',    key: 'Type',    val: p.type   },
        { icon: 'bi-geo-alt',     key: 'Ville',   val: p.city   },
        { icon: 'bi-signpost-2',  key: 'Adresse', val: p.address || '—' },
        { icon: 'bi-tag',         key: 'Statut',  val: p.status || '—' },
    ];

    document.getElementById('mInfoRows').innerHTML = rows.map(r => `
        <div class="info-row">
            <div class="info-row-left">
                <div class="info-row-icon"><i class="bi ${r.icon}"></i></div>
                <span class="info-row-key">${r.key}</span>
            </div>
            <span class="info-row-val">${r.val}</span>
        </div>`).join('');

    // Description
    const descWrap = document.getElementById('mDescWrap');
    if (p.description && p.description.trim()) {
        document.getElementById('mDesc').textContent = p.description;
        descWrap.style.display = 'block';
    } else {
        descWrap.style.display = 'none';
    }

    document.getElementById('propModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('propModal').classList.remove('open');
    document.body.style.overflow = '';
}

document.getElementById('propModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

document.addEventListener('keydown', e => e.key === 'Escape' && closeModal());

document.querySelectorAll('.remove-form').forEach(f => {
    f.addEventListener('submit', e => {
        if (!confirm('Retirer cette propriété de vos favoris ?')) e.preventDefault();
    });
});
</script>
@endsection