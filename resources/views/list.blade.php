@extends('users.header')

@section('title', 'Nos Propriétés')

@section('styles')
<style>
    /* ══════════════════════════════════════════
       DESIGN SYSTEM — calqué sur la sidebar
    ══════════════════════════════════════════ */

    /* ── Hero Section ── */
    .hero-section {
        position: relative;
        height: 480px;
        margin: -36px -40px 40px -40px;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
    }

    .hero-background {
        position: absolute;
        inset: 0;
        background:
            url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80')
            center / cover no-repeat;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            135deg,
            rgba(6,8,16,0.92)  0%,
            rgba(8,10,15,0.82) 50%,
            rgba(6,8,16,0.88) 100%
        );
    }

    .hero-section::after {
        content: '';
        position: absolute; inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
        background-size: 180px;
        pointer-events: none;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px 24px;
    }

    .hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 54px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 12px;
        letter-spacing: 0.03em;
        text-shadow: 0 4px 24px rgba(0,0,0,0.5);
    }

    .hero-title span { color: var(--gold); }

    .hero-subtitle {
        font-size: 16px;
        color: var(--text-soft);
        margin-bottom: 40px;
        max-width: 560px;
        letter-spacing: 0.02em;
    }

    .hero-search { width: 100%; max-width: 660px; }

    .search-wrapper {
        display: flex;
        background: var(--surface2);
        border-radius: 50px;
        border: 1px solid var(--border-glow);
        box-shadow: 0 0 40px rgba(197,160,85,0.07), 0 20px 40px rgba(0,0,0,0.4);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .search-wrapper:focus-within {
        border-color: rgba(197,160,85,0.45);
        box-shadow: 0 0 0 3px rgba(197,160,85,0.08), 0 20px 40px rgba(0,0,0,0.5);
    }

    .search-input {
        flex: 1;
        padding: 18px 28px;
        border: none;
        background: transparent;
        font-size: 15px;
        color: var(--text);
        outline: none;
        font-family: 'Inter', sans-serif;
    }

    .search-input::placeholder { color: var(--text-muted); }

    .search-button {
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        color: #080a0f;
        padding: 18px 36px;
        border: none;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .search-button:hover {
        filter: brightness(1.12);
        box-shadow: 0 0 20px rgba(197,160,85,0.35);
    }

    /* ── Filters Section ── */
    .filters-section {
        background: var(--surface);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        padding: 20px 24px;
        margin-bottom: 32px;
    }

    .filters-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .filter-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .filter-tab {
        padding: 9px 18px;
        border: 1px solid var(--border);
        border-radius: 50px;
        background: transparent;
        color: var(--text-soft);
        font-weight: 500;
        font-size: 13px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 7px;
        transition: all 0.25s ease;
        letter-spacing: 0.02em;
    }

    .filter-tab:hover {
        border-color: var(--border-glow);
        color: var(--gold);
        background: var(--gold-dim);
    }

    .filter-tab.active {
        background: linear-gradient(135deg, rgba(197,160,85,0.18), rgba(197,160,85,0.06));
        border-color: rgba(197,160,85,0.4);
        color: var(--gold-light);
        box-shadow: 0 0 14px rgba(197,160,85,0.1);
    }

    .filter-tab i { font-size: 14px; }

    .sort-select {
        padding: 9px 20px;
        border: 1px solid var(--border);
        border-radius: 50px;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-soft);
        background: var(--surface2);
        cursor: pointer;
        transition: all 0.25s ease;
        min-width: 190px;
        font-family: 'Inter', sans-serif;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2350535c' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        padding-right: 40px;
    }

    .sort-select:focus {
        outline: none;
        border-color: var(--border-glow);
        color: var(--text);
        box-shadow: 0 0 0 3px rgba(197,160,85,0.06);
    }

    .sort-select option {
        background: var(--surface2);
        color: var(--text);
    }

    /* ── Properties Grid ── */
    .properties-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .property-card {
        background: var(--surface);
        border-radius: var(--radius);
        overflow: hidden;
        border: 1px solid var(--border);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .property-card:hover {
        transform: translateY(-8px);
        border-color: var(--border-glow);
        box-shadow:
            0 20px 48px rgba(0,0,0,0.5),
            0 0 0 1px rgba(197,160,85,0.1),
            0 0 32px rgba(197,160,85,0.06);
    }

    /* ── Image Carousel ── */
    .property-image-wrapper {
        position: relative;
        height: 260px;
        background: var(--surface2);
    }

    .carousel { height: 100%; }
    .carousel-inner, .carousel-item { height: 100%; }

    .property-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.92;
        transition: opacity 0.3s ease;
    }

    .property-card:hover .property-image { opacity: 1; }

    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--surface2);
    }

    .no-image i { font-size: 56px; color: var(--text-muted); }

    .carousel-control-prev, .carousel-control-next {
        width: 36px;
        height: 36px;
        background: rgba(8,10,15,0.85);
        border: 1px solid var(--border);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .property-card:hover .carousel-control-prev,
    .property-card:hover .carousel-control-next { opacity: 1; }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        border-color: var(--border-glow);
        background: rgba(197,160,85,0.15);
    }

    .carousel-control-prev { left: 10px; }
    .carousel-control-next { right: 10px; }
    .carousel-control-prev-icon, .carousel-control-next-icon {
        background-size: 50%;
        filter: invert(1) brightness(0.85);
    }

    /* ── Badges ── */
    .property-badges {
        position: absolute;
        top: 14px; left: 14px;
        z-index: 2;
        display: flex;
        gap: 7px;
    }

    .badge-custom {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        backdrop-filter: blur(12px);
    }

    .badge-type {
        background: rgba(197,160,85,0.2);
        color: var(--gold-light);
        border: 1px solid rgba(197,160,85,0.3);
    }

    .badge-status.disponible {
        background: rgba(61,185,122,0.18);
        color: #6ee8aa;
        border: 1px solid rgba(61,185,122,0.28);
    }

    .badge-status.vendu {
        background: rgba(217,95,95,0.18);
        color: #f09090;
        border: 1px solid rgba(217,95,95,0.28);
    }

    .badge-status.loue {
        background: rgba(197,160,85,0.15);
        color: var(--gold);
        border: 1px solid rgba(197,160,85,0.25);
    }

    /* ── Favorite Button ── */
    .favorite-button {
        position: absolute;
        top: 14px; right: 14px;
        z-index: 2;
        width: 36px; height: 36px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border);
        background: rgba(8,10,15,0.8);
        color: var(--text-soft);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.25s ease;
        backdrop-filter: blur(10px);
        text-decoration: none;
    }

    .favorite-button:hover {
        border-color: var(--border-glow);
        color: var(--gold);
        background: var(--gold-dim);
        transform: scale(1.08);
    }

    .favorite-button.active {
        background: rgba(217,95,95,0.2);
        border-color: rgba(217,95,95,0.4);
        color: #f09090;
    }

    .favorite-button i { font-size: 16px; }

    /* ── Price Badge ── */
    .price-badge {
        position: absolute;
        bottom: 14px; right: 14px;
        background: rgba(8,10,15,0.9);
        border: 1px solid var(--border-glow);
        color: var(--gold-light);
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 700;
        font-family: 'Cormorant Garamond', serif;
        backdrop-filter: blur(12px);
        z-index: 2;
        letter-spacing: 0.02em;
    }

    /* ── Card Content ── */
    .property-content {
        padding: 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
        border-top: 1px solid var(--border);
    }

    .property-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 10px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        letter-spacing: 0.02em;
    }

    .property-location {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        color: var(--text-soft);
        font-size: 13px;
        margin-bottom: 16px;
    }

    .property-location i {
        font-size: 15px;
        color: var(--gold);
        margin-top: 1px;
        flex-shrink: 0;
    }

    .location-text { flex: 1; }

    .location-address {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    /* ── Features ── */
    .property-features {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 14px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--border);
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--text-soft);
        font-size: 13px;
        font-weight: 500;
    }

    .feature-item i { font-size: 14px; color: var(--gold); }

    .property-description {
        color: var(--text-muted);
        font-size: 13px;
        line-height: 1.65;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 16px;
    }

    /* ── Actions ── */
    .property-actions {
        display: flex;
        gap: 10px;
        margin-top: auto;
    }

    .btn-view-details {
        flex: 1;
        padding: 11px 18px;
        background: transparent;
        border: 1px solid var(--border);
        color: var(--text-soft);
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        letter-spacing: 0.03em;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        transition: all 0.25s ease;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
    }

    .btn-view-details:hover {
        border-color: var(--border-glow);
        color: var(--gold);
        background: var(--gold-dim);
    }

    .btn-visit-request, .btn-view-request {
        flex: 1;
        padding: 11px 18px;
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        color: #080a0f;
        border-radius: var(--radius-sm);
        border: none;
        font-weight: 700;
        font-size: 13px;
        letter-spacing: 0.04em;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
    }

    .btn-visit-request:hover, .btn-view-request:hover {
        filter: brightness(1.12);
        box-shadow: 0 0 20px rgba(197,160,85,0.3);
        color: #080a0f;
        transform: translateY(-1px);
    }

    /* ── Pagination ── */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin: 40px 0;
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

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: var(--surface);
        border-radius: var(--radius);
        border: 1px solid var(--border);
    }

    .empty-state i {
        font-size: 72px;
        color: var(--text-muted);
        margin-bottom: 24px;
        display: block;
    }

    .empty-state h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 26px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 12px;
    }

    .empty-state p {
        color: var(--text-soft);
        margin-bottom: 28px;
        font-size: 14px;
    }

    .btn-empty-action {
        padding: 13px 32px;
        background: transparent;
        border: 1px solid var(--gold);
        color: var(--gold);
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        letter-spacing: 0.05em;
        transition: all 0.25s ease;
        display: inline-block;
        position: relative;
        overflow: hidden;
    }

    .btn-empty-action::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .btn-empty-action span { position: relative; z-index: 1; }
    .btn-empty-action:hover::before { opacity: 1; }
    .btn-empty-action:hover { color: #080a0f; box-shadow: 0 0 22px rgba(197,160,85,0.3); }

    /* ── Results count ── */
    .results-count {
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 20px;
        letter-spacing: 0.02em;
    }

    .results-count strong { color: var(--gold); font-weight: 600; }
    .results-count em { color: var(--text-soft); font-style: normal; }

    /* ── Toast Notification ── */
    .toast-notification {
        position: fixed;
        bottom: 24px; right: 24px;
        z-index: 9999;
        min-width: 340px;
    }

    .toast-custom {
        background: var(--surface2);
        border-radius: var(--radius);
        border: 1px solid rgba(61,185,122,0.25);
        box-shadow: 0 12px 40px rgba(0,0,0,0.5);
    }

    .toast-header-success {
        background: rgba(61,185,122,0.12);
        color: #6ee8aa;
        border-radius: var(--radius) var(--radius) 0 0;
        border-bottom: 1px solid rgba(61,185,122,0.2);
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ── Modal visit request dark ── */
    .modal-content {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        color: var(--text);
    }

    .modal-header {
        border-bottom: 1px solid var(--border);
        padding: 20px 24px;
    }

    .modal-header .modal-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.2rem;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-header .modal-title i { color: var(--gold); }
    .modal-body { padding: 24px; }
    .modal-footer { border-top: 1px solid var(--border); padding: 16px 24px; }

    .modal .form-label { font-size: 13px; color: var(--text-soft); margin-bottom: 6px; }

    .modal .form-control,
    .modal .form-select {
        background: var(--surface2);
        border: 1px solid var(--border);
        color: var(--text);
        border-radius: var(--radius-sm);
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        padding: 10px 14px;
        transition: all 0.2s ease;
    }

    .modal .form-control:focus,
    .modal .form-select:focus {
        background: var(--surface2);
        border-color: var(--border-glow);
        color: var(--text);
        box-shadow: 0 0 0 3px rgba(197,160,85,0.08);
    }

    .modal .form-control::placeholder { color: var(--text-muted); }
    .modal .form-select option { background: var(--surface2); color: var(--text); }

    .modal .btn-secondary {
        background: transparent;
        border: 1px solid var(--border);
        color: var(--text-soft);
        border-radius: var(--radius-sm);
        padding: 10px 20px;
        font-size: 13px;
        transition: all 0.2s ease;
    }

    .modal .btn-secondary:hover { border-color: var(--border-glow); color: var(--text); }

    .modal .btn-primary {
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        border: none;
        color: #080a0f;
        border-radius: var(--radius-sm);
        padding: 10px 24px;
        font-weight: 700;
        font-size: 13px;
        letter-spacing: 0.04em;
        transition: all 0.25s ease;
    }

    .modal .btn-primary:hover { filter: brightness(1.1); box-shadow: 0 0 18px rgba(197,160,85,0.3); }
    .modal .btn-primary:disabled { opacity: 0.4; filter: none; box-shadow: none; }

    .modal-property-title {
        color: var(--text-soft);
        font-size: 14px;
        border-left: 2px solid var(--gold);
        padding-left: 12px;
    }

    .modal .alert-info {
        background: rgba(85,133,224,0.08);
        border: 1px solid rgba(85,133,224,0.2);
        color: #93b4f0;
        border-radius: var(--radius-sm);
        font-size: 13px;
    }

    .modal .alert-link { color: var(--gold-light); }
    .btn-close { filter: invert(0.5) brightness(1.4); }

    /* ════════════════════════════════════════════════
       MODAL DÉTAIL PROPRIÉTÉ (PDM)
    ════════════════════════════════════════════════ */
    .property-detail-modal .modal-dialog { max-width: 1100px; }

    .pdm-content {
        background: var(--surface);
        border: 1px solid var(--border-glow);
        border-radius: 20px;
        overflow: hidden;
        box-shadow:
            0 40px 100px rgba(0,0,0,0.8),
            0 0 0 1px rgba(197,160,85,0.08),
            0 0 80px rgba(197,160,85,0.05);
        position: relative;
        color: var(--text);
    }

    /* Layout 2 colonnes */
    .pdm-layout {
        display: grid;
        grid-template-columns: 1.15fr 1fr;
        min-height: 620px;
    }

    /* ── Bouton fermer ── */
    .pdm-close {
        position: absolute;
        top: 16px; right: 16px;
        z-index: 20;
        width: 40px; height: 40px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.12);
        background: rgba(8,10,15,0.9);
        color: var(--text-soft);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        backdrop-filter: blur(12px);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        font-size: 14px;
    }

    .pdm-close:hover {
        border-color: var(--border-glow);
        color: var(--gold);
        background: rgba(197,160,85,0.12);
        transform: rotate(90deg) scale(1.1);
    }

    /* ═══════════════════
       GALERIE
    ═══════════════════ */
    .pdm-gallery {
        position: relative;
        background: #020304;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .pdm-carousel {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .pdm-carousel .carousel-inner {
        flex: 1;
        height: 0; /* force flex child to fill */
        min-height: 460px;
    }

    .pdm-carousel .carousel-item { height: 100%; }

    .pdm-main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .pdm-gallery:hover .pdm-main-image { transform: scale(1.025); }

    /* Gradient en bas de l'image */
    .pdm-gallery::after {
        content: '';
        position: absolute;
        bottom: 90px; left: 0; right: 0;
        height: 140px;
        background: linear-gradient(to top, rgba(2,3,4,0.9) 0%, transparent 100%);
        pointer-events: none;
        z-index: 2;
    }

    /* No image */
    .pdm-no-image {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 16px;
        color: var(--text-muted);
        background: var(--surface2);
        min-height: 460px;
    }

    .pdm-no-image i { font-size: 64px; opacity: 0.4; }
    .pdm-no-image span { font-size: 12px; letter-spacing: 0.1em; text-transform: uppercase; opacity: 0.5; }

    /* Contrôles carousel */
    .pdm-ctrl-prev, .pdm-ctrl-next {
        position: absolute;
        width: 44px; height: 44px;
        background: rgba(8,10,15,0.88);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 50%;
        top: 50%;
        transform: translateY(calc(-50% - 45px));
        display: flex; align-items: center; justify-content: center;
        color: var(--text-soft);
        font-size: 17px;
        transition: all 0.25s ease;
        opacity: 0;
        z-index: 5;
        cursor: pointer;
        text-decoration: none;
    }

    .pdm-ctrl-prev { left: 16px; }
    .pdm-ctrl-next { right: 16px; }

    .pdm-gallery:hover .pdm-ctrl-prev,
    .pdm-gallery:hover .pdm-ctrl-next { opacity: 1; }

    .pdm-ctrl-prev:hover,
    .pdm-ctrl-next:hover {
        border-color: var(--border-glow);
        background: rgba(197,160,85,0.15);
        color: var(--gold);
        transform: translateY(calc(-50% - 45px)) scale(1.08);
    }

    /* Thumbnails */
    .pdm-thumbs {
        display: flex;
        gap: 7px;
        padding: 12px 16px;
        background: rgba(4,5,8,0.98);
        height: 90px;
        overflow-x: auto;
        overflow-y: hidden;
        scrollbar-width: thin;
        scrollbar-color: var(--border) transparent;
        position: relative;
        z-index: 3;
        flex-shrink: 0;
    }

    .pdm-thumbs::-webkit-scrollbar { height: 3px; }
    .pdm-thumbs::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }

    .pdm-thumb {
        flex-shrink: 0;
        width: 66px; height: 66px;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s ease;
        opacity: 0.45;
    }

    .pdm-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .pdm-thumb:hover { opacity: 0.8; border-color: rgba(197,160,85,0.4); transform: scale(1.04); }
    .pdm-thumb.active { border-color: var(--gold); opacity: 1; }

    /* Badges galerie */
    .pdm-gallery-badges {
        position: absolute;
        top: 16px; left: 16px;
        display: flex; gap: 7px;
        z-index: 10;
    }

    .pdm-badge {
        padding: 5px 13px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        backdrop-filter: blur(16px);
        display: flex; align-items: center; gap: 5px;
    }

    .pdm-badge-type {
        background: rgba(197,160,85,0.22);
        color: var(--gold-light);
        border: 1px solid rgba(197,160,85,0.35);
    }

    .pdm-badge-status.disponible {
        background: rgba(61,185,122,0.2);
        color: #6ee8aa;
        border: 1px solid rgba(61,185,122,0.32);
    }

    .pdm-badge-status.vendu {
        background: rgba(217,95,95,0.2);
        color: #f09090;
        border: 1px solid rgba(217,95,95,0.32);
    }

    .pdm-badge-status.loue {
        background: rgba(197,160,85,0.16);
        color: var(--gold);
        border: 1px solid rgba(197,160,85,0.28);
    }

    /* Compteur photos */
    .pdm-photo-count {
        position: absolute;
        z-index: 10;
        bottom: 96px; right: 16px;
        background: rgba(8,10,15,0.85);
        border: 1px solid rgba(255,255,255,0.08);
        color: var(--text-muted);
        padding: 5px 13px;
        border-radius: 20px;
        font-size: 11px;
        display: flex; align-items: center; gap: 5px;
        backdrop-filter: blur(12px);
        letter-spacing: 0.04em;
    }

    /* ═══════════════════
       INFO (droite)
    ═══════════════════ */
    .pdm-info {
        display: flex;
        flex-direction: column;
        padding: 36px 30px 28px;
        overflow-y: auto;
        max-height: 620px;
        background: var(--surface);
        scrollbar-width: thin;
        scrollbar-color: var(--border) transparent;
        border-left: 1px solid var(--border);
    }

    .pdm-info::-webkit-scrollbar { width: 3px; }
    .pdm-info::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }

    /* Prix */
    .pdm-price-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 14px;
        gap: 12px;
    }

    .pdm-price {
        font-family: 'Cormorant Garamond', serif;
        font-size: 40px;
        font-weight: 700;
        color: var(--gold-light);
        letter-spacing: 0.01em;
        line-height: 1;
    }

    .pdm-currency {
        font-size: 18px;
        font-weight: 500;
        color: var(--gold);
        margin-left: 6px;
        opacity: 0.8;
    }

    /* Bouton favori */
    .pdm-fav-btn {
        width: 42px; height: 42px;
        border-radius: 50%;
        border: 1px solid var(--border);
        background: var(--surface2);
        color: var(--text-muted);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        font-size: 16px;
        flex-shrink: 0;
    }

    .pdm-fav-btn:hover {
        border-color: rgba(217,95,95,0.5);
        color: #f09090;
        background: rgba(217,95,95,0.1);
        transform: scale(1.15);
    }

    .pdm-fav-btn.active {
        border-color: rgba(217,95,95,0.45);
        color: #f09090;
        background: rgba(217,95,95,0.15);
    }

    /* Titre */
    .pdm-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 27px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 14px;
        line-height: 1.3;
        letter-spacing: 0.02em;
    }

    /* Localisation */
    .pdm-location {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-bottom: 4px;
    }

    .pdm-location > i { color: var(--gold); font-size: 15px; margin-top: 2px; flex-shrink: 0; }
    .pdm-city { display: block; color: var(--text-soft); font-size: 14px; font-weight: 500; }
    .pdm-address { display: block; color: var(--text-muted); font-size: 12px; margin-top: 2px; }

    /* Séparateur décoratif */
    .pdm-divider {
        display: flex;
        align-items: center;
        margin: 22px 0;
        gap: 10px;
    }

    .pdm-divider::before,
    .pdm-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(197,160,85,0.25), transparent);
    }

    .pdm-divider-gem {
        color: var(--gold);
        font-size: 9px;
        opacity: 0.7;
    }

    /* Stats */
    .pdm-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 24px;
    }

    .pdm-stat {
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 16px 10px;
        text-align: center;
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }

    .pdm-stat::before {
        content: '';
        position: absolute;
        top: 0; left: 50%; right: 50%;
        height: 2px;
        background: linear-gradient(90deg, var(--gold), var(--gold-light));
        transition: all 0.3s ease;
    }

    .pdm-stat:hover {
        border-color: var(--border-glow);
        background: rgba(197,160,85,0.04);
    }

    .pdm-stat:hover::before {
        left: 20%; right: 20%;
    }

    .pdm-stat-icon {
        font-size: 19px;
        color: var(--gold);
        margin-bottom: 7px;
        opacity: 0.85;
    }

    .pdm-stat-val {
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        font-weight: 700;
        color: var(--text);
        line-height: 1;
    }

    .pdm-stat-label {
        font-size: 10px;
        color: var(--text-muted);
        margin-top: 4px;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    /* Description */
    .pdm-description-block { margin-bottom: 20px; }

    .pdm-section-title {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--gold);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 7px;
        opacity: 0.85;
    }

    .pdm-description {
        color: var(--text-soft);
        font-size: 13.5px;
        line-height: 1.75;
        margin: 0;
    }

    /* Détails grid */
    .pdm-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1px;
        margin-bottom: 26px;
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        background: var(--border);
    }

    .pdm-detail-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
        padding: 13px 16px;
        background: var(--surface2);
        transition: background 0.2s ease;
    }

    .pdm-detail-item:hover { background: rgba(197,160,85,0.04); }

    .pdm-detail-label {
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--text-muted);
        font-weight: 700;
    }

    .pdm-detail-val {
        font-size: 13px;
        color: var(--text-soft);
        font-weight: 500;
    }

    .pdm-status-disponible { color: #6ee8aa !important; }
    .pdm-status-vendu      { color: #f09090 !important; }
    .pdm-status-loue       { color: var(--gold) !important; }

    /* Actions */
    .pdm-actions {
        display: flex;
        gap: 10px;
        margin-top: auto;
        padding-top: 4px;
    }

    .pdm-btn-primary {
        flex: 1.4;
        padding: 13px 16px;
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        color: #080a0f;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 12px;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        display: flex; align-items: center; justify-content: center; gap: 7px;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
    }

    .pdm-btn-primary:hover {
        filter: brightness(1.12);
        box-shadow: 0 6px 24px rgba(197,160,85,0.35);
        transform: translateY(-2px);
        color: #080a0f;
    }

    .pdm-btn-secondary {
        flex: 1.4;
        padding: 13px 16px;
        background: rgba(197,160,85,0.07);
        color: var(--gold);
        border: 1px solid rgba(197,160,85,0.28);
        border-radius: 10px;
        font-weight: 600;
        font-size: 12px;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        display: flex; align-items: center; justify-content: center; gap: 7px;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
    }

    .pdm-btn-secondary:hover {
        background: rgba(197,160,85,0.13);
        border-color: rgba(197,160,85,0.5);
        color: var(--gold-light);
        transform: translateY(-1px);
    }

    .pdm-btn-outline {
        flex: 1;
        padding: 13px 14px;
        background: transparent;
        border: 1px solid var(--border);
        color: var(--text-muted);
        border-radius: 10px;
        font-weight: 600;
        font-size: 11px;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        display: flex; align-items: center; justify-content: center; gap: 6px;
        transition: all 0.25s ease;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
    }

    .pdm-btn-outline:hover {
        border-color: var(--border-glow);
        color: var(--gold);
        background: var(--gold-dim);
    }

    /* ── Animations ── */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .property-card { animation: fadeInUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both; }
    .property-card:nth-child(1) { animation-delay: 0.04s; }
    .property-card:nth-child(2) { animation-delay: 0.09s; }
    .property-card:nth-child(3) { animation-delay: 0.14s; }
    .property-card:nth-child(4) { animation-delay: 0.18s; }
    .property-card:nth-child(5) { animation-delay: 0.22s; }
    .property-card:nth-child(6) { animation-delay: 0.26s; }

    @keyframes pdmSlideIn {
        from { opacity: 0; transform: scale(0.96) translateY(16px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }

    .property-detail-modal.show .pdm-content {
        animation: pdmSlideIn 0.35s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    /* ── Responsive ── */
    @media (max-width: 992px) {
        .hero-section { margin: -22px -22px 32px -22px; }
        .hero-title { font-size: 40px; }
        .filters-row { flex-direction: column; align-items: stretch; }
        .sort-select { width: 100%; }
        .properties-grid { grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); }

        .pdm-layout { grid-template-columns: 1fr; }
        .pdm-carousel .carousel-inner { min-height: 300px; }
        .pdm-gallery::after { bottom: 90px; }
        .pdm-info { max-height: none; border-left: none; border-top: 1px solid var(--border); }
    }

    @media (max-width: 768px) {
        .property-detail-modal .modal-dialog { margin: 10px; }
        .pdm-info { padding: 24px 20px; }
        .pdm-price { font-size: 32px; }
        .pdm-title { font-size: 22px; }
        .pdm-stats { grid-template-columns: repeat(3, 1fr); gap: 8px; }
        .pdm-actions { flex-wrap: wrap; }
        .pdm-btn-primary, .pdm-btn-secondary { flex: 1; min-width: calc(50% - 5px); }
        .pdm-btn-outline { flex: 1 1 100%; }
    }

    @media (max-width: 576px) {
        .hero-section { height: 380px; margin: -14px -14px 28px -14px; }
        .hero-title { font-size: 30px; }
        .hero-subtitle { font-size: 14px; }
        .search-wrapper { flex-direction: column; border-radius: 16px; }
        .search-button { width: 100%; justify-content: center; border-radius: 0 0 14px 14px; }
        .filter-tabs { width: 100%; }
        .filter-tab { flex: 1; justify-content: center; }
        .properties-grid { grid-template-columns: 1fr; gap: 16px; }
        .property-actions { flex-direction: column; }
        .pdm-thumbs { height: 72px; }
        .pdm-thumb { width: 56px; height: 56px; }
    }
</style>
@endsection

@section('content')

<!-- ══════════════════════════════════════════
     Hero Section
══════════════════════════════════════════ -->
<div class="hero-section">
    <div class="hero-background"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">Découvrez Notre <span>Sélection</span></h1>
        <p class="hero-subtitle">Trouvez la propriété de vos rêves parmi nos meilleures offres</p>

        <div class="hero-search">
            <form action="{{ route('list') }}" method="GET">
                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <div class="search-wrapper">
                    <input type="text"
                           name="search"
                           class="search-input"
                           placeholder="Rechercher une propriété, une ville..."
                           value="{{ request('search') }}">
                    <button type="submit" class="search-button">
                        <i class="bi bi-search"></i>
                        Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════
     Filters Section
══════════════════════════════════════════ -->
<div class="filters-section">
    <div class="filters-row">
        <div class="filter-tabs">
            <a href="{{ route('list', array_merge(request()->except('type'), [])) }}"
               class="filter-tab {{ !request('type') ? 'active' : '' }}">
                Tous les types
            </a>
            <a href="{{ route('list', array_merge(request()->except('type'), ['type' => 'maison'])) }}"
               class="filter-tab {{ request('type') == 'maison' ? 'active' : '' }}">
                <i class="bi bi-house"></i> Maisons
            </a>
            <a href="{{ route('list', array_merge(request()->except('type'), ['type' => 'appartement'])) }}"
               class="filter-tab {{ request('type') == 'appartement' ? 'active' : '' }}">
                <i class="bi bi-building"></i> Appartements
            </a>
            <a href="{{ route('list', array_merge(request()->except('type'), ['type' => 'terrain'])) }}"
               class="filter-tab {{ request('type') == 'terrain' ? 'active' : '' }}">
                <i class="bi bi-tree"></i> Terrains
            </a>
            <a href="{{ route('list', array_merge(request()->except('type'), ['type' => 'bureau'])) }}"
               class="filter-tab {{ request('type') == 'bureau' ? 'active' : '' }}">
                <i class="bi bi-briefcase"></i> Bureaux
            </a>
        </div>

        <form action="{{ route('list') }}" method="GET" id="sortForm">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif
            <select class="sort-select" name="sort" id="sortBy" onchange="document.getElementById('sortForm').submit()">
                <option value="" {{ !request('sort') ? 'selected' : '' }}>Plus récentes</option>
                <option value="price_asc"  {{ request('sort') == 'price_asc'  ? 'selected' : '' }}>Prix croissant</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
            </select>
        </form>
    </div>
</div>

<!-- Results Count -->
<div class="results-count">
    <strong>{{ $properties->total() }}</strong> propriété(s) trouvée(s)
    @if(request('search')) pour « <em>{{ request('search') }}</em> » @endif
</div>

<!-- ══════════════════════════════════════════
     Properties Grid
══════════════════════════════════════════ -->
@if($properties->count() > 0)
<div class="properties-grid">
    @foreach($properties as $property)
    <div class="property-card">

        <!-- ── Image Carousel ── -->
        <div class="property-image-wrapper">
            @if($property->images->count() > 0)
            <div id="carousel{{ $property->id }}" class="carousel slide">
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
                        data-bs-target="#carousel{{ $property->id }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button"
                        data-bs-target="#carousel{{ $property->id }}" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
                @endif
            </div>
            @else
            <div class="no-image">
                <i class="bi bi-image"></i>
            </div>
            @endif

            <!-- Badges -->
            <div class="property-badges">
                <span class="badge-custom badge-type">{{ ucfirst($property->type) }}</span>
                <span class="badge-custom badge-status {{ $property->status }}">
                    {{ ucfirst($property->status) }}
                </span>
            </div>

            <!-- Favorite Button -->
            @auth
                @php $isFavorite = $property->favorites->where('user_id', auth()->id())->count() > 0; @endphp
                <form action="{{ route('properties.favorite.toggle', $property->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit"
                            class="favorite-button {{ $isFavorite ? 'active' : '' }}"
                            title="{{ $isFavorite ? 'Retirer des favoris' : 'Ajouter aux favoris' }}">
                        <i class="bi bi-heart{{ $isFavorite ? '-fill' : '' }}"></i>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="favorite-button" title="Connectez-vous">
                    <i class="bi bi-heart"></i>
                </a>
            @endauth

            <!-- Price Badge -->
            <div class="price-badge">
                {{ number_format($property->price, 0, ',', ' ') }} Ar
            </div>
        </div>

        <!-- ── Card Content ── -->
        <div class="property-content">
            <h3 class="property-title">{{ $property->title }}</h3>

            <div class="property-location">
                <i class="bi bi-geo-alt-fill"></i>
                <div class="location-text">
                    {{ $property->city }}
                    @if($property->address)
                    <div class="location-address">{{ $property->address }}</div>
                    @endif
                </div>
            </div>

            @if($property->surface || $property->rooms || $property->bathrooms)
            <div class="property-features">
                @if($property->surface)
                <div class="feature-item">
                    <i class="bi bi-arrows-angle-expand"></i>
                    <span>{{ number_format($property->surface, 0, ',', ' ') }} m²</span>
                </div>
                @endif
                @if($property->rooms)
                <div class="feature-item">
                    <i class="bi bi-door-closed"></i>
                    <span>{{ $property->rooms }} pièces</span>
                </div>
                @endif
                @if($property->bathrooms)
                <div class="feature-item">
                    <i class="bi bi-droplet"></i>
                    <span>{{ $property->bathrooms }} sdb</span>
                </div>
                @endif
            </div>
            @endif

            @if($property->description)
            <p class="property-description">{{ $property->description }}</p>
            @endif

            <!-- ── Actions ── -->
            <div class="property-actions">

                {{-- BOUTON VOIR DÉTAILS → ouvre la modal PDM --}}
                <button type="button"
                        class="btn-view-details"
                        data-bs-toggle="modal"
                        data-bs-target="#propertyDetailModal{{ $property->id }}">
                    <i class="bi bi-eye"></i>
                    Voir détails
                </button>

                @php
                    $hasUserRequest = false;
                    if (auth()->check()) {
                        $hasUserRequest = $property->appointments()
                            ->where('user_id', auth()->id())
                            ->whereIn('status', ['pending', 'confirmed'])
                            ->exists();
                    }
                @endphp

                @if($hasUserRequest)
                    <a href="{{ route('appointments.index') }}" class="btn-view-request">
                        <i class="bi bi-eye"></i>
                        Voir ma demande
                    </a>
                @else
                    <button type="button"
                            class="btn-visit-request"
                            data-bs-toggle="modal"
                            data-bs-target="#visitRequestModal{{ $property->id }}">
                        <i class="bi bi-calendar-check"></i>
                        Demande de visite
                    </button>
                @endif
            </div>
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════
         MODAL — DEMANDE DE VISITE
    ══════════════════════════════════════════════════════════ --}}
    <div class="modal fade" id="visitRequestModal{{ $property->id }}" tabindex="-1"
         aria-labelledby="visitRequestModalLabel{{ $property->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visitRequestModalLabel{{ $property->id }}">
                        <i class="bi bi-calendar-check"></i> Demande de visite
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('appointments.store', $property->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="modal-property-title fw-bold mb-3">{{ $property->title }}</p>

                        <div class="mb-3">
                            <label for="visitDate{{ $property->id }}" class="form-label">Date souhaitée</label>
                            <input type="date"
                                   class="form-control"
                                   id="visitDate{{ $property->id }}"
                                   name="visit_date"
                                   required
                                   min="{{ date('Y-m-d') }}">
                        </div>

                        <div class="mb-3">
                            <label for="visitTime{{ $property->id }}" class="form-label">Heure souhaitée</label>
                            <select class="form-select" id="visitTime{{ $property->id }}" name="visit_time" required>
                                <option value="">Choisir une heure</option>
                                <option value="09:00">09:00</option>
                                <option value="10:00">10:00</option>
                                <option value="11:00">11:00</option>
                                <option value="14:00">14:00</option>
                                <option value="15:00">15:00</option>
                                <option value="16:00">16:00</option>
                                <option value="17:00">17:00</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="message{{ $property->id }}" class="form-label">Message (optionnel)</label>
                            <textarea class="form-control"
                                      id="message{{ $property->id }}"
                                      name="message"
                                      rows="3"
                                      placeholder="Informations complémentaires..."></textarea>
                        </div>

                        @guest
                        <div class="alert alert-info">
                            <small>
                                <i class="bi bi-info-circle me-1"></i>
                                Vous devez être connecté pour effectuer une demande de visite.
                                <a href="{{ route('login') }}" class="alert-link">Connectez-vous</a> ou
                                <a href="{{ route('register') }}" class="alert-link">créez un compte</a>.
                            </small>
                        </div>
                        @endguest
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        @auth
                        <button type="submit" class="btn btn-primary">Envoyer la demande</button>
                        @else
                        <button type="button" class="btn btn-primary" disabled>Connectez-vous pour envoyer</button>
                        @endauth
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════
         MODAL — VOIR DÉTAILS PROPRIÉTÉ
    ══════════════════════════════════════════════════════════ --}}
    <div class="modal fade property-detail-modal"
         id="propertyDetailModal{{ $property->id }}"
         tabindex="-1"
         aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content pdm-content">

                <!-- Bouton fermer flottant -->
                <button type="button" class="pdm-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>

                <div class="pdm-layout">

                    {{-- ══ COLONNE GAUCHE : Galerie ══ --}}
                    <div class="pdm-gallery">

                        @if($property->images->count() > 0)

                        <!-- Carousel principal -->
                        <div id="pdmCarousel{{ $property->id }}"
                             class="carousel slide pdm-carousel"
                             data-bs-ride="false">

                            <div class="carousel-inner">
                                @foreach($property->images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image->image_url) }}"
                                         class="pdm-main-image"
                                         alt="{{ $property->title }}">
                                </div>
                                @endforeach
                            </div>

                            @if($property->images->count() > 1)
                            <!-- Contrôles -->
                            <button class="pdm-ctrl-prev carousel-control-prev"
                                    type="button"
                                    data-bs-target="#pdmCarousel{{ $property->id }}"
                                    data-bs-slide="prev">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button class="pdm-ctrl-next carousel-control-next"
                                    type="button"
                                    data-bs-target="#pdmCarousel{{ $property->id }}"
                                    data-bs-slide="next">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                            @endif
                        </div>

                        @if($property->images->count() > 1)
                        <!-- Thumbnails -->
                        <div class="pdm-thumbs">
                            @foreach($property->images as $index => $image)
                            <div class="pdm-thumb {{ $index === 0 ? 'active' : '' }}"
                                 data-bs-target="#pdmCarousel{{ $property->id }}"
                                 data-bs-slide-to="{{ $index }}">
                                <img src="{{ asset('storage/' . $image->image_url) }}"
                                     alt="Photo {{ $index + 1 }}">
                            </div>
                            @endforeach
                        </div>
                        @endif

                        @else
                        <!-- Pas d'image -->
                        <div class="pdm-no-image">
                            <i class="bi bi-image"></i>
                            <span>Aucune photo disponible</span>
                        </div>
                        @endif

                        <!-- Badges -->
                        <div class="pdm-gallery-badges">
                            <span class="pdm-badge pdm-badge-type">{{ ucfirst($property->type) }}</span>
                            <span class="pdm-badge pdm-badge-status {{ $property->status }}">
                                @if($property->status === 'disponible')<i class="bi bi-check-circle-fill"></i>
                                @elseif($property->status === 'vendu')<i class="bi bi-x-circle-fill"></i>
                                @else<i class="bi bi-clock-fill"></i>
                                @endif
                                {{ ucfirst($property->status) }}
                            </span>
                        </div>

                        <!-- Compteur photos -->
                        @if($property->images->count() > 1)
                        <div class="pdm-photo-count">
                            <i class="bi bi-images"></i>
                            {{ $property->images->count() }} photos
                        </div>
                        @endif

                    </div>{{-- /pdm-gallery --}}


                    {{-- ══ COLONNE DROITE : Informations ══ --}}
                    <div class="pdm-info">

                        <!-- Prix + Favori -->
                        <div class="pdm-price-row">
                            <div class="pdm-price">
                                {{ number_format($property->price, 0, ',', ' ') }}
                                <span class="pdm-currency">Ar</span>
                            </div>

                            @auth
                                @php $isFav = $property->favorites->where('user_id', auth()->id())->count() > 0; @endphp
                                <form action="{{ route('properties.favorite.toggle', $property->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="pdm-fav-btn {{ $isFav ? 'active' : '' }}"
                                            title="{{ $isFav ? 'Retirer des favoris' : 'Ajouter aux favoris' }}">
                                        <i class="bi bi-heart{{ $isFav ? '-fill' : '' }}"></i>
                                    </button>
                                </form>
                            @endauth
                        </div>

                        <!-- Titre -->
                        <h2 class="pdm-title">{{ $property->title }}</h2>

                        <!-- Localisation -->
                        <div class="pdm-location">
                            <i class="bi bi-geo-alt-fill"></i>
                            <div>
                                <span class="pdm-city">{{ $property->city }}</span>
                                @if($property->address)
                                <span class="pdm-address">{{ $property->address }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Séparateur -->
                        <div class="pdm-divider">
                            <span class="pdm-divider-gem">◆</span>
                        </div>

                        <!-- Stats -->
                        @if($property->surface || $property->rooms || $property->bathrooms)
                        <div class="pdm-stats">
                            @if($property->surface)
                            <div class="pdm-stat">
                                <div class="pdm-stat-icon"><i class="bi bi-arrows-angle-expand"></i></div>
                                <div class="pdm-stat-val">{{ number_format($property->surface, 0, ',', ' ') }}</div>
                                <div class="pdm-stat-label">m² surface</div>
                            </div>
                            @endif
                            @if($property->rooms)
                            <div class="pdm-stat">
                                <div class="pdm-stat-icon"><i class="bi bi-door-closed"></i></div>
                                <div class="pdm-stat-val">{{ $property->rooms }}</div>
                                <div class="pdm-stat-label">pièces</div>
                            </div>
                            @endif
                            @if($property->bathrooms)
                            <div class="pdm-stat">
                                <div class="pdm-stat-icon"><i class="bi bi-droplet-fill"></i></div>
                                <div class="pdm-stat-val">{{ $property->bathrooms }}</div>
                                <div class="pdm-stat-label">salles de bain</div>
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- Description -->
                        @if($property->description)
                        <div class="pdm-description-block">
                            <h4 class="pdm-section-title">
                                <i class="bi bi-card-text"></i> Description
                            </h4>
                            <p class="pdm-description">{{ $property->description }}</p>
                        </div>
                        @endif

                        <!-- Détails -->
                        <div class="pdm-details-grid">
                            <div class="pdm-detail-item">
                                <span class="pdm-detail-label">Type</span>
                                <span class="pdm-detail-val">{{ ucfirst($property->type) }}</span>
                            </div>
                            <div class="pdm-detail-item">
                                <span class="pdm-detail-label">Statut</span>
                                <span class="pdm-detail-val pdm-status-{{ $property->status }}">{{ ucfirst($property->status) }}</span>
                            </div>
                            @if($property->city)
                            <div class="pdm-detail-item">
                                <span class="pdm-detail-label">Ville</span>
                                <span class="pdm-detail-val">{{ $property->city }}</span>
                            </div>
                            @endif
                            @if($property->surface)
                            <div class="pdm-detail-item">
                                <span class="pdm-detail-label">Surface</span>
                                <span class="pdm-detail-val">{{ number_format($property->surface, 0, ',', ' ') }} m²</span>
                            </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="pdm-actions">
                            @php
                                $hasPdmRequest = false;
                                if (auth()->check()) {
                                    $hasPdmRequest = $property->appointments()
                                        ->where('user_id', auth()->id())
                                        ->whereIn('status', ['pending', 'confirmed'])
                                        ->exists();
                                }
                            @endphp

                            @if($hasPdmRequest)
                            <a href="{{ route('appointments.index') }}" class="pdm-btn-secondary">
                                <i class="bi bi-calendar2-check"></i>
                                Voir ma demande
                            </a>
                            @else
                            <button type="button"
                                    class="pdm-btn-primary"
                                    data-bs-dismiss="modal"
                                    data-bs-toggle="modal"
                                    data-bs-target="#visitRequestModal{{ $property->id }}">
                                <i class="bi bi-calendar-check"></i>
                                Demande de visite
                            </button>
                            @endif

                            <a href="{{ route('properties.show', $property->id) }}" class="pdm-btn-outline">
                                <i class="bi bi-box-arrow-up-right"></i>
                                Page complète
                            </a>
                        </div>

                    </div>{{-- /pdm-info --}}
                </div>{{-- /pdm-layout --}}
            </div>{{-- /pdm-content --}}
        </div>
    </div>
    {{-- ══ FIN MODAL DÉTAIL ══ --}}

    @endforeach
</div>

<!-- Pagination -->
<div class="pagination-wrapper">
    {{ $properties->appends(request()->query())->links() }}
</div>

@else
<!-- ── Empty State ── -->
<div class="empty-state">
    <i class="bi bi-house-x"></i>
    <h3>Aucune propriété disponible</h3>
    <p>Aucune propriété ne correspond à vos critères de recherche.</p>
    <a href="{{ route('list') }}" class="btn-empty-action">
        <span>Voir toutes les propriétés</span>
    </a>
</div>
@endif


<!-- ══════════════════════════════════════════
     Toast Notification
══════════════════════════════════════════ -->
@if(session('success'))
<div class="toast-notification">
    <div class="toast toast-custom show" role="alert">
        <div class="toast-header-success">
            <i class="bi bi-check-circle me-2"></i>
            <strong class="me-auto">Succès</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" style="color: var(--text-soft); font-size: 13px; padding: 14px 16px;">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Auto-hide toast ── */
    document.querySelectorAll('.toast').forEach(toast => {
        setTimeout(() => toast.classList.remove('show'), 5000);
    });

    /* ── Min date pour les inputs date ── */
    const today = new Date().toISOString().split('T')[0];
    document.querySelectorAll('input[type="date"]').forEach(input => {
        input.min = today;
    });

    /* ── Synchroniser les thumbnails PDM avec le carousel Bootstrap ── */
    document.querySelectorAll('.property-detail-modal').forEach(modalEl => {
        modalEl.addEventListener('show.bs.modal', function () {
            const modalId   = this.id;
            const propId    = modalId.replace('propertyDetailModal', '');
            const carouselEl = document.getElementById('pdmCarousel' + propId);
            if (!carouselEl) return;

            const thumbs = this.querySelectorAll('.pdm-thumb');

            /* Mise à jour des thumbs quand le slide change */
            carouselEl.addEventListener('slid.bs.carousel', function (e) {
                thumbs.forEach((t, i) => t.classList.toggle('active', i === e.to));

                /* Scroll auto vers le thumb actif */
                const activeThumb = thumbs[e.to];
                if (activeThumb) {
                    activeThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                }
            });
        });
    });

    /* ── Fermer la modal PDM puis ouvrir visitRequest sans délai visible ── */
    document.querySelectorAll('.pdm-btn-primary[data-bs-toggle="modal"]').forEach(btn => {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-bs-target');
            // Le data-bs-dismiss="modal" sur le bouton s'occupe déjà de fermer la PDM
            // On s'assure juste que Bootstrap a le temps de fermer avant d'ouvrir l'autre
            setTimeout(() => {
                const targetModal = document.querySelector(targetId);
                if (targetModal) {
                    const bsModal = new bootstrap.Modal(targetModal);
                    bsModal.show();
                }
            }, 300);
        });
    });

});
</script>
@endsection