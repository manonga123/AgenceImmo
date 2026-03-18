@extends('layouts.layout')

@section('title', 'Mes Propriétés')

@section('styles')
<style>
  /* ════════════════════════════════════════
     TOKENS — alignés sur le nouveau layout
  ════════════════════════════════════════ */
  :root {
    --p-gold:      #c5a055;
    --p-gold-l:    #e2c07a;
    --p-gold-dim:  rgba(197,160,85,0.12);
    --p-surface:   #0d1018;
    --p-surface2:  #111420;
    --p-surface3:  #161924;
    --p-border:    rgba(255,255,255,0.055);
    --p-border-g:  rgba(197,160,85,0.2);
    --p-text:      #f0ede8;
    --p-soft:      #a8a49e;
    --p-muted:     #50535c;
    --p-success:   #3db97a;
    --p-danger:    #d95f5f;
    --p-warning:   #e0a030;
    --p-blue:      #5585e0;
    --p-radius:    14px;
    --p-radius-sm: 9px;
    --tr:          0.26s cubic-bezier(0.4,0,0.2,1);
  }

  /* ── PAGE ZONE ── */
  .prop-zone {
    font-family: 'Inter', sans-serif;
    animation: zoneIn 0.5s cubic-bezier(.22,1,.36,1) both;
  }

  @keyframes zoneIn {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ── PAGE HEADER ── */
  .page-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 36px;
    padding-bottom: 28px;
    border-bottom: 1px solid var(--p-border);
    position: relative;
  }

  .page-head::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0;
    width: 120px; height: 1px;
    background: linear-gradient(90deg, var(--p-gold), transparent);
    opacity: 0.5;
  }

  .page-head-left {}

  .page-eyebrow {
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--p-gold);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .page-eyebrow::before {
    content: '';
    display: inline-block;
    width: 18px; height: 1px;
    background: var(--p-gold);
    opacity: 0.6;
  }

  .page-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    font-weight: 700;
    color: var(--p-text);
    margin: 0;
    letter-spacing: 0.02em;
    line-height: 1.1;
  }

  .page-subtitle {
    font-size: 0.82rem;
    color: var(--p-muted);
    margin-top: 6px;
    letter-spacing: 0.02em;
  }

  .btn-add {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 24px;
    border-radius: 50px;
    border: 1px solid var(--p-gold);
    background: transparent;
    color: var(--p-gold);
    font-family: 'Inter', sans-serif;
    font-size: 0.845rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.25s ease;
    letter-spacing: 0.04em;
    position: relative;
    overflow: hidden;
    align-self: center;
  }

  .btn-add::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, var(--p-gold), var(--p-gold-l));
    opacity: 0; transition: opacity 0.25s ease;
  }

  .btn-add span, .btn-add i { position: relative; z-index: 1; }

  .btn-add:hover::before { opacity: 1; }
  .btn-add:hover {
    color: #080a0f;
    box-shadow: 0 0 22px rgba(197,160,85,0.3);
  }

  /* ── STATS ── */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 36px;
  }

  .stat-card {
    background: var(--p-surface);
    border: 1px solid var(--p-border);
    border-radius: var(--p-radius);
    padding: 20px 22px;
    display: flex;
    align-items: center;
    gap: 16px;
    position: relative;
    overflow: hidden;
    transition: all var(--tr);
    opacity: 0;
    animation: fadeUp 0.45s ease forwards;
  }

  .stat-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    opacity: 0; transition: opacity var(--tr);
  }

  .stat-card:hover { transform: translateY(-3px); border-color: var(--p-border-g); }
  .stat-card:hover::before { opacity: 1; }

  .stat-card.total::before    { background: linear-gradient(90deg, var(--p-blue), transparent); }
  .stat-card.dispo::before    { background: linear-gradient(90deg, var(--p-success), transparent); }
  .stat-card.vendu::before    { background: linear-gradient(90deg, var(--p-danger), transparent); }
  .stat-card.loue::before     { background: linear-gradient(90deg, var(--p-warning), transparent); }

  .stat-card:nth-child(1) { animation-delay: 0.06s; }
  .stat-card:nth-child(2) { animation-delay: 0.12s; }
  .stat-card:nth-child(3) { animation-delay: 0.18s; }
  .stat-card:nth-child(4) { animation-delay: 0.24s; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .stat-icon-wrap {
    width: 46px; height: 46px;
    border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 18px;
  }

  .stat-icon-wrap.total   { background: rgba(85,133,224,0.12);  color: var(--p-blue);    border: 1px solid rgba(85,133,224,0.2); }
  .stat-icon-wrap.dispo   { background: rgba(61,185,122,0.12);  color: var(--p-success); border: 1px solid rgba(61,185,122,0.2); }
  .stat-icon-wrap.vendu   { background: rgba(217,95,95,0.12);   color: var(--p-danger);  border: 1px solid rgba(217,95,95,0.2); }
  .stat-icon-wrap.loue    { background: rgba(224,160,48,0.12);  color: var(--p-warning); border: 1px solid rgba(224,160,48,0.2); }

  .stat-meta {}
  .stat-label {
    font-size: 0.65rem; font-weight: 600;
    letter-spacing: 0.14em; text-transform: uppercase;
    color: var(--p-muted); margin-bottom: 5px;
  }
  .stat-value {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem; font-weight: 700;
    color: var(--p-text); line-height: 1;
  }

  /* ── GRID PROPRIÉTÉS ── */
  .properties-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
    gap: 20px;
    margin-bottom: 36px;
  }

  /* ── CARD ── */
  .property-card {
    background: var(--p-surface);
    border: 1px solid var(--p-border);
    border-radius: var(--p-radius);
    overflow: hidden;
    display: flex; flex-direction: column;
    cursor: pointer;
    transition: all 0.32s cubic-bezier(0.4,0,0.2,1);
    opacity: 0; animation: fadeUp 0.45s ease forwards;
    position: relative;
  }

  /* top shimmer on hover */
  .property-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, var(--p-gold), transparent);
    opacity: 0; transition: opacity var(--tr); z-index: 3;
  }

  .property-card:hover { transform: translateY(-5px); border-color: var(--p-border-g); box-shadow: 0 20px 50px rgba(0,0,0,0.5); }
  .property-card:hover::before { opacity: 1; }

  .property-card:nth-child(1) { animation-delay: 0.05s; }
  .property-card:nth-child(2) { animation-delay: 0.10s; }
  .property-card:nth-child(3) { animation-delay: 0.15s; }
  .property-card:nth-child(4) { animation-delay: 0.20s; }
  .property-card:nth-child(5) { animation-delay: 0.25s; }
  .property-card:nth-child(6) { animation-delay: 0.30s; }

  /* ── IMAGE ── */
  .property-img-wrap {
    position: relative;
    height: 200px;
    background: var(--p-surface2);
    overflow: hidden;
  }

  .property-img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
    filter: brightness(0.9);
  }

  .property-card:hover .property-img { transform: scale(1.06); filter: brightness(1); }

  .no-image {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    color: var(--p-muted);
    background: linear-gradient(135deg, var(--p-surface2), var(--p-surface));
  }

  .img-gradient {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, transparent 45%, rgba(8,10,15,0.75) 100%);
    z-index: 1;
  }

  /* ── BADGES ── */
  .prop-badges {
    position: absolute; top: 13px; left: 13px; right: 13px;
    display: flex; justify-content: space-between;
    z-index: 2;
  }

  .badge-pill {
    padding: 4px 11px;
    border-radius: 20px;
    font-size: 0.65rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.07em;
    backdrop-filter: blur(12px);
  }

  .badge-type {
    background: rgba(8,10,15,0.82);
    color: var(--p-soft);
    border: 1px solid rgba(255,255,255,0.08);
  }

  .badge-dispo   { background: rgba(61,185,122,0.88);  color: #fff; }
  .badge-vendu   { background: rgba(217,95,95,0.88);   color: #fff; }
  .badge-loue,
  .badge-loué    { background: rgba(224,160,48,0.9);   color: #080a0f; }

  /* ── CONTENT ── */
  .property-body {
    padding: 20px 22px;
    flex: 1; display: flex; flex-direction: column;
  }

  .property-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.08rem; font-weight: 600;
    color: var(--p-text); margin-bottom: 8px;
    line-height: 1.4;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden; min-height: 42px;
  }

  .property-location {
    display: flex; align-items: center; gap: 6px;
    color: var(--p-muted); font-size: 0.8rem; margin-bottom: 14px;
  }

  .property-location i { color: var(--p-gold); font-size: 12px; }

  .property-price {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.45rem; font-weight: 700;
    color: var(--p-gold); margin-bottom: 16px;
    letter-spacing: 0.01em;
  }

  /* ── FEATURES ── */
  .prop-features {
    display: flex; gap: 16px;
    padding: 12px 0;
    margin-bottom: 16px;
    border-top: 1px solid var(--p-border);
    border-bottom: 1px solid var(--p-border);
  }

  .feat-item {
    display: flex; align-items: center; gap: 6px;
    font-size: 0.78rem; color: var(--p-soft);
  }

  .feat-item i { color: var(--p-blue); font-size: 13px; }

  /* ── ACTIONS ── */
  .prop-actions {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 8px; margin-top: auto;
  }

  .btn-prop {
    padding: 9px 6px;
    border-radius: var(--p-radius-sm);
    border: 1px solid var(--p-border);
    background: transparent;
    font-family: 'Inter', sans-serif;
    font-weight: 500; font-size: 0.76rem;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 5px; cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none; color: var(--p-muted);
  }

  .btn-prop i { font-size: 15px; }
  .btn-prop:hover { transform: translateY(-2px); }

  .btn-view:hover  {
    border-color: rgba(85,133,224,0.4); color: var(--p-blue);
    background: rgba(85,133,224,0.08);
    box-shadow: 0 4px 14px rgba(85,133,224,0.15);
  }
  .btn-edit:hover  {
    border-color: rgba(224,160,48,0.4); color: var(--p-warning);
    background: rgba(224,160,48,0.08);
    box-shadow: 0 4px 14px rgba(224,160,48,0.15);
  }
  .btn-del:hover   {
    border-color: rgba(217,95,95,0.4); color: var(--p-danger);
    background: rgba(217,95,95,0.08);
    box-shadow: 0 4px 14px rgba(217,95,95,0.15);
  }

  .btn-prop form { display: contents; }

  /* ── EMPTY STATE ── */
  .empty-state {
    background: var(--p-surface);
    border: 1px solid var(--p-border);
    border-radius: var(--p-radius);
    padding: 90px 40px;
    text-align: center;
    position: relative; overflow: hidden;
  }

  .empty-state::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, var(--p-gold), transparent);
    opacity: 0.25;
  }

  .empty-icon {
    width: 100px; height: 100px;
    margin: 0 auto 28px;
    border-radius: 50%;
    background: var(--p-surface2);
    border: 1px solid var(--p-border);
    display: flex; align-items: center; justify-content: center;
    font-size: 38px; color: var(--p-muted);
    box-shadow: 0 0 40px rgba(0,0,0,0.3);
  }

  .empty-state h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.6rem; font-weight: 700;
    color: var(--p-text); margin-bottom: 10px; letter-spacing: 0.02em;
  }

  .empty-state p {
    color: var(--p-muted); font-size: 0.875rem;
    margin-bottom: 30px; max-width: 380px; margin-left: auto; margin-right: auto;
    line-height: 1.7;
  }

  .btn-empty {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 28px; border-radius: 50px;
    border: 1px solid var(--p-gold);
    background: transparent; color: var(--p-gold);
    font-family: 'Inter', sans-serif;
    font-size: 0.875rem; font-weight: 500;
    text-decoration: none; transition: all 0.25s ease;
    letter-spacing: 0.04em; position: relative; overflow: hidden;
  }

  .btn-empty::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, var(--p-gold), var(--p-gold-l));
    opacity: 0; transition: opacity 0.25s ease;
  }

  .btn-empty span, .btn-empty i { position: relative; z-index: 1; }
  .btn-empty:hover::before { opacity: 1; }
  .btn-empty:hover { color: #080a0f; box-shadow: 0 0 22px rgba(197,160,85,0.3); }

  /* ── PAGINATION ── */
  .pagination-wrapper {
    display: flex; justify-content: center; margin-top: 10px;
  }

  .pagination-wrapper .pagination .page-link {
    background: var(--p-surface);
    border-color: var(--p-border);
    color: var(--p-muted);
    transition: all 0.2s;
    font-size: 0.85rem;
  }

  .pagination-wrapper .pagination .page-link:hover {
    background: var(--p-gold-dim);
    border-color: var(--p-border-g);
    color: var(--p-gold);
  }

  .pagination-wrapper .pagination .page-item.active .page-link {
    background: var(--p-gold-dim);
    border-color: var(--p-gold);
    color: var(--p-gold);
    box-shadow: 0 0 14px rgba(197,160,85,0.15);
  }

  /* ── RESPONSIVE ── */
  @media (max-width: 1100px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 768px) {
    .page-head { flex-direction: column; }
    .btn-add { width: 100%; justify-content: center; }
    .properties-grid { grid-template-columns: 1fr; }
  }
  @media (max-width: 576px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .page-title { font-size: 1.6rem; }
  }
</style>
@endsection

@section('content')
<div class="prop-zone">

    {{-- ════════ HEADER ════════ --}}
    <div class="page-head">
        <div class="page-head-left">
            
            <h1 class="page-title">Mes Propriétés</h1>
            <p class="page-subtitle">Gérez et suivez toutes vos propriétés en un seul endroit</p>
        </div>
        @if(in_array(Auth::user()->role, ['owner', 'admin']))
        <a href="{{ route('properties.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i>
            <span>Ajouter une propriété</span>
        </a>
        @endif
    </div>

    @if($properties->count() > 0)

    {{-- ════════ STATS ════════ --}}
    @php
        $totalProperties = $properties->total();
        $disponibleCount = $properties->where('status', 'disponible')->count();
        $venduCount      = $properties->where('status', 'vendu')->count();
        $loueCount       = $properties->where('status', 'loué')->count();
    @endphp

    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon-wrap total">
                <i class="bi bi-building"></i>
            </div>
            <div class="stat-meta">
                <div class="stat-label">Total</div>
                <div class="stat-value">{{ $totalProperties }}</div>
            </div>
        </div>
        <div class="stat-card dispo">
            <div class="stat-icon-wrap dispo">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-meta">
                <div class="stat-label">Disponibles</div>
                <div class="stat-value">{{ $disponibleCount }}</div>
            </div>
        </div>
        <div class="stat-card vendu">
            <div class="stat-icon-wrap vendu">
                <i class="bi bi-cash-coin"></i>
            </div>
            <div class="stat-meta">
                <div class="stat-label">Vendues</div>
                <div class="stat-value">{{ $venduCount }}</div>
            </div>
        </div>
        <div class="stat-card loue">
            <div class="stat-icon-wrap loue">
                <i class="bi bi-person-check"></i>
            </div>
            <div class="stat-meta">
                <div class="stat-label">Louées</div>
                <div class="stat-value">{{ $loueCount }}</div>
            </div>
        </div>
    </div>

    {{-- ════════ GRID ════════ --}}
    <div class="properties-grid">
        @foreach($properties as $property)
        <div class="property-card"
             onclick="handleCardClick(event, '{{ route('properties.show', $property->id) }}')">

            {{-- Image --}}
            <div class="property-img-wrap">
                @if($property->images->count() > 0)
                    <img src="{{ asset('storage/' . $property->images->first()->image_url) }}"
                         class="property-img"
                         alt="{{ $property->title }}">
                @else
                    <div class="no-image">
                        <i class="bi bi-building" style="font-size:48px;opacity:0.25;"></i>
                    </div>
                @endif
                <div class="img-gradient"></div>
                <div class="prop-badges">
                    <span class="badge-pill badge-type">{{ ucfirst($property->type) }}</span>
                    <span class="badge-pill badge-{{ $property->status }}">{{ ucfirst($property->status) }}</span>
                </div>
            </div>

            {{-- Body --}}
            <div class="property-body">
                <h3 class="property-title">{{ $property->title }}</h3>

                <div class="property-location">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>{{ $property->city }}</span>
                </div>

                <div class="property-price">
                    {{ number_format($property->price, 0, ',', ' ') }} Ar
                </div>

                @if($property->surface || $property->rooms || $property->bathrooms)
                <div class="prop-features">
                    @if($property->surface)
                    <div class="feat-item">
                        <i class="bi bi-aspect-ratio"></i>
                        <span>{{ number_format($property->surface, 0, ',', ' ') }} m²</span>
                    </div>
                    @endif
                    @if($property->rooms)
                    <div class="feat-item">
                        <i class="bi bi-door-open"></i>
                        <span>{{ $property->rooms }} ch.</span>
                    </div>
                    @endif
                    @if($property->bathrooms)
                    <div class="feat-item">
                        <i class="bi bi-droplet"></i>
                        <span>{{ $property->bathrooms }} sdb</span>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Actions --}}
                <div class="prop-actions">
                    <a href="{{ route('properties.show', $property->id) }}"
                       class="btn-prop btn-view"
                       onclick="event.stopPropagation()">
                        <i class="bi bi-eye"></i>
                        <span>Voir</span>
                    </a>

                    <a href="{{ route('properties.edit', $property->id) }}"
                       class="btn-prop btn-edit"
                       onclick="event.stopPropagation()">
                        <i class="bi bi-pencil"></i>
                        <span>Modifier</span>
                    </a>

                    <form action="{{ route('properties.destroy', $property->id) }}"
                          method="POST"
                          onsubmit="return confirm('Supprimer cette propriété ? Cette action est irréversible.');"
                          onclick="event.stopPropagation()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-prop btn-del" style="width:100%;">
                            <i class="bi bi-trash"></i>
                            <span>Supprimer</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($properties->hasPages())
    <div class="pagination-wrapper">
        {{ $properties->links('pagination::bootstrap-5') }}
    </div>
    @endif

    @else

    {{-- ════════ EMPTY ════════ --}}
    <div class="empty-state">
        <div class="empty-icon">
            <i class="bi bi-building"></i>
        </div>
        <h3>Aucune propriété pour l'instant</h3>
        <p>Commencez par ajouter votre première propriété pour la gérer et la promouvoir auprès de vos clients.</p>
        @if(in_array(Auth::user()->role, ['owner', 'admin']))
        <a href="{{ route('properties.create') }}" class="btn-empty">
            <i class="bi bi-plus-lg"></i>
            <span>Ajouter ma première propriété</span>
        </a>
        @endif
    </div>

    @endif

</div>
@endsection

@section('scripts')
<script>
function handleCardClick(event, url) {
    if (!event.target.closest('a') &&
        !event.target.closest('button') &&
        !event.target.closest('form')) {
        window.location.href = url;
    }
}
</script>
@endsection