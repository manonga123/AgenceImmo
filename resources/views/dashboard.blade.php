@extends('layouts.layout')

@section('title', 'Tableau de bord')

@section('styles')
<style>
  /* ════════════════════════════════════════
     TOKENS — alignés sur le nouveau layout
  ════════════════════════════════════════ */
  :root {
    --d-gold:     #c5a055;
    --d-gold-l:   #e2c07a;
    --d-gold-dim: rgba(197,160,85,0.12);
    --d-surface:  #0d1018;
    --d-surface2: #111420;
    --d-surface3: #161924;
    --d-border:   rgba(255,255,255,0.055);
    --d-border-g: rgba(197,160,85,0.2);
    --d-text:     #f0ede8;
    --d-soft:     #a8a49e;
    --d-muted:    #50535c;
    --d-success:  #3db97a;
    --d-danger:   #d95f5f;
    --d-warning:  #e0a030;
    --d-blue:     #5585e0;
    --d-radius:   14px;
    --d-radius-sm:9px;
    --tr:         0.26s cubic-bezier(0.4,0,0.2,1);
  }

  .dash-zone {
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
    border-bottom: 1px solid var(--d-border);
    position: relative;
  }

  .page-head::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0;
    width: 120px; height: 1px;
    background: linear-gradient(90deg, var(--d-gold), transparent);
    opacity: 0.5;
  }

  .page-eyebrow {
    font-size: 0.6rem; font-weight: 700;
    letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--d-gold); margin-bottom: 8px;
    display: flex; align-items: center; gap: 8px;
  }

  .page-eyebrow::before {
    content: '';
    display: inline-block;
    width: 18px; height: 1px;
    background: var(--d-gold); opacity: 0.6;
  }

  .page-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem; font-weight: 700;
    color: var(--d-text); margin: 0;
    letter-spacing: 0.02em; line-height: 1.1;
  }

  .page-subtitle {
    font-size: 0.82rem; color: var(--d-muted);
    margin-top: 6px; letter-spacing: 0.02em;
  }

  /* ════════════════ BOUTONS HEADER ════════════════ */
  .head-actions {
    display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
  }

  .btn-add {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 24px; border-radius: 50px;
    border: 1px solid var(--d-gold);
    background: transparent; color: var(--d-gold);
    font-family: 'Inter', sans-serif;
    font-size: 0.845rem; font-weight: 500;
    text-decoration: none; transition: all 0.25s ease;
    letter-spacing: 0.04em;
    position: relative; overflow: hidden; align-self: center;
  }

  .btn-add::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, var(--d-gold), var(--d-gold-l));
    opacity: 0; transition: opacity 0.25s ease;
  }

  .btn-add span, .btn-add i { position: relative; z-index: 1; }
  .btn-add:hover::before { opacity: 1; }
  .btn-add:hover { color: #080a0f; box-shadow: 0 0 22px rgba(197,160,85,0.3); }

  .btn-pdf {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 22px; border-radius: 50px;
    border: 1px solid rgba(85,133,224,0.5);
    background: rgba(85,133,224,0.08); color: var(--d-blue);
    font-family: 'Inter', sans-serif;
    font-size: 0.845rem; font-weight: 500;
    text-decoration: none; transition: all 0.25s ease;
    letter-spacing: 0.04em; align-self: center;
  }

  .btn-pdf:hover {
    background: rgba(85,133,224,0.18);
    border-color: var(--d-blue);
    color: #fff;
    box-shadow: 0 0 18px rgba(85,133,224,0.25);
  }

  /* ════════════════ STAT CARDS ════════════════ */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 14px;
    margin-bottom: 36px;
  }

  .stat-card {
    background: var(--d-surface);
    border: 1px solid var(--d-border);
    border-radius: var(--d-radius);
    padding: 22px 24px;
    display: flex; align-items: center; gap: 18px;
    position: relative; overflow: hidden;
    transition: all var(--tr);
    opacity: 0; animation: fadeUp 0.45s ease forwards;
  }

  .stat-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    opacity: 0; transition: opacity var(--tr);
  }

  .stat-card:hover { transform: translateY(-3px); border-color: var(--d-border-g); }
  .stat-card:hover::before { opacity: 1; }

  .stat-card.c-blue::before    { background: linear-gradient(90deg, var(--d-blue),    transparent); }
  .stat-card.c-success::before { background: linear-gradient(90deg, var(--d-success),  transparent); }
  .stat-card.c-warning::before { background: linear-gradient(90deg, var(--d-warning),  transparent); }
  .stat-card.c-gold::before    { background: linear-gradient(90deg, var(--d-gold),     transparent); }

  .stat-card:nth-child(1) { animation-delay: 0.06s; }
  .stat-card:nth-child(2) { animation-delay: 0.12s; }
  .stat-card:nth-child(3) { animation-delay: 0.18s; }
  .stat-card:nth-child(4) { animation-delay: 0.24s; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .stat-icon {
    width: 48px; height: 48px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
  }

  .stat-icon.c-blue    { background: rgba(85,133,224,0.12);  color: var(--d-blue);    border: 1px solid rgba(85,133,224,0.2); }
  .stat-icon.c-success { background: rgba(61,185,122,0.12);  color: var(--d-success); border: 1px solid rgba(61,185,122,0.2); }
  .stat-icon.c-warning { background: rgba(224,160,48,0.12);  color: var(--d-warning); border: 1px solid rgba(224,160,48,0.2); }
  .stat-icon.c-gold    { background: rgba(197,160,85,0.12);  color: var(--d-gold);    border: 1px solid rgba(197,160,85,0.2); }

  .stat-meta {}
  .stat-label {
    font-size: 0.63rem; font-weight: 700;
    letter-spacing: 0.15em; text-transform: uppercase;
    color: var(--d-muted); margin-bottom: 6px;
  }
  .stat-value {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.1rem; font-weight: 700;
    color: var(--d-text); line-height: 1;
  }

  /* ════════════════ CHARTS GRID ════════════════ */
  .charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
    gap: 20px;
    margin-bottom: 28px;
  }

  .chart-card {
    background: var(--d-surface);
    border: 1px solid var(--d-border);
    border-radius: var(--d-radius);
    overflow: hidden;
    transition: all var(--tr);
    position: relative;
  }

  .chart-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, var(--d-gold), transparent);
    opacity: 0.18;
  }

  .chart-card:hover { border-color: var(--d-border-g); }

  .chart-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--d-border);
    display: flex; align-items: center; justify-content: space-between;
  }

  .chart-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem; font-weight: 600;
    color: var(--d-text); margin: 0;
    display: flex; align-items: center; gap: 10px;
    letter-spacing: 0.02em;
  }

  .chart-title i { color: var(--d-gold); font-size: 17px; }

  .chart-badge {
    font-size: 0.62rem; font-weight: 700;
    letter-spacing: 0.12em; text-transform: uppercase;
    color: var(--d-muted);
    background: var(--d-surface2);
    border: 1px solid var(--d-border);
    border-radius: 20px; padding: 4px 10px;
  }

  .chart-body { padding: 28px 24px; }

  .revenue-chart-wrap {
    position: relative;
    height: 260px;
  }

  /* ── DONUT CHART ── */
  .donut-chart {
    display: flex; align-items: center;
    justify-content: center; gap: 36px;
    flex-wrap: wrap;
  }

  .donut-container {
    position: relative;
    width: 190px; height: 190px; flex-shrink: 0;
  }

  .donut {
    width: 100%; height: 100%; border-radius: 50%;
    background: conic-gradient(
      var(--d-blue)    0deg,
      var(--d-blue)    var(--disponible-deg),
      var(--d-warning) var(--disponible-deg),
      var(--d-warning) var(--vendu-deg),
      var(--d-success) var(--vendu-deg),
      var(--d-success) 360deg
    );
    position: relative;
    box-shadow: 0 0 40px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.04);
  }

  .donut::before {
    content: '';
    position: absolute; top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 130px; height: 130px;
    background: var(--d-surface);
    border-radius: 50%;
    box-shadow: inset 0 0 20px rgba(0,0,0,0.3);
  }

  .donut-center {
    position: absolute; top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    text-align: center; z-index: 1;
  }

  .donut-center .total {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem; font-weight: 700;
    color: var(--d-text); line-height: 1;
  }

  .donut-center .dlabel {
    font-size: 0.62rem; color: var(--d-muted);
    letter-spacing: 0.12em; text-transform: uppercase;
    margin-top: 3px; display: block;
  }

  .donut-legend {
    display: flex; flex-direction: column; gap: 14px;
  }

  .legend-item {
    display: flex; align-items: center; gap: 12px;
  }

  .legend-dot {
    width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
  }

  .legend-info {}
  .legend-label {
    font-size: 0.82rem; font-weight: 500; color: var(--d-soft);
    display: block;
  }
  .legend-val {
    font-size: 0.72rem; color: var(--d-muted);
  }

  /* ════════════════ ACTIVITY ════════════════ */
  .activity-card {
    background: var(--d-surface);
    border: 1px solid var(--d-border);
    border-radius: var(--d-radius);
    overflow: hidden; position: relative;
  }

  .activity-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, var(--d-gold), transparent);
    opacity: 0.18;
  }

  .activity-head {
    padding: 20px 24px;
    border-bottom: 1px solid var(--d-border);
    display: flex; align-items: center; justify-content: space-between;
  }

  .activity-head-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem; font-weight: 600; color: var(--d-text);
    margin: 0; display: flex; align-items: center; gap: 10px;
    letter-spacing: 0.02em;
  }

  .activity-head-title i { color: var(--d-gold); }

  .btn-see-all {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 16px; border-radius: 50px;
    border: 1px solid var(--d-border);
    background: transparent; color: var(--d-soft);
    font-size: 0.78rem; font-weight: 500;
    text-decoration: none; transition: all 0.22s ease;
    letter-spacing: 0.03em;
  }

  .btn-see-all:hover {
    border-color: var(--d-border-g); color: var(--d-gold);
    background: var(--d-gold-dim);
  }

  .activity-list { padding: 16px; }

  .activity-item {
    display: flex; gap: 14px;
    padding: 14px 16px;
    border-radius: var(--d-radius-sm);
    transition: all 0.22s ease;
    margin-bottom: 8px;
    border: 1px solid transparent;
    position: relative;
  }

  .activity-item:last-child { margin-bottom: 0; }

  .activity-item:hover {
    background: var(--d-surface2);
    border-color: var(--d-border);
    transform: translateX(3px);
  }

  .act-icon {
    width: 44px; height: 44px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
    background: rgba(197,160,85,0.1);
    border: 1px solid rgba(197,160,85,0.2);
    color: var(--d-gold);
  }

  .act-body { flex: 1; min-width: 0; }

  .act-title {
    font-size: 0.875rem; font-weight: 500;
    color: var(--d-text); margin-bottom: 3px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }

  .act-desc {
    font-size: 0.78rem; color: var(--d-muted); margin-bottom: 5px;
  }

  .act-time {
    font-size: 0.7rem; color: var(--d-muted);
    display: flex; align-items: center; gap: 4px;
  }

  .act-time i { font-size: 11px; color: var(--d-gold); }

  .empty-state {
    text-align: center; padding: 56px 20px;
  }

  .empty-state i {
    font-size: 52px; color: var(--d-muted); opacity: 0.25;
    margin-bottom: 14px; display: block;
  }

  .empty-state h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.3rem; font-weight: 600;
    color: var(--d-soft); margin-bottom: 6px;
  }

  .empty-state p { color: var(--d-muted); font-size: 0.82rem; }

  /* ════════════════ RESPONSIVE ════════════════ */
  @media (max-width: 1100px) {
    .charts-grid { grid-template-columns: 1fr; }
    .stats-grid  { grid-template-columns: repeat(2, 1fr); }
  }

  @media (max-width: 768px) {
    .page-head { flex-direction: column; }
    .btn-add, .btn-pdf { width: 100%; justify-content: center; }
    .donut-chart { flex-direction: column; gap: 24px; }
    .head-actions { width: 100%; }
  }

  @media (max-width: 576px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .page-title { font-size: 1.65rem; }
  }
</style>
@endsection

@section('content')
<div class="dash-zone">

  {{-- ════════ HEADER ════════ --}}
  <div class="page-head">
    <div>
      <h1 class="page-title">Tableau de bord</h1>
      <p class="page-subtitle">Bienvenue — voici l'état de votre portefeuille immobilier</p>
    </div>
    <div class="head-actions">
      @if(in_array(Auth::user()->role, ['owner', 'admin']))
      <a href="{{ route('properties.create') }}" class="btn-add">
        <i class="bi bi-plus-lg"></i>
        <span>Ajouter une propriété</span>
      </a>
      @endif

      @if(Auth::user()->role === 'admin')
      <a href="{{ route('dashboard.export.pdf') }}" class="btn-pdf">
        <i class="bi bi-file-earmark-pdf"></i>
        <span>Télécharger PDF</span>
      </a>
      @endif
    </div>
  </div>

  {{-- ════════ STATS ════════ --}}

  @php
    // ✅ Clés normalisées — fonctionnent pour admin ET owner
    $totalProperties     = $stats['totalProperties']     ?? 0;
    $availableProperties = $stats['availableProperties'] ?? 0;
    $soldProperties      = $stats['soldProperties']      ?? 0;
    $rentedProperties    = $stats['rentedProperties']    ?? 0;
  @endphp

  <div class="stats-grid">

    @if(Auth::user()->role == 'admin')
      {{-- ── ADMIN : 4 cartes globales ── --}}
      <div class="stat-card c-blue">
        <div class="stat-icon c-blue"><i class="bi bi-building"></i></div>
        <div class="stat-meta">
          <div class="stat-label">Total Propriétés</div>
          <div class="stat-value">{{ $totalProperties }}</div>
        </div>
      </div>

      <div class="stat-card c-success">
        <div class="stat-icon c-success"><i class="bi bi-check-circle"></i></div>
        <div class="stat-meta">
          <div class="stat-label">Disponibles</div>
          <div class="stat-value">{{ $availableProperties }}</div>
        </div>
      </div>

      <div class="stat-card c-warning">
        <div class="stat-icon c-warning"><i class="bi bi-cash-coin"></i></div>
        <div class="stat-meta">
          <div class="stat-label">Vendues</div>
          <div class="stat-value">{{ $soldProperties }}</div>
        </div>
      </div>

      <div class="stat-card c-gold">
        <div class="stat-icon c-gold"><i class="bi bi-house-check"></i></div>
        <div class="stat-meta">
          <div class="stat-label">Louées</div>
          <div class="stat-value">{{ $rentedProperties }}</div>
        </div>
      </div>

    @elseif(Auth::user()->role == 'owner')
      {{-- ── OWNER : 4 cartes filtrées sur ses propriétés ── --}}
      <div class="stat-card c-blue">
        <div class="stat-icon c-blue"><i class="bi bi-house-door"></i></div>
        <div class="stat-meta">
          <div class="stat-label">Mes Propriétés</div>
          <div class="stat-value">{{ $stats['myProperties'] ?? 0 }}</div>
        </div>
      </div>

      <div class="stat-card c-success">
        <div class="stat-icon c-success"><i class="bi bi-check-circle"></i></div>
        <div class="stat-meta">
          <div class="stat-label">Disponibles</div>
          <div class="stat-value">{{ $stats['myAvailable'] ?? 0 }}</div>
        </div>
      </div>

      <div class="stat-card c-warning">
        <div class="stat-icon c-warning"><i class="bi bi-cash-coin"></i></div>
        <div class="stat-meta">
          <div class="stat-label">Vendues</div>
          <div class="stat-value">{{ $stats['mySold'] ?? 0 }}</div>
        </div>
      </div>

      <div class="stat-card c-gold">
        <div class="stat-icon c-gold"><i class="bi bi-house-check"></i></div>
        <div class="stat-meta">
          <div class="stat-label">Louées</div>
          <div class="stat-value">{{ $stats['myRented'] ?? 0 }}</div>
        </div>
      </div>
    @endif

  </div>

  {{-- ════════ PHP DATA pour le donut ════════ --}}
  @php
    $totalNonZero  = $totalProperties > 0 ? $totalProperties : 1;
    $disponiblePct = ($availableProperties / $totalNonZero) * 100;
    $venduPct      = ($soldProperties      / $totalNonZero) * 100;
    $louePct       = ($rentedProperties    / $totalNonZero) * 100;

    $disponibleDeg = ($disponiblePct / 100) * 360;
    $venduDeg      = $disponibleDeg + (($venduPct / 100) * 360);
  @endphp

  {{-- ════════ CHARTS — visibles pour admin ET owner ════════ --}}
  @if(in_array(Auth::user()->role, ['admin', 'owner']))
  <div class="charts-grid">

    {{-- Graphique revenus mensuels --}}
    <div class="chart-card">
      <div class="chart-header">
        <h3 class="chart-title">
          <i class="bi bi-graph-up-arrow"></i>
          @if(Auth::user()->role === 'admin')
            Historique de revenus
          @else
            Mes revenus (propriétés vendues / louées)
          @endif
        </h3>
        <span class="chart-badge">{{ now()->year }}</span>
      </div>
      <div class="chart-body">
        <div class="revenue-chart-wrap">
          <canvas id="revenueChart"></canvas>
        </div>
      </div>
    </div>

    {{-- Donut répartition des statuts --}}
    <div class="chart-card">
      <div class="chart-header">
        <h3 class="chart-title">
          <i class="bi bi-pie-chart-fill"></i>
          Répartition des statuts
        </h3>
        <span class="chart-badge">{{ $totalProperties }} total</span>
      </div>
      <div class="chart-body">
        @if($totalProperties > 0)
        <div class="donut-chart">
          <div class="donut-container">
            <div class="donut"
                 style="--disponible-deg: {{ $disponibleDeg }}deg;
                        --vendu-deg: {{ $venduDeg }}deg;">
              <div class="donut-center">
                <div class="total">{{ $totalProperties }}</div>
                <span class="dlabel">Total</span>
              </div>
            </div>
          </div>
          <div class="donut-legend">
            <div class="legend-item">
              <div class="legend-dot" style="background: var(--d-blue);"></div>
              <div class="legend-info">
                <span class="legend-label">Disponibles</span>
                <span class="legend-val">{{ $availableProperties }} · {{ number_format($disponiblePct,1) }}%</span>
              </div>
            </div>
            <div class="legend-item">
              <div class="legend-dot" style="background: var(--d-warning);"></div>
              <div class="legend-info">
                <span class="legend-label">Vendues</span>
                <span class="legend-val">{{ $soldProperties }} · {{ number_format($venduPct,1) }}%</span>
              </div>
            </div>
            <div class="legend-item">
              <div class="legend-dot" style="background: var(--d-success);"></div>
              <div class="legend-info">
                <span class="legend-label">Louées</span>
                <span class="legend-val">{{ $rentedProperties }} · {{ number_format($louePct,1) }}%</span>
              </div>
            </div>
          </div>
        </div>
        @else
        <div class="empty-state">
          <i class="bi bi-pie-chart"></i>
          <h3>Aucune donnée</h3>
          <p>Les statistiques apparaîtront ici</p>
        </div>
        @endif
      </div>
    </div>

  </div>
  @endif

  {{-- ════════ ACTIVITÉS RÉCENTES ════════ --}}
  <div class="activity-card">
    <div class="activity-head">
      <h3 class="activity-head-title">
        <i class="bi bi-clock-history"></i>
        Activités récentes
      </h3>
      <a href="{{ route('properties.index') }}" class="btn-see-all">
        Voir tout <i class="bi bi-arrow-right"></i>
      </a>
    </div>
    <div class="activity-list">
      @if($recentActivities->count() > 0)
        @foreach($recentActivities as $activity)
        <div class="activity-item">
          <div class="act-icon">
            <i class="bi bi-house-door"></i>
          </div>
          <div class="act-body">
            <div class="act-title">{{ $activity->title }}</div>
            <div class="act-desc">
              {{ ucfirst($activity->type) }} &middot; {{ $activity->city }}
              &middot; {{ number_format($activity->price, 0, ',', ' ') }} Ar
            </div>
            <div class="act-time">
              <i class="bi bi-clock"></i>
              {{ $activity->created_at->diffForHumans() }}
            </div>
          </div>
        </div>
        @endforeach
      @else
      <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <h3>Aucune activité</h3>
        <p>Les activités récentes apparaîtront ici</p>
      </div>
      @endif
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

@if(in_array(Auth::user()->role, ['admin', 'owner']))
<script>
  const revenueData = @json($monthlyRevenue ?? array_fill(0, 12, 0));

  const ctx = document.getElementById('revenueChart').getContext('2d');

  const gradient = ctx.createLinearGradient(0, 0, 0, 260);
  gradient.addColorStop(0,   'rgba(197,160,85,0.35)');
  gradient.addColorStop(1,   'rgba(197,160,85,0.02)');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan','Fév','Mar','Avr','Mai','Juin','Juil','Aoû','Sep','Oct','Nov','Déc'],
      datasets: [{
        label: 'Revenus (Ar)',
        data: revenueData,
        borderColor: '#c5a055',
        borderWidth: 2.5,
        pointBackgroundColor: '#c5a055',
        pointBorderColor: '#0d1018',
        pointBorderWidth: 2,
        pointRadius: 5,
        pointHoverRadius: 7,
        backgroundColor: gradient,
        fill: true,
        tension: 0.4,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: { mode: 'index', intersect: false },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#161924',
          borderColor: 'rgba(197,160,85,0.3)',
          borderWidth: 1,
          titleColor: '#c5a055',
          bodyColor: '#f0ede8',
          padding: 12,
          callbacks: {
            label: ctx => ' ' + Number(ctx.raw).toLocaleString('fr-MG') + ' Ar'
          }
        }
      },
      scales: {
        x: {
          grid: { color: 'rgba(255,255,255,0.04)' },
          ticks: { color: '#50535c', font: { size: 11 } },
          border: { color: 'rgba(255,255,255,0.055)' }
        },
        y: {
          min: 0,
          ticks: {
            color: '#50535c',
            font: { size: 11 },
            callback: val => val.toLocaleString('fr-MG') + ' Ar'
          },
          grid: { color: 'rgba(255,255,255,0.04)' },
          border: { color: 'rgba(255,255,255,0.055)' }
        }
      }
    }
  });
</script>
@endif
@endsection