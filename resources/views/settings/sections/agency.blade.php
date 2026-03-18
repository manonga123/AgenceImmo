<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-building me-2"></i> Paramètres de l'Agence</h5>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Logo de l'agence -->
            <div class="mb-4">
                <label class="form-label">Logo de l'agence</label>
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ $agency->logo_url ?? asset('images/default-logo.png') }}" 
                         class="rounded" 
                         width="100" 
                         alt="Logo agence">
                    <input type="file" class="form-control" name="logo" accept="image/*">
                </div>
            </div>
            
            <!-- Informations de l'agence -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nom de l'agence</label>
                    <input type="text" class="form-control" name="name" value="{{ $agency->name }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>SIRET</label>
                    <input type="text" class="form-control" name="siret" value="{{ $agency->siret }}">
                </div>
                <div class="col-12 mb-3">
                    <label>Adresse</label>
                    <input type="text" class="form-control" name="address" value="{{ $agency->address }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Ville</label>
                    <input type="text" class="form-control" name="city" value="{{ $agency->city }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Code postal</label>
                    <input type="text" class="form-control" name="postal_code" value="{{ $agency->postal_code }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Téléphone</label>
                    <input type="tel" class="form-control" name="phone" value="{{ $agency->phone }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{ $agency->email }}">
                </div>
                <div class="col-12 mb-3">
                    <label>Site web</label>
                    <input type="url" class="form-control" name="website" value="{{ $agency->website }}">
                </div>
                <div class="col-12 mb-3">
                    <label>Description de l'agence</label>
                    <textarea class="form-control" name="description" rows="4">{{ $agency->description }}</textarea>
                </div>
                <div class="col-12 mb-3">
                    <label>Horaires d'ouverture</label>
                    <textarea class="form-control" name="opening_hours" rows="3">{{ $agency->opening_hours }}</textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Mettre à jour l'agence</button>
                </div>
            </div>
        </form>
        
        <hr>
        
        <!-- Configuration des commissions -->
        <h6 class="mb-3">Commissions</h6>
        <form action="" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Commission vente (%)</label>
                    <input type="number" class="form-control" name="sale_commission" 
                           value="{{ $agency->sale_commission }}" step="0.1" min="0" max="100">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Commission location (%)</label>
                    <input type="number" class="form-control" name="rental_commission" 
                           value="{{ $agency->rental_commission }}" step="0.1" min="0" max="100">
                </div>
                <div class="col-md-4 mb-3">
                    <label>TVA (%)</label>
                    <input type="number" class="form-control" name="vat_rate" 
                           value="{{ $agency->vat_rate }}" step="0.1" min="0" max="100">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Mettre à jour les commissions</button>
                </div>
            </div>
        </form>
    </div>
</div>