<div class="card property-card-grid h-100 border-0 shadow-sm">
    @if($property->images->count() > 0)
    <div class="property-image position-relative overflow-hidden" style="height: 200px;">
        <img src="{{ asset('storage/' . $property->images->first()->image_url) }}" 
             class="w-100 h-100" 
             style="object-fit: cover;"
             alt="{{ $property->title }}">
        <div class="position-absolute top-0 start-0 p-2">
            <span class="badge bg-primary">{{ ucfirst($property->type) }}</span>
            <span class="badge bg-{{ $property->status == 'disponible' ? 'success' : 'warning' }}">
                {{ ucfirst($property->status) }}
            </span>
        </div>
        <div class="position-absolute bottom-0 end-0 m-2">
            <span class="badge bg-white text-dark fs-6 px-3 py-1 shadow">
                {{ number_format($property->price, 0, ',', ' ') }} €
            </span>
        </div>
    </div>
    @endif
    
    <div class="card-body">
        <h5 class="card-title">{{ Str::limit($property->title, 50) }}</h5>
        <p class="card-text text-muted mb-2">
            <i class="bi bi-geo-alt me-1"></i>
            {{ $property->city }}
        </p>
        
        <div class="property-features mb-3">
            @if($property->surface)
            <span class="badge bg-light text-dark me-1">
                <i class="bi bi-arrows-angle-expand me-1"></i>
                {{ $property->surface }} m²
            </span>
            @endif
            @if($property->rooms)
            <span class="badge bg-light text-dark me-1">
                <i class="bi bi-door-open me-1"></i>
                {{ $property->rooms }} pièces
            </span>
            @endif
        </div>
        
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('properties.show', $property->id) }}" 
               class="btn btn-sm btn-outline-primary">
                Voir détails
            </a>
            <small class="text-muted">
                {{ $property->created_at->diffForHumans() }}
            </small>
        </div>
    </div>
</div>