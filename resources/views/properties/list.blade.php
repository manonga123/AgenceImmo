@extends('layouts.layout')

@section('title', 'Nos Propriétés')

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        position: relative;
        height: 500px;
        margin: -32px -32px 40px -32px;
        border-radius: 0 0 24px 24px;
        overflow: hidden;
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    }

    .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80') center/cover;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(30, 58, 138, 0.75) 100%);
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
        padding: 40px 20px;
        color: white;
    }

    .hero-title {
        font-size: 56px;
        font-weight: 800;
        margin-bottom: 16px;
        letter-spacing: -1px;
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .hero-subtitle {
        font-size: 20px;
        margin-bottom: 40px;
        opacity: 0.95;
        max-width: 600px;
    }

    /* Search Bar */
    .hero-search {
        width: 100%;
        max-width: 700px;
    }

    .search-wrapper {
        display: flex;
        background: white;
        border-radius: 50px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .search-wrapper:focus-within {
        box-shadow: 0 24px 48px rgba(0, 0, 0, 0.4);
        transform: translateY(-2px);
    }

    .search-input {
        flex: 1;
        padding: 20px 32px;
        border: none;
        font-size: 16px;
        outline: none;
    }

    .search-input::placeholder {
        color: #94a3b8;
    }

    .search-button {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 20px 40px;
        border: none;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .search-button:hover {
        transform: scale(1.05);
    }

    /* Filters Section */
    .filters-section {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-md);
        padding: 24px;
        margin-bottom: 32px;
        border: 1px solid var(--border-color);
    }

    .filters-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 24px;
    }

    .filter-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .filter-tab {
        padding: 10px 20px;
        border: 2px solid var(--border-color);
        border-radius: 50px;
        background: white;
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .filter-tab:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        transform: translateY(-2px);
    }

    .filter-tab.active {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .filter-tab i {
        font-size: 16px;
    }

    .sort-select {
        padding: 10px 20px;
        border: 2px solid var(--border-color);
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-primary);
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 200px;
    }

    .sort-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    /* Properties Grid */
    .properties-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 28px;
        margin-bottom: 40px;
    }

    .property-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .property-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    /* Image Carousel */
    .property-image-wrapper {
        position: relative;
        height: 280px;
        background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
    }

    .carousel {
        height: 100%;
    }

    .carousel-inner,
    .carousel-item {
        height: 100%;
    }

    .property-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
    }

    .no-image i {
        font-size: 64px;
        color: #cbd5e0;
    }

    /* Image Controls */
    .carousel-control-prev,
    .carousel-control-next {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .property-card:hover .carousel-control-prev,
    .property-card:hover .carousel-control-next {
        opacity: 1;
    }

    .carousel-control-prev {
        left: 12px;
    }

    .carousel-control-next {
        right: 12px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-size: 50%;
        filter: invert(1);
    }

    /* Badges */
    .property-badges {
        position: absolute;
        top: 16px;
        left: 16px;
        z-index: 2;
        display: flex;
        gap: 8px;
    }

    .badge-custom {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .badge-type {
        background: rgba(37, 99, 235, 0.95);
        color: white;
    }

    .badge-status.disponible {
        background: rgba(16, 185, 129, 0.95);
        color: white;
    }

    .badge-status.vendu {
        background: rgba(239, 68, 68, 0.95);
        color: white;
    }

    .badge-status.loue {
        background: rgba(245, 158, 11, 0.95);
        color: white;
    }

    /* Favorite Button */
    .favorite-button {
        position: absolute;
        top: 16px;
        right: 16px;
        z-index: 2;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.95);
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .favorite-button:hover {
        transform: scale(1.1);
        background: white;
    }

    .favorite-button.active {
        background: var(--danger-color);
        color: white;
    }

    .favorite-button i {
        font-size: 18px;
    }

    /* Price Badge */
    .price-badge {
        position: absolute;
        bottom: 16px;
        right: 16px;
        background: white;
        color: var(--primary-color);
        padding: 10px 20px;
        border-radius: 50px;
        font-size: 20px;
        font-weight: 700;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        z-index: 2;
    }

    /* Card Content */
    .property-content {
        padding: 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .property-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 12px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .property-location {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        color: var(--text-secondary);
        font-size: 14px;
        margin-bottom: 16px;
    }

    .property-location i {
        font-size: 16px;
        color: var(--primary-color);
        margin-top: 2px;
    }

    .location-text {
        flex: 1;
    }

    .location-address {
        font-size: 12px;
        color: var(--text-secondary);
        margin-top: 2px;
    }

    /* Features */
    .property-features {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border-color);
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--text-secondary);
    }

    .feature-item i {
        font-size: 16px;
        color: var(--primary-color);
    }

    /* Description */
    .property-description {
        color: var(--text-secondary);
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Actions */
    .property-actions {
        display: flex;
        gap: 12px;
        margin-top: auto;
    }

    .btn-view-details {
        flex: 1;
        padding: 12px 20px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-view-details:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        color: white;
    }

    .btn-visit-request {
        flex: 1;
        padding: 12px 20px;
        background: white;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-visit-request:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    .btn-view-request {
        flex: 1;
        padding: 12px 20px;
        background: white;
        color: var(--info-color);
        border: 2px solid var(--info-color);
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-view-request:hover {
        background: var(--info-color);
        color: white;
        transform: translateY(-2px);
    }

    /* Modal */
    .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 24px;
        border: none;
    }

    .modal-title {
        font-size: 20px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-body {
        padding: 32px;
    }

    .modal-property-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid var(--border-color);
    }

    .modal-footer {
        padding: 24px 32px;
        border-top: 1px solid var(--border-color);
        gap: 12px;
    }

    .modal-footer .btn {
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
    }

    .empty-state i {
        font-size: 80px;
        color: var(--text-secondary);
        opacity: 0.3;
        margin-bottom: 24px;
    }

    .empty-state h3 {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 12px;
    }

    .empty-state p {
        color: var(--text-secondary);
        font-size: 16px;
        margin-bottom: 24px;
    }

    .btn-empty-action {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 14px 32px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 16px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-empty-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
        color: white;
    }

    /* Toast Notification */
    .toast-notification {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
        min-width: 350px;
    }

    .toast-custom {
        background: white;
        border-radius: 12px;
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2);
        border: none;
    }

    .toast-header-success {
        background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
        color: white;
        border-radius: 12px 12px 0 0;
        border: none;
        padding: 16px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .hero-title {
            font-size: 40px;
        }

        .hero-subtitle {
            font-size: 18px;
        }

        .filters-row {
            flex-direction: column;
            align-items: stretch;
        }

        .sort-select {
            width: 100%;
        }

        .properties-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }
    }

    @media (max-width: 576px) {
        .hero-section {
            height: 400px;
            margin: -20px -16px 32px -16px;
        }

        .hero-title {
            font-size: 32px;
        }

        .hero-subtitle {
            font-size: 16px;
        }

        .search-wrapper {
            flex-direction: column;
            border-radius: 16px;
        }

        .search-button {
            width: 100%;
            justify-content: center;
        }

        .filter-tabs {
            width: 100%;
        }

        .filter-tab {
            flex: 1;
            justify-content: center;
        }

        .properties-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .property-actions {
            flex-direction: column;
        }

        .property-card:hover {
            transform: translateY(-8px);
        }
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .property-card {
        animation: fadeIn 0.6s ease forwards;
    }

    .property-card:nth-child(1) { animation-delay: 0.05s; }
    .property-card:nth-child(2) { animation-delay: 0.1s; }
    .property-card:nth-child(3) { animation-delay: 0.15s; }
    .property-card:nth-child(4) { animation-delay: 0.2s; }
    .property-card:nth-child(5) { animation-delay: 0.25s; }
    .property-card:nth-child(6) { animation-delay: 0.3s; }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-background"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">Découvrez Notre Sélection</h1>
        <p class="hero-subtitle">Trouvez la propriété de vos rêves parmi nos meilleures offres</p>
        
        <div class="hero-search">
            <form action="{{ route('search.index') }}" method="GET">
                <div class="search-wrapper">
                    <input type="text" 
                           name="keyword" 
                           class="search-input" 
                           placeholder="Rechercher une propriété, une ville..." 
                           value="{{ request('keyword') }}">
                    <button type="submit" class="search-button">
                        <i class="bi bi-search"></i>
                        Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Filters Section -->
<div class="filters-section">
    <div class="filters-row">
        <div class="filter-tabs">
            <a href="{{ route('properties.list') }}" class="filter-tab {{ !request('type') ? 'active' : '' }}">
                Tous les types
            </a>
            <a href="{{ route('properties.list', ['type' => 'maison']) }}" class="filter-tab {{ request('type') == 'maison' ? 'active' : '' }}">
                <i class="bi bi-house"></i>
                Maisons
            </a>
            <a href="{{ route('properties.list', ['type' => 'appartement']) }}" class="filter-tab {{ request('type') == 'appartement' ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                Appartements
            </a>
            <a href="{{ route('properties.list', ['type' => 'terrain']) }}" class="filter-tab {{ request('type') == 'terrain' ? 'active' : '' }}">
                <i class="bi bi-tree"></i>
                Terrains
            </a>
            <a href="{{ route('properties.list', ['type' => 'bureau']) }}" class="filter-tab {{ request('type') == 'bureau' ? 'active' : '' }}">
                <i class="bi bi-briefcase"></i>
                Bureaux
            </a>
        </div>
        
        <select class="sort-select" id="sortBy">
            <option value="newest">Plus récentes</option>
            <option value="price_asc">Prix croissant</option>
            <option value="price_desc">Prix décroissant</option>
        </select>
    </div>
</div>

<!-- Properties Grid -->
@if($properties->count() > 0)
<div class="properties-grid">
    @foreach($properties as $property)
    <div class="property-card">
        <!-- Image Carousel -->
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
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $property->id }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $property->id }}" data-bs-slide="next">
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
                @php
                    $isFavorite = $property->favorites->where('user_id', auth()->id())->count() > 0;
                @endphp
                <form action="{{ route('properties.favorite.toggle', $property->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="favorite-button {{ $isFavorite ? 'active' : '' }}" title="{{ $isFavorite ? 'Retirer des favoris' : 'Ajouter aux favoris' }}">
                        <i class="bi bi-heart{{ $isFavorite ? '-fill' : '' }}"></i>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="favorite-button" title="Connectez-vous pour ajouter aux favoris">
                    <i class="bi bi-heart"></i>
                </a>
            @endauth

            <!-- Price Badge -->
            <div class="price-badge">
                {{ number_format($property->price, 0, ',', ' ') }} Ar
            </div>
        </div>
        
        <!-- Card Content -->
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
        
            <!-- Actions -->
            <div class="property-actions">
                <a href="{{ route('properties.show', $property->id) }}" class="btn-view-details">
                    <i class="bi bi-eye"></i>
                    Voir détails
                </a>
                
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
                    <button type="button" class="btn-visit-request" data-bs-toggle="modal" data-bs-target="#visitRequestModal{{ $property->id }}">
                        <i class="bi bi-calendar-check"></i>
                        Demande de visite
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal pour la demande de visite -->
    <div class="modal fade" id="visitRequestModal{{ $property->id }}" tabindex="-1" aria-labelledby="visitRequestModalLabel{{ $property->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visitRequestModalLabel{{ $property->id }}">
                        <i class="bi bi-calendar-check"></i>
                        Demande de visite
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('appointments.store', $property->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <h6 class="modal-property-title">{{ $property->title }}</h6>
                        
                        <div class="form-group">
                            <label for="visitDate{{ $property->id }}" class="form-label">Date souhaitée</label>
                            <input type="date" 
                                   class="form-input" 
                                   id="visitDate{{ $property->id }}" 
                                   name="visit_date" 
                                   required 
                                   min="{{ date('Y-m-d') }}">
                        </div>
                        
                        <div class="form-group">
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
                        
                        <div class="form-group">
                            <label for="message{{ $property->id }}" class="form-label">Message (optionnel)</label>
                            <textarea class="form-textarea" 
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
    @endforeach
</div>
@else
<!-- Empty State -->
<div class="empty-state">
    <i class="bi bi-house-x"></i>
    <h3>Aucune propriété disponible</h3>
    <p>Aucune propriété ne correspond à vos critères de recherche.</p>
    <a href="{{ route('properties.list') }}" class="btn-empty-action">
        Voir toutes les propriétés
    </a>
</div>
@endif

<!-- Toast Notification -->
@if(session('success'))
<div class="toast-notification">
    <div class="toast toast-custom show" role="alert">
        <div class="toast-header-success">
            <i class="bi bi-check-circle me-2"></i>
            <strong class="me-auto">Succès</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide toast after 5 seconds
    const toasts = document.querySelectorAll('.toast');
    toasts.forEach(toast => {
        setTimeout(() => {
            toast.classList.remove('show');
        }, 5000);
    });
    
    // Set minimum date for date inputs
    const today = new Date().toISOString().split('T')[0];
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        input.min = today;
    });
});
</script>
@endsection