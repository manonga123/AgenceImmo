@extends('layouts.layout')

@section('title', 'Détails de la propriété')

@section('styles')
<style>
  /* ════════════════════════════════════════
     TOKENS — alignés sur le nouveau layout
  ════════════════════════════════════════ */
  :root {
    --c-gold:     #c5a055;
    --c-gold-l:   #e2c07a;
    --c-gold-dim: rgba(197,160,85,0.12);
    --c-surface:  #0d1018;
    --c-surface2: #111420;
    --c-surface3: #161924;
    --c-border:   rgba(255,255,255,0.055);
    --c-border-g: rgba(197,160,85,0.2);
    --c-text:     #f0ede8;
    --c-soft:     #a8a49e;
    --c-muted:    #50535c;
    --c-success:  #3db97a;
    --c-danger:   #d95f5f;
    --c-warning:  #e0a030;
    --c-blue:     #5585e0;
    --c-radius:   14px;
    --c-radius-sm:9px;
    --tr:         0.26s cubic-bezier(0.4,0,0.2,1);
  }

  .show-zone {
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
    border-bottom: 1px solid var(--c-border);
    position: relative;
  }

  .page-head::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0;
    width: 120px; height: 1px;
    background: linear-gradient(90deg, var(--c-gold), transparent);
    opacity: 0.5;
  }

  .page-eyebrow {
    font-size: 0.6rem; font-weight: 700;
    letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--c-gold); margin-bottom: 8px;
    display: flex; align-items: center; gap: 8px;
  }

  .page-eyebrow::before {
    content: '';
    display: inline-block;
    width: 18px; height: 1px;
    background: var(--c-gold); opacity: 0.6;
  }

  .page-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem; font-weight: 700;
    color: var(--c-text); margin: 0;
    letter-spacing: 0.02em; line-height: 1.2;
  }

  .page-subtitle {
    font-size: 0.82rem; color: var(--c-muted);
    margin-top: 6px; letter-spacing: 0.02em;
  }

  .btn-back {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px; border-radius: 50px;
    border: 1px solid var(--c-border);
    background: transparent; color: var(--c-soft);
    font-family: 'Inter', sans-serif;
    font-size: 0.82rem; font-weight: 500;
    text-decoration: none; transition: all 0.22s ease;
    align-self: center;
  }

  .btn-back:hover {
    border-color: var(--c-border-g); color: var(--c-gold);
    background: var(--c-gold-dim);
  }

  /* ════════════════ MAIN LAYOUT ════════════════ */
  .show-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 22px;
    align-items: start;
  }

  /* ════════════════ SECTION CARD ════════════════ */
  .section-card {
    background: var(--c-surface);
    border: 1px solid var(--c-border);
    border-radius: var(--c-radius);
    padding: 28px;
    margin-bottom: 20px;
    position: relative; overflow: hidden;
    opacity: 0; animation: fadeUp 0.45s ease forwards;
  }

  .section-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, var(--c-gold), transparent);
    opacity: 0.18;
  }

  .section-card:nth-child(1) { animation-delay: 0.04s; }
  .section-card:nth-child(2) { animation-delay: 0.08s; }
  .section-card:nth-child(3) { animation-delay: 0.12s; }
  .section-card:nth-child(4) { animation-delay: 0.16s; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .section-header {
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 22px; padding-bottom: 16px;
    border-bottom: 1px solid var(--c-border);
    position: relative;
  }

  .section-header::after {
    content: '';
    position: absolute; bottom: -1px; left: 0;
    width: 60px; height: 1px;
    background: var(--c-gold); opacity: 0.5;
  }

  .section-icon {
    width: 36px; height: 36px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
    background: var(--c-gold-dim);
    border: 1px solid rgba(197,160,85,0.2);
    color: var(--c-gold);
  }

  .section-header h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.15rem; font-weight: 700;
    color: var(--c-text); margin: 0;
    letter-spacing: 0.02em;
  }

  /* ════════════════ IMAGE GALLERY ════════════════ */
  .carousel {
    border-radius: var(--c-radius-sm);
    overflow: hidden;
    margin-bottom: 14px;
    border: 1px solid var(--c-border);
  }

  .property-image {
    width: 100%;
    height: 460px;
    object-fit: cover;
    display: block;
  }

  .carousel-control-prev,
  .carousel-control-next {
    width: 44px; height: 44px;
    background: rgba(197,160,85,0.18);
    border: 1px solid rgba(197,160,85,0.3);
    border-radius: 50%;
    top: 50%; transform: translateY(-50%);
    transition: all 0.22s ease;
    backdrop-filter: blur(6px);
  }

  .carousel-control-prev { left: 14px; }
  .carousel-control-next { right: 14px; }

  .carousel-control-prev:hover,
  .carousel-control-next:hover {
    background: rgba(197,160,85,0.35);
    border-color: var(--c-gold);
  }

  .carousel-control-prev-icon,
  .carousel-control-next-icon {
    width: 16px; height: 16px;
  }

  .image-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
    gap: 8px;
    margin-top: 14px;
  }

  .gallery-item {
    position: relative;
    border-radius: var(--c-radius-sm);
    overflow: hidden;
    aspect-ratio: 1;
    border: 1px solid var(--c-border);
    cursor: pointer;
    transition: all 0.22s ease;
    background: var(--c-surface2);
  }

  .gallery-item:hover {
    border-color: var(--c-border-g);
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(197,160,85,0.15);
  }

  .gallery-item img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.3s ease;
  }

  .gallery-item:hover img { transform: scale(1.06); }

  .empty-gallery {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 56px 20px;
    background: var(--c-surface2);
    border-radius: var(--c-radius-sm);
    border: 1px dashed rgba(197,160,85,0.2);
    text-align: center;
  }

  .empty-gallery i {
    font-size: 48px; color: var(--c-muted);
    margin-bottom: 14px; opacity: 0.5;
  }

  .empty-gallery p { color: var(--c-muted); font-size: 0.875rem; margin: 0; }

  /* ════════════════ DESCRIPTION ════════════════ */
  .description-text {
    color: var(--c-soft);
    font-size: 0.9rem;
    line-height: 1.8;
    background: var(--c-surface2);
    border-radius: var(--c-radius-sm);
    padding: 18px 20px;
    border: 1px solid var(--c-border);
  }

  /* ════════════════ INFO GRID ════════════════ */
  .info-cols {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
  }

  .info-sub-label {
    font-size: 0.65rem; font-weight: 700;
    letter-spacing: 0.14em; text-transform: uppercase;
    color: var(--c-gold); margin-bottom: 14px;
    display: flex; align-items: center; gap: 8px;
  }

  .info-sub-label::after {
    content: ''; flex: 1; height: 1px;
    background: var(--c-border-g); opacity: 0.5;
  }

  .info-list { display: flex; flex-direction: column; gap: 10px; }

  .info-item {
    display: flex; align-items: center; gap: 12px;
    padding: 13px 15px;
    background: var(--c-surface2);
    border: 1px solid var(--c-border);
    border-radius: var(--c-radius-sm);
    transition: border-color 0.2s ease;
  }

  .info-item:hover { border-color: var(--c-border-g); }

  .info-icon {
    width: 32px; height: 32px; border-radius: 8px;
    background: var(--c-gold-dim);
    border: 1px solid rgba(197,160,85,0.2);
    display: flex; align-items: center; justify-content: center;
    color: var(--c-gold); font-size: 14px; flex-shrink: 0;
  }

  .info-content strong {
    display: block;
    font-size: 0.65rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: var(--c-muted); margin-bottom: 2px;
  }

  .info-content .value {
    font-size: 0.875rem; font-weight: 600;
    color: var(--c-text);
  }

  /* ════════════════ SIDEBAR CARDS ════════════════ */
  .sidebar { position: sticky; top: 24px; }

  .sidebar .section-card:nth-child(1) { animation-delay: 0.1s; }
  .sidebar .section-card:nth-child(2) { animation-delay: 0.16s; }
  .sidebar .section-card:nth-child(3) { animation-delay: 0.22s; }

  /* Price card */
  .price-block {
    text-align: center;
    padding: 22px 18px;
    background: var(--c-surface2);
    border: 1px solid var(--c-border-g);
    border-radius: var(--c-radius-sm);
    position: relative; overflow: hidden;
  }

  .price-block::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, var(--c-gold), transparent);
    opacity: 0.6;
  }

  .price-amount {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.2rem; font-weight: 700;
    color: var(--c-gold); letter-spacing: -0.5px;
    line-height: 1; margin-bottom: 12px;
  }

  .price-unit {
    font-size: 0.75rem; color: var(--c-muted);
    font-weight: 500; letter-spacing: 0.06em;
  }

  .status-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 6px 16px; border-radius: 50px;
    font-size: 0.75rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: 0.06em;
    margin-top: 14px;
  }

  .status-disponible {
    background: rgba(61,185,122,0.12);
    border: 1px solid rgba(61,185,122,0.3);
    color: var(--c-success);
  }

  .status-vendu {
    background: rgba(217,95,95,0.12);
    border: 1px solid rgba(217,95,95,0.3);
    color: var(--c-danger);
  }

  .status-loué, .status-lou\E9 {
    background: rgba(224,160,48,0.12);
    border: 1px solid rgba(224,160,48,0.3);
    color: var(--c-warning);
  }

  /* Owner card */
  .owner-block {
    display: flex; align-items: center; gap: 14px;
    padding: 16px;
    background: var(--c-surface2);
    border: 1px solid var(--c-border);
    border-radius: var(--c-radius-sm);
  }

  .owner-avatar {
    width: 52px; height: 52px; border-radius: 50%;
    background: var(--c-gold-dim);
    border: 1px solid var(--c-border-g);
    display: flex; align-items: center; justify-content: center;
    color: var(--c-gold); font-size: 22px; flex-shrink: 0;
  }

  .owner-info h3 {
    font-size: 0.925rem; font-weight: 600;
    color: var(--c-text); margin: 0 0 3px 0;
  }

  .owner-info .email {
    font-size: 0.78rem; color: var(--c-muted);
  }

  /* Action buttons */
  .action-buttons {
    display: flex; flex-direction: column; gap: 10px;
  }

  .btn-action {
    width: 100%;
    display: flex; align-items: center; justify-content: center;
    gap: 8px; padding: 13px 20px;
    border-radius: 50px;
    font-family: 'Inter', sans-serif;
    font-size: 0.855rem; font-weight: 600;
    text-decoration: none; cursor: pointer;
    border: none; transition: all 0.25s ease;
    position: relative; overflow: hidden;
    letter-spacing: 0.03em;
  }

  /* Edit button — gold outline */
  .btn-edit {
    border: 1px solid var(--c-gold);
    background: transparent; color: var(--c-gold);
  }

  .btn-edit::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, var(--c-gold), var(--c-gold-l));
    opacity: 0; transition: opacity 0.25s ease;
  }

  .btn-edit span, .btn-edit i { position: relative; z-index: 1; }
  .btn-edit:hover::before { opacity: 1; }
  .btn-edit:hover { color: #080a0f; box-shadow: 0 0 22px rgba(197,160,85,0.3); }

  /* Delete button — danger outline */
  .btn-delete {
    border: 1px solid rgba(217,95,95,0.4);
    background: transparent; color: var(--c-danger);
  }

  .btn-delete:hover {
    background: rgba(217,95,95,0.1);
    border-color: var(--c-danger);
    box-shadow: 0 0 18px rgba(217,95,95,0.2);
  }

  /* Secondary button */
  .btn-secondary {
    border: 1px solid var(--c-border);
    background: transparent; color: var(--c-muted);
  }

  .btn-secondary:hover {
    border-color: var(--c-border-g); color: var(--c-soft);
    background: rgba(255,255,255,0.03);
  }

  /* ════════════════ RESPONSIVE ════════════════ */
  @media (max-width: 1100px) {
    .show-grid { grid-template-columns: 1fr; }
    .sidebar { position: static; }
  }

  @media (max-width: 768px) {
    .info-cols { grid-template-columns: 1fr; }
    .page-head { flex-direction: column; }
    .property-image { height: 280px; }
    .page-title { font-size: 1.65rem; }
  }

  @media (max-width: 576px) {
    .section-card { padding: 18px; }
    .price-amount { font-size: 1.8rem; }
  }
</style>
@endsection

@section('content')
<div class="show-zone">

  {{-- ════════ HEADER ════════ --}}
  <div class="page-head">
    <div>
      <h1 class="page-title">{{ $property->title }}</h1>
      <p class="page-subtitle">{{ ucfirst($property->type) }} · {{ $property->city }}</p>
    </div>
    <a href="{{ route('properties.index') }}" class="btn-back">
      <i class="bi bi-arrow-left"></i>
      <span>Retour à la liste</span>
    </a>
  </div>

  <div class="show-grid">

    {{-- ════════ COLONNE PRINCIPALE ════════ --}}
    <div>

      {{-- Images --}}
      <div class="section-card">
        <div class="section-header">
          <div class="section-icon"><i class="bi bi-images"></i></div>
          <h2>Photos</h2>
        </div>

        @if($property->images && $property->images->count() > 0)

          <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              @foreach($property->images as $index => $image)
              <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/' . $image->image_url) }}"
                     class="property-image"
                     alt="{{ $property->title }}">
              </div>
              @endforeach
            </div>
            @if($property->images->count() > 1)
            <button class="carousel-control-prev" type="button"
                    data-bs-target="#propertyCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button"
                    data-bs-target="#propertyCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Suivant</span>
            </button>
            @endif
          </div>

          @if($property->images->count() > 1)
          <div class="image-gallery">
            @foreach($property->images as $image)
            <div class="gallery-item">
              <img src="{{ asset('storage/' . $image->image_url) }}"
                   alt="Image de {{ $property->title }}">
            </div>
            @endforeach
          </div>
          @endif

        @else
          <div class="empty-gallery">
            <i class="bi bi-image"></i>
            <p>Aucune photo disponible</p>
          </div>
        @endif
      </div>

      {{-- Description --}}
      <div class="section-card">
        <div class="section-header">
          <div class="section-icon"><i class="bi bi-text-paragraph"></i></div>
          <h2>Description</h2>
        </div>
        <div class="description-text">
          {{ $property->description ?: 'Aucune description disponible.' }}
        </div>
      </div>

      {{-- Informations détaillées --}}
      <div class="section-card">
        <div class="section-header">
          <div class="section-icon"><i class="bi bi-info-circle"></i></div>
          <h2>Informations détaillées</h2>
        </div>

        <div class="info-cols">

          {{-- Caractéristiques --}}
          <div>
            <div class="info-sub-label">Caractéristiques</div>
            <div class="info-list">
              <div class="info-item">
                <div class="info-icon"><i class="bi bi-arrows-fullscreen"></i></div>
                <div class="info-content">
                  <strong>Surface</strong>
                  <div class="value">
                    {{ $property->surface ? number_format($property->surface, 0, ',', ' ') . ' m²' : 'Non spécifiée' }}
                  </div>
                </div>
              </div>

              <div class="info-item">
                <div class="info-icon"><i class="bi bi-door-closed"></i></div>
                <div class="info-content">
                  <strong>Pièces</strong>
                  <div class="value">{{ $property->rooms ?? 'Non spécifié' }}</div>
                </div>
              </div>

              <div class="info-item">
                <div class="info-icon"><i class="bi bi-droplet"></i></div>
                <div class="info-content">
                  <strong>Salles de bain</strong>
                  <div class="value">{{ $property->bathrooms ?? 'Non spécifié' }}</div>
                </div>
              </div>

              <div class="info-item">
                <div class="info-icon"><i class="bi bi-tag"></i></div>
                <div class="info-content">
                  <strong>Type</strong>
                  <div class="value">{{ ucfirst($property->type) }}</div>
                </div>
              </div>
            </div>
          </div>

          {{-- Localisation --}}
          <div>
            <div class="info-sub-label">Localisation</div>
            <div class="info-list">
              <div class="info-item">
                <div class="info-icon"><i class="bi bi-geo-alt"></i></div>
                <div class="info-content">
                  <strong>Adresse</strong>
                  <div class="value">{{ $property->address ?: 'Non spécifiée' }}</div>
                </div>
              </div>

              <div class="info-item">
                <div class="info-icon"><i class="bi bi-building"></i></div>
                <div class="info-content">
                  <strong>Ville</strong>
                  <div class="value">{{ $property->city }}</div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>

    {{-- ════════ SIDEBAR ════════ --}}
    <aside class="sidebar">

      {{-- Prix & Statut --}}
      <div class="section-card">
        <div class="section-header">
          <div class="section-icon"><i class="bi bi-cash-coin"></i></div>
          <h2>Prix</h2>
        </div>
        <div class="price-block">
          <div class="price-amount">
            {{ number_format($property->price, 0, ',', ' ') }}
            <span style="font-size:1rem;color:var(--c-soft);font-family:'Inter',sans-serif;">Ar</span>
          </div>
          <div class="price-unit">Prix de vente / location</div>
          @php $statusClass = 'status-' . $property->status; @endphp
          <div>
            <span class="status-badge {{ $statusClass }}">
              @if($property->status === 'disponible') <i class="bi bi-check-circle"></i>
              @elseif($property->status === 'vendu')  <i class="bi bi-x-circle"></i>
              @else                                   <i class="bi bi-key"></i>
              @endif
              {{ ucfirst($property->status) }}
            </span>
          </div>
        </div>
      </div>

      {{-- Propriétaire --}}
      <div class="section-card">
        <div class="section-header">
          <div class="section-icon"><i class="bi bi-person"></i></div>
          <h2>Propriétaire</h2>
        </div>

        @if($property->owner)
          <div class="owner-block">
            <div class="owner-avatar">
              <i class="bi bi-person-fill"></i>
            </div>
            <div class="owner-info">
              <h3>{{ $property->owner->first_name }} {{ $property->owner->last_name }}</h3>
              <div class="email">{{ $property->owner->email }}</div>
            </div>
          </div>
        @else
          <p style="color:var(--c-muted);font-size:0.875rem;margin:0;">Propriétaire non spécifié.</p>
        @endif
      </div>

      {{-- Actions --}}
      <div class="section-card">
        <div class="section-header">
          <div class="section-icon"><i class="bi bi-gear"></i></div>
          <h2>Actions</h2>
        </div>

        <div class="action-buttons">

          @if(Auth::user()->role == 'admin' || Auth::id() == $property->owner_id)

            <a href="{{ route('properties.edit', $property->id) }}" class="btn-action btn-edit">
              <i class="bi bi-pencil"></i>
              <span>Modifier</span>
            </a>

            <form action="{{ route('properties.destroy', $property->id) }}"
                  method="POST"
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette propriété ?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-action btn-delete">
                <i class="bi bi-trash"></i>
                <span>Supprimer</span>
              </button>
            </form>

          @endif

          <a href="{{ route('properties.index') }}" class="btn-action btn-secondary">
            <i class="bi bi-list"></i>
            <span>Toutes les propriétés</span>
          </a>

        </div>
      </div>

    </aside>

  </div>
</div>
@endsection