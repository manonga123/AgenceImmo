@extends('layouts.layout')

@section('title', 'Recherche de propriétés')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    /* ══════════════════════════════════════
       VARIABLES — même thème que properties
    ══════════════════════════════════════ */
    :root {
        --primary-color:  #2563eb;
        --primary-dark:   #1d4ed8;
        --primary-light:  #eff6ff;
        --primary-mid:    #dbeafe;
        --accent-color:   #06b6d4;
        --success-color:  #10b981;
        --warning-color:  #f59e0b;
        --danger-color:   #ef4444;
        --text-primary:   #0f172a;
        --text-secondary: #64748b;
        --text-muted:     #94a3b8;
        --bg-primary:     #f8fafc;
        --bg-secondary:   #f1f5f9;
        --border-color:   #e2e8f0;
        --white:          #ffffff;
        --shadow-sm:      0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
        --shadow-md:      0 4px 16px rgba(0,0,0,.07), 0 2px 6px rgba(0,0,0,.04);
        --shadow-lg:      0 10px 32px rgba(0,0,0,.10), 0 4px 10px rgba(0,0,0,.05);
        --shadow-xl:      0 20px 60px rgba(0,0,0,.13);
        --shadow-blue:    0 4px 20px rgba(37,99,235,.25);
        --radius-sm:      8px;
        --radius:         12px;
        --radius-lg:      18px;
        --radius-xl:      24px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Inter', sans-serif;
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 14px;
        line-height: 1.6;
    }

    /* ══════════════════════════════════════
       PAGE HERO BANNER
    ══════════════════════════════════════ */
    .search-hero {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 60%, #1e3a8a 100%);
        padding: 48px 40px 100px;
        position: relative;
        overflow: hidden;
    }

    .search-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .search-hero::after {
        content: '';
        position: absolute;
        bottom: -2px; left: 0; right: 0;
        height: 64px;
        background: var(--bg-primary);
        clip-path: ellipse(55% 100% at 50% 100%);
    }

    .hero-inner {
        position: relative;
        z-index: 1;
        text-align: center;
        max-width: 680px;
        margin: 0 auto;
    }

    .hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 20px;
        padding: 5px 14px;
        font-size: 12px;
        font-weight: 600;
        color: rgba(255,255,255,0.9);
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 18px;
        backdrop-filter: blur(6px);
    }

    .hero-title {
        font-size: 38px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -1px;
        line-height: 1.15;
        margin-bottom: 10px;
    }

    .hero-title span {
        color: #93c5fd;
    }

    .hero-subtitle {
        color: rgba(255,255,255,0.65);
        font-size: 15px;
        font-weight: 400;
    }

    /* ══════════════════════════════════════
       FLOATING SEARCH BAR (overlap hero)
    ══════════════════════════════════════ */
    .search-bar-wrap {
        max-width: 860px;
        margin: -44px auto 0;
        padding: 0 24px;
        position: relative;
        z-index: 10;
    }

    .search-bar {
        background: var(--white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-xl);
        padding: 8px 8px 8px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid rgba(37,99,235,.08);
    }

    .search-bar-input {
        flex: 1;
        border: none;
        outline: none;
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        color: var(--text-primary);
        background: transparent;
    }

    .search-bar-input::placeholder { color: var(--text-muted); }

    .search-bar-divider {
        width: 1px;
        height: 28px;
        background: var(--border-color);
        flex-shrink: 0;
    }

    .search-bar-select {
        border: none;
        outline: none;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: var(--text-secondary);
        background: transparent;
        padding: 0 8px;
        cursor: pointer;
        min-width: 110px;
    }

    .search-bar-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        border: none;
        border-radius: var(--radius-lg);
        padding: 14px 28px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.25s;
        white-space: nowrap;
        box-shadow: var(--shadow-blue);
    }

    .search-bar-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 28px rgba(37,99,235,.4);
    }

    /* ══════════════════════════════════════
       MAIN LAYOUT
    ══════════════════════════════════════ */
    .page-body {
        max-width: 1400px;
        margin: 0 auto;
        padding: 32px 24px 60px;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 28px;
        align-items: start;
    }

    /* ══════════════════════════════════════
       FILTERS PANEL
    ══════════════════════════════════════ */
    .filters-panel {
        position: sticky;
        top: 20px;
    }

    .filter-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        overflow: hidden;
        margin-bottom: 16px;
    }

    .filter-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid var(--border-color);
        background: linear-gradient(135deg, var(--primary-light), var(--white));
    }

    .filter-card-head-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        color: var(--primary-color);
        letter-spacing: 0.3px;
    }

    .filter-card-head-title i { font-size: 15px; }

    .filter-clear-link {
        font-size: 11px;
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.15s;
    }
    .filter-clear-link:hover { color: var(--danger-color); }

    .filter-body {
        padding: 18px 20px;
    }

    .filter-group {
        margin-bottom: 20px;
    }
    .filter-group:last-child { margin-bottom: 0; }

    .filter-group-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 8px;
        display: block;
    }

    /* Type chips */
    .type-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .type-chips input[type="radio"] { display: none; }

    .type-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 11px;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-sm);
        font-size: 12px;
        font-weight: 500;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.18s;
        user-select: none;
        background: var(--bg-primary);
    }

    .type-chips input:checked + .type-chip {
        background: var(--primary-light);
        border-color: var(--primary-color);
        color: var(--primary-color);
        font-weight: 600;
    }

    .type-chip:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        background: var(--primary-light);
    }

    /* Inputs */
    .filter-input,
    .filter-select {
        width: 100%;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-sm);
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        color: var(--text-primary);
        padding: 9px 12px;
        outline: none;
        background: var(--bg-primary);
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .filter-input:focus,
    .filter-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37,99,235,.08);
        background: var(--white);
    }

    .filter-input::placeholder { color: var(--text-muted); }

    .filter-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    /* Range */
    .filter-range {
        -webkit-appearance: none;
        width: 100%;
        height: 4px;
        border-radius: 2px;
        background: var(--primary-mid);
        outline: none;
        margin: 10px 0 4px;
    }

    .filter-range::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--primary-color);
        cursor: pointer;
        box-shadow: 0 0 0 3px rgba(37,99,235,.2);
        transition: box-shadow 0.2s;
    }
    .filter-range::-webkit-slider-thumb:hover {
        box-shadow: 0 0 0 5px rgba(37,99,235,.15);
    }

    .range-labels {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* Search btn */
    .btn-filter-search {
        width: 100%;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        border: none;
        border-radius: var(--radius-sm);
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        font-weight: 600;
        padding: 12px;
        cursor: pointer;
        transition: all 0.25s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: var(--shadow-blue);
        margin-bottom: 8px;
    }

    .btn-filter-search:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 24px rgba(37,99,235,.4);
    }

    .btn-filter-reset {
        width: 100%;
        background: transparent;
        color: var(--text-secondary);
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-sm);
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 500;
        padding: 9px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-filter-reset:hover {
        border-color: var(--danger-color);
        color: var(--danger-color);
        background: #fff5f5;
    }

    /* Stats mini card */
    .stats-mini {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        border-radius: var(--radius-lg);
        padding: 18px 20px;
        box-shadow: var(--shadow-blue);
    }

    .stats-mini-title {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.55);
        margin-bottom: 14px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .stat-box {
        background: rgba(255,255,255,0.1);
        border-radius: var(--radius-sm);
        padding: 12px;
        text-align: center;
        backdrop-filter: blur(6px);
    }

    .stat-box-val {
        font-size: 22px;
        font-weight: 800;
        color: white;
        line-height: 1;
        margin-bottom: 3px;
    }

    .stat-box-key {
        font-size: 10px;
        color: rgba(255,255,255,0.55);
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    .stats-types { margin-top: 12px; }

    .stat-type-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 5px 0;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .stat-type-row:last-child { border-bottom: none; }

    .stat-type-name { font-size: 12px; color: rgba(255,255,255,0.65); }

    .stat-type-bar-wrap {
        flex: 1;
        height: 3px;
        background: rgba(255,255,255,0.15);
        border-radius: 2px;
        margin: 0 10px;
    }

    .stat-type-bar {
        height: 100%;
        background: rgba(255,255,255,0.7);
        border-radius: 2px;
        transition: width 0.6s ease;
    }

    .stat-type-count {
        font-size: 11px;
        font-weight: 600;
        color: white;
    }

    /* ══════════════════════════════════════
       RESULTS AREA
    ══════════════════════════════════════ */
    .results-area {}

    /* Toolbar */
    .results-toolbar {
        background: var(--white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        padding: 14px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 12px;
        flex-wrap: wrap;
    }

    .toolbar-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .results-badge {
        background: var(--primary-light);
        color: var(--primary-color);
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 700;
    }

    .results-label {
        font-size: 13px;
        font-weight: 500;
        color: var(--text-secondary);
    }

    .toolbar-right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .toolbar-sort {
        appearance: none;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-sm);
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        color: var(--text-primary);
        padding: 8px 32px 8px 12px;
        background: var(--bg-primary);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        outline: none;
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .toolbar-sort:focus { border-color: var(--primary-color); }

    /* View toggle */
    .view-toggle {
        display: flex;
        background: var(--bg-secondary);
        border-radius: var(--radius-sm);
        padding: 3px;
        gap: 2px;
    }

    .view-btn {
        background: transparent;
        border: none;
        border-radius: 6px;
        padding: 7px 11px;
        cursor: pointer;
        color: var(--text-muted);
        font-size: 14px;
        transition: all 0.18s;
        line-height: 1;
    }

    .view-btn.active {
        background: var(--primary-color);
        color: white;
        box-shadow: var(--shadow-sm);
    }

    /* Active filter chips */
    .active-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px;
    }

    .active-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--primary-light);
        border: 1px solid var(--primary-mid);
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 500;
        color: var(--primary-dark);
    }

    .active-chip .chip-remove {
        display: flex;
        align-items: center;
        color: var(--primary-color);
        opacity: 0.6;
        text-decoration: none;
        transition: opacity 0.15s;
        font-size: 13px;
    }

    .active-chip .chip-remove:hover { opacity: 1; color: var(--danger-color); }

    .chip-clear-all {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #fff5f5;
        border: 1px solid #fecaca;
        border-radius: 20px;
        padding: 5px 13px;
        font-size: 12px;
        font-weight: 600;
        color: var(--danger-color);
        text-decoration: none;
        transition: all 0.2s;
    }
    .chip-clear-all:hover { background: var(--danger-color); color: white; border-color: var(--danger-color); }

    /* ══════════════════════════════════════
       PROPERTY CARDS — GRID VIEW
    ══════════════════════════════════════ */
    .props-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .prop-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.32s cubic-bezier(.25,.46,.45,.94);
        display: flex;
        flex-direction: column;
        animation: cardIn 0.45s ease both;
    }

    @keyframes cardIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .prop-card:nth-child(1) { animation-delay: .05s }
    .prop-card:nth-child(2) { animation-delay: .10s }
    .prop-card:nth-child(3) { animation-delay: .15s }
    .prop-card:nth-child(4) { animation-delay: .20s }
    .prop-card:nth-child(5) { animation-delay: .25s }
    .prop-card:nth-child(6) { animation-delay: .30s }

    .prop-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
        border-color: transparent;
    }

    /* Image zone */
    .prop-img {
        position: relative;
        height: 215px;
        overflow: hidden;
        background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
    }

    .prop-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .prop-card:hover .prop-img img { transform: scale(1.06); }

    .prop-no-img {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .prop-no-img i { font-size: 40px; color: #cbd5e0; }
    .prop-no-img span { font-size: 11px; color: var(--text-muted); letter-spacing: 0.5px; }

    /* Image overlays */
    .img-top-row {
        position: absolute;
        top: 12px;
        left: 12px;
        right: 12px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .img-badges { display: flex; gap: 5px; flex-wrap: wrap; }

    .badge-type {
        background: rgba(15,23,42,.75);
        color: white;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        padding: 4px 9px;
        border-radius: 6px;
        backdrop-filter: blur(8px);
    }

    .badge-status {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        padding: 4px 9px;
        border-radius: 6px;
        backdrop-filter: blur(8px);
    }

    .badge-disponible { background: rgba(16,185,129,.85); color: white; }
    .badge-vendu      { background: rgba(239,68,68,.85);  color: white; }
    .badge-loue, .badge-lou\E9 { background: rgba(245,158,11,.9); color: var(--text-primary); }

    /* Image count pill */
    .img-count {
        background: rgba(15,23,42,.65);
        color: white;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
        backdrop-filter: blur(8px);
    }

    .img-price {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 28px 14px 12px;
        background: linear-gradient(to top, rgba(15,23,42,.75) 0%, transparent 100%);
        color: white;
        font-size: 18px;
        font-weight: 800;
        letter-spacing: -0.3px;
    }

    /* Card body */
    .prop-body {
        padding: 18px 18px 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .prop-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 6px;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .prop-location {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: var(--text-secondary);
        margin-bottom: 12px;
    }

    .prop-location i { color: var(--primary-color); font-size: 13px; }

    /* Feature pills */
    .prop-features {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .feat-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: var(--bg-secondary);
        border-radius: 6px;
        padding: 4px 9px;
        font-size: 11px;
        font-weight: 600;
        color: var(--text-secondary);
    }

    .feat-pill i { font-size: 12px; color: var(--primary-color); }

    .prop-desc {
        font-size: 12px;
        color: var(--text-muted);
        line-height: 1.5;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 14px;
    }

    /* Card footer */
    .prop-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 1px solid var(--bg-secondary);
        margin-top: auto;
    }

    .prop-date {
        font-size: 11px;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .btn-view {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.22s;
        box-shadow: 0 2px 8px rgba(37,99,235,.3);
    }

    .btn-view:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(37,99,235,.4);
        color: white;
    }

    /* ══════════════════════════════════════
       LIST VIEW
    ══════════════════════════════════════ */
    .props-list {
        display: none;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 32px;
    }

    .props-list.active { display: flex; }
    .props-grid.hidden { display: none; }

    .list-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        overflow: hidden;
        display: grid;
        grid-template-columns: 240px 1fr;
        box-shadow: var(--shadow-md);
        transition: all 0.25s;
        animation: cardIn 0.4s ease both;
    }

    .list-card:hover {
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-mid);
        transform: translateX(3px);
    }

    .list-img-wrap {
        position: relative;
        overflow: hidden;
    }

    .list-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        min-height: 170px;
        transition: transform 0.4s;
    }

    .list-card:hover .list-img-wrap img { transform: scale(1.04); }

    .list-body {
        padding: 20px 22px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .list-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 10px;
    }

    .list-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .list-price {
        font-size: 20px;
        font-weight: 800;
        color: var(--primary-color);
        white-space: nowrap;
        letter-spacing: -0.3px;
    }

    /* ══════════════════════════════════════
       EMPTY STATE
    ══════════════════════════════════════ */
    .empty-state {
        background: var(--white);
        border-radius: var(--radius-xl);
        border: 2px dashed var(--border-color);
        padding: 72px 40px;
        text-align: center;
    }

    .empty-icon-wrap {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .empty-icon-wrap i {
        font-size: 36px;
        color: var(--primary-color);
    }

    .empty-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 8px;
    }

    .empty-text {
        color: var(--text-secondary);
        font-size: 14px;
        margin-bottom: 24px;
    }

    .btn-empty {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        border-radius: var(--radius);
        padding: 12px 28px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s;
        box-shadow: var(--shadow-blue);
    }

    .btn-empty:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(37,99,235,.4); color: white; }

    /* ══════════════════════════════════════
       AUTOCOMPLETE
    ══════════════════════════════════════ */
    .autocomplete-dropdown {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        background: white;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius);
        z-index: 1000;
        display: none;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .autocomplete-item {
        padding: 10px 16px;
        font-size: 13px;
        cursor: pointer;
        color: var(--text-secondary);
        border-bottom: 1px solid var(--bg-secondary);
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background 0.15s;
    }

    .autocomplete-item:last-child { border-bottom: none; }
    .autocomplete-item:hover { background: var(--primary-light); color: var(--primary-color); }
    .autocomplete-item i { font-size: 12px; color: var(--primary-color); }

    /* ══════════════════════════════════════
       PAGINATION
    ══════════════════════════════════════ */
    .pagination-wrap {
        display: flex;
        justify-content: center;
        padding-top: 8px;
    }

    /* Responsive */
    @media (max-width: 1100px) {
        .page-body { grid-template-columns: 250px 1fr; padding: 24px 16px 48px; }
        .search-hero { padding: 36px 24px 80px; }
        .search-bar-wrap { padding: 0 16px; }
    }

    @media (max-width: 768px) {
        .page-body { grid-template-columns: 1fr; }
        .filters-panel { position: static; }
        .props-grid { grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); }
        .list-card { grid-template-columns: 1fr; }
        .hero-title { font-size: 26px; }
        .search-bar { flex-wrap: wrap; padding: 12px; gap: 8px; }
        .search-bar-divider { display: none; }
        .search-bar-input { min-width: 0; width: 100%; }
    }
</style>
@endsection


@section('content')

{{-- ═══════════════ HERO ═══════════════ --}}
<div class="search-hero">
    <div class="hero-inner">
        <div class="hero-tag">
            <i class="bi bi-house-heart"></i> Recherche immobilière
        </div>
        <h1 class="hero-title">
            Trouvez votre<br><span>bien idéal</span>
        </h1>
        <p class="hero-subtitle">{{ $properties->total() ?? 0 }} propriétés disponibles à la recherche</p>
    </div>
</div>

{{-- ═══════════════ FLOATING SEARCH BAR ═══════════════ --}}
<div class="search-bar-wrap">
    <div class="search-bar">
        <i class="bi bi-search" style="color:var(--primary-color);font-size:16px;flex-shrink:0;"></i>
        <input class="search-bar-input"
               type="text"
               placeholder="Rechercher par titre, ville, description…"
               id="heroKeyword"
               value="{{ request('keyword') }}"
               autocomplete="off">
        <div class="search-bar-divider"></div>
        <select class="search-bar-select" id="heroCity">
            <option value="">Toutes les villes</option>
            @foreach($filterData['cities'] as $city)
                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
            @endforeach
        </select>
        <div class="search-bar-divider"></div>
        <select class="search-bar-select" id="heroStatus">
            <option value="">Tout statut</option>
            <option value="disponible" {{ request('status')=='disponible' ? 'selected' : '' }}>Disponible</option>
            <option value="loué" {{ request('status')=='loué' ? 'selected' : '' }}>Loué</option>
            <option value="vendu" {{ request('status')=='vendu' ? 'selected' : '' }}>Vendu</option>
        </select>
        <button class="search-bar-btn" id="heroSearchBtn">
            <i class="bi bi-search"></i> Rechercher
        </button>
    </div>
</div>

{{-- ═══════════════ PAGE BODY ═══════════════ --}}
<div class="page-body">

    {{-- ── SIDEBAR FILTERS ── --}}
    <aside class="filters-panel">
        <div class="filter-card">
            <div class="filter-card-head">
                <div class="filter-card-head-title">
                    <i class="bi bi-sliders"></i>
                    Filtres avancés
                </div>
                <a href="{{ route('search.index') }}" class="filter-clear-link">
                    <i class="bi bi-x-circle me-1"></i>Effacer
                </a>
            </div>
            <div class="filter-body">
                <form id="searchForm" action="{{ route('search.submit') }}" method="GET">

                    {{-- Mot-clé --}}
                    <div class="filter-group">
                        <label class="filter-group-label">Mot-clé</label>
                        <div style="position:relative">
                            <input type="text"
                                   class="filter-input"
                                   id="keyword"
                                   name="keyword"
                                   placeholder="Maison, appartement, ville…"
                                   value="{{ request('keyword') }}"
                                   autocomplete="off"
                                   style="padding-left:36px">
                            <i class="bi bi-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:13px;pointer-events:none"></i>
                            <div id="autocompleteResults" class="autocomplete-dropdown"></div>
                        </div>
                    </div>

                    {{-- Type --}}
                    <div class="filter-group">
                        <label class="filter-group-label">Type de bien</label>
                        <div class="type-chips">
                            <input type="radio" name="type" id="t_all" value="" {{ !request('type') ? 'checked' : '' }}>
                            <label class="type-chip" for="t_all">Tous</label>

                            <input type="radio" name="type" id="t_maison" value="maison" {{ request('type')=='maison' ? 'checked' : '' }}>
                            <label class="type-chip" for="t_maison"><i class="bi bi-house"></i>Maison</label>

                            <input type="radio" name="type" id="t_appart" value="appartement" {{ request('type')=='appartement' ? 'checked' : '' }}>
                            <label class="type-chip" for="t_appart"><i class="bi bi-building"></i>Appart.</label>

                            <input type="radio" name="type" id="t_terrain" value="terrain" {{ request('type')=='terrain' ? 'checked' : '' }}>
                            <label class="type-chip" for="t_terrain"><i class="bi bi-tree"></i>Terrain</label>

                            <input type="radio" name="type" id="t_bureau" value="bureau" {{ request('type')=='bureau' ? 'checked' : '' }}>
                            <label class="type-chip" for="t_bureau"><i class="bi bi-briefcase"></i>Bureau</label>
                        </div>
                    </div>

                    {{-- Prix --}}
                    <div class="filter-group">
                        <label class="filter-group-label">Prix (Ar)</label>
                        <div class="filter-row" style="margin-bottom:8px">
                            <input type="number" class="filter-input" name="min_price" placeholder="Min" value="{{ request('min_price') }}">
                            <input type="number" class="filter-input" name="max_price" placeholder="Max" value="{{ request('max_price') }}" id="maxPriceInput">
                        </div>
                        <input type="range" class="filter-range" id="priceRange"
                               min="0"
                               max="{{ $filterData['price_range']['max'] ?? 1000000 }}"
                               step="10000"
                               value="{{ request('max_price', $filterData['price_range']['max'] ?? 1000000) }}">
                        <div class="range-labels">
                            <span>0</span>
                            <span id="priceRangeLabel">{{ number_format($filterData['price_range']['max'] ?? 1000000, 0, ',', ' ') }} Ar</span>
                        </div>
                    </div>

                    {{-- Surface --}}
                    <div class="filter-group">
                        <label class="filter-group-label">Surface (m²)</label>
                        <div class="filter-row" style="margin-bottom:8px">
                            <input type="number" class="filter-input" name="min_surface" placeholder="Min" value="{{ request('min_surface') }}">
                            <input type="number" class="filter-input" name="max_surface" placeholder="Max" value="{{ request('max_surface') }}" id="maxSurfaceInput">
                        </div>
                        <input type="range" class="filter-range" id="surfaceRange"
                               min="0"
                               max="{{ $filterData['surface_range']['max'] ?? 500 }}"
                               step="10"
                               value="{{ request('max_surface', $filterData['surface_range']['max'] ?? 500) }}">
                        <div class="range-labels">
                            <span>0</span>
                            <span id="surfaceRangeLabel">{{ $filterData['surface_range']['max'] ?? 500 }} m²</span>
                        </div>
                    </div>

                    {{-- Pièces / SDB --}}
                    <div class="filter-group">
                        <label class="filter-group-label">Pièces & salles de bain</label>
                        <div class="filter-row">
                            <select class="filter-select" name="rooms">
                                <option value="">Pièces</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ request('rooms') == $i ? 'selected' : '' }}>{{ $i }}+ pièce{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                            <select class="filter-select" name="bathrooms">
                                <option value="">SDB</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ request('bathrooms') == $i ? 'selected' : '' }}>{{ $i }}+ sdb</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    {{-- Ville --}}
                    <div class="filter-group">
                        <label class="filter-group-label">Ville</label>
                        <select class="filter-select" name="city">
                            <option value="">Toutes les villes</option>
                            @foreach($filterData['cities'] as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Statut --}}
                    <div class="filter-group">
                        <label class="filter-group-label">Statut</label>
                        <select class="filter-select" name="status">
                            <option value="">Tous les statuts</option>
                            <option value="disponible" {{ request('status')=='disponible' ? 'selected' : '' }}>✅ Disponible</option>
                            <option value="loué" {{ request('status')=='loué' ? 'selected' : '' }}>🔑 Loué</option>
                            <option value="vendu" {{ request('status')=='vendu' ? 'selected' : '' }}>🏷 Vendu</option>
                        </select>
                    </div>

                    {{-- Tri --}}
                    <div class="filter-group">
                        <label class="filter-group-label">Trier par</label>
                        <select class="filter-select" name="sort_by">
                            <option value="newest" {{ request('sort_by')=='newest' ? 'selected' : '' }}>Plus récentes</option>
                            <option value="price_asc" {{ request('sort_by')=='price_asc' ? 'selected' : '' }}>Prix croissant</option>
                            <option value="price_desc" {{ request('sort_by')=='price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                            <option value="oldest" {{ request('sort_by')=='oldest' ? 'selected' : '' }}>Plus anciennes</option>
                            <option value="surface_desc" {{ request('sort_by')=='surface_desc' ? 'selected' : '' }}>Surface décroissante</option>
                        </select>
                    </div>

                </form>

                <button type="submit" form="searchForm" class="btn-filter-search">
                    <i class="bi bi-search"></i> Lancer la recherche
                </button>
                <a href="{{ route('search.index') }}" class="btn-filter-reset">
                    <i class="bi bi-arrow-clockwise"></i> Réinitialiser
                </a>
            </div>
        </div>

     
    </aside>

    {{-- ── RESULTS ── --}}
    <div class="results-area">

        {{-- Toolbar --}}
        <div class="results-toolbar">
            <div class="toolbar-left">
                <span class="results-badge">{{ $properties->total() }}</span>
                <span class="results-label">
                    {{ $properties->total() > 1 ? 'propriétés trouvées' : 'propriété trouvée' }}
                </span>
            </div>
            <div class="toolbar-right">
                <select class="toolbar-sort" id="sortSelect">
                    <option value="newest" {{ request('sort_by')=='newest' ? 'selected' : '' }}>Plus récentes</option>
                    <option value="price_asc" {{ request('sort_by')=='price_asc' ? 'selected' : '' }}>Prix ↑</option>
                    <option value="price_desc" {{ request('sort_by')=='price_desc' ? 'selected' : '' }}>Prix ↓</option>
                    <option value="surface_desc" {{ request('sort_by')=='surface_desc' ? 'selected' : '' }}>Surface ↓</option>
                </select>
                <div class="view-toggle">
                    <button type="button" class="view-btn active" id="gridViewBtn" title="Grille">
                        <i class="bi bi-grid-3x3-gap"></i>
                    </button>
                    <button type="button" class="view-btn" id="listViewBtn" title="Liste">
                        <i class="bi bi-list-ul"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Active filter chips --}}
        @php
            $activeFilters = [];
            if(request('keyword'))   $activeFilters[] = ['key'=>'keyword',   'label'=>'« '.request('keyword').' »'];
            if(request('type'))      $activeFilters[] = ['key'=>'type',      'label'=>ucfirst(request('type'))];
            if(request('city'))      $activeFilters[] = ['key'=>'city',      'label'=>request('city')];
            if(request('status'))    $activeFilters[] = ['key'=>'status',    'label'=>ucfirst(request('status'))];
            if(request('min_price')) $activeFilters[] = ['key'=>'min_price', 'label'=>'Min '.number_format(request('min_price'),0,',',' ').' Ar'];
            if(request('max_price')) $activeFilters[] = ['key'=>'max_price', 'label'=>'Max '.number_format(request('max_price'),0,',',' ').' Ar'];
            if(request('rooms'))     $activeFilters[] = ['key'=>'rooms',     'label'=>request('rooms').'+ pièces'];
            if(request('bathrooms')) $activeFilters[] = ['key'=>'bathrooms', 'label'=>request('bathrooms').'+ SDB'];
        @endphp

        @if(count($activeFilters) > 0)
        <div class="active-chips">
            @foreach($activeFilters as $f)
            <div class="active-chip">
                <i class="bi bi-tag-fill" style="font-size:10px"></i>
                {{ $f['label'] }}
                <a href="{{ request()->fullUrlWithoutQuery([$f['key']]) }}" class="chip-remove" title="Retirer">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            @endforeach
            <a href="{{ route('search.index') }}" class="chip-clear-all">
                <i class="bi bi-x-circle"></i> Effacer tout
            </a>
        </div>
        @endif

        @if($properties->count() > 0)

        {{-- GRID --}}
        <div class="props-grid" id="propsGrid">
            @foreach($properties as $property)
            <div class="prop-card">
                <div class="prop-img">
                    @if($property->images->count() > 0)
                        <img src="{{ asset('storage/' . $property->images->first()->image_url) }}"
                             alt="{{ $property->title }}"
                             loading="lazy">
                    @else
                        <div class="prop-no-img">
                            <i class="bi bi-house-door"></i>
                            <span>Aucune photo</span>
                        </div>
                    @endif

                    <div class="img-top-row">
                        <div class="img-badges">
                            <span class="badge-type">{{ ucfirst($property->type) }}</span>
                            <span class="badge-status badge-{{ $property->status }}">{{ ucfirst($property->status) }}</span>
                        </div>
                        @if($property->images->count() > 1)
                        <div class="img-count">
                            <i class="bi bi-images"></i>
                            {{ $property->images->count() }}
                        </div>
                        @endif
                    </div>

                    <div class="img-price">
                        {{ number_format($property->price, 0, ',', ' ') }} Ar
                    </div>
                </div>

                <div class="prop-body">
                    <h3 class="prop-title">{{ $property->title }}</h3>

                    <div class="prop-location">
                        <i class="bi bi-geo-alt-fill"></i>
                        {{ $property->city }}
                        @if($property->address)
                            · {{ Str::limit($property->address, 28) }}
                        @endif
                    </div>

                    @if($property->surface || $property->rooms || $property->bathrooms)
                    <div class="prop-features">
                        @if($property->surface)
                        <div class="feat-pill">
                            <i class="bi bi-arrows-angle-expand"></i>
                            {{ number_format($property->surface, 0) }} m²
                        </div>
                        @endif
                        @if($property->rooms)
                        <div class="feat-pill">
                            <i class="bi bi-door-open"></i>
                            {{ $property->rooms }} pièces
                        </div>
                        @endif
                        @if($property->bathrooms)
                        <div class="feat-pill">
                            <i class="bi bi-droplet"></i>
                            {{ $property->bathrooms }} SDB
                        </div>
                        @endif
                    </div>
                    @endif

                    @if($property->description)
                    <p class="prop-desc">{{ $property->description }}</p>
                    @endif

                    <div class="prop-footer">
                        <span class="prop-date">
                            <i class="bi bi-clock"></i>
                            {{ $property->created_at->diffForHumans() }}
                        </span>
                        <a href="{{ route('properties.show', $property->id) }}" class="btn-view">
                            Voir <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- LIST --}}
        <div class="props-list" id="propsList">
            @foreach($properties as $property)
            <div class="list-card">
                <div class="list-img-wrap">
                    @if($property->images->count() > 0)
                        <img src="{{ asset('storage/' . $property->images->first()->image_url) }}"
                             alt="{{ $property->title }}"
                             loading="lazy">
                    @else
                        <div class="prop-no-img" style="min-height:170px">
                            <i class="bi bi-house-door"></i>
                        </div>
                    @endif
                    <div style="position:absolute;top:10px;left:10px;display:flex;gap:5px">
                        <span class="badge-type">{{ ucfirst($property->type) }}</span>
                        <span class="badge-status badge-{{ $property->status }}">{{ ucfirst($property->status) }}</span>
                    </div>
                </div>
                <div class="list-body">
                    <div>
                        <div class="list-top">
                            <div>
                                <div class="list-title">{{ $property->title }}</div>
                                <div class="prop-location" style="margin-bottom:8px">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    {{ $property->city }}
                                    @if($property->address) · {{ $property->address }} @endif
                                </div>
                            </div>
                            <div class="list-price">{{ number_format($property->price, 0, ',', ' ') }} Ar</div>
                        </div>

                        @if($property->surface || $property->rooms || $property->bathrooms)
                        <div class="prop-features" style="margin-bottom:10px">
                            @if($property->surface)
                            <div class="feat-pill"><i class="bi bi-arrows-angle-expand"></i>{{ number_format($property->surface,0) }} m²</div>
                            @endif
                            @if($property->rooms)
                            <div class="feat-pill"><i class="bi bi-door-open"></i>{{ $property->rooms }} pièces</div>
                            @endif
                            @if($property->bathrooms)
                            <div class="feat-pill"><i class="bi bi-droplet"></i>{{ $property->bathrooms }} SDB</div>
                            @endif
                        </div>
                        @endif

                        @if($property->description)
                        <p class="prop-desc">{{ Str::limit($property->description, 160) }}</p>
                        @endif
                    </div>

                    <div class="prop-footer">
                        <span class="prop-date"><i class="bi bi-clock"></i> {{ $property->created_at->diffForHumans() }}</span>
                        <a href="{{ route('properties.show', $property->id) }}" class="btn-view">
                            Voir les détails <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrap">
            {{ $properties->withQueryString()->links() }}
        </div>

        @else
        <div class="empty-state">
            <div class="empty-icon-wrap">
                <i class="bi bi-search"></i>
            </div>
            <div class="empty-title">Aucune propriété trouvée</div>
            <p class="empty-text">Essayez de modifier ou de réinitialiser vos critères de recherche.</p>
            <a href="{{ route('search.index') }}" class="btn-empty">
                <i class="bi bi-arrow-clockwise"></i> Réinitialiser la recherche
            </a>
        </div>
        @endif

    </div>{{-- end results-area --}}
</div>{{-- end page-body --}}

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Hero search bar ── */
    document.getElementById('heroSearchBtn')?.addEventListener('click', function () {
        const url = new URL('{{ route('search.submit') }}');
        const kw = document.getElementById('heroKeyword').value;
        const city = document.getElementById('heroCity').value;
        const status = document.getElementById('heroStatus').value;
        if (kw) url.searchParams.set('keyword', kw);
        if (city) url.searchParams.set('city', city);
        if (status) url.searchParams.set('status', status);
        window.location.href = url.toString();
    });

    document.getElementById('heroKeyword')?.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') document.getElementById('heroSearchBtn').click();
    });

    /* ── Sort ── */
    document.getElementById('sortSelect')?.addEventListener('change', function () {
        const url = new URL(window.location.href);
        url.searchParams.set('sort_by', this.value);
        window.location.href = url.toString();
    });

    /* ── View toggle ── */
    const grid = document.getElementById('propsGrid');
    const list = document.getElementById('propsList');
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');

    function setView(v) {
        if (v === 'list') {
            grid?.classList.add('hidden');
            list?.classList.add('active');
            listBtn?.classList.add('active');
            gridBtn?.classList.remove('active');
        } else {
            grid?.classList.remove('hidden');
            list?.classList.remove('active');
            gridBtn?.classList.add('active');
            listBtn?.classList.remove('active');
        }
        localStorage.setItem('propView', v);
    }

    gridBtn?.addEventListener('click', () => setView('grid'));
    listBtn?.addEventListener('click', () => setView('list'));
    setView(localStorage.getItem('propView') || 'grid');

    /* ── Range sliders ── */
    const priceRange = document.getElementById('priceRange');
    const priceLabel = document.getElementById('priceRangeLabel');
    const maxPriceIn = document.getElementById('maxPriceInput');

    priceRange?.addEventListener('input', function () {
        maxPriceIn.value = this.value;
        priceLabel.textContent = new Intl.NumberFormat('fr-FR').format(this.value) + ' Ar';
    });

    const surfaceRange = document.getElementById('surfaceRange');
    const surfaceLabel = document.getElementById('surfaceRangeLabel');
    const maxSurfaceIn = document.getElementById('maxSurfaceInput');

    surfaceRange?.addEventListener('input', function () {
        maxSurfaceIn.value = this.value;
        surfaceLabel.textContent = this.value + ' m²';
    });

    /* ── Autocomplete ── */
    const kwInput = document.getElementById('keyword');
    const acDrop = document.getElementById('autocompleteResults');
    let acTimer;

    kwInput?.addEventListener('input', function () {
        clearTimeout(acTimer);
        const q = this.value.trim();
        if (q.length < 2) { acDrop.style.display = 'none'; return; }
        acTimer = setTimeout(() => {
            fetch(`/search/autocomplete?q=${encodeURIComponent(q)}`)
                .then(r => r.json())
                .then(data => {
                    if (!data.length) { acDrop.style.display = 'none'; return; }
                    acDrop.innerHTML = data.slice(0, 7).map(item => `
                        <div class="autocomplete-item" data-val="${item.value}">
                            <i class="bi bi-search"></i> ${item.label}
                        </div>
                    `).join('');
                    acDrop.style.display = 'block';
                    acDrop.querySelectorAll('.autocomplete-item').forEach(el => {
                        el.addEventListener('click', function () {
                            kwInput.value = this.dataset.val;
                            acDrop.style.display = 'none';
                        });
                    });
                })
                .catch(() => { acDrop.style.display = 'none'; });
        }, 280);
    });

    document.addEventListener('click', e => {
        if (!acDrop?.contains(e.target) && e.target !== kwInput) {
            if (acDrop) acDrop.style.display = 'none';
        }
    });

    /* ── Stats ── */
    fetch('{{ route('search.stats') }}')
        .then(r => r.json())
        .then(data => {
            const total = data.total_properties ?? 0;
            const avg = data.average_price
                ? new Intl.NumberFormat('fr-FR', { notation: 'compact' }).format(data.average_price) + ' Ar'
                : '—';

            document.getElementById('statTotal').textContent = total;
            document.getElementById('statAvg').textContent = avg;

            const types = data.types_count || {};
            const maxCount = Math.max(...Object.values(types), 1);
            const typesHtml = Object.entries(types).map(([t, c]) => `
                <div class="stat-type-row">
                    <span class="stat-type-name">${t.charAt(0).toUpperCase() + t.slice(1)}</span>
                    <div class="stat-type-bar-wrap">
                        <div class="stat-type-bar" style="width:${Math.round(c/maxCount*100)}%"></div>
                    </div>
                    <span class="stat-type-count">${c}</span>
                </div>
            `).join('');
            document.getElementById('statsTypes').innerHTML = typesHtml;
        })
        .catch(() => {});
});
</script>
@endpush