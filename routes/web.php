<?php
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MesProprietesController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// connexion
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dans web.php, ajoutez cette route
Route::get('/properties/list', [PropertyController::class, 'list'])->name('properties.list');
//recherche de propriétés
// Routes de recherche
Route::prefix('recherche')->name('search.')->group(function () {
    Route::get('/', [SearchController::class, 'index'])->name('index');
    
    // Recherche avec filtres
    Route::post('/search', [SearchController::class, 'search'])->name('submit');
    
    // API pour autocomplétion
    Route::get('/autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');
    
    // Statistiques
    Route::get('/stats', [SearchController::class, 'stats'])->name('stats');
    
    // Supprimer un filtre
    Route::get('/remove-filter/{filter}', [SearchController::class, 'removeFilter'])->name('remove-filter');
});

// Routes publiques pour les propriétés
Route::prefix('proprietes')->name('properties.')->group(function () {
    Route::get('/', [PropertyController::class, 'liste'])->name('list');
    Route::get('/{id}', [PropertyController::class, 'show'])->name('show');
});

// zone protégée
Route::middleware('auth')->group(function () {  
    Route::get('/dashboard', function () { return view('dashboard');})->name('dashboard');
    Route::get('/list', [PropertyController::class, 'list'])->name('list');

    // Routes individuelles COMPLÈTES (sans Route::resource())
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
   
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
   
    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    
    Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
    Route::resource('properties', PropertyController::class);
    Route::delete('/property-images/{image}', [PropertyController::class, 'deleteImage'])
         ->name('property-images.destroy');
         
    Route::prefix('recherche')->name('search.')->group(function () {
        Route::get('/', [SearchController::class, 'index'])->name('index');
        
        // Recherche avec filtres
        Route::get('/search', [SearchController::class, 'search'])->name('submit');
        
        // API pour autocomplétion
        Route::get('/autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');
        
        // Statistiques
        Route::get('/stats', [SearchController::class, 'stats'])->name('stats');
        
        // Supprimer un filtre
        Route::get('/remove-filter/{filter}', [SearchController::class, 'removeFilter'])->name('remove-filter');
    });
      Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
     Route::post('/properties/{property}/favorite', [FavoriteController::class, 'toggle'])->name('properties.favorite.toggle');
            Route::delete('/favorites/{favorite}', [FavoriteController::class, 'remove'])->name('favorites.remove');
       
    ///routes pour mes propriétés uniquement

    Route::get('/mes-proprietes', [App\Http\Controllers\MesProprietesController::class, 'index'])
            ->name('mes-proprietes.index');
        
        Route::get('/mes-proprietes/{id}', [App\Http\Controllers\MesProprietesController::class, 'show'])
            ->name('mes-proprietes.show');
        
        Route::delete('/mes-proprietes/{id}', [App\Http\Controllers\MesProprietesController::class, 'destroy'])
            ->name('mes-proprietes.destroy');


            ///pour les rendez-vous
    Route::get('/appointments', [AppointmentController::class, 'index'])
        ->name('appointments.index');
        // Ajoutez ces routes dans votre fichier web.php
Route::patch('/appointments/{appointment}/accept', [AppointmentController::class, 'accept'])
    ->name('appointments.accept');

Route::patch('/appointments/{appointment}/reject', [AppointmentController::class, 'reject'])
    ->name('appointments.reject');
   
    // Voir uniquement mes demandes envoyées
    Route::get('/my-appointments', [AppointmentController::class, 'myRequests'])
        ->name('appointments.my-requests');
    
    // Voir uniquement les demandes reçues pour mes propriétés
    Route::get('/received-appointments', [AppointmentController::class, 'receivedRequests'])
        ->name('appointments.received');
    
    // Envoyer une demande de visite
    Route::post('/properties/{property}/appointments', [AppointmentController::class, 'store'])
        ->name('appointments.store');
    
    // Modifier une demande (confirmer/rejetter) - seulement propriétaire
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])
        ->name('appointments.update');
    
    // Annuler une demande - seulement l'utilisateur qui l'a créée
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])
        ->name('appointments.destroy');

    Route::get('/properties/{property}/has-request', [AppointmentController::class, 'hasUserRequest'])->name('appointments.has-request');

    Route::get('/appointments/confirmed', [AppointmentController::class, 'confirmedRequests'])
        ->name('appointments.confirmed');
    
    // Voir les demandes en attente
    Route::get('/appointments/pending', [AppointmentController::class, 'pendingRequests'])
        ->name('appointments.pending');
   
        
    //settings
    Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
    
    // Profil
    
     Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

    // Mise à jour du profil
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');

    // Mot de passe
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');

    // Notifications
    Route::put('/settings/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.notifications.update');

    // Export RGPD
    Route::get('/settings/export', [SettingsController::class, 'exportData'])->name('settings.export');

    // Suppression de compte
    Route::delete('/settings/account', [SettingsController::class, 'deleteAccount'])->name('settings.account.delete');

    // Sessions
    Route::delete('/settings/sessions/{sessionId}', [SettingsController::class, 'logoutSession'])->name('settings.sessions.logout');

    // Admin uniquement
    Route::put('/settings/agency',      [SettingsController::class, 'updateAgency'])->name('settings.agency.update');
    Route::put('/settings/commissions', [SettingsController::class, 'updateCommissions'])->name('settings.commissions.update');

    // Owner uniquement
    Route::put('/settings/bank',             [SettingsController::class, 'updateBank'])->name('settings.bank.update');
    Route::put('/settings/owner-preferences',[SettingsController::class, 'updateOwnerPreferences'])->name('settings.owner.update');
 
    
    // Propriétés
    Route::put('/properties', [SettingsController::class, 'updateProperties'])->name('settings.properties.update');
    
    // Propriétaire
    Route::put('/bank', [SettingsController::class, 'updateBank'])->name('settings.bank.update');
    Route::put('/owner/preferences', [SettingsController::class, 'updateOwnerPreferences'])->name('settings.owner.preferences.update');
    ///dashboard
      Route::get('/dashboard',            [DashboardController::class, 'index'])->name('dashboard');
          Route::get('/dashboard/export-pdf', [DashboardController::class, 'exportPdf'])
        ->name('dashboard.export.pdf');
    

    // Notifications
        Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');
    
    // Récupérer les notifications non lues (AJAX)
    Route::get('/notifications/unread', [NotificationController::class, 'getUnreadNotifications'])
        ->name('notifications.unread');
    
    // Marquer une notification comme lue
    Route::post('/notifications/{id}/toggle-read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.toggle-read');
    
    // Marquer toutes les notifications comme lues
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.mark-all-read');

});

       