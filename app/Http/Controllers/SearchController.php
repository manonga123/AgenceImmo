<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class SearchController extends Controller
{
         public function index(Request $request)
    {
        return $this->search($request);
    }

    /**
     * Recherche avancée des propriétés
     */
    public function search(Request $request)
    {
        // Valider les paramètres de recherche
        $validated = $request->validate([
            'keyword' => 'nullable|string|max:255',
            'type' => 'nullable|in:maison,appartement,terrain,bureau',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'min_surface' => 'nullable|numeric|min:0',
            'max_surface' => 'nullable|numeric|min:0',
            'rooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'city' => 'nullable|string|max:150',
            'status' => 'nullable|in:disponible,vendu,loué',
            'sort_by' => 'nullable|in:price_asc,price_desc,newest,oldest,surface_desc',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        // Initialiser la requête
        $query = Property::query()->with('images');

        // Filtrer par mot-clé
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('city', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%");
            });
        }

        // Filtrer par type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtrer par prix
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filtrer par surface
        if ($request->filled('min_surface')) {
            $query->where('surface', '>=', $request->min_surface);
        }
        if ($request->filled('max_surface')) {
            $query->where('surface', '<=', $request->max_surface);
        }

        // Filtrer par nombre de pièces
        if ($request->filled('rooms')) {
            $query->where('rooms', '>=', $request->rooms);
        }

        // Filtrer par nombre de salles de bain
        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        // Filtrer par ville
        if ($request->filled('city')) {
            $query->where('city', 'like', "%{$request->city}%");
        }

        // Filtrer par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Par défaut, ne pas afficher les propriétés vendues
            $query->where('status', '!=', 'vendu');
        }

        // Trier les résultats
        switch ($request->get('sort_by', 'newest')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'surface_desc':
                $query->orderBy('surface', 'desc');
                break;
        }

        // Pagination
        $perPage = $request->get('per_page', 12);
        $properties = $query->paginate($perPage);

        // Données pour les filtres
        $filterData = [
            'cities' => Property::select('city')
                ->distinct()
                ->whereNotNull('city')
                ->orderBy('city')
                ->pluck('city'),
            'price_range' => [
                'min' => Property::min('price') ?? 0,
                'max' => Property::max('price') ?? 1000000,
            ],
            'surface_range' => [
                'min' => Property::min('surface') ?? 0,
                'max' => Property::max('surface') ?? 500,
            ],
            'room_options' => Property::select('rooms')
                ->distinct()
                ->whereNotNull('rooms')
                ->orderBy('rooms')
                ->pluck('rooms')
                ->filter()
                ->values(),
        ];

        // Récupérer les paramètres actuels pour les badges
        $currentFilters = $request->only([
            'keyword', 'type', 'min_price', 'max_price', 
            'min_surface', 'max_surface', 'rooms', 
            'bathrooms', 'city', 'status'
        ]);

        // Retour selon le type de requête
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'properties' => $properties,
                'filters' => $filterData,
                'total' => $properties->total(),
                'current_filters' => $validated,
            ]);
        }

        return view('properties.search', [
            'properties' => $properties,
            'filterData' => $filterData,
            'currentFilters' => $currentFilters,
        ]);
    }

    /**
     * Recherche par autocomplétion
     */
    public function autocomplete(Request $request)
    {
        $query = $request->get('query');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = Property::select('id', 'title', 'city', 'type')
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('city', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->where('status', '!=', 'vendu')
            ->limit(8)
            ->get()
            ->map(function($property) {
                return [
                    'id' => $property->id,
                    'name' => $property->title,
                    'city' => $property->city,
                    'type' => $property->type,
                    'url' => route('properties.show', $property->id),
                ];
            });

        return response()->json($results);
    }

    /**
     * Récupérer les statistiques de recherche
     */
    public function stats()
    {
        $stats = [
            'total_properties' => Property::where('status', '!=', 'vendu')->count(),
            'average_price' => Property::where('status', '!=', 'vendu')->avg('price') ?? 0,
            'types_count' => Property::where('status', '!=', 'vendu')
                ->select('type', DB::raw('count(*) as count'))
                ->groupBy('type')
                ->pluck('count', 'type'),
            'cities_count' => Property::where('status', '!=', 'vendu')
                ->select('city', DB::raw('count(*) as count'))
                ->groupBy('city')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
        ];

        return response()->json($stats);
    }

    /**
     * Supprimer un filtre spécifique
     */
    public function removeFilter(Request $request, $filter)
    {
        $queryParams = $request->query();
        
        if (is_array($filter)) {
            foreach ($filter as $f) {
                unset($queryParams[$f]);
            }
        } else {
            unset($queryParams[$filter]);
        }
        
        return redirect()->route('search.index', $queryParams);
    }
}



