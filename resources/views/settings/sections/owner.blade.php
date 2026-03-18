<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-key me-2"></i> Paramètres Propriétaire</h5>
    </div>
    <div class="card-body">
        <!-- Informations bancaires pour les paiements -->
        <h6 class="mb-3">Informations bancaires</h6>
        <form action="{{ route('settings.bank.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Titulaire du compte</label>
                    <input type="text" class="form-control" name="account_holder" 
                           value="{{ auth()->user()->bank_account_holder }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>IBAN</label>
                    <input type="text" class="form-control" name="iban" 
                           value="{{ auth()->user()->iban }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>BIC/SWIFT</label>
                    <input type="text" class="form-control" name="bic" 
                           value="{{ auth()->user()->bic }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Nom de la banque</label>
                    <input type="text" class="form-control" name="bank_name" 
                           value="{{ auth()->user()->bank_name }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </div>
        </form>
        
        <hr>
        
        <!-- Préférences de notification propriétaire -->
        <h6 class="mb-3">Préférences spécifiques</h6>
        <form action="{{ route('settings.owner.preferences.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="auto_confirm_visits" 
                           id="autoConfirm" {{ auth()->user()->auto_confirm_visits ? 'checked' : '' }}>
                    <label class="form-check-label" for="autoConfirm">
                        Confirmer automatiquement les demandes de visite
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="receive_visit_reminders" 
                           id="visitReminders" {{ auth()->user()->receive_visit_reminders ? 'checked' : '' }}>
                    <label class="form-check-label" for="visitReminders">
                        Recevoir des rappels de visites
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label>Délai de réponse maximum (heures)</label>
                <input type="number" class="form-control" name="max_response_time" 
                       value="{{ auth()->user()->max_response_time ?? 24 }}" min="1" max="168">
                <small class="text-muted">Temps maximum pour répondre à une demande de visite</small>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Enregistrer les préférences</button>
            </div>
        </form>
    </div>
</div>