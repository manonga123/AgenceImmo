{{-- create-property.blade.php --}}
@extends('layouts.layout')

@section('title', 'Ajouter une propriété')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle me-2"></i>Ajouter une nouvelle propriété
                    </h4>
                </div>
                
                <div class="card-body">
                    <form id="propertyForm" action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Informations de base -->
                                <div class="mb-4">
                                    <h5 class="border-bottom pb-2">
                                        <i class="bi bi-info-circle me-2"></i>Informations de base
                                    </h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="title" class="form-label">Titre *</label>
                                            <input type="text" class="form-control" id="title" name="title" 
                                                   value="{{ old('title') }}" required>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="type" class="form-label">Type *</label>
                                            <select class="form-select" id="type" name="type" required>
                                                <option value="">Sélectionner un type</option>
                                                <option value="maison" {{ old('type') == 'maison' ? 'selected' : '' }}>Maison</option>
                                                <option value="appartement" {{ old('type') == 'appartement' ? 'selected' : '' }}>Appartement</option>
                                                <option value="terrain" {{ old('type') == 'terrain' ? 'selected' : '' }}>Terrain</option>
                                                <option value="bureau" {{ old('type') == 'bureau' ? 'selected' : '' }}>Bureau</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" 
                                                  rows="3">{{ old('description') }}</textarea>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="price" class="form-label">Prix (€) *</label>
                                            <input type="number" class="form-control" id="price" name="price" 
                                                   value="{{ old('price') }}" min="0" step="0.01" required>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="surface" class="form-label">Surface (m²)</label>
                                            <input type="number" class="form-control" id="surface" name="surface" 
                                                   value="{{ old('surface') }}" min="0">
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="status" class="form-label">Statut</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="">Sélectionner un statut</option>
                                                <option value="disponible" {{ old('status') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                                <option value="vendu" {{ old('status') == 'vendu' ? 'selected' : '' }}>Vendu</option>
                                                <option value="loué" {{ old('status') == 'loué' ? 'selected' : '' }}>Loué</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Localisation -->
                                <div class="mb-4">
                                    <h5 class="border-bottom pb-2">
                                        <i class="bi bi-geo-alt me-2"></i>Localisation
                                    </h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="city" class="form-label">Ville *</label>
                                            <input type="text" class="form-control" id="city" name="city" 
                                                   value="{{ old('city') }}" required>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="address" class="form-label">Adresse</label>
                                            <input type="text" class="form-control" id="address" name="address" 
                                                   value="{{ old('address') }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Caractéristiques -->
                                <div class="mb-4">
                                    <h5 class="border-bottom pb-2">
                                        <i class="bi bi-house-door me-2"></i>Caractéristiques
                                    </h5>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="rooms" class="form-label">Nombre de pièces</label>
                                            <input type="number" class="form-control" id="rooms" name="rooms" 
                                                   value="{{ old('rooms') }}" min="0">
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="bathrooms" class="form-label">Nombre de salles de bain</label>
                                            <input type="number" class="form-control" id="bathrooms" name="bathrooms" 
                                                   value="{{ old('bathrooms') }}" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <!-- Upload d'images -->
                                <div class="card mb-4">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0">
                                            <i class="bi bi-images me-2"></i>Photos de la propriété
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="images" class="form-label">Ajouter des photos</label>
                                            <input type="file" class="form-control" id="images" name="images[]" 
                                                   multiple accept="image/*">
                                            <div class="form-text">
                                                Formats acceptés : JPEG, PNG, JPG, GIF, WebP. Max 2MB par image.
                                            </div>
                                        </div>
                                        
                                        <!-- Aperçu des images -->
                                        <div class="mt-3">
                                            <h6>Aperçu des images :</h6>
                                            <div id="imagePreview" class="row g-2 mt-2">
                                                <!-- Les aperçus seront ajoutés ici par JavaScript -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Bouton de soumission -->
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-check-circle me-2"></i>Créer la propriété
                                    </button>
                                    <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-2"></i>Annuler
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('images');
    const imagePreview = document.getElementById('imagePreview');
    
    // Gestion de l'aperçu des images
    imageInput.addEventListener('change', function(event) {
        imagePreview.innerHTML = '';
        
        const files = event.target.files;
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            
            // Vérifier si c'est une image
            if (!file.type.match('image.*')) {
                continue;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-6 col-md-4';
                
                col.innerHTML = `
                    <div class="card">
                        <img src="${e.target.result}" class="card-img-top" style="height: 100px; object-fit: cover;" alt="Aperçu">
                        <div class="card-body p-2">
                            <small class="text-muted">${file.name}</small>
                            <small class="d-block text-muted">${(file.size / 1024).toFixed(2)} KB</small>
                        </div>
                    </div>
                `;
                
                imagePreview.appendChild(col);
            };
            
            reader.readAsDataURL(file);
        }
    });
    
    // Validation du formulaire
    const form = document.getElementById('propertyForm');
    form.addEventListener('submit', function(event) {
        // Validation supplémentaire si nécessaire
        const price = document.getElementById('price').value;
        if (price < 0) {
            event.preventDefault();
            alert('Le prix ne peut pas être négatif');
        }
    });
});
</script>
@endsection