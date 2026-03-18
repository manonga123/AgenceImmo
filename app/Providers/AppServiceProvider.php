<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Partage des données utilisateur avec toutes les vues
        View::composer('*', function ($view) {
            $view->with('currentUser', Auth::user());
        });
        
        // Définir les breadcrumbs par défaut
        View::composer('*', function ($view) {
            $breadcrumb = [];
            
            // Vous pouvez personnaliser les breadcrumbs selon la route
            if (request()->route()) {
                $routeName = request()->route()->getName();
                
                switch ($routeName) {
                    case 'dashboard':
                        $breadcrumb = [
                            ['label' => 'Tableau de bord']
                        ];
                        break;
                    case 'properties.index':
                        $breadcrumb = [
                            ['label' => 'Tableau de bord', 'url' => route('dashboard')],
                            ['label' => 'Propriétés']
                        ];
                        break;
                    case 'properties.create':
                        $breadcrumb = [
                            ['label' => 'Tableau de bord', 'url' => route('dashboard')],
                            ['label' => 'Propriétés', 'url' => route('properties.index')],
                            ['label' => 'Ajouter une propriété']
                        ];
                        break;
                    case 'properties.edit':
                        $breadcrumb = [
                            ['label' => 'Tableau de bord', 'url' => route('dashboard')],
                            ['label' => 'Propriétés', 'url' => route('properties.index')],
                            ['label' => 'Modifier une propriété']
                        ];
                        break;
                }
            }
            
            $view->with('breadcrumb', $breadcrumb);
        });
    }
}