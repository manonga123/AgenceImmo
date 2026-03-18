<!-- Code pour la vue détaillée d'une propriété -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $property->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <a href="{{ route('mes-proprietes.index') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Retour à mes propriétés
        </a>
        
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">{{ $property->title }}</h1>
                <h3 class="text-primary">{{ number_format($property->price, 0, ',', ' ') }} €</h3>
                
                <!-- Caractéristiques principales -->
                <div class="row mt-4">
                    @if($property->surface)
                        <div class="col-md-3">
                            <strong>Surface:</strong> {{ $property->surface }} m²
                        </div>
                    @endif
                    @if($property->rooms)
                        <div class="col-md-3">
                            <strong>Chambres:</strong> {{ $property->rooms }}
                        </div>
                    @endif
                    @if($property->bathrooms)
                        <div class="col-md-3">
                            <strong>Salles de bain:</strong> {{ $property->bathrooms }}
                        </div>
                    @endif
                    <div class="col-md-3">
                        <strong>Type:</strong> {{ ucfirst($property->type) }}
                    </div>
                </div>
                
                <!-- Description -->
                @if($property->description)
                    <div class="mt-4">
                        <h4>Description</h4>
                        <p>{{ $property->description }}</p>
                    </div>
                @endif
                
                <!-- Images -->
                @if($property->images->count() > 0)
                    <div class="mt-4">
                        <h4>Images</h4>
                        <div class="row">
                            @foreach($property->images as $image)
                                <div class="col-md-3 mb-3">
                                    <img src="{{ asset('storage/' . $image->image_url) }}" 
                                         class="img-fluid img-thumbnail" 
                                         alt="Image de la propriété">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Boutons d'action -->
                <div class="mt-4">
                    <a href="{{ route('properties.edit', $property->id) }}" 
                       class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    
                    <form action="{{ route('mes-proprietes.destroy', $property->id) }}" 
                          method="POST" 
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette propriété ?')">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>