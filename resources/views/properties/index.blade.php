@extends('layouts.layout')

@section('title', 'Liste des propriétés')

@section('styles')
<style>
  /* ════════════════════════════════════════
     TOKENS — alignés sur le nouveau layout
  ════════════════════════════════════════ */
  :root {
    --l-gold:     #c5a055;
    --l-gold-l:   #e2c07a;
    --l-gold-dim: rgba(197,160,85,0.12);
    --l-surface:  #0d1018;
    --l-surface2: #111420;
    --l-surface3: #161924;
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
    --l-radius-sm:9px;
    --tr:         0.26s cubic-bezier(0.4,0,0.2,1);
  }

  .list-zone {
    font-family: 'Inter', sans-serif;
    animation: zoneIn 0.5s cubic-bezier(.22,1,.36,1) both;
  }

  @keyframes zoneIn {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ════════════════ PAGE HEADER ════════════════ */
  .page-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 36px;
    padding-bottom: 28px;
    border-bottom: 1px solid var(--l-border);
    position: relative;
  }

  .page-head::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0;
    width: 120px; height: 1px;
    background: linear-gradient(90deg, var(--l-gold), transparent);
    opacity: 0.5;
  }

  .page-eyebrow {
    font-size: 0.6rem; font-weight: 700;
    letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--l-gold); margin-bottom: 8px;
    display: flex; align-items: center; gap: 8px;
  }

  .page-eyebrow::before {
    content: '';
    display: inline-block;
    width: 18px; height: 1px;
    background: var(--l-gold); opacity: 0.6;
  }

  .page-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem; font-weight: 700;
    color: var(--l-text); margin: 0;
    letter-spacing: 0.02em; line-height: 1.1;
  }

  .page-subtitle {
    font-size: 0.82rem; color: var(--l-muted);
    margin-top: 6px; letter-spacing: 0.02em;
  }

  .btn-add {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 24px; border-radius: 50px;
    border: 1px solid var(--l-gold);
    background: transparent; color: var(--l-gold);
    font-family: 'Inter', sans-serif;
    font-size: 0.845rem; font-weight: 500;
    text-decoration: none; transition: all 0.25s ease;
    letter-spacing: 0.04em;
    position: relative; overflow: hidden; align-self: center;
  }

  .btn-add::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, var(--l-gold), var(--l-gold-l));
    opacity: 0; transition: opacity 0.25s ease;
  }

  .btn-add span, .btn-add i { position: relative; z-index: 1; }
  .btn-add:hover::before { opacity: 1; }
  .btn-add:hover { color: #080a0f; box-shadow: 0 0 22px rgba(197,160,85,0.3); }

  /* ════════════════ SEARCH CARD ════════════════ */
  .search-card {
    background: var(--l-surface);
    border: 1px solid var(--l-border);
    border-radius: var(--l-radius);
    padding: 22px 24px;
    margin-bottom: 24px;
    position: relative; overflow: hidden;
  }

  .search-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, var(--l-gold), transparent);
    opacity: 0.18;
  }

  .search-form {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 12px;
    align-items: start;
  }

  .search-input-group {
    display: flex;
    border: 1px solid var(--l-border);
    border-radius: var(--l-radius-sm);
    overflow: hidden;
    transition: all 0.25s ease;
    background: var(--l-surface2);
  }

  .search-input-group:focus-within {
    border-color: var(--l-border-g);
    box-shadow: 0 0 0 3px rgba(197,160,85,0.08);
  }

  .search-icon {
    display: flex; align-items: center;
    padding: 0 14px;
    background: transparent;
    color: var(--l-muted); font-size: 15px;
    flex-shrink: 0;
  }

  .search-input-group input {
    flex: 1; border: none;
    padding: 12px 14px;
    font-size: 0.855rem; outline: none;
    background: transparent;
    color: var(--l-text);
    font-family: 'Inter', sans-serif;
  }

  .search-input-group input::placeholder { color: var(--l-muted); }

  .btn-search {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 22px; border: 1px solid var(--l-gold);
    border-radius: var(--l-radius-sm);
    background: transparent; color: var(--l-gold);
    font-family: 'Inter', sans-serif;
    font-size: 0.845rem; font-weight: 500;
    cursor: pointer; white-space: nowrap;
    transition: all 0.25s ease;
    position: relative; overflow: hidden;
  }

  .btn-search::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, var(--l-gold), var(--l-gold-l));
    opacity: 0; transition: opacity 0.25s ease;
  }

  .btn-search span, .btn-search i { position: relative; z-index: 1; }
  .btn-search:hover::before { opacity: 1; }
  .btn-search:hover { color: #080a0f; box-shadow: 0 0 18px rgba(197,160,85,0.25); }

  .search-filters {
    display: flex; gap: 10px; margin-top: 12px; flex-wrap: wrap;
  }

  .select-dark {
    padding: 10px 14px;
    border: 1px solid var(--l-border);
    border-radius: var(--l-radius-sm);
    font-size: 0.82rem;
    color: var(--l-soft);
    background: var(--l-surface2);
    cursor: pointer;
    transition: all 0.22s ease;
    font-family: 'Inter', sans-serif;
    flex: 1; min-width: 120px;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%2350535c' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 30px;
  }

  .select-dark:focus {
    outline: none;
    border-color: var(--l-border-g);
    box-shadow: 0 0 0 3px rgba(197,160,85,0.08);
    color: var(--l-text);
  }

  .select-dark option { background: var(--l-surface2); color: var(--l-text); }

  /* ════════════════ PROPERTIES GRID ════════════════ */
  .properties-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
    gap: 20px;
    margin-bottom: 28px;
  }

  /* ── CARD ── */
  .property-card {
    background: var(--l-surface);
    border: 1px solid var(--l-border);
    border-radius: var(--l-radius);
    overflow: hidden;
    display: flex; flex-direction: column;
    transition: all 0.32s cubic-bezier(0.4,0,0.2,1);
    opacity: 0; animation: fadeUp 0.45s ease forwards;
    position: relative;
  }

  .property-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, var(--l-gold), transparent);
    opacity: 0; transition: opacity var(--tr); z-index: 3;
  }

  .property-card:hover {
    transform: translateY(-5px);
    border-color: var(--l-border-g);
    box-shadow: 0 20px 50px rgba(0,0,0,0.5);
  }

  .property-card:hover::before { opacity: 1; }

  .property-card:nth-child(1) { animation-delay: 0.05s; }
  .property-card:nth-child(2) { animation-delay: 0.10s; }
  .property-card:nth-child(3) { animation-delay: 0.15s; }
  .property-card:nth-child(4) { animation-delay: 0.20s; }
  .property-card:nth-child(5) { animation-delay: 0.25s; }
  .property-card:nth-child(6) { animation-delay: 0.30s; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ── IMAGE ── */
  .prop-img-wrap {
    position: relative;
    height: 210px;
    background: var(--l-surface2);
    overflow: hidden;
  }

  .prop-img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease, filter 0.4s ease;
    filter: brightness(0.88);
  }

  .property-card:hover .prop-img {
    transform: scale(1.06); filter: brightness(1);
  }

  .no-img {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    font-size: 48px; color: var(--l-muted); opacity: 0.2;
    background: linear-gradient(135deg, var(--l-surface2), var(--l-surface));
  }

  .img-gradient {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, transparent 40%, rgba(8,10,15,0.72) 100%);
    z-index: 1;
  }

  /* badges */
  .prop-badges {
    position: absolute; top: 12px; left: 12px; right: 12px;
    display: flex; justify-content: space-between;
    align-items: flex-start; z-index: 2;
  }

  .badge-pill {
    padding: 4px 11px; border-radius: 20px;
    font-size: 0.65rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.07em;
    backdrop-filter: blur(12px);
  }

  .badge-type {
    background: rgba(8,10,15,0.82);
    color: var(--l-soft);
    border: 1px solid rgba(255,255,255,0.08);
  }

  .badge-disponible { background: rgba(61,185,122,0.88);  color: #fff; }
  .badge-vendu      { background: rgba(217,95,95,0.88);   color: #fff; }
  .badge-loue,
  .badge-loué       { background: rgba(224,160,48,0.9);   color: #080a0f; }

  /* img count */
  .img-count {
    position: absolute; bottom: 12px; left: 12px; z-index: 2;
    display: flex; align-items: center; gap: 5px;
    background: rgba(8,10,15,0.75);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.08);
    color: var(--l-soft); font-size: 0.72rem; font-weight: 600;
    padding: 4px 10px; border-radius: 20px;
  }

  /* ── BODY ── */
  .prop-body {
    padding: 20px 22px;
    flex: 1; display: flex; flex-direction: column;
  }

  .prop-type-tag {
    display: inline-block;
    padding: 3px 10px;
    background: var(--l-gold-dim);
    border: 1px solid rgba(197,160,85,0.2);
    color: var(--l-gold);
    border-radius: 20px;
    font-size: 0.62rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.1em;
    margin-bottom: 12px;
  }

  .prop-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.08rem; font-weight: 600;
    color: var(--l-text); margin-bottom: 8px;
    line-height: 1.4;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden; min-height: 42px;
  }

  .prop-title a {
    color: inherit; text-decoration: none;
    transition: color var(--tr);
  }

  .prop-title a:hover { color: var(--l-gold); }

  .prop-location {
    display: flex; align-items: center; gap: 6px;
    color: var(--l-muted); font-size: 0.8rem; margin-bottom: 10px;
  }

  .prop-location i { color: var(--l-gold); font-size: 12px; }

  /* owner */
  .prop-owner {
    display: flex; align-items: center; gap: 8px;
    font-size: 0.78rem; color: var(--l-muted); margin-bottom: 14px;
  }

  .owner-avatar {
    width: 24px; height: 24px; border-radius: 7px;
    background: linear-gradient(135deg, rgba(197,160,85,0.22), rgba(197,160,85,0.06));
    border: 1px solid rgba(197,160,85,0.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.68rem; font-weight: 700; color: var(--l-gold);
    flex-shrink: 0;
  }

  /* features */
  .prop-features {
    display: flex; gap: 14px; flex-wrap: wrap;
    padding: 12px 0;
    border-top: 1px solid var(--l-border);
    border-bottom: 1px solid var(--l-border);
    margin-bottom: 16px;
  }

  .feat-item {
    display: flex; align-items: center; gap: 5px;
    font-size: 0.78rem; color: var(--l-soft);
  }

  .feat-item i { color: var(--l-blue); font-size: 13px; }

  /* footer */
  .prop-footer {
    display: flex; justify-content: space-between;
    align-items: center; margin-top: auto;
  }

  .prop-price {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.4rem; font-weight: 700;
    color: var(--l-gold); letter-spacing: 0.01em;
  }

  .prop-actions { display: flex; gap: 7px; }

  .btn-act {
    width: 36px; height: 36px; border-radius: 9px;
    border: 1px solid var(--l-border);
    background: transparent;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; cursor: pointer;
    transition: all 0.2s ease;
    color: var(--l-muted); text-decoration: none;
  }

  .btn-act:hover { transform: translateY(-2px); }

  .btn-act.view:hover {
    border-color: rgba(85,133,224,0.4); color: var(--l-blue);
    background: rgba(85,133,224,0.08);
    box-shadow: 0 4px 14px rgba(85,133,224,0.15);
  }

  .btn-act.edit:hover {
    border-color: rgba(224,160,48,0.4); color: var(--l-warning);
    background: rgba(224,160,48,0.08);
    box-shadow: 0 4px 14px rgba(224,160,48,0.15);
  }

  .btn-act.del {
    background: transparent; border: 1px solid var(--l-border);
  }

  .btn-act.del:hover {
    border-color: rgba(217,95,95,0.4); color: var(--l-danger);
    background: rgba(217,95,95,0.08);
    box-shadow: 0 4px 14px rgba(217,95,95,0.15);
  }

  /* ════════════════ PAGINATION ════════════════ */
  .pagination-wrap {
    background: var(--l-surface);
    border: 1px solid var(--l-border);
    border-radius: var(--l-radius);
    padding: 16px 24px;
    display: flex; justify-content: space-between;
    align-items: center; gap: 16px;
    flex-wrap: wrap; position: relative; overflow: hidden;
  }

  .pagination-wrap::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, var(--l-gold), transparent);
    opacity: 0.15;
  }

  .pagination-info {
    font-size: 0.78rem; color: var(--l-muted);
    letter-spacing: 0.02em;
  }

  .pagination-info strong { color: var(--l-soft); }

  .pagination-wrap .pagination .page-link {
    background: var(--l-surface2);
    border-color: var(--l-border);
    color: var(--l-muted);
    font-size: 0.82rem;
    transition: all 0.2s;
  }

  .pagination-wrap .pagination .page-link:hover {
    background: var(--l-gold-dim);
    border-color: var(--l-border-g);
    color: var(--l-gold);
  }

  .pagination-wrap .pagination .page-item.active .page-link {
    background: var(--l-gold-dim);
    border-color: var(--l-gold);
    color: var(--l-gold);
    box-shadow: 0 0 12px rgba(197,160,85,0.15);
  }

  /* ════════════════ EMPTY STATE ════════════════ */
  .empty-state {
    background: var(--l-surface);
    border: 1px solid var(--l-border);
    border-radius: var(--l-radius);
    padding: 90px 40px;
    text-align: center;
    position: relative; overflow: hidden;
  }

  .empty-state::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, var(--l-gold), transparent);
    opacity: 0.22;
  }

  .empty-icon {
    width: 100px; height: 100px;
    margin: 0 auto 26px;
    border-radius: 50%;
    background: var(--l-surface2);
    border: 1px solid var(--l-border);
    display: flex; align-items: center; justify-content: center;
    font-size: 40px; color: var(--l-muted); opacity: 0.35;
  }

  .empty-state h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.55rem; font-weight: 700;
    color: var(--l-text); margin-bottom: 10px;
  }

  .empty-state p {
    color: var(--l-muted); font-size: 0.875rem;
    max-width: 380px; margin: 0 auto 28px; line-height: 1.7;
  }

  .btn-empty {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 28px; border-radius: 50px;
    border: 1px solid var(--l-gold);
    background: transparent; color: var(--l-gold);
    font-family: 'Inter', sans-serif;
    font-size: 0.875rem; font-weight: 500;
    text-decoration: none; transition: all 0.25s ease;
    letter-spacing: 0.04em; position: relative; overflow: hidden;
  }

  .btn-empty::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, var(--l-gold), var(--l-gold-l));
    opacity: 0; transition: opacity 0.25s ease;
  }

  .btn-empty span, .btn-empty i { position: relative; z-index: 1; }
  .btn-empty:hover::before { opacity: 1; }
  .btn-empty:hover { color: #080a0f; box-shadow: 0 0 22px rgba(197,160,85,0.3); }

  /* ════════════════ NO RESULT INLINE ════════════════ */
  .no-result-inline {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    color: var(--l-muted);
    font-size: 0.875rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 14px;
  }

  .no-result-inline .no-result-icon {
    width: 70px; height: 70px;
    border-radius: 50%;
    background: var(--l-surface2);
    border: 1px solid var(--l-border);
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; color: var(--l-muted); opacity: 0.4;
  }

  .no-result-inline span {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem;
    color: var(--l-soft);
  }

  /* ════════════════ RESPONSIVE ════════════════ */
  @media (max-width: 992px) {
    .page-head { flex-direction: column; }
    .btn-add   { width: 100%; justify-content: center; }
    .search-form { grid-template-columns: 1fr; }
    .properties-grid { grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); }
    .pagination-wrap { flex-direction: column; text-align: center; }
  }

  @media (max-width: 576px) {
    .properties-grid { grid-template-columns: 1fr; }
    .search-filters  { flex-direction: column; }
    .page-title      { font-size: 1.65rem; }
  }
</style>
@endsection

@section('content')
<div class="list-zone">

  {{-- ════════ HEADER ════════ --}}
  <div class="page-head">
    <div>
      <h1 class="page-title">Liste des propriétés</h1>
      <p class="page-subtitle">Parcourez et gérez l'ensemble du portefeuille immobilier</p>
    </div>
    @if(in_array(Auth::user()->role, ['owner', 'admin']))
    <a href="{{ route('properties.create') }}" class="btn-add">
      <i class="bi bi-plus-lg"></i>
      <span>Ajouter une propriété</span>
    </a>
    @endif
  </div>

  {{-- ════════ SEARCH ════════ --}}
  <div class="search-card">
    <form method="GET" action="{{ route('properties.index') }}" class="search-form" id="search-form">
      <div class="search-input-group">
        <span class="search-icon">
          <i class="bi bi-search"></i>
        </span>
        <input type="text"
               id="search-input"
               name="search"
               placeholder="Rechercher par titre, ville, adresse…"
               value="{{ request('search') }}"
               autocomplete="off">
      </div>
      <button type="submit" class="btn-search">
        <i class="bi bi-search"></i>
        <span>Rechercher</span>
      </button>
    </form>

    <div class="search-filters">
      <select name="per_page" class="select-dark"
              onchange="window.location.href=updateParam('per_page', this.value)">
        <option value="10"  {{ request('per_page', 10) == 10  ? 'selected' : '' }}>10 par page</option>
        <option value="25"  {{ request('per_page', 10) == 25  ? 'selected' : '' }}>25 par page</option>
        <option value="50"  {{ request('per_page', 10) == 50  ? 'selected' : '' }}>50 par page</option>
        <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100 par page</option>
      </select>
    </div>
  </div>

  {{-- ════════ GRID ════════ --}}
  @if($properties->count() > 0)
  <div class="properties-grid" id="properties-grid">
    @foreach($properties as $property)
    <div class="property-card"
         data-title="{{ strtolower($property->title) }}"
         data-city="{{ strtolower($property->city) }}"
         data-type="{{ strtolower($property->type) }}"
         data-owner="{{ strtolower(($property->owner->first_name ?? '') . ' ' . ($property->owner->last_name ?? '')) }}"
         data-address="{{ strtolower($property->address ?? '') }}">

      {{-- Image --}}
      <div class="prop-img-wrap">
        @if($property->images->count() > 0)
          <img src="{{ asset('storage/' . $property->images->first()->image_url) }}"
               class="prop-img" alt="{{ $property->title }}">
        @else
          <div class="no-img">
            <i class="bi bi-building"></i>
          </div>
        @endif
        <div class="img-gradient"></div>

        <div class="prop-badges">
          <span class="badge-pill badge-type">{{ ucfirst($property->type) }}</span>
          <span class="badge-pill badge-{{ $property->status }}">{{ ucfirst($property->status) }}</span>
        </div>

        @if($property->images->count() > 1)
        <div class="img-count">
          <i class="bi bi-images"></i>
          {{ $property->images->count() }}
        </div>
        @endif
      </div>

      {{-- Body --}}
      <div class="prop-body">
        <span class="prop-type-tag">{{ ucfirst($property->type) }}</span>

        <h3 class="prop-title">
          <a href="{{ route('properties.show', $property->id) }}">
            {{ $property->title }}
          </a>
        </h3>

        <div class="prop-location">
          <i class="bi bi-geo-alt-fill"></i>
          <span>{{ $property->city }}</span>
        </div>

        <div class="prop-owner">
          <div class="owner-avatar">
            {{ strtoupper(substr($property->owner->first_name ?? 'A', 0, 1)) }}
          </div>
          <span>{{ ($property->owner->first_name ?? '') . ' ' . ($property->owner->last_name ?? '') }}</span>
        </div>

        @if($property->surface || $property->bedrooms || $property->bathrooms)
        <div class="prop-features">
          @if($property->surface)
          <div class="feat-item">
            <i class="bi bi-aspect-ratio"></i>
            <span>{{ number_format($property->surface, 0, ',', ' ') }} m²</span>
          </div>
          @endif
          @if($property->bedrooms)
          <div class="feat-item">
            <i class="bi bi-door-open"></i>
            <span>{{ $property->bedrooms }} ch.</span>
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

        {{-- Footer --}}
        <div class="prop-footer">
          <div class="prop-price">
            {{ number_format($property->price, 0, ',', ' ') }} Ar
          </div>
          <div class="prop-actions">
            <a href="{{ route('properties.show', $property->id) }}"
               class="btn-act view" title="Voir">
              <i class="bi bi-eye"></i>
            </a>

            @if(Auth::user()->role == 'admin' || Auth::id() == $property->owner_id)
            <a href="{{ route('properties.edit', $property->id) }}"
               class="btn-act edit" title="Modifier">
              <i class="bi bi-pencil"></i>
            </a>

            <form action="{{ route('properties.destroy', $property->id) }}"
                  method="POST" style="display:inline;"
                  onsubmit="return confirm('Supprimer cette propriété ? Action irréversible.');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-act del" title="Supprimer">
                <i class="bi bi-trash"></i>
              </button>
            </form>
            @endif
          </div>
        </div>

      </div>
    </div>
    @endforeach
  </div>

  {{-- ════════ PAGINATION ════════ --}}
  <div class="pagination-wrap" id="pagination-wrap">
    <div class="pagination-info" id="pagination-info">
      Affichage de <strong>{{ $properties->firstItem() }}</strong>
      à <strong>{{ $properties->lastItem() }}</strong>
      sur <strong>{{ $properties->total() }}</strong> propriétés
    </div>
    <div>
      {{ $properties->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
  </div>

  @else

  {{-- ════════ EMPTY ════════ --}}
  <div class="empty-state">
    <div class="empty-icon">
      <i class="bi bi-building-x"></i>
    </div>
    <h3>Aucune propriété trouvée</h3>
    <p>
      @if(request()->anyFilled(['search']))
        Aucune propriété ne correspond à vos critères de recherche. Essayez d'autres termes.
      @else
        Le catalogue est vide pour l'instant. Commencez par ajouter votre première propriété.
      @endif
    </p>
    @if(request()->anyFilled(['search']))
    <a href="{{ route('properties.index') }}" class="btn-empty">
      <i class="bi bi-arrow-clockwise"></i>
      <span>Réinitialiser la recherche</span>
    </a>
    @elseif(in_array(Auth::user()->role, ['owner', 'admin']))
    <a href="{{ route('properties.create') }}" class="btn-empty">
      <i class="bi bi-plus-lg"></i>
      <span>Ajouter la première propriété</span>
    </a>
    @endif
  </div>

  @endif

</div>
@endsection

@section('scripts')
<script>
  function updateParam(key, value) {
    const url = new URL(window.location.href);
    url.searchParams.set(key, value);
    url.searchParams.delete('page');
    return url.toString();
  }

  document.addEventListener('DOMContentLoaded', function () {
    const searchInput   = document.getElementById('search-input');
    const grid          = document.getElementById('properties-grid');
    const paginationWrap = document.getElementById('pagination-wrap');
    const paginationInfo = document.getElementById('pagination-info');

    // S'il n'y a pas de grille (page vide côté serveur), on s'arrête
    if (!searchInput || !grid) return;

    // Récupère toutes les cartes une seule fois
    const allCards = Array.from(grid.querySelectorAll('.property-card'));
    const totalServer = allCards.length;

    // Place le curseur à la fin après rechargement de page
    const initialVal = searchInput.value;
    searchInput.value = '';
    searchInput.focus();
    searchInput.value = initialVal;

    // Référence au message "aucun résultat" inline (créé dynamiquement)
    let noResultEl = null;

    searchInput.addEventListener('input', function () {
      const query = this.value.trim().toLowerCase();

      // ── Si le champ est vide : tout réafficher, pagination visible ──
      if (query === '') {
        allCards.forEach(function (card) {
          card.style.display = '';
        });
        if (noResultEl) {
          noResultEl.remove();
          noResultEl = null;
        }
        if (paginationWrap) paginationWrap.style.display = '';
        if (paginationInfo) paginationInfo.innerHTML =
          'Affichage de <strong>' + totalServer + '</strong> propriétés chargées';
        return;
      }

      // ── Filtrage ──
      let visibleCount = 0;

      allCards.forEach(function (card) {
        const haystack = [
          card.dataset.title   || '',
          card.dataset.city    || '',
          card.dataset.type    || '',
          card.dataset.owner   || '',
          card.dataset.address || ''
        ].join(' ');

        const match = haystack.includes(query);
        card.style.display = match ? '' : 'none';
        if (match) visibleCount++;
      });

      // ── Message aucun résultat ──
      if (visibleCount === 0) {
        if (!noResultEl) {
          noResultEl = document.createElement('div');
          noResultEl.className = 'no-result-inline';
          noResultEl.innerHTML =
            '<div class="no-result-icon"><i class="bi bi-search"></i></div>' +
            '<span>Aucune propriété ne correspond à « ' + escapeHtml(this.value.trim()) + ' »</span>';
          grid.appendChild(noResultEl);
        } else {
          noResultEl.querySelector('span').textContent =
            'Aucune propriété ne correspond à « ' + this.value.trim() + ' »';
        }
      } else {
        if (noResultEl) {
          noResultEl.remove();
          noResultEl = null;
        }
      }

      // ── Pagination : masquée pendant filtrage actif ──
      if (paginationWrap) paginationWrap.style.display = 'none';

      // ── Compteur mis à jour ──
      if (paginationInfo) {
        paginationInfo.innerHTML =
          '<strong>' + visibleCount + '</strong> résultat' + (visibleCount > 1 ? 's' : '') +
          ' pour « ' + escapeHtml(this.value.trim()) + ' »';
      }
    });

    // Petit utilitaire anti-XSS pour l'injection dans innerHTML
    function escapeHtml(str) {
      return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
    }
  });
</script>
@endsection