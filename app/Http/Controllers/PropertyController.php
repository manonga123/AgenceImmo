<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\NotificationTrait;
class PropertyController extends Controller

{
      use NotificationTrait;
    /**
     * Affiche la liste des propriétés (GET /properties)
     */
    public function index()
    {
        // Récupérer les propriétés selon le rôle
        if (Auth::user()->role == 'admin') {
            $properties = Property::with('owner', 'images')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else if (Auth::user()->role == 'owner') {
            $properties = Property::with('owner', 'images')
                ->where('owner_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Pour les autres rôles (client, etc.)
            $properties = Property::with('owner', 'images')
                ->where('status', 'disponible')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('properties.index', compact('properties'));
    }

    /**
     * Affiche le formulaire de création (GET /properties/create)
     */
    public function create()
    {
        // Vérifier que l'utilisateur peut créer des propriétés
        if (!in_array(Auth::user()->role, ['owner', 'admin'])) {
            abort(403, 'Vous n\'avez pas la permission de créer une propriété');
        }

        return view('properties.create');
    }
       /**
     * Stocke une nouvelle propriété (POST /properties)
     */

       
 public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['owner', 'admin'])) {
            abort(403);
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'type'        => 'required|in:maison,appartement,terrain,bureau',
            'status'      => 'nullable|in:disponible,vendu,loué',
            'city'        => 'required|string|max:150',
            'address'     => 'nullable|string|max:255',
            'surface'     => 'nullable|numeric',
            'rooms'       => 'nullable|integer|min:0',
            'bathrooms'   => 'nullable|integer|min:0',
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Créer la propriété
        $property = Property::create([
            ...$validated,
            'owner_id' => Auth::id()
        ]);

        // Créer la notification pour nouvelle propriété
        $this->createNewPropertyNotification($property, Auth::user());

        // Gérer l'upload des images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('proprietes', $imageName, 'public');
                
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_url' => $imagePath,
                ]);
            }
        }

        return redirect()->route('properties.index')
            ->with('success', 'Propriété créée avec succès avec ses images');
    }
    

  /**
 * Liste des propriétés (vue publique)
 */
// Dans PropertyController.php
public function list(Request $request)
{
    $query = Property::query()->with('images')->where('status', '!=', 'vendu');
    
    // Recherche simple par mot-clé
    if ($request->filled('search')) {
        $keyword = $request->search;
        $query->where(function($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%")
              ->orWhere('city', 'like', "%{$keyword}%");
        });
    }
    
    // Filtre par type
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }
    
    // Tri
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
        }
    } else {
        $query->latest();
    }
    
    // Pagination
    $properties = $query->paginate(12);
    
    // return view('properties.list', compact('properties'));
    return view('list', compact('properties'));
}

 public function liste(Request $request)
{
    $query = Property::query()->with('images')->where('status', '!=', 'vendu');
    
    // Recherche simple par mot-clé
    if ($request->filled('search')) {
        $keyword = $request->search;
        $query->where(function($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%")
              ->orWhere('city', 'like', "%{$keyword}%");
        });
    }
    
    // Filtre par type
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }
    
    // Tri
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
        }
    } else {
        $query->latest();
    }
    
    // Pagination
    $properties = $query->paginate(12);
    
    return view('properties.list', compact('properties'));
    
}
    /**
     * Affiche une propriété spécifique (GET /properties/{property})
     */
   public function show($id)
{
    $property = Property::with(['images', 'owner'])->findOrFail($id);

    return view('properties.show', compact('property'));
}

    /**
     * Affiche le formulaire d'édition (GET /properties/{property}/edit)
     */
    public function edit(Property $property)
    {
        // Vérifier les autorisations
        if (
            Auth::user()->role !== 'admin' &&
            Auth::id() !== $property->owner_id
        ) {
            abort(403, 'Vous n\'avez pas la permission de modifier cette propriété');
        }

        return view('properties.edit', compact('property'));
    }

    /**
     * Met à jour une propriété (PUT/PATCH /properties/{property})
     */
    public function update(Request $request, Property $property)
    {
        // autorisation
        if (
            Auth::user()->role !== 'admin' &&
            Auth::id() !== $property->owner_id
        ) {
            abort(403);
        }

        $validated = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'sometimes|numeric|min:0',
            'type'        => 'sometimes|in:maison,appartement,terrain,bureau',
            'status'      => 'sometimes|in:disponible,vendu,loué',
            'city'        => 'sometimes|string|max:150',
            'address'     => 'nullable|string|max:255',
            'surface'     => 'nullable|numeric',
            'rooms'       => 'nullable|integer|min:0',
            'bathrooms'   => 'nullable|integer|min:0',
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Mettre à jour la propriété
        $property->update($validated);

        // Ajouter de nouvelles images si fournies
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('properties', $imageName, 'public');
                
               // Dans la méthode update()
            PropertyImage::create([
                'property_id' => $property->id,
                'image_url' => $imagePath, // Ou 'path' si c'est le nom de la colonne
                // Assurez-vous que le nom de la colonne correspond à votre base de données
            ]);
            }
        }

        return redirect()->route('properties.show', $property)
            ->with('success', 'Propriété mise à jour avec succès');
    }

    /**
     * Supprime une propriété (DELETE /properties/{property})
     */
    public function destroy(Property $property)
    {
        if (
            Auth::user()->role !== 'admin' &&
            Auth::id() !== $property->owner_id
        ) {
            abort(403);
        }

        // Supprimer les images du storage
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image_url);
        }

        // Supprimer la propriété (cascade supprime aussi les PropertyImage)
        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Propriété et ses images supprimées avec succès');
    }

    /**
     * Méthode pour supprimer une image spécifique
     */
    public function deleteImage(PropertyImage $image)
    {
        // Vérifier que l'utilisateur peut supprimer cette image
        $property = $image->property;
        if (
            Auth::user()->role !== 'admin' &&
            Auth::id() !== $property->owner_id
        ) {
            abort(403);
        }

        // Supprimer le fichier du storage
        Storage::disk('public')->delete($image->image_url);
        
        // Supprimer l'enregistrement de la base
        $image->delete();

        return response()->json([
            'message' => 'Image supprimée avec succès'
        ]);
    }
}