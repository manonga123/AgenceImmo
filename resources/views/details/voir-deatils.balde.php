{{-- show.blade.php --}}
@extends('layouts.layout')

@section('title', $property->title)

@section('content')
<div class="container-fluid py-4">
    <!-- Header avec bouton retour -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('properties.list') }}" class="btn btn-outline-primary mb-3">
                <i class="bi bi-arrow-left me-2"></i> Retour aux propriétés
            </a>
        </div>
    </div>

    <!-- Propriété Principale -->
    <div class="row">
        <!-- Galerie d'images -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-lg overflow-hidden rounded-4">
                @if($property->images->count() > 0)
                <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($property->images as $index => $image)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $image->image_url) }}" 
                                 class="d-block w-100" 
                                 style="height: 500px; object-fit: cover;"
                                 alt="Image {{ $index + 1 }} de {{ $property->title }}">
                        </div>
                        @endforeach
                    </div>
                    
                    @if($property->images->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
                    </button>
                    
                    <!-- Indicateurs -->
                    <div class="carousel-indicators position-absolute bottom-0">
                        @foreach($property->images as $index => $image)
                        <button type="button" 
                                data-bs-target="#propertyCarousel" 
                                data-bs-slide-to="{{ $index }}" 
                                class="{{ $index === 0 ? 'active' : '' }} mx-1"
                                style="width: 10px; height: 10px; border-radius: 50%; border: 2px solid white;">
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>
                
                <!-- Miniatures (si plus d'une image) -->
                @if($property->images->count() > 1)
                <div class="row g-2 mt-2 px-3 pb-3">
                    @foreach($property->images as $index => $image)
                    <div class="col-3">
                        <a href="#" class="thumbnail-link" data-bs-target="#propertyCarousel" data-bs-slide-to="{{ $index }}">
                            <img src="{{ asset('storage/' . $image->image_url) }}" 
                                 class="img-fluid rounded-2" 
                                 style="height: 80px; width: 100%; object-fit: cover; cursor: pointer;"
                                 alt="Miniature {{ $index + 1 }}">
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
                @else
                <div class="d-flex align-items-center justify-content-center" style="height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="text-center text-white">
                        <i class="bi bi-image display-1"></i>
                        <p class="mt-3">Aucune image disponible</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Informations et CTA -->
        <div class="col-lg-4 mb-4">
            <div class="sticky-top" style="top: 20px;">
                <!-- En-tête de la carte -->
                <div class="card border-0 shadow-lg rounded-4 mb-4">
                    <div class="card-body">
                        <!-- Badges -->
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge bg-primary fs-6">{{ ucfirst($property->type) }}</span>
                                <span class="badge bg-{{ $property->status == 'disponible' ? 'success' : 'warning' }} fs-6 ms-2">
                                    {{ ucfirst($property->status) }}
                                </span>
                            </div>
                            <!-- Favoris -->
                            @auth
                            <form action="{{ route('properties.favorite.toggle', $property->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link text-danger p-0" 
                                        title="{{ $property->favoritedBy(auth()->user()) ? 'Retirer des favoris' : 'Ajouter aux favoris' }}">
                                    <i class="bi {{ $property->favoritedBy(auth()->user()) ? 'bi-heart-fill' : 'bi-heart' }} fs-3"></i>
                                </button>
                            </form>
                            @endauth
                        </div>

                        <!-- Titre -->
                        <h1 class="h2 fw-bold mb-3">{{ $property->title }}</h1>
                        
                        <!-- Prix -->
                        <div class="d-flex align-items-center mb-4">
                            <span class="display-5 fw-bold text-primary">
                                {{ number_format($property->price, 0, ',', ' ') }} €
                            </span>
                            @if($property->type == 'location')
                            <span class="ms-2 text-muted">/mois</span>
                            @endif
                        </div>

                        <!-- Localisation -->
                        <div class="d-flex align-items-center mb-4">
                            <i class="bi bi-geo-alt-fill text-primary fs-4 me-3"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $property->city }}</h6>
                                @if($property->address)
                                <p class="text-muted mb-0">{{ $property->address }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Caractéristiques principales -->
                        <div class="row g-3 mb-4">
                            @if($property->surface)
                            <div class="col-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                    <i class="bi bi-arrows-angle-expand text-primary fs-4 me-3"></i>
                                    <div>
                                        <p class="mb-0 text-muted">Surface</p>
                                        <h5 class="mb-0 fw-bold">{{ $property->surface }} m²</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($property->rooms)
                            <div class="col-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                    <i class="bi bi-door-closed text-primary fs-4 me-3"></i>
                                    <div>
                                        <p class="mb-0 text-muted">Pièces</p>
                                        <h5 class="mb-0 fw-bold">{{ $property->rooms }}</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($property->bathrooms)
                            <div class="col-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                    <i class="bi bi-water text-primary fs-4 me-3"></i>
                                    <div>
                                        <p class="mb-0 text-muted">Salles de bain</p>
                                        <h5 class="mb-0 fw-bold">{{ $property->bathrooms }}</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($property->bedrooms)
                            <div class="col-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                    <i class="bi bi-bed text-primary fs-4 me-3"></i>
                                    <div>
                                        <p class="mb-0 text-muted">Chambres</p>
                                        <h5 class="mb-0 fw-bold">{{ $property->bedrooms }}</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Bouton Contact -->
                        <button class="btn btn-primary btn-lg w-100 py-3 fw-bold mb-3" data-bs-toggle="modal" data-bs-target="#contactModal">
                            <i class="bi bi-envelope me-2"></i> Contacter l'agence
                        </button>

                        <!-- Partage -->
                        <div class="text-center">
                            <p class="text-muted mb-2">Partager cette propriété</p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#" class="text-dark fs-4"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="text-dark fs-4"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="text-dark fs-4"><i class="bi bi-whatsapp"></i></a>
                                <a href="#" class="text-dark fs-4"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Description -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    <h2 class="h3 fw-bold mb-4">Description</h2>
                    @if($property->description)
                    <div class="property-description">
                        {!! nl2br(e($property->description)) !!}
                    </div>
                    @else
                    <p class="text-muted">Aucune description disponible pour cette propriété.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Caractéristiques détaillées -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    <h2 class="h3 fw-bold mb-4">Caractéristiques détaillées</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span class="fw-medium">Type de propriété:</span> {{ ucfirst($property->type) }}
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span class="fw-medium">Statut:</span> {{ ucfirst($property->status) }}
                                </li>
                                @if($property->surface)
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span class="fw-medium">Surface habitable:</span> {{ $property->surface }} m²
                                </li>
                                @endif
                                @if($property->rooms)
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span class="fw-medium">Nombre de pièces:</span> {{ $property->rooms }}
                                </li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                @if($property->bathrooms)
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span class="fw-medium">Salles de bain:</span> {{ $property->bathrooms }}
                                </li>
                                @endif
                                @if($property->bedrooms)
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span class="fw-medium">Chambres:</span> {{ $property->bedrooms }}
                                </li>
                                @endif
                                @if($property->construction_year)
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span class="fw-medium">Année de construction:</span> {{ $property->construction_year }}
                                </li>
                                @endif
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span class="fw-medium">Référence:</span> #PROP{{ str_pad($property->id, 6, '0', STR_PAD_LEFT) }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Localisation -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    <h2 class="h3 fw-bold mb-4">Localisation</h2>
                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-geo-alt-fill text-primary fs-3 me-3"></i>
                        <div>
                            <h4 class="mb-1">{{ $property->city }}</h4>
                            @if($property->address)
                            <p class="text-muted mb-0">{{ $property->address }}</p>
                            @endif
                        </div>
                    </div>
                    <!-- Carte (placeholder) -->
                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 300px;">
                        <div class="text-center">
                            <i class="bi bi-map display-1 text-muted"></i>
                            <p class="mt-3 text-muted">Carte interactive de localisation</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Contact -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Contacter l'agence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="contactForm">
                    @csrf
                    <input type="hidden" name="property_id" value="{{ $property->id }}">
                    <input type="hidden" name="property_title" value="{{ $property->title }}">
                    
                    <div class="mb-3">
                        <label class="form-label">Votre nom complet *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Votre email *</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Votre téléphone</label>
                        <input type="tel" class="form-control" name="phone">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Votre message *</label>
                        <textarea class="form-control" name="message" rows="4" required>Bonjour, je suis intéressé(e) par la propriété "{{ $property->title }}" ({{ number_format($property->price, 0, ',', ' ') }} €). Pourriez-vous m'en dire plus ?</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                        <i class="bi bi-send me-2"></i> Envoyer la demande
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .property-description {
        line-height: 1.8;
        font-size: 1.1rem;
        color: #333;
    }
    
    .property-description p {
        margin-bottom: 1rem;
    }
    
    .carousel-control-prev, .carousel-control-next {
        width: 60px;
        height: 60px;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.8;
    }
    
    .carousel-control-prev:hover, .carousel-control-next:hover {
        opacity: 1;
    }
    
    .thumbnail-link:hover img {
        opacity: 0.8;
        transform: scale(1.05);
        transition: all 0.3s ease;
    }
    
    .thumbnail-link img {
        transition: all 0.3s ease;
    }
    
    .badge {
        font-size: 0.85rem;
        padding: 0.5em 1em;
    }
    
    .sticky-top {
        position: -webkit-sticky;
        position: sticky;
    }
    
    .modal-content {
        border: none;
    }
    
    .modal-header {
        padding: 1.5rem 1.5rem 0.5rem;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des miniatures
    const thumbnailLinks = document.querySelectorAll('.thumbnail-link');
    thumbnailLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.getAttribute('data-bs-target');
            const slideTo = this.getAttribute('data-bs-slide-to');
            
            const carousel = document.querySelector(target);
            const bsCarousel = new bootstrap.Carousel(carousel);
            bsCarousel.to(slideTo);
        });
    });
    
    // Formulaire de contact
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Indicateur de chargement
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Envoi en cours...';
            submitBtn.disabled = true;
            
            // Envoyer la requête
            fetch('{{ route("contact.property") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Succès
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i> Message envoyé !';
                    submitBtn.className = 'btn btn-success w-100 py-3 fw-bold';
                    
                    // Fermer le modal après 2 secondes
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('contactModal'));
                        modal.hide();
                        
                        // Réinitialiser le formulaire et le bouton
                        contactForm.reset();
                        submitBtn.innerHTML = originalText;
                        submitBtn.className = 'btn btn-primary w-100 py-3 fw-bold';
                        submitBtn.disabled = false;
                    }, 2000);
                    
                    // Afficher une notification
                    showToast('Succès', 'Votre message a été envoyé avec succès !', 'success');
                } else {
                    // Erreur
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    showToast('Erreur', data.message || 'Une erreur est survenue', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                showToast('Erreur', 'Une erreur est survenue lors de l\'envoi', 'error');
            });
        });
    }
    
    // Fonction pour afficher les notifications
    function showToast(title, message, type = 'info') {
        const toastHtml = `
            <div class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong>${title}:</strong> ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }
        
        toastContainer.insertAdjacentHTML('beforeend', toastHtml);
        const toastEl = toastContainer.lastElementChild;
        const toast = new bootstrap.Toast(toastEl, { autohide: true, delay: 5000 });
        toast.show();
        
        toastEl.addEventListener('hidden.bs.toast', function() {
            this.remove();
        });
    }
});
</script>
@endsection